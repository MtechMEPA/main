<template>
    <form>
        <v-card class="mx-auto my-15" max-width="800" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>

                <div class="col-12">
                    <center>
                        <img src="../assets/logomepa.png" alt="" srcset="" width="40%">

                        <h2 color="blue-grey">Lengkapi Data Relawan</h2>
                    </center>
                </div>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-card-subtitle class="text-center">
                <p>Mohon lengkapi data berikut untuk menyelesaikan pendaftaran Anda.</p>
            </v-card-subtitle>
            <v-card-text class="text--primary">
                <v-alert v-if="!this.response.error" text dense close-icon="mdi-close-circle-outline"
                    color="cyan darken-2" v-model="alert" elevation="2" icon="mdi-information-outline" border="left"
                    dismissible transition="scale-transition">
                    {{ response.message }}
                </v-alert>

                <!-- Bagian 1: Data Diri -->
                <v-row class="mb-4">
                    <v-col cols="12">
                        <h3>1. Data Diri</h3>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="name" :error-messages="nameErrors" label="Nama" required
                            @input="$v.name.$touch()" @blur="$v.name.$touch()"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="email" :error-messages="emailErrors" label="Email"
                            required @input="$v.email.$touch()" @blur="$v.email.$touch()"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="phone" :error-messages="phoneErrors" label="Tlp/WhatsApp"
                            required @input="$v.phone.$touch()" @blur="$v.phone.$touch()"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="address" :error-messages="addressErrors" label="Alamat"
                            required @input="$v.address.$touch()" @blur="$v.address.$touch()"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-select outlined dense v-model="gender" :items="['male', 'female']" label="Jenis Kelamin"
                            required :error-messages="genderErrors" @input="$v.gender.$touch()"
                            @blur="$v.gender.$touch()"></v-select>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="birthDate" label="Tanggal Lahir" type="date" required
                            :error-messages="birthDateErrors" @input="$v.birthDate.$touch()"
                            @blur="$v.birthDate.$touch()"></v-text-field>
                    </v-col>
                </v-row>

                <!-- Bagian 2: Upload KTP -->
                <v-row class="mb-4">
                    <v-col cols="12">
                        <h3>2. Upload KTP</h3>
                    </v-col>

                    <v-col cols="12">
                        <div>
                            <v-file-input ref="fileInput" outlined dense v-model="personID" @change="uploadFile"
                                label="Upload KTP/SIM" accept="image/*" required :error-messages="personIDErrors"
                                @input="$v.personID.$touch()" @blur="$v.personID.$touch()"></v-file-input>

                            <div v-if="isUploadLoading">
                                <v-progress-circular indeterminate color="primary"></v-progress-circular>
                            </div>

                            <div>
                                <span class="mb-2" color="text--green" v-if="imageLink != ''">KTP/SIM berhasil
                                    tersimpan</span>
                            </div>
                            <img v-if="imageLink != ''" :src="imageLink" class="col-5" alt="" width="40%">
                        </div>
                    </v-col>
                </v-row>

                <!-- Bagian 3: Alamat Tinggal / Daerah Pemilihan -->
                <v-row class="mb-4">
                    <v-col cols="12">
                        <h3>3. Alamat Tinggal / Daerah Pemilihan</h3>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-select outlined dense v-model="regency" :error-messages="regencyErrors"
                            @input="$v.regency.$touch()" @blur="$v.regency.$touch()" :items="regencies" item-text="name"
                            item-value="id" label="Kabupaten/Kota" @change="onRegencyChange" required></v-select>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-select outlined dense v-model="district" :items="districts" item-text="name" item-value="id"
                            label="Kecamatan" required :error-messages="districtErrors" @input="$v.district.$touch()"
                            @blur="$v.district.$touch()"></v-select>
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
                        <v-text-field outlined dense v-model="rt" label="RT" required :error-messages="rtErrors"
                            @input="$v.rt.$touch()" @blur="$v.rt.$touch()"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="rw" label="RW" required :error-messages="rwErrors"
                            @input="$v.rw.$touch()" @blur="$v.rw.$touch()"></v-text-field>
                    </v-col>
                </v-row>

                <!-- Bagian 4: Data Daerah pemenangan Relawan -->
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
                            :error-messages="volunteersRegencyIDErrors" @input="$v.volunteersRegencyID.$touch()"
                            @blur="$v.volunteersRegencyID.$touch()" :items="regencies" item-text="name" item-value="id"
                            label="Kabupaten/Kota" @change="onRegencyRelawanChange" required></v-select>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-select outlined dense v-model="volunteersDistrictID" :items="districtsVolunteer"
                            item-text="name" item-value="id" label="Kecamatan" required
                            :error-messages="volunteersDistrictIDErrors" @input="$v.volunteersDistrictID.$touch()"
                            @blur="$v.volunteersDistrictID.$touch()"></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea outlined dense v-model="volunteersDescription" label="Deskripsi Relawan" required
                            :error-messages="volunteersDescriptionErrors" @input="$v.volunteersDescription.$touch()"
                            @blur="$v.volunteersDescription.$touch()"></v-textarea>
                    </v-col>
                </v-row>

                <!-- Bagian 5: Review/Summary -->
                <v-row class="mb-4">
                    <v-col cols="12">
                        <h3>5. Review/Summary</h3>
                    </v-col>
                    <v-col cols="12">

                        <v-card>
                            <v-card-title>Summary</v-card-title>
                            <v-card-subtitle>Berikut adalah data yang telah Anda masukkan:</v-card-subtitle>
                            <v-card-text>
                                <p><strong>Nomor Anggota:</strong> {{ username }}</p>
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
                                <p v-if="imageLink != ''"><strong>Gambar KTP/SIM:</strong> <img :src="imageLink"
                                        width="200"></p>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-card-actions>
                <v-btn :disabled="!isValid || isCompletedLoad" class="mr-4 white--text" color="cyan darken-2"
                    @click="submitForm">
                    <v-icon>mdi-floppy</v-icon> Submit
                </v-btn>
                <v-btn text class="mr-4 white--text" color="blue-grey" @click="clearForm">
                    <v-icon>mdi-cached</v-icon> Clear
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
                            <v-alert text dense color="green darken-2" elevation="2" icon="mdi-information-outline"
                                border="left" transition="scale-transition">
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

        </v-card>
    </form>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
