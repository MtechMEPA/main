<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text--disabled text-center mb-4">
                <h1 class="font-weight-medium">Selamat datang di Meki Nawipa - MEPA</h1>
                <span class="description d-block" :color="color">Anda masuk sebagai Admin</span>
            </v-col>

            <v-col cols="12" class="mb-4">
                <v-card>
                    <v-row class="py-2 px-2">
                        <v-col class="col-md-5 col-sm-5">
                            <v-select v-model="selectedRegency" :items="newRegencies" label="Kabupaten/Kota"
                                item-text="name" item-value="id" @change="onRegencyChange" outlined dense></v-select>
                        </v-col>
                        <v-col class="col-md-5 col-sm-5">
                            <v-select v-model="selectedDistrict" :items="districts" label="Kecamatan" item-text="name"
                                item-value="id" outlined dense></v-select>
                        </v-col>
                        <v-col class="col-md-2 col-sm-2">
                            <v-btn color="cyan darken-2" @click="filterData" class="white--text">Filter</v-btn>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>

            <v-col cols="12" md="4" class="mb-4">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                Relawan
                                <v-btn to="/relawan" color="cyan" small text>Lihat</v-btn>
                            </v-list-item-title>
                            <v-list-item-subtitle>Total data Relawan Terverifikasi</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalRelawanActive }}</v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-email-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="4" class="mb-4">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                Pemilih
                                <v-btn to="/pemilih" color="cyan" small text>Lihat</v-btn>
                            </v-list-item-title>
                            <v-list-item-subtitle>Total data Pemilih Terverifikasi</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalPemilihActive }}</v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-email-fast-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="4" class="mb-4">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">Total</v-list-item-title>
                            <v-list-item-subtitle>Total keseluruhan data</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalActive }}</v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-database-check-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

            <!-- Tabel untuk menampilkan data volunteer -->
            <v-col cols="12" class="mb-4">
                <v-data-table :headers="headers" :items="volunteers" class="elevation-1" disable-pagination>
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title>Data Relawan</v-toolbar-title>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.status="{ item }">
                        <v-chip :color="item.status === 'active' ? 'green' : 'red'" dark>{{ item.status }}</v-chip>
                    </template>
                    <template v-slot:item.index="{ index }">
                        {{ index + 1 }}
                    </template>
                </v-data-table>
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
    },
    data() {
        return {
            color: "grey darken-2",
            listCountData: {
                totalRelawanActive: 0,
                totalPemilihActive: 0,
                totalActive: 0,
            },
            newRegencies: [], // Array for regency list
            districts: [], // Array for district list
            selectedRegency: null,
            selectedDistrict: null,
            isLoading: false,
            volunteers: [], // Array to store volunteer data
            headers: [
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

                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/statistic", param);
                const listData = userDetailsRes.data.data[0];
                if (listData) {
                    this.listCountData.totalRelawanActive = listData.totalRelawanActive;
                    this.listCountData.totalPemilihActive = listData.totalPemilihActive;
                    this.listCountData.totalActive = listData.totalActive;
                    console.log(this.listCountData);
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
                this.volunteers = relawanData.data.data;
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
        await this.getVolunteers(); // Fetch volunteer data on created
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
