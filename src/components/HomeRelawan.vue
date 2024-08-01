<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text--disabled text-center mb-4">
                <h1 class="font-weight-medium">Selamat datang di Meki Nawipa - MEPA</h1>
                <span class="description d-block" :color="color">Anda masuk sebagai Relawan</span>
            </v-col>

            <v-col cols="12" md="4" class="mb-4">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                Pemilih
                                <v-btn to="/relawan" color="cyan" small text>Lihat</v-btn>
                            </v-list-item-title>
                            <v-list-item-subtitle>Total data Pemilih Terverifikasi</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalOutbox }}</v-col>
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
                            <v-list-item-subtitle>Total data Pemilih Belum Terverifikasi</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalInbox }}</v-col>
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
                            <v-col class="text-h2" cols="8">{{ listCountData.totalNadine }}</v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-database-check-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
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
    },
    data() {
        return {
            color: "grey darken-2",
            listCountData: {
                totalInbox: 0,
                totalOutbox: 0,
                totalNadine: 0,
            },
            newRegencies: [], // Array for regency list
            districts: [], // Array for district list
            selectedRegency: null,
            selectedDistrict: null,
            isLoading: false,
            // isOverlayLoading: false,
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
                    volunteerID: null,
                    volunteerName: null,
                    volunteersDistrictID: this.selectedDistrict,
                    volunteersRegencyID: this.selectedRegency,
                };

                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/statistic", param);
                var listData = userDetailsRes.data.data[0];

                if (listData) {
                    this.listCountData.totalInbox = listData.totalInactive;
                    this.listCountData.totalOutbox = listData.totalPemilihActive;
                    this.listCountData.totalNadine = (listData.totalInactive + listData.totalPemilihActive);
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

                this.newRegencies = this.regencies;;
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
        // async filterData() {
        //     // Implement the filter logic here
        //     console.log('Filter clicked', this.selectedRegency, this.selectedDistrict);
        // },
        onRegencyChange(regencyId) {
            const regency = this.regencies.find(reg => reg.id === regencyId);
            this.districts = regency ? regency.districts : [];
            this.districts.unshift({ id: null, name: 'All/Semua' });
            this.district = null; // Reset the selected district
        }
    },
    async created() {
        await this.filterData();
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
