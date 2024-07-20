<template>
  <v-app dark>
    <v-alert v-if="alertVisible" text dense close-icon="mdi-close-circle-outline" color="cyan darken-2" elevation="2"
      icon="mdi-information-outline" border="left" dismissible transition="scale-transition"
      @click:close="alertVisible = false">
      {{ alertMessage }}
    </v-alert>
    <v-container>
      <C_Header v-if="isLoggedIn" />
      <router-view />
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios';
import C_Header from '@/components/C_Header.vue';
import Footers from '@/components/C_Footer.vue';
import { mapGetters } from 'vuex';

export default {
  name: "app",
  data() {
    return {
      alertVisible: false,
      alertMessage: '',
      isCompletedLoad: false
    };
  },
  computed: {
    ...mapGetters(['isLoggedIn', 'username']),
    isLogin() {
      var status = false;
      if (localStorage.getItem('token') != null) {
        status = true;
      }
      console.log(status);
      return status;
    },
    initDataAfterLogin() {
      return localStorage.getItem('successLogin') === 'true';
    }
  },
  methods: {
    async logout() {
      this.isCompletedLoad = true;
      try {
        await axios.post(process.env.VUE_APP_SERVICE_URL + "auth/logout");

        // Clear localStorage
        localStorage.removeItem('token');
        localStorage.removeItem('successLogin');

        // Set alert response
        this.alertMessage = "Logout berhasil";
        this.alertVisible = true;

        // Redirect to login page
        setTimeout(() => {
          this.$router.push("/login");
        }, 1500); // Delay for alert visibility

      } catch (error) {
        // Handle error
        this.alertMessage = "Logout gagal";
        this.alertVisible = true;
        console.log(error);
      } finally {
        this.isCompletedLoad = false;
      }
    },
    onScroll(e) {
      if (typeof window === 'undefined') return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.fab = top > 20;
    },
    toTop() {
      this.$vuetify.goTo(0)
    },
    isMobile() {
      return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    },
    setMobileDeviceSettings() {
      const datas = { isMobileData: this.isMobile() };
      this.$store.dispatch('settings', datas);
    }
  },
  watch: {
    $route: {
      immediate: true,
      handler(to, from) {
        document.title = to.meta.title || 'Meki Nawipa - MEPA';
      }
    }
  },
  created() {
    this.setMobileDeviceSettings();
    if (this.initDataAfterLogin) {
      // Optionally do something after login
    }
  },
  components: {
    C_Header,
    Footers
  }
}
</script>

<style lang="css" scoped>
.on-hover {
  transition: all 0.5s ease;
}

.hero {
  background: url('./assets/mepaheader.jpg');
  background-size: cover;
  background-position-y: center;
  background-position-x: left;
  height: 45vh;
}
</style>
