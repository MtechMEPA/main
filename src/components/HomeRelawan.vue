<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text--disabled text-center mb-4">
                <h1 class="font-weight-medium">Selamat datang di Aplikasi Relawan Meki Nawipa - MEPA</h1>
                <span class="description d-block" :color="color">Anda masuk sebagai <strong>Relawan</strong></span>
            </v-col>



            <!-- Summary Cards -->
            <div class="text--disabled text-center mb-4">
                <h2 class="font-weight-medium">Data Pemilih yang telah anda himpun</h2>
            </div>
            <v-row>

                <!-- Relawan Card -->
                <v-col cols="12" md="4" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Aktif <v-icon
                                        class="text-h4 text--disabled">mdi-account-check-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total data Pemilih yang sudah anda
                                    verifikasi</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <span class="text-h2">{{ listCountData.totalActive }}</span>

                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Pemilih Card -->
                <v-col cols="12" md="4" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Belum Aktif <v-icon
                                        class="text-h4 text--disabled">mdi-account-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total data Pemilih yang belum anda
                                    verifikasi</v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <span class="text-h2">{{ listCountData.totalInactive }}</span>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Total Card -->
                <v-col cols="12" md="4" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Total Keseluruhan <v-icon
                                        class="text-h4 text--disabled">mdi-database-check-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total keseluruhan data yang anda himpun</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <span class="text-h2">{{ listCountData.totalPemilih }}</span>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
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
    },
    data() {
        return {
            color: "grey darken-2",
            listCountData: {
                totalActive: 0,
                totalInactive: 0,
                totalPemilih: 0
            },
            newRegencies: [], // Array for regency list
            districts: [], // Array for district list
            selectedRegency: null,
            selectedDistrict: null,
            isLoading: false,
            volunteers: [], // Array to store volunteer data
            headerprops: {
                "sort-icon": "mdi-arrow-up"
            },
            headers: [
                { text: 'No', value: 'num' },
                { text: 'Nomor Anggota', value: 'volunteerID' },
                { text: 'Nama', value: 'name' },
                { text: 'Nama Relawan', value: 'volunteerName' },
                { text: 'Total Pemilih', value: 'totalPemilih' },
                { text: 'Total Aktif', value: 'totalActive' },
                { text: 'Total Tidak Aktif', value: 'totalInactive' },
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
        async filterData() {
            this.showOverlayLoading();

            try {
                this.isLoading = true;

                var param = {
                    volunteerName: null,
                    volunteersDistrictID: this.selectedDistrict,
                    volunteersRegencyID: this.selectedRegency,
                };

                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/relawan/statistic", {});
                if (userDetailsRes.data.data) {
                    console.log(this.username);
                    var filterData = userDetailsRes.data.data.filter(val => val.volunteerID == this.username.toUpperCase())[0];
                    this.listCountData.totalActive = filterData.totalActive;
                    this.listCountData.totalInactive = filterData.totalInactive;
                    this.listCountData.totalPemilih = filterData.totalPemilih;
                }

            } catch (error) {
                console.log(error);
            } finally {
                this.isLoading = false;
                this.hideOverlayLoading();
            }
        },
        async loadRegencies() {
            try {
                this.newRegencies = this.regencies;
                this.newRegencies.unshift({ id: null, name: 'All/Semua' });
            } catch (error) {
                console.log(error);
            }
        },
        async loadDistricts() {
            if (this.selectedRegency) {
                try {
                    const response = await axios.get(`${process.env.VUE_APP_SERVICE_URL}districts?regency=${this.selectedRegency}`);
                    this.districts = response.data;
                    this.districts.unshift({ id: null, name: 'All/Semua' });
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.districts = [];
            }
        },
        async getVolunteers() {
            this.showOverlayLoading();
            try {
                const relawanData = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/relawan/statistic", {});

                if (relawanData.data && relawanData.data.data) {
                    this.volunteers = relawanData.data.data.filter(val => val.volunteerID == this.username);
                }
                console.log(this.volunteers);
            } catch (error) {
                console.log(error);
            } finally {
                this.hideOverlayLoading();
            }
        },
        onRegencyChange(regencyId) {
            const regency = this.regencies.find(reg => reg.id === regencyId);
            this.districts = regency ? regency.districts : [];
            this.districts.unshift({ id: null, name: 'All/Semua' });
            this.district = null; // Reset the selected district
        }
    },
    async created() {
        await this.filterData();
        // await this.getVolunteers(); // Fetch volunteer data on created
    },
    async mounted() {
        await this.loadRegencies();
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
</style>
