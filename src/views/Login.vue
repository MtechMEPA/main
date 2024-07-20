<template>
    <form>
        <v-card class="mx-auto my-15" max-width="500" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>
                <div class="col-12">
                    <center>
                        <img src="../assets/logomepa.png" alt="" srcset="" width="40%">
                        <h2>Login</h2>
                    </center>
                </div>
                <v-spacer></v-spacer>
            </v-card-title>

            <v-card-text class="text--primary">
                <div>
                    <v-alert text dense close-icon="mdi-close-circle-outline" color="cyan darken-2" v-model="alert"
                        elevation="2" icon="mdi-information-outline" border="left" dismissible
                        transition="scale-transition">
                        {{ response.message }}
                    </v-alert>
                </div>

                <v-text-field outlined dense v-model="nomorAnggota" :error-messages="nomorAnggotaErrors"
                    label="Nomor Anggota" required @input="$v.nomorAnggota.$touch()"></v-text-field>
                <v-text-field outlined dense v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    required @input="$v.password.$touch()" @blur="$v.password.$touch()"
                    :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password"
                    :error-messages="passwordErrors" counter @click:append="show1 = !show1"></v-text-field>
            </v-card-text>

            <v-card-actions>
                <v-btn :disabled="!isValid || isCompletedLoad" class="mr-4 white--text" color="cyan darken-2"
                    @click="login">
                    <v-icon>mdi-lock-outline</v-icon> Login
                </v-btn>
                <v-btn text class="mr-4 white--text" color="blue-grey" @click="clear">
                    <v-icon>mdi-cached</v-icon> Clear
                </v-btn>
            </v-card-actions>

            <v-card-subtitle class="text-center">
                <p>*Jika belum punya akun, silahkan daftar dengan klik link dibawah ini <br /> Pilih
                    <strong>RELAWAN</strong> jika anda koordinator Lapangan <br /> Pilih
                    <strong>PEMILIH</strong> jika anda pendukung Meki Nawipa - MEPA
                </p>
                <v-divider></v-divider>
                <p> <v-btn text class="mr-4 white--text ml-2" color="cyan darken-2"
                        @click="navigateTo('registration-relawan')">
                        Relawan
                    </v-btn> atau <v-btn text class="mr-4 white--text ml-2" color="cyan darken-2"
                        @click="navigateTo('registration-pemilih')">
                        Pemilih
                    </v-btn></p>
            </v-card-subtitle>
        </v-card>
    </form>
</template>

<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import { mapGetters } from 'vuex';
var maxlength = 18;

export default {
    mixins: [validationMixin],
    validations: {
        nomorAnggota: { required, maxLength: maxLength(maxlength) },
        password: { required, maxLength: maxLength(maxlength) },
    },
    data() {
        return {
            isCompletedLoad: false,
            nomorAnggota: '',
            password: '',
            show1: false,
            alert: false,
            response: {
                message: ""
            }
        }
    },
    methods: {
        async login() {
            this.isCompletedLoad = true;
            const param = { "username": this.nomorAnggota, "password": this.password };
            try {
                const res = await axios.post(process.env.VUE_APP_SERVICE_URL + "auth/login", param);
                const token = res.data.data; // Token berada di dalam properti 'data'
                console.log(res);
                await this.$store.dispatch('login', { token, username: this.nomorAnggota });

                this.alert = true;
                this.response.message = "Berhasil login";
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                this.$router.push('/').catch(() => { });

            } catch (error) {
                this.alert = true;
                console.log(error.response);
                this.response.message = error.response.data.message || 'Gagal login. Periksa username dan password Anda.';
            } finally {
                this.isCompletedLoad = false;
            }
        },
        clear() {
            this.$v.$reset();
            this.nomorAnggota = '';
            this.password = '';
        },
        navigateTo(target) {
            this.$router.push('/' + target);
        }
    },
    computed: {
        ...mapGetters(['users', 'settings', 'lookups']),
        nomorAnggotaErrors() {
            const errors = [];
            if (!this.$v.nomorAnggota.$dirty) return errors;
            !this.$v.nomorAnggota.maxLength && errors.push('Nomor Anggota must be at most ' + maxlength + ' characters long');
            !this.$v.nomorAnggota.required && errors.push('Nomor Anggota is required.');
            return errors;
        },
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) return errors;
            !this.$v.password.maxLength && errors.push('Password must be at most ' + maxlength + ' characters long');
            !this.$v.password.required && errors.push('Password is required.');
            return errors;
        },
        isValid() {
            return this.$v.$dirty && !this.$v.$pending && !this.$v.$error &&
                !this.nomorAnggotaErrors.length && !this.passwordErrors.length;
        }
    },
}
</script>

<style scoped>
.login-btn {
    background-color: #1E88E5;
    /* Ganti dengan warna yang diinginkan */
}

.clear-btn {
    background-color: #9E9E9E;
    /* Ganti dengan warna yang diinginkan */
}

.v-card-actions {
    display: flex;
    justify-content: space-between;
}
</style>
