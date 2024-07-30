<template>
    <v-overlay :value="isOverlayLoading" z-index="2000">
        <v-progress-circular indeterminate color="white" size="70"></v-progress-circular>
    </v-overlay>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'isOverlayLoading',
    computed: {
        ...mapGetters(['isOverlayLoading']),
    },
};
</script>

<style scoped>
/* Optional styling for the loading overlay */
</style>