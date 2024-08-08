<template>
    <v-container>
        <v-card class="mx-auto" max-width="800" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>

            <v-card-title class="justify-center">
                <div class="col-12 text-center">
                    <h2>Profil Admin</h2>
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
