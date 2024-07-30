<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text--disabled">
                <h1 class="font-weight-medium text-center">Selamat datang di Meki Nawipa - MEPA</h1>
                <span class="description text-center d-block" :color="color">Anda masuk sebagai Pemilih</span>
            </v-col>

            <v-col cols="12" md="4">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">Relawan</v-list-item-title>
                            <v-list-item-subtitle>Total data relawan</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalInbox }}</v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-email-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="4">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">Data Pemilih</v-list-item-title>
                            <v-list-item-subtitle>Total data pemilih yang telah anda himpun</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">{{ listCountData.totalOutbox }}</v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-email-fast-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="4">
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
import moment from 'moment';
import { mapState } from "vuex";

export default {
    name: "Hero",
    computed: {
        ...mapState(['settings'])
    },
    data() {
        return {
            color: "grey darken-2",
            listCountData: {
                totalInbox: 0,
                totalOutbox: 0,
                totalNadine: 0,
            },
            isLoading: false,
            isOverlayLoading: false,
        }
    },
    methods: {
        async getData() {
            try {
                await axios.get(process.env.VUE_APP_SERVICE_URL + "employee");
            } catch (error) {
                this.isLoading = false;
            }
        },
        async getCountPage() {
            try {
                this.isOverlayLoading = true;
                this.isLoading = true;
                var response = await axios.get(process.env.VUE_APP_SERVICE_URL + "countPages", { params: { employeeId: this.users.employeeId } });
                var listData = !!response ? response.data[0] : [];
                if (listData) {
                    this.listCountData.totalInbox = listData.totalInbox;
                    this.listCountData.totalOutbox = listData.totalOutbox;
                    this.listCountData.totalNadine = listData.totalNadine;
                }
            } catch (error) {
            }
        }
    },
    async created() {
        // await this.$store.dispatch('setDialog', {
        //             isShowDialog: true,
        //             title: 'Berhasil Login',
        //             details: 'Silahkan menggunakan menu yang ada sebagaimana mestinya',
        //             color: "cyan darken-2"
        //         });

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