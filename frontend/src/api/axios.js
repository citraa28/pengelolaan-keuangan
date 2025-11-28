import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost:8000/api", 
  headers: {
    "Content-Type": "application/json",
  }
});

// Tambahkan interceptor untuk request
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

// Interceptor untuk response (MENANGKAP TOKEN EXPIRED)
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      // Hapus token dari localStorage
      localStorage.removeItem('token');

      // Redirect otomatis ke halaman login
      window.location.href = "/login";
    }

    return Promise.reject(error);
  }
);

export default api;
