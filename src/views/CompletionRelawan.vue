<template>
    <form>
        <v-card class="mx-auto my-15" max-width="800" outlined elevation="5">
            <v-progress-linear v-show="isCompletedLoad" indeterminate color="cyan darken-2"></v-progress-linear>
            <v-card-title class="justify-center">
                <v-spacer></v-spacer>
                <div class="col-12">
                    <center>

                        <h2 color="blue-grey">Lengkapi Data Relawan</h2>
                    </center>
                </div>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-card-subtitle class="text-center">
                <p>Mohon lengkapi data berikut untuk menyelesaikan pendaftaran Anda.</p>
            </v-card-subtitle>
            <v-card-text class="text--primary">
                <div>
                    <v-alert v-if="!this.response.error" text dense close-icon="mdi-close-circle-outline"
                        color="cyan darken-2" v-model="alert" elevation="2" icon="mdi-information-outline" border="left"
                        dismissible transition="scale-transition">
                        {{ response.message }}
                    </v-alert>
                    <v-alert v-else text dense close-icon="mdi-close-circle-outline" color="red" v-model="alert"
                        elevation="2" icon="mdi-information-outline" border="left" dismissible
                        transition="scale-transition">
                        {{ response.message }} <br>
                        {{ response.error.name }} <br>
                        {{ response.error.email }} <br>
                        {{ response.error.phone }} <br>
                        {{ response.error.address }}
                    </v-alert>
                </div>
                <v-row>
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
                        <v-select outlined dense v-model="gender" :items="['male', 'female']"
                            :error-messages="genderErrors" label="Jenis Kelamin" required @input="$v.gender.$touch()"
                            @blur="$v.gender.$touch()"></v-select>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-file-input ref="fileInput" outlined dense v-model="personID" @change="uploadFile"
                            label="Upload KTP/SIM" accept="image/*" required
                            @update:model-value="uploadFile"></v-file-input>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="birthDate" label="Tanggal Lahir" type="date"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="regency" label="Kabupaten/Kota" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="district" label="Kecamatan" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="ward" label="Kelurahan" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="village" label="Desa" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="rt" label="RT" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="rw" label="RW" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="volunteerName" label="Nama Relawan"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="volunteersRegencyID" label="ID Kabupaten Relawan"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field outlined dense v-model="volunteersDistrictID" label="ID Kecamatan Relawan"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea outlined dense v-model="volunteersDescription" label="Deskripsi Relawan"
                            required></v-textarea>
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
        </v-card>
        <v-dialog v-model="showDialog" scrollable persistent width="600px">
            <v-card>
                <v-card-title>Data Relawan Berhasil Dikirim
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
                        <v-alert text dense color="orange darken-2" elevation="2" icon="mdi-information-outline"
                            border="left" transition="scale-transition">
                            Perhatian! <br>
                            Silahkan simpan Nomor Anggota <strong>{{ response.data.volunteerID }}</strong> anda untuk
                            gunakan saat login
                        </v-alert>
                    </div>
                    <div>
                        <p><strong>Nomor Anggota:</strong> {{ response.data.volunteerID }}</p>
                        <p><strong>Name:</strong> {{ response.data.name }}</p>
                        <p><strong>Tlp/WhatsApp:</strong> {{ response.data.phone }}</p>
                        <p><strong>Email:</strong> {{ response.data.email }}</p>
                        <p class="text-uppercase"><strong>Tipe:</strong> {{ response.data.role }}</p>
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
            regency: '',
            district: '',
            ward: '',
            village: '',
            rt: '',
            rw: '',
            volunteerName: '',
            volunteersRegencyID: '',
            volunteersDistrictID: '',
            volunteersDescription: '',
            alert: false,
            showDialog: false,
            response: {
                message: '',
                data: [],
                error: {}
            }
        };
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'username', 'userDetails', 'token']),
        isValid() {
            return !this.$v.$invalid;
        },
        nameErrors() {
            const errors = [];
            if (!this.$v.name.$pending) {
                if (!this.$v.name.required) errors.push('Nama wajib diisi');
                if (!this.$v.name.minLength) errors.push(`Nama minimal ${minlength5} karakter`);
                if (!this.$v.name.maxLength) errors.push(`Nama maksimal ${maxlength25} karakter`);
            }
            return errors;
        },
        emailErrors() {
            const errors = [];
            if (!this.$v.email.$pending) {
                if (!this.$v.email.required) errors.push('Email wajib diisi');
                if (!this.$v.email.email) errors.push('Format email tidak valid');
                if (!this.$v.email.minLength) errors.push(`Email minimal ${minlength5} karakter`);
            }
            return errors;
        },
        phoneErrors() {
            const errors = [];
            if (!this.$v.phone.$pending) {
                if (!this.$v.phone.required) errors.push('Tlp/WhatsApp wajib diisi');
                if (!this.$v.phone.minLength) errors.push(`Tlp/WhatsApp minimal ${minlength10} karakter`);
                if (!this.$v.phone.maxLength) errors.push(`Tlp/WhatsApp maksimal ${maxlength15} karakter`);
                if (!this.$v.phone.numeric) errors.push('Tlp/WhatsApp harus berupa angka');
            }
            return errors;
        },
        addressErrors() {
            const errors = [];
            if (!this.$v.address.$pending) {
                if (!this.$v.address.required) errors.push('Alamat wajib diisi');
                if (!this.$v.address.minLength) errors.push(`Alamat minimal ${minlength5} karakter`);
            }
            return errors;
        },
        genderErrors() {
            const errors = [];
            if (!this.$v.gender.$pending) {
                if (!this.$v.gender.required) errors.push('Jenis Kelamin wajib dipilih');
            }
            return errors;
        }
    },
    methods: {
        async submitForm() {
            this.$v.$touch();

            if (this.isValid) {
                this.isCompletedLoad = true;
                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('address', this.address);
                formData.append('gender', this.gender);
                // formData.append('image', this.personID);
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

                axios.post(`${process.env.VUE_APP_SERVICE_URL}/relawan/completion`, formData)
                    .then(response => {
                        this.response = response.data;
                        if (!this.response.error) {
                            this.alert = true;
                            this.showDialog = true;
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

            const formData = new FormData();
            formData.append('image', file);
            formData.append('volunteerID', this.username); // menambahkan data teks ke formData

            try {

                const response = await axios.post(process.env.VUE_APP_SERVICE_URL + "attachment/upload", formData);
                this.personID = response.data.filePath; // atau sesuai dengan struktur respons
            } catch (error) {
                console.error('File upload failed:', error);
                this.response.error = { ...this.response.error, fileUpload: 'File upload failed' };
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
            this.$router.push('/');
        },
        async fetchUserDetails() {
            if (!this.userDetails) {
                const userDetailsParam = { "volunteerID": this.username };
                const userDetailsRes = await axios.post(process.env.VUE_APP_SERVICE_URL + "search/user", userDetailsParam);
                const userDetails = userDetailsRes.data.data[0];
                await this.$store.dispatch('login', { token: localStorage.getItem('token'), username: this.username, userDetails });
            }
        }
    },
    async created() {
        await this.fetchUserDetails();
        if (this.userDetails) {
            this.name = this.userDetails.name;
            this.email = this.userDetails.email;
            this.phone = this.userDetails.phone;
            this.address = this.userDetails.address;
            this.gender = this.userDetails.gender;
            this.personID = this.userDetails.personID;
            this.birthDate = this.userDetails.birthDate;
            this.regency = this.userDetails.regency;
            this.district = this.userDetails.district;
            this.ward = this.userDetails.ward;
            this.village = this.userDetails.village;
            this.rt = this.userDetails.rt;
            this.rw = this.userDetails.rw;
            this.volunteerName = this.userDetails.volunteerName;
            this.volunteersRegencyID = this.userDetails.volunteersRegencyID;
            this.volunteersDistrictID = this.userDetails.volunteersDistrictID;
            this.volunteersDescription = this.userDetails.volunteersDescription;
        }
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
