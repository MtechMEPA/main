<template>
    <v-container>
        <v-card class="mx-auto" max-width="800" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>

            <v-card-title class="justify-center">
                <div class="col-12 text-center">
                    <h2>Profil Relawan</h2>
                </div>
            </v-card-title>

            <v-card-subtitle class="text-center">
                <p>Berikut data profil anda yang sudah tersimpan, mohon dilengkapi jika masih ada yang kurang.</p>
            </v-card-subtitle>

            <v-alert v-if="!this.response.error" text dense close-icon="mdi-close-circle-outline" color="cyan darken-2"
                v-model="alert" elevation="2" icon="mdi-information-outline" border="left" dismissible
                transition="scale-transition">
                {{ response.message }}
            </v-alert>

            <v-card-text class="text--primary">
                <template v-if="!isEditing">

                    <v-row class="mb-4">
                        <v-col cols="12">
                            <h3>1. Data Diri</h3>
                        </v-col>
                        <v-col cols="12">
                            <p><strong>Nama:</strong> {{ name }}</p>
                            <p><strong>Email:</strong> {{ email }}</p>
                            <p><strong>Tlp/WhatsApp:</strong> {{ phone }}</p>
                            <p><strong>Alamat:</strong> {{ address }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ gender }}</p>
                            <p><strong>Tanggal Lahir:</strong> {{ birthDate }}</p>
                            <p v-if="imageLink != ''"><strong>Gambar KTP/SIM:</strong> <img :src="imageLink"
                                    width="200"></p>
                        </v-col>
                    </v-row>

                    <v-row class="mb-4">
                        <v-col cols="12">
                            <h3>2. Alamat Tinggal / Daerah Pemilihan</h3>
                        </v-col>
                        <v-col cols="12">
                            <p><strong>Kabupaten/Kota:</strong> {{ regency }}</p>
                            <p><strong>Kecamatan:</strong> {{ district }}</p>
                            <p><strong>Kelurahan:</strong> {{ ward }}</p>
                            <p><strong>Desa:</strong> {{ village }}</p>
                            <p><strong>RT:</strong> {{ rt }}</p>
                            <p><strong>RW:</strong> {{ rw }}</p>
                        </v-col>
                    </v-row>


                    <v-row class="mb-4">
                        <v-col cols="12">
                            <h3>3. Daerah Pemenangan Relawan</h3>
                        </v-col>
                        <v-col cols="12">
                            <p><strong>Nama Relawan:</strong> {{ volunteerName }}</p>
                            <p><strong>Kabupaten/Kota Pemenangan:</strong> {{ volunteersRegencyName }}</p>
                            <p><strong>Kecamatan Pemenangan:</strong> {{ volunteersDistrictName }}</p>

                        </v-col>
                    </v-row>


                    <v-btn class="mr-4 white--text" color="cyan darken-2" @click="isEditing = true">
                        <v-icon>mdi-pencil</v-icon> Edit
                    </v-btn>
                </template>

                <template v-else>
                    <v-container>
                        <v-card-text class="text--primary">
                            <!-- Bagian 1: Koordinator Wilayah -->
                            <v-row class="mb-4">
                                <v-col cols="12">
                                    <h3>1. Koordinator Wilayah</h3>
                                </v-col>
                                <v-col cols="12">

                                    <v-select outlined dense v-model="parent" :items="listParentUsers" item-text="name"
                                        item-value="volunteerID" label="Koordinator Wilayah / Relawan" required
                                        :error-messages="parentErrors" @input="$v.parent.$touch()"
                                        @blur="$v.parent.$touch()"></v-select>
                                </v-col>
                            </v-row>

                            <!-- Bagian 2: Data Diri -->
                            <v-row class="mb-4">
                                <v-col cols="12">
                                    <h3>2. Data Diri</h3>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="name" :error-messages="nameErrors"
                                        label="Nama" required @input="$v.name.$touch()"
                                        @blur="$v.name.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="email" :error-messages="emailErrors"
                                        label="Email" required @input="$v.email.$touch()"
                                        @blur="$v.email.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="phone" :error-messages="phoneErrors"
                                        label="Tlp/WhatsApp" required @input="$v.phone.$touch()"
                                        @blur="$v.phone.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="address" :error-messages="addressErrors"
                                        label="Alamat" required @input="$v.address.$touch()"
                                        @blur="$v.address.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select outlined dense v-model="gender" item-text="name"
                                        item-value="jeniskelaminID" :items="jeniskelamin" label="Jenis Kelamin" required
                                        :error-messages="genderErrors" @input="$v.gender.$touch()"
                                        @blur="$v.gender.$touch()"></v-select>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="birthDate" label="Tanggal Lahir" type="date"
                                        required :error-messages="birthDateErrors" @input="$v.birthDate.$touch()"
                                        @blur="$v.birthDate.$touch()"></v-text-field>
                                </v-col>
                            </v-row>

                            <!-- Bagian 3: Upload KTP -->
                            <v-row class="mb-4">
                                <template>
                                    <v-col cols="12">
                                        <v-card class="pa-4">
                                            <v-card-title class="headline">Upload KTP/SIM</v-card-title>
                                            <v-card-subtitle>
                                                <v-file-input ref="fileInput" outlined dense v-model="personID"
                                                    @change="uploadFile" label="Pilih File" accept="image/*" required
                                                    :error-messages="personIDErrors" @input="$v.personID.$touch()"
                                                    @blur="$v.personID.$touch()"></v-file-input>
                                            </v-card-subtitle>

                                            <v-divider></v-divider>

                                            <v-card-actions>
                                                <div v-if="isUploadLoading">
                                                    <v-progress-circular indeterminate color="primary"
                                                        class="ma-4"></v-progress-circular>
                                                </div>
                                                <v-alert v-if="imageLink != ''" type="success" color="green"
                                                    border="left" icon="mdi-check-circle-outline" class="ma-4">
                                                    KTP/SIM sudah tersimpan
                                                </v-alert>

                                                <a :href="imageLink" v-if="imageLink != ''">
                                                    <v-img :src="imageLink" class="my-4" max-width="50"
                                                        max-height="50"></v-img>
                                                </a>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                </template>
                            </v-row>

                            <!-- Bagian 4: Alamat Tinggal / Daerah Pemilihan -->
                            <v-row class="mb-4">
                                <v-col cols="12">
                                    <h3>4. Alamat Tinggal / Daerah Pemilihan</h3>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select outlined dense v-model="regency" :error-messages="regencyErrors"
                                        @input="$v.regency.$touch()" @blur="$v.regency.$touch()" :items="regencies"
                                        item-text="name" item-value="id" label="Kabupaten/Kota"
                                        @change="onRegencyChange" required></v-select>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select outlined dense v-model="district" :items="districts" item-text="name"
                                        item-value="id" label="Kecamatan" required :error-messages="districtErrors"
                                        @input="$v.district.$touch()" @blur="$v.district.$touch()"></v-select>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="ward" label="Kelurahan" required
                                        :error-messages="wardErrors" @input="$v.ward.$touch()"
                                        @blur="$v.ward.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="village" label="Desa" required
                                        :error-messages="villageErrors" @input="$v.village.$touch()"
                                        @blur="$v.village.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="rt" label="RT" required
                                        :error-messages="rtErrors" @input="$v.rt.$touch()"
                                        @blur="$v.rt.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense v-model="rw" label="RW" required
                                        :error-messages="rwErrors" @input="$v.rw.$touch()"
                                        @blur="$v.rw.$touch()"></v-text-field>
                                </v-col>
                            </v-row>

                            <!-- Bagian 5: Data Daerah pemenangan Relawan -->
                            <v-row class="mb-4">
                                <v-col cols="12">
                                    <h3>4. Data Daerah Pemenangan Relawan</h3>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-text-field outlined dense v-model="volunteerName" label="Nama Relawan" required
                                        :error-messages="volunteerNameErrors" @input="$v.volunteerName.$touch()"
                                        @blur="$v.volunteerName.$touch()"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select outlined dense v-model="volunteersRegencyID"
                                        :error-messages="volunteersRegencyIDErrors"
                                        @input="$v.volunteersRegencyID.$touch()" @blur="$v.volunteersRegencyID.$touch()"
                                        :items="regencies" item-text="name" item-value="id" label="Kabupaten/Kota"
                                        @change="onRegencyRelawanChange" required></v-select>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select outlined dense v-model="volunteersDistrictID" :items="districtsVolunteer"
                                        item-text="name" item-value="id" label="Kecamatan" required
                                        :error-messages="volunteersDistrictIDErrors"
                                        @input="$v.volunteersDistrictID.$touch()"
                                        @blur="$v.volunteersDistrictID.$touch()"></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea outlined dense v-model="volunteersDescription" label="Deskripsi Relawan"
                                        required :error-messages="volunteersDescriptionErrors"
                                        @input="$v.volunteersDescription.$touch()"
                                        @blur="$v.volunteersDescription.$touch()"></v-textarea>
                                </v-col>
                            </v-row>

                            <!-- Bagian 6: Review/Summary -->
                            <v-row class="mb-4">
                                <v-col cols="12">
                                    <h3>5. Review/Summary</h3>
                                </v-col>
                                <v-col cols="12">

                                    <v-card>
                                        <v-card-title>Summary</v-card-title>
                                        <v-card-subtitle>Berikut adalah data yang telah Anda
                                            masukkan:</v-card-subtitle>
                                        <v-card-text>
                                            <p><strong>Nomor Anggota:</strong> {{ username }}</p>
                                            <p><strong>Koordinator Wilayah:</strong> {{ parent }}</p>
                                            <p><strong>Nama:</strong> {{ name }}</p>
                                            <p><strong>Email:</strong> {{ email }}</p>
                                            <p><strong>Tlp/WhatsApp:</strong> {{ phone }}</p>
                                            <p><strong>Alamat:</strong> {{ address }}</p>
                                            <p><strong>Jenis Kelamin:</strong> {{ gender }}</p>
                                            <p><strong>Tanggal Lahir:</strong> {{ birthDate }}</p>
                                            <p><strong>Kabupaten/Kota:</strong> {{ regency }}</p>
                                            <p><strong>Kecamatan:</strong> {{ district }}</p>
                                            <p><strong>Kelurahan:</strong> {{ ward }}</p>
                                            <p><strong>Desa:</strong> {{ village }}</p>
                                            <p><strong>RT:</strong> {{ rt }}</p>
                                            <p><strong>RW:</strong> {{ rw }}</p>
                                            <p v-if="imageLink != ''"><strong>Gambar KTP/SIM:</strong> <img
                                                    :src="imageLink" width="200"></p>
                                            <p><strong>Nama Relawan:</strong> {{ volunteerName }}</p>
                                            <p><strong>Kabupaten/Kota Pemenangan:</strong> {{ volunteersRegencyName }}
                                            </p>
                                            <p><strong>Kecamatan Pemenangan:</strong> {{ volunteersDistrictName }}</p>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card-text>

                        <v-card-actions>
                            <v-btn :disabled="!isValid || isCompletedLoad" class="mr-4 white--text"
                                color="cyan darken-2" @click="submitForm">
                                <v-icon>mdi-floppy</v-icon> Submit
                            </v-btn>
                            <v-btn text class="mr-4 white--text" color="blue-grey" @click="clearForm">
                                <v-icon>mdi-cached</v-icon> Clear
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn text class="mr-4 white--text" color="blue-grey" @click="isEditing = false">
                                <v-icon>mdi-keyboard-backspace</v-icon> Kembali
                            </v-btn>
                        </v-card-actions>

                        <v-dialog v-model="showDialog" scrollable persistent width="600px">
                            <v-card>
                                <v-card-title>Data Relawan Berhasil Tersimpan
                                    <v-spacer></v-spacer>
                                    <v-btn color="cyan darken-2" icon @click="closeDialog">
                                        <v-icon>
                                            mdi-close
                                        </v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <div class="mb-2">
                                        <v-alert text dense color="green darken-2" elevation="2"
                                            icon="mdi-information-outline" border="left" transition="scale-transition">
                                            Data anda sudah tersimpan! <br>
                                            Pengurus pusat akan melakukan review terhadap data anda.
                                        </v-alert>
                                    </div>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-btn color="cyan darken-2" @click="closeDialog" text>
                                        OK
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-container>
                </template>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
