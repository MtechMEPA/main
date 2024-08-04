<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text--disabled text-center mb-4">
                <h1 class="font-weight-medium">Selamat datang di Aplikasi Relawan Meki Nawipa - MEPA</h1>
                <span class="description d-block" :color="color">Anda masuk sebagai <strong>Admin</strong></span>
            </v-col>

            <!-- Filter Section -->
            <v-row class="mb-4">
                <v-col cols="12">
                    <v-card>
                        <v-row class="py-2 px-2">
                            <v-col md="5" sm="5">
                                <v-select v-model="selectedRegency" :items="newRegencies" label="Kabupaten/Kota"
                                    item-text="name" item-value="id" @change="onRegencyChange" outlined
                                    dense></v-select>
                            </v-col>
                            <v-col md="5" sm="5">
                                <v-select v-model="selectedDistrict" :items="districts" label="Kecamatan"
                                    item-text="name" item-value="id" outlined dense></v-select>
                            </v-col>
                            <v-col md="2" sm="2">
                                <v-btn color="cyan darken-2" @click="filterData" class="white--text">Filter</v-btn>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>

            <!-- Summary Cards -->
            <v-row>
                <!-- Relawan Card -->
                <v-col cols="12" md="4" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Relawan <v-icon
                                        class="text-h4 text--disabled">mdi-account-check-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total data Relawan</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-row class="mb-2">
                                        <v-col> Aktif:
                                            <v-chip color="cyan" class="ma-1">
                                                {{ listCountData.totalRelawanActive }}
                                            </v-chip>
                                        </v-col>
                                        <v-col> Belum Aktif:
                                            <v-chip color="orange" class="ma-1">
                                                {{ listCountData.totalRelawanInactive }}
                                            </v-chip>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Pemilih Card -->
                <v-col cols="12" md="4" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Pemilih <v-icon
                                        class="text-h4 text--disabled">mdi-account-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total data Pemilih</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-row class="mb-2">
                                        <v-col> Aktif:
                                            <v-chip color="cyan" class="ma-1">
                                                {{ listCountData.totalPemilihActive }}
                                            </v-chip>
                                        </v-col>
                                        <v-col> Belum Aktif:
                                            <v-chip color="orange" class="ma-1">
                                                {{ listCountData.totalPemilihInactive }}
                                            </v-chip>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Total Card -->
                <v-col cols="12" md="4" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Total Relawan+Pemilih <v-icon
                                        class="text-h4 text--disabled">mdi-database-check-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total Relawan+Pemilih Aktif dan tidak</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-row class="mb-2">
                                        <v-col> Data Data Belum Terverifikasi semua
                                            <v-chip color="green" class="ma-1">
                                                {{ listCountData.totalAll }}
                                            </v-chip>
                                        </v-col>

                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="12" class="mb-4">
                    <v-card class="mx-auto">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">Total Keseluruhan <v-icon
                                        class="text-h4 text--disabled">mdi-database-check-outline</v-icon></v-list-item-title>
                                <v-list-item-subtitle>Total keseluruhan data dari semua Relawan</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-row class="mb-2">
                                        <v-col> Data Terverifikasi
                                            <v-chip color="green" class="ma-1">
                                                {{ listCountData.totalActive }}
                                            </v-chip>
                                        </v-col>

                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <!-- Tabel untuk menampilkan data volunteer -->
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        <v-toolbar flat>
                            <v-toolbar-title>Pencapaian Relawan</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" label="Cari" append-icon="mdi-magnify" class="mx-4"
                                hide-details></v-text-field>
                        </v-toolbar>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="filteredVolunteers" disable-pagination multi-sort
                        :headerProps="headerprops" :items-per-page="filteredVolunteers.length" hide-default-footer
                        class="elevation-1 table-style">

                        <!-- Item slots -->
                        <template v-slot:item.num="{ index }">
                            {{ index + 1 }}
                        </template>
                        <template v-slot:item.totalPemilih="{ item }">
                            <v-chip :color="item.totalPemilih > 0 ? 'cyan' : ''">
                                {{ item.totalPemilih }}
                            </v-chip>
                        </template>
                        <template v-slot:item.totalActive="{ item }">
                            <v-chip :color="item.totalActive > 0 ? 'green' : ''">
                                {{ item.totalActive }}
                            </v-chip>
                        </template>
                        <template v-slot:item.totalInactive="{ item }">
                            <v-chip :color="item.totalInactive > 0 ? 'orange' : ''">
                                {{ item.totalInactive }}
                            </v-chip>
                        </template>

                        <!-- Footer slot for total summary -->
                        <template v-slot:body.append>
                            <tr>
                                <td class="text-right" colspan="4"><strong>Total:</strong></td>
                                <td class="text-left"><strong>{{ totalPemilih }}</strong></td>
                                <td class="text-left"><strong>{{ totalActive }}</strong></td>
                                <td class="text-left"><strong>{{ totalInactive }}</strong></td>
                            </tr>
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
        totalPemilih() {
            return this.filteredVolunteers.reduce((acc, volunteer) => acc + Number(volunteer.totalPemilih), 0);
        },
        totalActive() {
            return this.filteredVolunteers.reduce((acc, volunteer) => acc + Number(volunteer.totalActive), 0);
        },
        totalInactive() {
            return this.filteredVolunteers.reduce((acc, volunteer) => acc + Number(volunteer.totalInactive), 0);
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
                { text: 'Total Pemilih', value: 'totalPemilih' },
                { text: 'Total Aktif', value: 'totalActive' },
                { text: 'Total Belum Aktif', value: 'totalInactive' },
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
                    this.listCountData.totalPemilihInactive = listData.totalPemilihInactive;
                    this.listCountData.totalRelawanInactive = listData.totalRelawanInactive;
                    this.listCountData.totalAll = (
                        Number(listData.totalRelawanActive) + Number(listData.totalRelawanInactive)
                    ) + (
                            Number(listData.totalPemilihActive) + Number(listData.totalPemilihInactive)
                        );

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

.table-style {
    margin-bottom: 16px;
}
</style>
