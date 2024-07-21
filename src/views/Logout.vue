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
        async logout() {
            this.isCompletedLoad = true;
            try {
                await axios.post(process.env.VUE_APP_SERVICE_URL + "auth/logout");

                // Clear localStorage
                localStorage.clear();

                // Set alert response
                this.response.message = "Logout berhasil";
                this.alert = true;

                // Redirect to login page
                setTimeout(() => {
                    this.$router.push("/login").catch(() => { })
                        .then(() => { this.$router.go() });
                }, 1000);


            } catch (error) {
                // Handle error
                localStorage.clear();
                this.response.message = "Logout gagal";
                this.alert = true;
                console.log(error);
                setTimeout(() => {
                    this.$router.push("/login").catch(() => { })
                        .then(() => { this.$router.go() });
                    localStorage.clear();
                }, 1000);
            } finally {
                this.isCompletedLoad = false;
            }
        }
    },
    created() {
        this.logout();
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