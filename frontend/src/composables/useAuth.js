import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api/axios';
import { useKeuangan } from './useKeuangan.js';

// State reaktif di luar fungsi agar menjadi singleton (hanya ada satu state)
const user = ref(null);
const token = ref(localStorage.getItem('token') || null);

export function useAuth() {
  const errors = ref({});
  const loading = ref(false);
  const { fetchPemasukan, fetchPengeluaran, clearKeuanganState } = useKeuangan();

  // Header diatur oleh axios interceptor, tidak perlu pengaturan manual di sini.

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
    const router = useRouter();
    loading.value = true;
    errors.value = {};
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
      } else {
        errors.value = { general: ['Terjadi kesalahan. Silakan coba lagi.'] };
        console.error(e);
      }
    } finally {
      loading.value = false;
    }
  };

  const register = async (data) => {
    const router = useRouter();
    loading.value = true;
    errors.value = {};
    try {
      const response = await api.post('/auth/register', data);
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

      // Redirect ke beranda karena user sudah otomatis login
      router.push({ name: 'Beranda' });

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
    const router = useRouter();
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
      
      // Hapus state keuangan
      clearKeuanganState();
      
      // Redirect ke halaman login
      router.push({ name: 'Login' }); // Pastikan Anda punya route dengan name 'Login'
    }
  };

  return {
    login,
    register,
    logout,
    attempt,
    user,
    errors,
    loading,
    // Status otentikasi sekarang hanya bergantung pada keberadaan token
    isAuthenticated: computed(() => !!token.value),
  };
}