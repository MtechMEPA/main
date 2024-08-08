<template>
    <v-container fluid>
        <v-row>
            <!-- Filter Section -->
            <v-col cols="12">
                <v-card>
                    <v-row class="py-2 px-2">

                        <v-col cols="12">
                            <v-toolbar-title>Data Pemilih <v-icon
                                    class="text-h4 text--disabled">mdi-account-multiple-outline</v-icon></v-toolbar-title>

                        </v-col>
                        <v-col cols="6" v-if="userLogin.role == 'admin'">

                            <v-select v-model="volunteerRelawanValue" :items="volunteerRelawan" label="Pilih Relawan"
                                item-text="name" item-value="volunteerID" outlined dense
                                append-icon="mdi-menu-down"></v-select>


                        </v-col>
                        <v-col cols="6">

                            <v-text-field v-model="search" label="Pencarian" outlined dense append-icon="mdi-magnify"
                                hide-details></v-text-field>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>


            <!-- Tabel untuk menampilkan data volunteer -->
            <v-col cols="12">
                <v-card>

                    <v-data-table :headers="headers" :items="filteredVolunteers" multi-sort :header-props="headerprops"
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
                            <v-chip dark :color="item.statusName == 'Sudah' ? 'green' : 'orange'">
                                {{ item.statusName }}
                                <v-icon class="ml-2" v-if="item.statusName == 'Sudah'">mdi-check-circle-outline</v-icon>
                            </v-chip>
                        </template>
                        <template v-slot:item.attachmentName="{ item }">
                            <v-icon color="green" v-if="item.attachmentName != ''">mdi-check-circle-outline</v-icon>
                            <v-icon color="grey" v-else>mdi-close-circle-outline</v-icon>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>

        <!-- Dialog untuk menampilkan detail data -->
        <v-dialog v-model="dialog" max-width="400px">
            <v-card>
                <v-card-title>
                    Detail Data
                    <v-spacer></v-spacer>
                    <v-btn icon @click="dialog = false">
                        <v-icon>mdi-close-circle-outline</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-subtitle>
                    <v-row>
                        <!-- Kolom untuk Data Diri -->

                        <v-col cols="12">
                            <v-alert color="orange lighten-2">
                                <strong>[Perhatian]</strong>
                                Silahkan Aktifkan Jika data pemilih sudah benar,
                                dan jangan diaktifkan jika data belum benar.
                            </v-alert>
                        </v-col>
                        <v-col cols="12">
                            <small class="mr-1 mb-1">KTP/SIM <v-icon color="green"
                                    v-if="selectedItem.attachmentName != ''">mdi-check-circle-outline</v-icon></small>
                            <a v-if="selectedItem.attachmentName != ''" :href="imageLink" target="_blank">Lihat ukuran
                                penuh</a>


                            <v-img class="col-12" v-if="selectedItem.attachmentName" @load="loadingImg = false"
                                :src="imageLink" :max-width="400" width="300" alt="Example Image">
                                <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                        <v-progress-circular indeterminate color="cyan darken-2"></v-progress-circular>
                                    </v-row>
                                </template>
                            </v-img>
                        </v-col>
                        <v-col cols="12">
                            <h3>1. Data Diri</h3>
                            <p><strong>Nama:</strong> {{ selectedItem.name }}</p>
                            <p><strong>Email:</strong> {{ selectedItem.email }}</p>
                            <p><strong>Tlp/WhatsApp:</strong> {{ selectedItem.phone }}</p>
                            <p><strong>Alamat:</strong> {{ selectedItem.address }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ selectedItem.gender }}</p>
                            <p><strong>Tanggal Lahir:</strong> {{ selectedItem.birthDate }}</p>
                        </v-col>

                        <!-- Kolom untuk Alamat Tinggal -->
                        <v-col cols="12">
                            <h3>2. Alamat Tinggal / Daerah Pemilihan</h3>
                            <p><strong>Kabupaten/Kota:</strong> {{ selectedItem.regency }}</p>
                            <p><strong>Kecamatan:</strong> {{ selectedItem.district }}</p>
                            <p><strong>Kelurahan:</strong> {{ selectedItem.ward }}</p>
                            <p><strong>Desa:</strong> {{ selectedItem.village }}</p>
                            <p><strong>RT:</strong> {{ selectedItem.rt }}</p>
                            <p><strong>RW:</strong> {{ selectedItem.rw }}</p>
                        </v-col>

                        <!-- Kolom untuk Daerah Pemenangan Relawan -->
                        <v-col cols="12" v-if="selectedItem.role == 'relawan'">
                            <h3>3. Daerah Pemenangan Relawan</h3>
                            <p><strong>Nama Relawan:</strong> {{ selectedItem.volunteerName }}</p>
                            <p><strong>Kabupaten/Kota Pemenangan:</strong> {{ selectedItem.volunteersRegencyName }}</p>
                            <p><strong>Kecamatan Pemenangan:</strong> {{ selectedItem.volunteersDistrictName }}</p>
                        </v-col>
                    </v-row>
                </v-card-subtitle>
                <div class="fixed-card-actions">

                    <v-card-actions>

                        <v-btn v-if="selectedItem.status == 'inactive'" color="green" dark
                            @click="toggleStatus('Aktif')">Aktifkan?</v-btn>
                        <v-btn v-if="selectedItem.status == 'active'" color="orange" dark
                            @click="toggleStatus('Tidak Aktif')">Non
                            Aktifkan?</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn text @click="dialog = false">Close </v-btn>
                    </v-card-actions>
                </div>


            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Hero",
    data() {
        return {
            loadingImg: true,
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
            volunteerRelawan: [],
            volunteerRelawanValue: null,
            search: '',
            headerprops: {
                "sort-icon": "mdi-arrow-up"
            },
            headers: [
                { text: 'No', value: 'num' },
                { text: 'Nomor Anggota', value: 'volunteerID' },
                { text: 'Koordinator/Relawan', value: 'parentName' },
                { text: 'Nama', value: 'name' },
                { text: 'Kabupaten', value: 'regencyName' },
                { text: 'Kecamatan', value: 'districtName' },
                { text: 'KTP/SIM', value: 'attachmentName' },
                { text: 'Verifikasi', value: 'statusName' },
            ],
            dialog: false, // Untuk mengontrol tampilan dialog
            selectedItem: {}, // Data baris yang dipilih
            imageLink: '' // Link untuk gambar
        }
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'username', 'userData', 'token', 'regencies', 'isOverlayLoading', 'userLogin']),
        filteredVolunteers() {

            let filtered = this.volunteers;
            console.log(this.volunteerRelawanValue);
            // Filter by volunteerRelawanValue
            if (this.volunteerRelawanValue) {
                filtered = filtered.filter(item => item.parent === this.volunteerRelawanValue);

            }

            // Filter by search term
            if (this.search && this.search.length > 3) {
                console.log(this.search);
                const searchTerm = this.search.toLowerCase();
                filtered = filtered.filter(item =>
                    item.volunteerID.toLowerCase().includes(searchTerm) ||
                    item.name.toLowerCase().includes(searchTerm) ||
                    item.statusName.toLowerCase().includes(searchTerm)
                    // item.districtName ? item.districtName.toLowerCase().includes(searchTerm) : ''
                );
            }



            return filtered;
        },
    },
    methods: {
        ...mapActions(['showOverlayLoading', 'hideOverlayLoading']),
        async rowClick(row) {
            const userDetailsParam = { "volunteerID": row.volunteerID };
            var listData = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/userByID", userDetailsParam);
            this.selectedItem = listData.data.data[0];
            this.imageLink = process.env.VUE_APP_SERVICE_URL + "core/public/attachment/" + this.selectedItem.attachmentName; // Set link gambar
            this.dialog = true; // Tampilkan dialog
        },
        async getVolunteers() {
            this.showOverlayLoading();
            try {
                // Jika login berhasil, panggil API search/user
                const userDetailsParam = { "role": 'pemilih' };
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/userByID", userDetailsParam);
                this.volunteers = userDetailsRes.data.data;
                if (this.userLogin.role == 'relawan') {
                    this.volunteers = userDetailsRes.data.data.filter(value => value.parent == this.username.toUpperCase());
                }
            } catch (error) {

            } finally {
                this.hideOverlayLoading();
            }
        },
        async getVolunteerRelawan() {
            this.showOverlayLoading();
            try {
                // Jika login berhasil, panggil API search/user
                const userDetailsParam = { "role": 'relawan' };
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/userByID", userDetailsParam);
                this.volunteerRelawan = userDetailsRes.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.hideOverlayLoading();
            }
        },
        async toggleStatus(status) {
            try {
                const updatedItem = { ...this.selectedItem, statusName: status };
                // Ganti URL dengan endpoint yang sesuai untuk memperbarui status
                await axios.post(process.env.VUE_APP_SERVICE_URL + "update/status", updatedItem);
                // Perbarui data lokal
                this.selectedItem.statusName = status;
                this.dialog = false; // Tutup dialog setelah memperbarui status
            } catch (error) {
                console.log(error);
            }
        }
    },
    mounted() {
        this.getVolunteers();
        this.getVolunteerRelawan();
    }
};
</script>

<style scoped>
.table-style {
    font-size: 0.875rem;
    font-weight: 400;
    border-radius: 4px;
}

.fixed-card-actions {
    position: sticky;
    bottom: 0;
    background-color: white;
    z-index: 1;
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
