import axios from 'axios';
import router from '../router';

// Mengatur header Authorization dengan token dari localStorage
const setAuthHeader = (config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
};

// Fungsi untuk menangani respon yang tidak terotorisasi (401 Unauthorized)
const handleUnauthorized = async (error) => {
    if (error.response && error.response.status === 401) {
        // Hapus semua item dari localStorage
        localStorage.clear();
        // Redirect ke halaman login
        router.push('/logout');
    }
    return Promise.reject(error);
};

// Interceptor untuk menangani permintaan API
axios.interceptors.request.use((config) => {
    return setAuthHeader(config);
}, (error) => {
    return Promise.reject(error);
});

// Interceptor untuk menangani respon API
axios.interceptors.response.use(response => response, handleUnauthorized);

export default axios;
