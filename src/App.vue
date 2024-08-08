<template>
  <v-app dark>

    <LoadingOverlay />
    <v-container>
      <C_Header v-if="isLogin" />
      <AlertComponent />
      <router-view />
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios';
import C_Header from '@/components/C_Header.vue';
import Footers from '@/components/C_Footer.vue';
import { mapGetters, mapActions } from 'vuex';
import LoadingOverlay from '@/components/LoadingOverlay.vue';
import AlertComponent from '@/components/AlertComponent.vue';



export default {
  name: "app",
  components: {
    C_Header,
    Footers,
    LoadingOverlay,
    AlertComponent
  },
  data() {
    return {
      alertVisible: false,
      alertMessage: '',
      isCompletedLoad: false
    };
  },
  computed: {
    ...mapGetters(['isLoggedIn', 'username', 'isOverlayLoading', 'userLogin']),

    isLogin() {
      var status = false;
      if (this.isLoggedIn) {
        status = true;
      }
      return status;
    }
  },
  methods: {
    ...mapActions(['showOverlayLoading', 'hideOverlayLoading', 'setUserData', 'updateDialog']),

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
    },
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
