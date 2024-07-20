<template>
    <v-row>
        <v-col lg="12" class="text--disabled">
            <h1 class="font-weight-medium">Selamat datang di Meki Nawipa - MEPA</h1>
            <span class="description" :color="color">Sebuah tools yang dirancang untuk membantu proses penelusuran
                data Relawan dan Pemilih Loyal Meki Nawipa</span>

        </v-col>
        <v-col cols="4">
            <template>
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                Relawan
                            </v-list-item-title>
                            <v-list-item-subtitle>Total data relawan</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">
                                {{ listCountData.totalInbox }}
                            </v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-email-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </template>
        </v-col>

        <v-col cols="4">
            <template>
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                Pemilih
                            </v-list-item-title>
                            <v-list-item-subtitle>Total data pemilih</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">
                                {{ listCountData.totalOutbox }}
                            </v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-email-fast-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </template>
        </v-col>

        <v-col cols="4">
            <template>
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                Total
                            </v-list-item-title>
                            <v-list-item-subtitle>Total keseluruhan data</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-card-text>
                        <v-row align="center">
                            <v-col class="text-h2" cols="8">
                                {{ listCountData.totalNadine }}
                            </v-col>
                            <v-col cols="4">
                                <v-icon class="text-h2 text--disabled">mdi-database-check-outline</v-icon>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </template>
        </v-col> 
    </v-row>
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
            searchValue: "",
            search: "",
            headerprops: {
                "sort-icon": "mdi-arrow-up"
            },
            headers: [
                { text: 'No', value: 'num' },
                { text: 'No.Agenda', value: 'nomorAgenda' },
                { text: 'Tgl.Penerimaan', value: 'tglPenerimaanDisplayText' },
                { text: 'No.Surat', value: 'nomorSurat' },
                { text: 'Tgl.Surat', value: 'tglSuratDisplayText' },
                { text: 'Sifat Surat', value: 'sifatSurat' },
                { text: 'Dari', value: 'dari' },
                { text: 'Kepada', value: 'kepada', width: '15%' },
                { text: 'Isi Ringkasan', value: 'isiRingkasan' },
                { text: 'Keterangan', value: 'keterangan', width: '10%' },
                { text: 'Uploader', value: 'unitUploader', width: '5%' },
                { text: 'Duplication', value: 'isUnknown', width: '5%' },

            ],
            listCountData: {
                totalInbox: 0,
                totalOutbox: 0,
                totalNadine: 0,
            },
            listData: [],
            isLoading: false,
            isOverlayLoading: false,
            filter: {
                range: true,
                sifatSurat: "",
                noAgenda: "",
                noSurat: "",
                dari: "",
                kepada: "",
                ket: "",
                isiRingkasan: "",
                dateActionTerima: [],
                dateActionSurat: [],
                tglTerimaStart: "",
                tglTerimaEnd: "",
                tglSuratStart: "",
                tglSuratEnd: "",
                modalDateTglTerima: null,
                modalDateTglSurat: null,
                searchingParams: [],
                unknownModelData: "",
                listUploaderData: ""
            },
            isShowTable: false,
            historyListData: {
                header: [],
                subHeader: []
            },
            isOverlayLoading: false,
            trackingId: "",
            dialogDetail: false,
            detailDataRow: [],
            loadingUploadButton: false
        }
    },
    methods: {
        async getData() {
            try {
                await axios.get(process.env.VUE_APP_SERVICE_URL + "employee");
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        },
        async getTracking() {
            try {
                this.isOverlayLoading = true;
                this.isLoading = true;
                var remappingParam = {
                    employeeId: this.users.employeeId
                };
                this.filter.searchingParams = remappingParam;

                var response = await axios.get(process.env.VUE_APP_SERVICE_URL + "tracking", { params: { searchingParams: this.filter.searchingParams } });
                this.listData = !!response ? response.data : [];
                const state = {
                    tracking: !!response ? response.data : [],
                    tempTracking: [],
                    totalOriginalData: 0
                }
                this.$store.dispatch('trackings', state);
                this.isShowTable = true;
                this.isLoading = false;
                this.isOverlayLoading = false;
            } catch (error) {
                console.log(error);
                this.isLoading = false;
                this.responseAlert.message = 'Something wrong, please refresh the page to fix this issue. detail : ' + error.message;
                this.responseAlert.color = "red";
                this.isShowAlert = true;
                this.isOverlayLoading = false;
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
        },
        rowClick(row) {
            this.detailDataRow = row;
            this.date = moment(String(row.receiptDate)).format('YYYY-MM-DD');
            this.userDefault = this.users.name;
            this.trackingId = row.trackingId;
            this.dialogDetail = true;
            this.getHistoryHeader();
        },
        async getHistoryHeader() {
            try {
                this.isOverlayLoading = true;
                this.loadingUploadButton = true;
                var response = await axios.get(process.env.VUE_APP_SERVICE_URL + 'history', { params: { trackingId: this.trackingId } });
                var dataVal = !!response ? response.data : [];

                this.historyListData.header = dataVal.header;
                this.historyListData.subHeader = dataVal.headerDetail;
                this.isOverlayLoading = false;
            } catch (error) {
                console.log(error);
                this.isOverlayLoading = false;
            }
        },
        momentJsFormating(dateValue, dateType) {
            moment.locale('id');
            var newDate = "";
            if (dateType == 1) {
                newDate = moment(dateValue).format("dddd,Do MMMM YYYY, HH:mm");
            } else if (dateType == 2) {
                newDate = moment(dateValue).format("dddd,Do MMMM YYYY");
            }
            return newDate;
        },
        detailHistory(item) {
            // Returns true to show content for completed steps, false for others
            return this.historyListData.subHeader.filter((e) => e.unitFrom === item.unitFromCode)
                .map((e) => { return e });
        },
    },
    async created() {
        var listData = JSON.parse(localStorage.getItem('userData'));
        this.users = listData != undefined && listData.user ? listData.user : [];
        await this.getData();
        await this.getCountPage();
    }
}
</script>

<style lang="css" scoped>
.intro-text {
    font-size: 40px;
    font-weight: 600;
    font-family: 'Roboto';
    line-height: 40pt;
    /* color: #444444ba; */
}

p.description {
    font-size: 19px;
    margin: 32px 0px;
    /* color: #444444ba; */

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
</style>