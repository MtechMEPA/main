<template>

    <HomePemilih v-if="userLogin && userLogin.role == 'pemilih'" />
    <HomeRelawan v-else-if="userLogin && userLogin.role == 'relawan'" />
    <HomeAdmin v-else-if="userLogin && userLogin.role == 'admin'" />
</template>

<script>
import axios from 'axios';
import moment from 'moment';

import HomePemilih from '@/components/HomePemilih.vue';
import HomeRelawan from '@/components/HomeRelawan.vue';
import HomeAdmin from '@/components/HomeAdmin.vue';
import { mapGetters } from "vuex";
export default {
    name: "Hero",
    components: {
        HomePemilih,
        HomeRelawan,
        HomeAdmin
    },
    created() {
        this.headerValue = this.userLogin;
    },
    computed: {
        ...mapGetters(['userLogin'])
    },
    data() {
        return {
            headerValue: null
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