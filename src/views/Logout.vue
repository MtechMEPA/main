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
            this.showOverlayLoading();
            try {
                await axios.post(process.env.VUE_APP_SERVICE_URL + "auth/logout");
                await this.$store.dispatch('setDialog', {
                    isShowDialog: true,
                    title: 'Sukses',
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
            } finally {
                this.hideOverlayLoading();
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