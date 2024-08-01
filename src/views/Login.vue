<template>
    <form>
        <v-card class="mx-auto my-15" max-width="500" outlined elevation="5">
            <v-overlay v-show="isCompletedLoad" :value="true" z-index="2000">
                <v-progress-circular indeterminate color="white" size="70"></v-progress-circular>
            </v-overlay>
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
import { mapGetters, mapActions } from 'vuex';

var maxlength = 18;

export default {
    mixins: [validationMixin],
    validations: {
        nomorAnggota: { required },
        password: { required },
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
        ...mapActions(['showOverlayLoading', 'hideOverlayLoading']),

        async login() {
            this.showOverlayLoading();
            const loginParam = { "username": this.nomorAnggota, "password": this.password };
            try {
                // Panggil API login
                const loginRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "auth/login", loginParam);
                const token = loginRes.data.data; // Token berada di dalam properti 'data'

                await this.$store.dispatch('login', { token, username: this.nomorAnggota });
                await this.initUserData();

            } catch (error) {
                this.alert = true;
                this.response.message = error.response.data.message || 'Gagal login. Periksa username dan password Anda.';
            } finally {
                this.hideOverlayLoading();
            }
        },
        async initUserData() {

            // load all data for first time and save into localstorage
            this.showOverlayLoading();
            try {

                // Jika login berhasil, panggil API search/user
                const userDetailsParam = {};
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/userByID", userDetailsParam);
                const users = userDetailsRes.data.data;
                var userDetails = users.filter(volunteer => volunteer.volunteerID === this.nomorAnggota.toString().toUpperCase().replace(/\s+/g, ''));
                console.log(userDetails);
                await this.$store.dispatch('setUserData', { users });
                await this.$store.dispatch('setUserLogin', { userLogin: userDetails[0] });



                var message = '';
                var color = "";
                if (userDetails[0].status == "inactive" && userDetails[0].role == "relawan") {
                    // this.$router.push('/completion-relawan').catch(() => { });
                    message = "Akun anda belum diaktifkan oleh pengurus pusat. Silahkan lengkapi data anda terlebih dahulu setelah itu hubungi pengurus untuk diaktifkan";
                    color = "orange darken-2";
                } else if (userDetails[0].status == "inactive" && userDetails[0].role == "pemilih") {
                    // this.$router.push('/completion-pemilih').catch(() => { });
                    message = "Akun anda belum diaktifkan oleh koordinator relawan anda. Silahkan lengkapi data anda terlebih dahulu setelah itu hubungi koordinator relawan untuk diaktifkan";
                    color = "orange darken-2";
                } else {
                    message = 'Silahkan menggunakan menu yang ada sebagaimana mestinya';
                    color = "cyan darken-2";
                }

                await this.$store.dispatch('setDialog', {
                    isShowDialog: true,
                    title: '[Perhatian]',
                    details: message,
                    color: color
                });

                this.$router.push('/').catch(() => { });

            } catch (error) {

            } finally {
                this.hideOverlayLoading();


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
        ...mapGetters(['users', 'settings', 'lookups', 'isOverlayLoading']),

        nomorAnggotaErrors() {
            const errors = [];
            if (!this.$v.nomorAnggota.$dirty) return errors;
            !this.$v.nomorAnggota.required && errors.push('Nomor Anggota is required.');
            return errors;
        },
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) return errors;
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
