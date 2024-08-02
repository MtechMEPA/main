<template>
    <div v-if="isLoggedIn">

        <div class="d-lg-none">
            <v-container>
                <v-row>
                    <v-img alt="Vuetify Name" class="col-sm-12 col-md-6 col-lg-12" contain src="../assets/logomepa.png"
                        max-width="20%" />
                    <span class="mx-5">Hi, {{ userLogin.name }}</span>
                    <v-spacer></v-spacer>
                    <div class="text-center d-flex align-center justify-space-around pr-10">


                        <v-btn text
                            :to="userLogin.role == 'admin' ? '/profile-admin' : userLogin.role == 'pemilih' ? '/profile-pemilih' : '/profile-relawan'"
                            class="mx-2">
                            <v-icon>mdi-human-male</v-icon> Profile
                        </v-btn>
                        <v-btn class="mx-2" text to="/logout">
                            <v-icon>mdi-lock</v-icon> Logout

                        </v-btn>
                        <span>|</span>
                        <v-btn small icon @click="toggleDarkMode" class="mx-5">
                            <v-icon class="mx-1">
                                {{ $vuetify.theme.dark ? 'mdi-white-balance-sunny' : 'mdi-moon-waxing-crescent' }}
                            </v-icon>
                            <span v-if="$vuetify.theme.dark">Light</span>
                            <span v-else="$vuetify.theme.dark">Dark</span>
                        </v-btn>
                    </div>
                    <v-col class="text-right col-md-12 col-sm-12">
                        <v-btn :small="styleData.small" v-for="link in renderMenu" :active-class="('cyan--text')"
                            :key="link.name" :to="link.path" text class="my-4" :outlined="link.outlined"
                            v-show="link.isShow">

                            <span>
                                {{ link.name }}
                            </span>
                        </v-btn>
                    </v-col>



                </v-row>
            </v-container>
        </div>

        <!-- Desktop View -->
        <div class="d-none d-lg-block">
            <v-row class="mt-2">

                <v-col md="12" class="text-right pt-0 pb-0">
                    <v-row>
                        <v-spacer></v-spacer>
                        <div class="text-center d-flex align-center justify-space-around pr-10">
                            <span class="mx-5">Hi, {{ userLogin.name }}</span>

                            <v-btn text
                                :to="userLogin.role == 'admin' ? '/profile-admin' : userLogin.role == 'pemilih' ? '/profile-pemilih' : '/profile-relawan'"
                                class="mx-2">
                                <v-icon>mdi-human-male</v-icon> Profile
                            </v-btn>
                            <v-btn class="mx-2" text to="/logout">
                                <v-icon>mdi-lock</v-icon> Logout

                            </v-btn>
                            <span>|</span>
                            <v-btn small icon @click="toggleDarkMode" class="mx-5">
                                <v-icon class="mx-1">
                                    {{ $vuetify.theme.dark ? 'mdi-white-balance-sunny' : 'mdi-moon-waxing-crescent' }}
                                </v-icon>
                                <span v-if="$vuetify.theme.dark">Light</span>
                                <span v-else="$vuetify.theme.dark">Dark</span>
                            </v-btn>
                        </div>
                    </v-row>
                </v-col>
                <v-col class="col-md-3 col-sm-3">
                    <router-link to="/">
                        <v-img alt="Vuetify Name" class="shrink mt-1 hidden-sm-and-down" contain
                            src="../assets/logomepa.png" width="50%" />
                    </router-link>

                </v-col>
                <v-col class="text-right col-md-9 col-sm-9">
                    <v-btn :small="styleData.small" v-for="link in renderMenu" :active-class="('cyan--text')"
                        :key="link.name" :to="link.path" text class="my-4" :outlined="link.outlined"
                        v-show="link.isShow">

                        <span>
                            {{ link.name }}
                        </span>
                    </v-btn>
                </v-col>
            </v-row>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'Header',
    data() {
        return {
            isMobileData: false,
            imageName: '',
            darkMode: false,
            dialog: false,
            menus: [],
            styleData: {
                small: false,
                rounded: true,
                color: 'grey darken-2'
            },
            headerValue: null
        };
    },
    mounted() {
        this.showOverlayLoading();
        setTimeout(() => {
            this.updateHeaderValue();

        }, 1000);
        this.hideOverlayLoading();
    },
    methods: {
        ...mapActions(['showOverlayLoading', 'hideOverlayLoading']),

        updateHeaderValue() {
            this.headerValue = this.userLogin;
        },
        searching() {
            this.dialog = true;
        },
        toggleDarkMode() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            this.darkMode = !this.darkMode;
        },
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'settings', 'username', 'userLogin', 'isOverlayLoading']),
        switchLabel() {
            return this.darkMode ? 'light' : 'dark';
        },
        renderMenu() {
            if (!this.headerValue) {
                return [];
            }

            var level = this.headerValue.role;
            var status = this.headerValue.status;
            const menus = [
                {
                    name: "Home",
                    path: "/",
                    icon: "mdi-home-roof",
                    isShow: ((level == "relawan" || level == 'pemilih' || level == 'admin') ? true : false)
                },
                {
                    name: "Lengkapi Data Pemilih",
                    path: "/completion-pemilih",
                    icon: "mdi-phone",
                    isShow: (level == 'pemilih' && status == 'inactive') ? true : false
                },
                {
                    name: "Lengkapi Data Relawan",
                    path: "/completion-relawan",
                    icon: "mdi-phone",
                    isShow: (level == 'relawan' && status == 'inactive') ? true : false
                },
                {
                    name: "Relawan",
                    path: "/relawan",
                    icon: "mdi-phone",
                    isShow: (level == 'admin' && status == 'active') ? true : false
                },
                {
                    name: "Pemilih",
                    path: "/pemilih",
                    icon: "mdi-phone",
                    isShow: (level == 'relawan' || level == 'admin' && status == 'active') ? true : false
                },

                {
                    name: "Report",
                    path: "/report",
                    icon: "mdi-phone",
                    isShow: (level == 'admin' ? true : false)
                },
            ];
            return menus;
        }
    }
};
</script>