import { validationMixin } from 'vuelidate';
import { required, maxLength, email as emailValidator, minLength, numeric } from 'vuelidate/lib/validators';
import { scrollToTop } from '@/helpers/scrollHelper';
import { formatDateToDDMMYYYY, parseDateToYYYYMMDD } from '@/helpers/dateHelpers';


const maxlength15 = 15;
const minlength10 = 10;
const maxlength25 = 25;
const minlength5 = 5;

export default {
    mixins: [validationMixin],
    validations: {
        name: { required, minLength: minLength(minlength5), maxLength: maxLength(maxlength25) },
        email: { required, email: emailValidator, minLength: minLength(minlength5) },
        phone: { required, minLength: minLength(minlength10), maxLength: maxLength(maxlength15), numeric },
        address: { required, minLength: minLength(minlength5) },
        gender: { required },
        birthDate: { required },
        regency: { required },
        district: { required },
        volunteerName: { required },
        volunteersDescription: { required },
        volunteersRegencyID: { required },
        volunteersDistrictID: { required },
        ward: { required },
        village: { required },
        rt: { required },
        rw: { required },
        personID: { required }
    },
    data() {
        return {
            isEditing: false,
            isCompletedLoad: false,
            name: '',
            email: '',
            phone: '',
            address: '',
            gender: '',
            personID: null,
            birthDate: '',
            regency: null,
            district: null,
            ward: '',
            village: '',
            rt: '',
            rw: '',
            volunteerName: '',
            volunteersRegencyName: '',
            volunteersDistrictName: '',
            volunteersRegencyID: null,
            volunteersDistrictID: null,
            volunteersDescription: '',
            alert: false,
            showDialog: false,
            imageLink: "",
            response: {
                message: '',
                data: [],
                error: {}
            },
            districts: [],
            districtsVolunteer: [],
            jeniskelamin: [
                {
                    jeniskelaminID: "male",
                    name: "Laki-Laki"
                },
                {
                    jeniskelaminID: "female",
                    name: "Perempuan"
                }
            ],
            isUploadLoading: false
        };
    },
    computed: {
        // ...mapGetters(['isLoggedIn', 'username', 'userDetails', 'token', 'regencies', 'userLogin']),
        ...mapGetters(['isLoggedIn', 'username', 'userData', 'token', 'regencies', 'isOverlayLoading', 'userLogin']),
        isValid() {
            return !this.$v.$invalid;
        },
        nameErrors() { return this.getErrors('name', 'Nama'); },
        emailErrors() { return this.getErrors('email', 'Email'); },
        phoneErrors() { return this.getErrors('phone', 'Tlp/WhatsApp'); },
        addressErrors() { return this.getErrors('address', 'Alamat'); },
        genderErrors() { return this.getErrors('gender', 'Jenis Kelamin'); },
        birthDateErrors() { return this.getErrors('birthDate', 'Tanggal Lahir'); },
        regencyErrors() { return this.getErrors('regency', 'Kabupaten/Kota'); },
        districtErrors() { return this.getErrors('district', 'Kecamatan/Distrik'); },
        volunteersRegencyIDErrors() { return this.getErrors('volunteersRegencyID', 'Kabupaten/Kota Pemenangan'); },
        volunteersDistrictIDErrors() { return this.getErrors('volunteersDistrictID', 'Kecamatan/Distrik Pemenangan'); },
        volunteerNameErrors() { return this.getErrors('volunteerName', 'Nama Relawan'); },
        volunteersDescriptionErrors() { return this.getErrors('volunteersDescription', 'Deskripsi/Keterangan Relawan'); },
        wardErrors() { return this.getErrors('ward', 'Kelurahan'); },
        rtErrors() { return this.getErrors('rt', 'RT'); },
        rwErrors() { return this.getErrors('rw', 'RW'); },
        villageErrors() { return this.getErrors('village', 'Desa/Kampung'); },
        personIDErrors() { return this.getErrors('personID', 'KTP/SIM'); },

    },
    methods: {
        ...mapActions(['showOverlayLoading', 'hideOverlayLoading']),
        async submitForm() {
            this.$v.$touch();

            if (this.isValid) {
                this.showOverlayLoading();
                this.isCompletedLoad = true;
                const formData = new FormData();
                formData.append('volunteerID', this.username);

                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('address', this.address);
                formData.append('gender', this.gender);
                formData.append('birthDate', this.birthDate);
                formData.append('regency', this.regency);
                formData.append('district', this.district);
                formData.append('ward', this.ward);
                formData.append('village', this.village);
                formData.append('rt', this.rt);
                formData.append('rw', this.rw);
                formData.append('volunteerName', this.volunteerName);
                formData.append('volunteersRegencyID', this.volunteersRegencyID);
                formData.append('volunteersDistrictID', this.volunteersDistrictID);
                formData.append('volunteersDescription', this.volunteersDescription);
                formData.append('role', 'relawan');
                formData.append('status', 'inactive');
                formData.append('personID', 'relawanimage');

                axios.post(`${process.env.VUE_APP_SERVICE_URL}relawan/completion`, formData)
                    .then(async response => {
                        this.response = response.data;
                        if (!this.response.error) {
                            this.alert = true;
                            this.showDialog = true;
                            await this.fetchUserDetails();
                        }
                    })
                    .catch(error => {
                        this.response.error = error.response.data.errors;
                        this.alert = true;
                    })
                    .finally(() => {

                        this.isCompletedLoad = false;
                        this.hideOverlayLoading();
                        scrollToTop();
                    });
            }
        },
        async uploadFile(event) {
            const file = this.personID;
            if (!file) return;
            this.isUploadLoading = true;
            const formData = new FormData();
            formData.append('image', file);
            formData.append('volunteerID', this.username); // menambahkan data teks ke formData
            try {
                const response = await axios.post(
                    process.env.VUE_APP_SERVICE_URL + "attachment/upload",
                    formData
                );
                // this.personID = response.data.data.name;
                if (response.data && response.data.data) {
                    this.imageLink = process.env.VUE_APP_SERVICE_URL + "core/public/attachment/" + response.data.data.name;
                }
            } catch (error) {
                this.response.error = { ...this.response.error, fileUpload: 'File upload failed' };
            } finally {
                this.isUploadLoading = false; // Selesai loading
            }
        },
        clearForm() {
            this.name = '';
            this.email = '';
            this.phone = '';
            this.address = '';
            this.gender = '';
            this.personID = null;
            this.birthDate = '';
            this.regency = '';
            this.district = '';
            this.ward = '';
            this.village = '';
            this.rt = '';
            this.rw = '';
            this.volunteerName = '';
            this.volunteersRegencyID = '';
            this.volunteersDistrictID = '';
            this.volunteersDescription = '';
            this.$v.$reset();
        },
        closeDialog() {
            this.showDialog = false;
        },
        async fetchUserDetails() {
            this.showOverlayLoading();
            try {
                // Jika login berhasil, panggil API search/user
                const userDetailsParam = { "volunteerID": this.username };
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/userByID", userDetailsParam);
                const userDetails = userDetailsRes.data.data;
                await this.$store.dispatch('setUserLogin', { userLogin: userDetails[0] });
                this.editForm();
            } catch (error) {
            } finally {
                this.hideOverlayLoading();
            }
        },
        onRegencyChange() {
            const regency = this.regencies.find(reg => reg.id === regencyId);
            this.districts = regency ? regency.districts : [];
            this.district = null; // Reset the selected district
        },
        editForm() {
            if (this.userLogin) {
                var userDetails = this.userLogin;

                this.parent = userDetails.parent;
                this.name = userDetails.name;
                this.email = userDetails.email;
                this.phone = userDetails.phone;
                this.address = userDetails.address;
                this.gender = userDetails.gender;
                this.personID = userDetails.personID;
                this.birthDate = userDetails.birthDate;
                this.regency = userDetails.regency;
                this.ward = userDetails.ward;
                this.village = userDetails.village;
                this.rt = userDetails.rt;
                this.rw = userDetails.rw;
                this.volunteerName = userDetails.volunteerName;
                this.volunteersDescription = userDetails.volunteersDescription;
                this.volunteersRegencyID = userDetails.volunteersRegencyID;

                this.imageLink = process.env.VUE_APP_SERVICE_URL + "core/public/attachment/" + userDetails.attachmentName;
                this.onRegencyChange(this.regency);
                this.onRegencyRelawanChange(this.volunteersRegencyID);
                this.district = userDetails.district;
                this.volunteersDistrictID = userDetails.volunteersDistrictID;
                this.volunteersDistrictName = userDetails.volunteersDistrictName;
                this.volunteersRegencyName = userDetails.volunteersRegencyName;
            }
        },
        getErrors(field, fieldMessage) {
            const errors = [];
            const validation = this.$v[field];

            if (!validation.$pending) {
                if (!validation.required) errors.push(`${fieldMessage} wajib diisi`);

                if (validation.$params.minLength && !validation.minLength) {
                    errors.push(`${fieldMessage} minimal ${validation.$params.minLength.min} karakter`);
                }

                if (validation.$params.maxLength && !validation.maxLength) {
                    errors.push(`${fieldMessage} maksimal ${validation.$params.maxLength.max} karakter`);
                }

                if (validation.$params.numeric && !validation.numeric) {
                    errors.push(`${fieldMessage} harus berupa angka`);
                }

                if (validation.$params.email && !validation.email) {
                    errors.push(`Format email tidak valid`);
                }
            }

            return errors;
        },

        onRegencyChange(regencyId) {
            const regency = this.regencies.find(reg => reg.id === regencyId);
            this.districts = regency ? regency.districts : [];
            this.district = null; // Reset the selected district
        },
        onRegencyRelawanChange(volunteersRegencyID) {
            const regency = this.regencies.find(reg => reg.id === volunteersRegencyID);
            this.districtsVolunteer = regency ? regency.districts : [];
            this.volunteersDistrictID = null; // Reset the selected district
        }
    },
    async created() {
        await this.fetchUserDetails();
        this.editForm();
    }
}
</script>

<style scoped>
.v-card {
    padding: 20px;
}

.v-btn {
    margin: 10px 0;
}
</style>
