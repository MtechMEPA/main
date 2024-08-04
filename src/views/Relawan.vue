<template>
    <v-container fluid>
        <v-row>
            <!-- Tabel untuk menampilkan data volunteer -->
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        <v-toolbar flat>
                            <v-toolbar-title>Data Relawan <v-icon
                                    class="text-h4 text--disabled">mdi-account-multiple-outline</v-icon></v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" label="Pencarian" append-icon="mdi-magnify" class="mx-4"
                                hide-details></v-text-field>
                        </v-toolbar>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="filteredVolunteers" multi-sort :headerProps="headerprops"
                        class="elevation-1 table-style" :loading="isLoading"
                        :loading-text="isLoading ? 'Loading... Please wait' : ''" @click:row="rowClick" :footer-props="{
                                showFirstLastPage: true,
                                firstIcon: 'mdi-arrow-collapse-left',
                                lastIcon: 'mdi-arrow-collapse-right',
                                prevIcon: 'mdi-minus',
                                nextIcon: 'mdi-plus'
                            }">

                        <!-- Item slots -->
                        <template v-slot:item.num="{ index }">
                            {{ index + 1 }}
                        </template>
                        <template v-slot:item.statusName="{ item }">
                            <v-chip dark :color="item.statusName == 'Terverifikasi' ? 'green' : 'orange'">
                                {{ item.statusName }}
                                <v-icon class="ml-2"
                                    v-if="item.statusName == 'Terverifikasi'">mdi-check-circle-outline</v-icon>
                            </v-chip>
                        </template>

                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Hero",
    computed: {
        ...mapGetters(['isLoggedIn', 'username', 'userData', 'token', 'regencies', 'isOverlayLoading', 'userLogin']),
        filteredVolunteers() {
            if (!this.search) return this.volunteers;
            return this.volunteers.filter(volunteer => {
                const searchLower = this.search.toLowerCase();
                return Object.keys(volunteer).some(key =>
                    String(volunteer[key]).toLowerCase().includes(searchLower)
                );
            });
        },
    },
    data() {
        return {
            color: "grey darken-2",
            listCountData: {
                totalRelawanActive: 0,
                totalPemilihActive: 0,
                totalActive: 0,
                totalRelawanInactive: 0,
                totalPemilihInactive: 0,
                totalAll: 0
            },
            newRegencies: [], // Array for regency list
            districts: [], // Array for district list
            selectedRegency: null,
            selectedDistrict: null,
            isLoading: false,
            volunteers: [], // Array to store volunteer data
            search: '',
            headerprops: {
                "sort-icon": "mdi-arrow-up"
            },
            headers: [
                { text: 'No', value: 'num' },
                { text: 'Nomor Anggota', value: 'volunteerID' },
                { text: 'Nama', value: 'name' },
                { text: 'Nama Relawan', value: 'volunteerName' },
                { text: 'Status', value: 'statusName' },
            ],
        }
    },
    methods: {
        ...mapActions(['showOverlayLoading', 'hideOverlayLoading']),

        async getData() {
            try {
                await axios.get(process.env.VUE_APP_SERVICE_URL + "search/statistic");
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        },
        rowClick(row) {
            console.log(row);
        },
        async getVolunteers() {
            this.showOverlayLoading();
            try {
                // Jika login berhasil, panggil API search/user
                const userDetailsParam = { "role": 'relawan' };
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/userByID", userDetailsParam);
                this.volunteers = userDetailsRes.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.hideOverlayLoading();
            }
        },
    },
    async created() {
        await this.getVolunteers(); // Fetch volunteer data on created
    },
    async mounted() {
        // await this.loadRegencies();
    }
}
</script>
<style scoped>
.intro-text {
    font-size: 40px;
    font-weight: 600;
    font-family: 'Roboto';
    line-height: 40pt;
}

p.description {
    font-size: 19px;
    margin: 32px 0px;
}

.errorColor {
    background-color: #FFCDD2 !important;
}

#table>.v-data-footer .v-icon {
    color: black !important;
}

.table-style>>>tbody tr:hover {
    cursor: pointer;
    background: #0097A7 !important;
    color: white;
}

@media (max-width: 600px) {
    .intro-text {
        font-size: 24px;
    }

    p.description {
        font-size: 16px;
    }

    .text-h5 {
        font-size: 18px;
    }

    .text-h2 {
        font-size: 24px;
    }
}

.table-style {
    margin-bottom: 16px;
}
</style>
