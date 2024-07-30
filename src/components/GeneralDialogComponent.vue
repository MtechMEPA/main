<template>
  <div class="mt-5">
    <v-alert v-if="isShowDialog" text dense close-icon="mdi-close-circle-outline" :color="dialogData.color"
      elevation="2" icon="mdi-information-outline" border="left" dismissible transition="scale-transition"
      @click="closeDialog">
      {{ dialogData.title }} - {{ dialogData.details }}
    </v-alert>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['isShowDialog', 'dialogData'])
  },
  methods: {
    closeDialog() {
      this.$store.dispatch('setDialog', {
        isShowDialog: false,
        title: '',
        details: '',
        color: ''
      });
    }
  }
};
</script>
