<template>
    <form>
        <v-card class="mx-auto my-15" max-width="500" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>
                <div class="col-12">
                    <center>
                        <img src="../assets/logomepa.png" alt="" srcset="" width="60%">
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

                <TextFieldComponent v-model="nip" :error-messages="nipErrors" label="Nomor Anggota" required
                    @input="$v.nip.$touch()">
                </TextFieldComponent>

                <TextFieldComponent v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" required
                    @input="$v.password.$touch()" @blur="$v.password.$touch()" :type="show1 ? 'text' : 'password'"
                    name="input-10-1" label="Password" :error-messages="passwordErrors" counter
                    @click:append="show1 = !show1">
                </TextFieldComponent>
            </v-card-text>

            <v-card-actions>
                <v-btn :disabled="isValid || isCompletedLoad" text class="mr-4 white--text" color="cyan darken-2"
                    @click="login">
                    <v-icon>mdi-lock-outline</v-icon> Login
                </v-btn>
                <v-btn text class="mr-4 white--text" color="blue-grey" @click="clear">
                    <v-icon>mdi-cached</v-icon> Clear
                </v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>

<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import { mapGetters } from 'vuex';
import TextFieldComponent from '@/components/TextFieldComponent.vue';  // Path to your component

var maxlength = 18;
export default {
    name: 'LoginComponent',
    components: {
        TextFieldComponent,
    },
    mixins: [validationMixin],
    validations: {
        nip: { required, maxLength: maxLength(maxlength) },
        password: { required, maxLength: maxLength(maxlength) },
    },
    data() {
        return {
            isCompletedLoad: false,
            nip: '',
            select: null,
            userData: [],
            token: "",
            show1: false,
            password: '',
            alert: false,
            response: {
                fail: ""
            }
        }
    },
    methods: {
        async login() {
            this.isCompletedLoad = true;
            const param = { "nip": this.nip, "password": this.password }
            await axios.post(process.env.VUE_APP_SERVICE_URL + "otentikasi", param).then(async res => {
                var userDatas = res.data;

                this.token = res.data.access_token;
                localStorage.setItem('token', res.data.access_token);
                localStorage.setItem('darkMode', this.$store.state.settings['isDarkMode']);
                localStorage.setItem('userData', JSON.stringify(userDatas));
                localStorage.setItem('isLogin', this.token != "" ? true : false);
                localStorage.setItem('alertSuccessLogin', true);
                axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

                if (this.token != "") {
                    var paramLookup = { "params": ['STATUS', 'TYPE', 'HEADER', 'DESC', 'ACCESS', 'LEVEL', 'ACTION', 'FILEPREFIX'] };
                    await axios.post(process.env.VUE_APP_SERVICE_URL + "lookup/detail", paramLookup).then(res => {
                        var resulttData = !!res ? res : [];
                        if (resulttData) {
                            localStorage.setItem('lookups', JSON.stringify(resulttData.data));
                            this.$router.push("/").catch(() => { })
                                .then(() => { this.$router.go() });
                        }

                    }).catch(error => {
                        this.alert = true;
                        this.response.fail = error.response.message;

                    });
                }

            }).catch(error => {
                this.alert = true;
                console.log(error.response);
                this.response.fail = error.response.message;

            });
            this.isCompletedLoad = false;
        },
        submit() {
            this.$v.$touch()
        },
        clear() {
            this.$v.$reset()
            this.name = ''
            this.nip = ''
            this.password = ''
        },
    },
    computed: {
        ...mapGetters(['users', 'settings', 'lookups']),
        nipErrors() {
            const errors = []
            if (!this.$v.nip.$dirty) return errors
            !this.$v.nip.maxLength && errors.push('Nomor Anggota must be at most ' + maxlength + ' characters long')
            !this.$v.nip.required && errors.push('Nomor Anggota is required.')
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
            if ((nip != '' || nip.length > maxLength) && (password != '' || nip.length > maxLength)) {
                return false;
            } else {
                return true;
            }
        }
    },
}
</script>
