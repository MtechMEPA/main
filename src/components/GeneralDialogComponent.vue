<template>
  <v-dialog v-model="isShowDialog" scrollable persistent width="600px">
    <v-card>
      <v-card-title>{{ dialogData.title || 'Default Title' }}
        <v-spacer></v-spacer>
        <v-btn :color="settings.color" icon class="white--text" @click="closeDialog">
          <v-icon>
            mdi-close
          </v-icon>
        </v-btn>
      </v-card-title>
      <v-divider></v-divider>
      <v-card-text>
        <div v-if="hasDetails">
          <v-simple-table>
            <tbody>
              <tr v-for="(value, key) in dialogData.details" :key="key">
                <td><strong>{{ formatLabel(key) }}</strong></td>
                <td>{{ formatValue(key, value) }}</td>
              </tr>
            </tbody>
          </v-simple-table>
        </div>
        <div v-else>
          No details available.
        </div>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-btn :color="settings.color" @click="closeDialog" class="white--text" text>
          OK
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      dialogData: 'getDialogData',
      isShowDialog: 'isDialogVisible'
    }),
    hasDetails() {
      return this.dialogData.details && Object.keys(this.dialogData.details).length > 0;
    }
  },
  methods: {
    closeDialog() {
      this.$store.dispatch('updateDialog', {
        isShowDialog: false,
        data: {
          title: '',
          details: {}
        }
      });
    },
    formatLabel(key) {
      const labels = {
        volunteerID: 'Nomor Anggota',
        name: 'Nama',
        phone: 'Tlp/WhatsApp',
        email: 'Email',
        role: 'Jenis'
      };
      return labels[key] || key;
    },
    formatValue(key, value) {
      if (key === 'role') {
        return value.toUpperCase();
      }
      return value;
    }
  }
};
</script>

<style scoped>
td {
  padding: 8px;
}
</style>
