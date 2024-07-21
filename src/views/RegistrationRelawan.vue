<template>
    <form>
        <v-card class="mx-auto my-15" max-width="500" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>

                <div class="col-12">
                    <center>
                        <img src="../assets/logomepa.png" alt="" srcset="" width="40%">
                        <h2 color="blue-grey">Registrasi Relawan</h2>
                    </center>
                </div>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-card-subtitle class="text-center">
                <p>Registrasi sebagai relawan koordinator wilayah untuk memenangkan Meki Nawipa, mohon
                    mengisi
                    dengan data yang benar.</p>
            </v-card-subtitle>

            <v-card-text class="text--primary">
                <div>
                    <v-alert text dense close-icon="mdi-close-circle-outline" color="cyan darken-2" v-model="alert"
                        elevation="2" icon="mdi-information-outline" border="left" dismissible
                        transition="scale-transition">
                        {{ response.fail }}
                    </v-alert>
                </div>

                <v-text-field outlined dense v-model="name" :error-messages="nameErrors" label="Nama" required
                    @input="$v.name.$touch()" @blur="$v.name.$touch()"></v-text-field>

                <v-text-field outlined dense v-model="email" :error-messages="emailErrors" label="Email" required
                    @input="$v.email.$touch()" @blur="$v.email.$touch()"></v-text-field>

                <v-text-field outlined dense v-model="phone" :error-messages="phoneErrors" label="Tlp/WhatsApp" required
                    @input="$v.phone.$touch()" @blur="$v.phone.$touch()"></v-text-field>

                <v-text-field outlined dense v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    required @input="$v.password.$touch()" @blur="$v.password.$touch()"
                    :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password"
                    :error-messages="passwordErrors" counter @click:append="show1 = !show1"></v-text-field>

            </v-card-text>

            <v-card-actions>
                <v-btn :disabled="!isValid || isCompletedLoad" class="mr-4 white--text" color="cyan darken-2"
                    @click="register">
                    <v-icon>mdi-floppy</v-icon> REGISTER
                </v-btn>
                <v-btn text class="mr-4 white--text" color="blue-grey" @click="clear">
                    <v-icon>mdi-cached</v-icon> Clear
                </v-btn>
            </v-card-actions>
            <v-card-subtitle class="text-center">
                <p>Sudah punya akun? <v-btn text @click="navigateTo('login')" class="mr-4 white--text"
                        color="cyan darken-2">
                        Login di sini
                    </v-btn></p>
            </v-card-subtitle>
        </v-card>
    </form>
</template>

<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate'
import { required, maxLength, email as emailValidator, minLength, numeric } from 'vuelidate/lib/validators'

const maxlength15 = 15;
const minlength10 = 10;

const maxlength25 = 25;
const minlength5 = 5;

export default {
    mixins: [validationMixin],
    validations: {
        name: { required, minLength: minLength(minlength5), maxLength: maxLength(maxlength25) },
        email: { required, email: emailValidator, minLength: minLength(minlength5) },
        phone: { required, minLength: minLength(minlength10), maxLength: maxLength(maxlength15), numeric },
        password: { required, maxLength: minLength(minlength5) },
    },
    data() {
        return {
            isCompletedLoad: false,
            name: '',
            email: '',
            phone: '',
            password: '',
            show1: false,
            alert: false,
            response: {
                fail: ""
            }
        }
    },
    methods: {
        async register() {
            this.isCompletedLoad = true;
            const param = { name: this.name, email: this.email, phone: this.phone, password: this.password }
            try {
                const res = await axios.post(process.env.VUE_APP_SERVICE_URL + "register", param);
                this.$router.push('/login').catch(() => { })
            } catch (error) {
                this.alert = true;
                console.log(error.response);
                this.response.fail = error.response.data.message || 'An error occurred during registration.';
            } finally {
                this.isCompletedLoad = false;
            }
        },
        clear() {
            this.$v.$reset();
            this.name = '';
            this.email = '';
            this.phone = '';
            this.password = '';
        },
        navigateTo(target) {
            this.$router.push('/' + target);
        }
    },
    computed: {
        nameErrors() {
            const errors = [];
            if (!this.$v.name.$dirty) return errors;
            !this.$v.name.minLength && errors.push('Nama minimal ' + minlength5 + ' karakter');
            !this.$v.name.maxLength && errors.push('Nama maksimal ' + maxlength25 + ' karakter');
            !this.$v.name.required && errors.push('Nama tidak boleh kosong.');
            return errors;
        },
        emailErrors() {
            const errors = [];
            if (!this.$v.email.$dirty) return errors;
            !this.$v.email.email && errors.push('Email harus valid');
            !this.$v.email.minLength && errors.push('Email minimal ' + minlength5 + ' karakter');
            !this.$v.email.required && errors.push('Email tidak boleh kosong');
            return errors;
        },
        phoneErrors() {
            const errors = [];
            if (!this.$v.phone.$dirty) return errors;
            !this.$v.phone.minLength && errors.push('Tlp/WhatsApp minimal ' + minlength10 + ' karakter');
            !this.$v.phone.maxLength && errors.push('Tlp/WhatsApp minimal ' + maxlength15 + ' karakter');
            !this.$v.phone.required && errors.push('Tlp/WhatsApp tidak boleh kosong.');
            !this.$v.phone.numeric && errors.push('Tlp/WhatsApp harus berupa angka.');
            return errors;
        },
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) return errors;
            !this.$v.password.maxLength && errors.push('Password minimal ' + minlength5 + ' karakter');
            !this.$v.password.required && errors.push('Password todak boleh kosong.');
            return errors;
        },
        isValid() {
            // Ensure all fields have been touched and are valid
            return this.$v.$dirty && !this.$v.$pending && !this.$v.$error &&
                !this.nameErrors.length && !this.emailErrors.length &&
                !this.phoneErrors.length && !this.passwordErrors.length &&
                this.name && this.email && this.phone && this.password;
        }
    },
}
</script>
<style scoped>
.register-btn {
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