import { validationMixin } from 'vuelidate';
import { required, maxLength, email as emailValidator, minLength, numeric } from 'vuelidate/lib/validators';

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
            isUploadLoading: false
        };
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'username', 'userDetails', 'token', 'regencies']),
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
        async submitForm() {
            this.$v.$touch();

            if (this.isValid) {
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
                console.error('File upload failed:', error);
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
            this.$router.go(0);
        },
        async fetchUserDetails() {
            try {
                const userDetailsParam = { "volunteerID": this.username };
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/user", userDetailsParam);
                const userDetails = userDetailsRes.data.data[0];
                this.editForm(userDetails);
                await this.$store.dispatch('login', { token: localStorage.getItem('token'), username: this.username, userDetails });
            } catch (error) {
                console.log(error);
            }

        },
        onRegencyChange() {
            const regency = this.regencies.find(reg => reg.id === regencyId);
            this.districts = regency ? regency.districts : [];
            this.district = null; // Reset the selected district
        },
        editForm(userDetails) {
            if (userDetails) {
                this.parent = userDetails.parent;
                this.name = userDetails.name;
                this.email = userDetails.email;
                this.phone = userDetails.phone;
                this.address = userDetails.address;
                this.gender = userDetails.gender;
                this.personID = userDetails.personID;
                this.birthDate = userDetails.birthDate;
                this.regency = userDetails.regency;
                this.district = userDetails.district;
                this.ward = userDetails.ward;
                this.village = userDetails.village;
                this.rt = userDetails.rt;
                this.rw = userDetails.rw;

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
