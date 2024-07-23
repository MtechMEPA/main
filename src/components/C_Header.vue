<template>
    <div>
        <!-- Mobile View -->
        <div class="d-lg-none">
            <v-container>
                <v-row>
                    <!-- Logo -->
                    <v-img alt="Vuetify Name" v-if="settings.screenSize.type.islg" contain src="../assets/logomepa.png"
                        width="100%" max-width="30%" />
                    <v-img alt="Vuetify Name" v-if="settings.screenSize.type.ismd" max-width="10%" contain
                        src="../assets/logomepa.png" width="100%" />
                    <v-img alt="Vuetify Name" v-else contain src="../assets/logomepa.png" width="100%"
                        max-width="15%" />
                    <v-spacer></v-spacer>
                    <template>
                        <div class="my-5">
                            <span class="mr-5">Hi, {{ userDeta.name }}</span>
                            <v-btn icon @click="toggleDarkMode" class="mr-5">
                                <v-icon>
                                    {{ $vuetify.theme.dark ? 'mdi-white-balance-sunny' : 'mdi-moon-waxing-crescent' }}
                                </v-icon>
                            </v-btn>
                            <v-menu transition="slide-x-transition" bottom right offset-y>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn v-bind="attrs" v-on="on" small icon>
                                        <v-icon>mdi-cog-outline</v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-list-item to="/profile">
                                        <v-icon class="pr-3">mdi-account-cog-outline</v-icon>Profile
                                    </v-list-item>
                                    <v-list-item to="/logout">
                                        <v-icon class="pr-3">mdi-logout-variant</v-icon>Logout
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </template>
                </v-row>
            </v-container>
        </div>

        <!-- Desktop View -->
        <div class="d-none d-lg-block">
            <v-row class="mt-2">
                <v-col md="4" class="text-left pt-0 pb-0">
                    <v-img alt="Vuetify Name" contain src="../assets/logomepa.png" width="30%" />
                </v-col>
                <v-col md="8" class="text-right pt-0 pb-0">
                    <v-row>
                        <v-spacer></v-spacer>
                        <div class="text-center d-flex align-center justify-space-around pr-10">
                            <span class="pr-15">Hi, {{ userDeta.name }}</span>
                            <v-btn small icon @click="toggleDarkMode" class="mx-5">
                                <v-icon>
                                    {{ $vuetify.theme.dark ? 'mdi-white-balance-sunny' : 'mdi-moon-waxing-crescent' }}
                                </v-icon>
                            </v-btn>
                            <v-menu transition="slide-x-transition" bottom right offset-y>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn v-bind="attrs" v-on="on" small icon>
                                        <v-icon>mdi-cog-outline</v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-list-item to="/profile">
                                        <v-icon class="pr-3">mdi-account-cog-outline</v-icon>Profile
                                    </v-list-item>
                                    <v-list-item to="/logout">
                                        <v-icon class="pr-3">mdi-logout-variant</v-icon>Logout
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </v-row>
                </v-col>
            </v-row>
            <div class="mt-2">
                <v-alert dense dark close-icon="mdi-close-circle-outline" color="cyan darken-1"
                    v-show="alertSuccessLogin" elevation="2" icon="mdi-information-outline" border="left" dismissible
                    transition="scale-transition">
                    Hi <strong>{{ userDeta.name }}</strong> Selamat datang di Meki Nawipa - MEPA
                </v-alert>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';

export default {
    name: 'Header',
    data() {
        return {
            isDisabledJabatan: true,
            alertSuccessLogin: false,
            isMobileData: false,
            imageName: '',
            darkMode: false,
            dialog: false,
            menu: {},
            styleData: {
                small: false,
                rounded: true,
                color: 'grey darken-2'
            },
            users: [],
            listDataRiwajatRole: [],
            dialogRole: false,
            selectedItemRole: '',
            isOverlayLoading: true,
            selectedRole: [],
            selectedRoleValue: '',
            userDeta: {}
        };
    },
    created() {
        this.userDeta = this.$store.state.auth['userDetails'];
    },
    methods: {
        searching() {
            this.dialog = true;
        },
        toggleDarkMode() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            this.darkMode = !this.darkMode;
        }
    },
    computed: {
        ...mapState(['isLoggedIn', 'userDetails', 'settings']),
        switchLabel() {
            return this.darkMode ? 'light' : 'dark';
        }
    }
};
</script>