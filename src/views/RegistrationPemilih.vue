<template>
    <form>
        <v-card class="mx-auto my-15" max-width="500" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>

                <div class="col-12">
                    <center>
                        <img src="../assets/logomepa.png" alt="" srcset="" width="60%">
                        <h2>Registrasi Pemilih</h2>
                    </center>
                </div>
                <v-spacer></v-spacer>
            </v-card-title>

            <v-card-text class="text--primary">
                <div>
                    <v-alert text dense close-icon="mdi-close-circle-outline" color="cyan darken-2" v-model="alert"
                        elevation="2" icon="mdi-information-outline" border="left" dismissible
                        transition="scale-transition">
                        {{ response.fail }}
                    </v-alert>
                </div>

                <v-text-field v-model="name" :error-messages="nameErrors" label="Name" required
                    @input="$v.name.$touch()"></v-text-field>
                <v-text-field v-model="email" :error-messages="emailErrors" label="Email" required
                    @input="$v.email.$touch()"></v-text-field>
                <v-text-field v-model="phone" :error-messages="phoneErrors" label="Phone" required
                    @input="$v.phone.$touch()"></v-text-field>
                <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" required
                    @input="$v.password.$touch()" @blur="$v.password.$touch()" :type="show1 ? 'text' : 'password'"
                    name="input-10-1" label="Password" :error-messages="passwordErrors" counter
                    @click:append="show1 = !show1"></v-text-field>

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
                <p>Sudah punya akun? <v-btn text @click="navigateTo('login')" class="ml-2">
                        Login di sini
                    </v-btn></p>
            </v-card-subtitle>
        </v-card>
    </form>
</template>

<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate'
import { required, maxLength, email as emailValidator, minLength } from 'vuelidate/lib/validators'
import { mapGetters } from 'vuex';

const maxlength = 18;
const minlength = 3;

export default {
    mixins: [validationMixin],
    validations: {
        name: { required, minLength: minLength(minlength) },
        email: { required, email: emailValidator },
        phone: { required, minLength: minLength(minlength) },
        password: { required, maxLength: maxLength(maxlength) },
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
            await axios.post(process.env.VUE_APP_SERVICE_URL + "register", param).then(res => {
                // Handle successful registration logic here
                this.$router.push('/login').catch(() => { })
            }).catch(error => {
                this.alert = true;
                console.log(error.response);
                this.response.fail = error.response.data.message || 'An error occurred during registration.';
            });
            this.isCompletedLoad = false;
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
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.name.minLength && errors.push('Name must be at least ' + minlength + ' characters long')
            !this.$v.name.required && errors.push('Name is required.')
            return errors
        },
        emailErrors() {
            const errors = []
            if (!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Email must be a valid email address.')
            !this.$v.email.required && errors.push('Email is required.')
            return errors
        },
        phoneErrors() {
            const errors = []
            if (!this.$v.phone.$dirty) return errors
            !this.$v.phone.minLength && errors.push('Phone must be at least ' + minlength + ' characters long')
            !this.$v.phone.required && errors.push('Phone is required.')
            return errors
        },
        passwordErrors() {
            const errors = []
            if (!this.$v.password.$dirty) return errors
            !this.$v.password.maxLength && errors.push('Password must be at most ' + maxlength + ' characters long')
            !this.$v.password.required && errors.push('Password is required.')
            return errors
        },
        isValid() {
            return !this.$v.$pending && !this.$v.$error &&
                !this.nameErrors.length && !this.emailErrors.length &&
                !this.phoneErrors.length && !this.passwordErrors.length;
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
