<template>
    <form>
        <v-card class="mx-auto my-15" max-width="500" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>
                <img src="../assets/login-mail-track.png" alt="" srcset="" width="20%">
                <div class="mx-2">
                    Login <br>Mail Track Minerba
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

                <VTextField v-model="nip" :error-messages="nipErrors" label="NIP" required @input="$v.nip.$touch()">
                </VTextField>
                <VTextField v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" required
                    @input="$v.password.$touch()" @blur="$v.password.$touch()" :type="show1 ? 'text' : 'password'"
                    name="input-10-1" label="Password" :error-messages="passwordErrors" counter
                    @click:append="show1 = !show1"></VTextField>
            </v-card-text>

            <v-card-actions>
                <v-btn :disabled="isValid || isCompletedLoad" text class="mr-4 white--text" color="cyan darken-2"
                    @click="$emit('login', { nip, password })">
                    <v-icon>mdi-lock-outline</v-icon> Login
                </v-btn>
                <v-btn text class="mr-4 white--text" color="blue-grey" @click="$emit('clear')">
                    <v-icon>mdi-cached</v-icon> Clear
                </v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>

<script>
import VTextField from './VTextField.vue';

export default {
    name: 'Login',
    components: {
        VTextField,
    },
    props: {
        nip: String,
        password: String,
        nipErrors: Array,
        passwordErrors: Array,
        isCompletedLoad: Boolean,
        isValid: Boolean,
        alert: Boolean,
        response: Object,
        show1: Boolean,
    },
};
</script>