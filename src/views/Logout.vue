<template>
    <v-card-text class="text--primary">
        <v-alert text dense close-icon="mdi-close-circle-outline" color="cyan darken-2" v-model="alert" elevation="2"
            icon="mdi-information-outline" border="left" dismissible transition="scale-transition">
            {{ response.message }}
        </v-alert>
    </v-card-text>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';


export default {
    data() {
        return {
            isCompletedLoad: false,
            alert: false,
            response: {
                message: ""
            }
        }
    },
    methods: {
        ...mapActions(['showOverlayLoading', 'hideOverlayLoading']),

        async logout() {

            try {

                await this.$store.dispatch('setDialog', {
                    isShowDialog: true,
                    title: 'Berhasil Logout',
                    details: 'Berhasil logout',
                    color: "cyan darken-2"
                });
                this.$store.dispatch('logout');
                this.$router.push('/login').catch(() => { });

            } catch (error) {
                // Handle error
                localStorage.clear();
                this.response.message = "Logout gagal";
                this.alert = false;
                setTimeout(() => {
                    this.$router.push("/login").catch(() => { })
                        .then(() => { this.$router.go() });
                    localStorage.clear();
                }, 1000);
            } finally {

                this.$store.dispatch('logout');

            }
        }
    },
    computed: {
        ...mapGetters(['users', 'settings', 'lookups', 'isOverlayLoading'])
    },
    async mounted() {
        await this.logout();
    }
}
</script>

<style scoped>
.logout-btn {
    background-color: #1E88E5;
    /* Ganti dengan warna yang diinginkan */
}

.v-card-actions {
    display: flex;
    justify-content: space-between;
}
</style>
<style scoped>
.v-alert {
    margin: 16px 0;
}
</style>