import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api/axios';
import { useKeuangan } from './useKeuangan.js';

// State reaktif di luar fungsi agar menjadi singleton (hanya ada satu state)
const user = ref(null);
const token = ref(localStorage.getItem('token') || null);
const needsVerification = ref(false); // New state to track if email verification is needed

export function useAuth() {
  const router = useRouter();
  const errors = ref({});
  const loading = ref(false);
  const { fetchPemasukan, fetchPengeluaran, clearKeuanganState } = useKeuangan();

  // Fungsi untuk mencoba mengambil data user jika ada token
  const attempt = async () => {
    if (!token.value) {
      return;
    }
    try {
      loading.value = true;
      const response = await api.get('/auth/me');
      user.value = response.data;
    } catch (e) {
      // Jika token tidak valid, hapus
      console.error('Failed to fetch user, token might be invalid.', e);
      user.value = null;
      token.value = null;
      localStorage.removeItem('token');
    } finally {
      loading.value = false;
    }
  };

  const login = async (credentials) => {
    loading.value = true;
    errors.value = {};
    needsVerification.value = false; // Reset on new login attempt
    try {
      const response = await api.post('/auth/login', credentials);
      const newToken = response.data.access_token;

      // Simpan token
      localStorage.setItem('token', newToken);
      token.value = newToken;
      // Header diatur oleh interceptor

      // Ambil data user
      await attempt();
      
      if (user.value) {
        await fetchPemasukan();
        await fetchPengeluaran();
      }
      
      // Redirect ke beranda
      router.push({ name: 'Beranda' }); // Pastikan Anda punya route dengan name 'Beranda'
    } catch (e) {
      if (e.response && e.response.status === 422) {
        errors.value = e.response.data.errors;
      } else if (e.response && e.response.status === 401) {
        errors.value = { general: ['Email atau password salah.'] };
      } else if (e.response && e.response.status === 403) {
        if (e.response.data.error === 'Please verify your email address before logging in.') {
          needsVerification.value = true; // Set flag for login page
          errors.value = { general: ['Email Anda belum diverifikasi.'] };
        } else {
          errors.value = { general: [e.response.data.error || 'Terjadi kesalahan otorisasi.'] };
        }
      } else {
        errors.value = { general: ['Terjadi kesalahan. Silakan coba lagi.'] };
        console.error(e);
      }
    } finally {
      loading.value = false;
    }
  };

  const register = async (data) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.post('/auth/register', data);
      
      // Redirect ke halaman login dengan notifikasi
      router.push({ name: 'Login', query: { registered: 'true' } });

    } catch (e) {
      if (e.response && (e.response.status === 422 || e.response.status === 400)) {
        errors.value = e.response.data.errors || e.response.data;
      } else {
        errors.value = { general: ['Terjadi kesalahan saat registrasi.'] };
        console.error(e);
      }
    } finally {
      loading.value = false;
    }
  };

  const logout = async () => {
    if (!token.value) return;
    
    try {
      // Minta server untuk membatalkan token
      await api.post('/auth/logout');
    } catch (e) {
      console.error('Logout failed on server, but logging out client-side anyway.', e);
    } finally {
      // Hapus data dari state dan localStorage
      user.value = null;
      token.value = null;
      localStorage.removeItem('token');
      needsVerification.value = false; // Reset on logout
      
      // Hapus state keuangan
      clearKeuanganState();
      
      // Redirect ke halaman login
      router.push({ name: 'Login' }); // Pastikan Anda punya route dengan name 'Login'
    }
  };

  const resendVerificationEmail = async (email) => {
    loading.value = true;
    errors.value = {};
    let successMessage = '';
    try {
      const response = await api.post('/auth/email/resend', { email });
      successMessage = response.data.message;
    } catch (e) {
      if (e.response && (e.response.status === 422 || e.response.status === 400 || e.response.status === 404)) {
        errors.value = { general: [e.response.data.message || 'Gagal mengirim ulang email verifikasi.'] };
      } else {
        errors.value = { general: ['Terjadi kesalahan saat mengirim ulang email verifikasi.'] };
        console.error(e);
      }
    } finally {
      loading.value = false;
      return successMessage;
    }
  };

  return {
    login,
    register,
    logout,
    attempt,
    resendVerificationEmail, // Expose the new function
    user,
    errors,
    loading,
    needsVerification, // Expose the new state
    // Status otentikasi sekarang hanya bergantung pada keberadaan token
    isAuthenticated: computed(() => !!token.value),
  };
}