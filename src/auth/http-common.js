import axios from 'axios';
import router from '../router';

// Mengatur header Authorization dengan token dari localStorage
const setAuthHeader = () => {
    const token = localStorage.getItem('token');
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    } else {
        delete axios.defaults.headers.common['Authorization'];
    }
};

// Fungsi untuk menangani respon yang tidak terotorisasi (401 Unauthorized)
const handleUnauthorized = async (error) => {
    if (error.response && error.response.status === 401) {
        // Hapus semua item dari localStorage
        localStorage.clear();
    } else {
        return Promise.reject(error);
    }
};

// Interceptor untuk menangani permintaan API
axios.interceptors.request.use(config => {
    setAuthHeader();
    return config;
}, (error) => {
    return Promise.reject(error);
});

// Interceptor untuk menangani respon API
axios.interceptors.response.use(resp => resp, handleUnauthorized);

export default axios;
