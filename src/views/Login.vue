<template>
    <Login :nip="nip" :password="password" :nipErrors="nipErrors" :passwordErrors="passwordErrors"
        :isCompletedLoad="isCompletedLoad" :isValid="isValid" :alert="alert" :response="response" :show1="show1"
        @login="login" @clear="clear" />
</template>

<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate';
import { required, maxLength } from 'vuelidate/lib/validators';
import { mapGetters } from 'vuex';
import Login from '../components/Login.vue';

export default {
    name: 'Login',
    mixins: [validationMixin],
    components: {
        Login,
    },
    validations: {
        nip: { required, maxLength: maxLength(18) },
        password: { required, maxLength: maxLength(18) },
    },
    data() {
        return {
            isCompletedLoad: false,
            nip: '',
            password: '',
            show1: false,
            alert: false,
            response: {
                fail: '',
            },
        };
    },
    methods: {
        async login({ nip, password }) {
            this.isCompletedLoad = true;
            const param = {
                "username": nip,
                "password": password
            };
            console.log(param);
            // try {
            //     const res = await axios.post(process.env.VUE_APP_SERVICE_URL + 'auth/login', param);
            //     const userDatas = res.data;

            //     this.token = res.data.access_token;
            //     localStorage.setItem('token', res.data.access_token);
            //     localStorage.setItem('darkMode', this.$store.state.settings.isDarkMode);
            //     localStorage.setItem('userData', JSON.stringify(userDatas));
            //     localStorage.setItem('isLogin', this.token !== '' ? true : false);
            //     localStorage.setItem('alertSuccessLogin', true);
            //     axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

            //     if (this.token !== '') {
            //         const paramLookup = { params: ['STATUS', 'TYPE', 'HEADER', 'DESC', 'ACCESS', 'LEVEL', 'ACTION', 'FILEPREFIX'] };
            //         const lookupRes = await axios.post(process.env.VUE_APP_SERVICE_URL + 'lookup/detail', paramLookup);
            //         const resulttData = lookupRes ? lookupRes : [];
            //         if (resulttData) {
            //             localStorage.setItem('lookups', JSON.stringify(resulttData.data));
            //             this.$router.push('/').catch(() => { }).then(() => {
            //                 this.$router.go();
            //             });
            //         }
            //     }
            // } catch (error) {
            //     this.alert = true;
            //     this.response.fail = error.response.message;
            // } finally {
            //     this.isCompletedLoad = false;
            // }
        },
        clear() {
            this.$v.$reset();
            this.nip = '';
            this.password = '';
        },
    },
    computed: {
        ...mapGetters(['users', 'settings', 'lookups']),
        nipErrors() {
            const errors = [];
            if (!this.$v.nip.$dirty) return errors;
            !this.$v.nip.maxLength && errors.push('NIP must be at most 18 characters long');
            !this.$v.nip.required && errors.push('NIP is required.');
            return errors;
        },
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) return errors;
            !this.$v.password.maxLength && errors.push('Password must be at most 18 characters long');
            !this.$v.password.required && errors.push('Password is required.');
            return errors;
        },
        isValid() {
            return this.nip === '' || this.password === '';
        },
    },
};
</script>