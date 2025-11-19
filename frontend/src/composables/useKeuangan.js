import { ref } from 'vue';
import api from '../api/axios';

// State reaktif di luar fungsi agar menjadi singleton
const pemasukan = ref([]);
const pengeluaran = ref([]);
const loading = ref(false);
const errors = ref({});

export function useKeuangan() {

  const clearKeuanganState = () => {
    pemasukan.value = [];
    pengeluaran.value = [];
    errors.value = {};
  };

  const fetchPemasukan = async () => {
    loading.value = true;
    errors.value = {};
    try {
      const response = await api.get('/pemasukan');
      pemasukan.value = response.data;
    } catch (e) {
      errors.value.fetchPemasukan = 'Gagal mengambil data pemasukan.';
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const fetchPengeluaran = async () => {
    loading.value = true;
    errors.value = {};
    try {
      const response = await api.get('/pengeluaran');
      pengeluaran.value = response.data;
    } catch (e) {
      errors.value.fetchPengeluaran = 'Gagal mengambil data pengeluaran.';
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const addPemasukan = async (data) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.post('/pemasukan', data);
      await fetchPemasukan(); // Re-fetch data to update the list
    } catch (e) {
      if (e.response && e.response.status === 422) {
        errors.value.addPemasukan = e.response.data.errors;
      } else {
        errors.value.addPemasukan = 'Terjadi kesalahan saat menambah data.';
      }
      throw e; // Re-throw error to be caught in the component
    } finally {
      loading.value = false;
    }
  };

  const addPengeluaran = async (data) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.post('/pengeluaran', data);
      await fetchPengeluaran(); // Re-fetch data to update the list
    } catch (e) {
      if (e.response && e.response.status === 422) {
        errors.value.addPengeluaran = e.response.data.errors;
      } else {
        errors.value.addPengeluaran = 'Terjadi kesalahan saat menambah data.';
      }
      throw e; // Re-throw error to be caught in the component
    } finally {
      loading.value = false;
    }
  };

  const updatePemasukan = async (id, data) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.put(`/pemasukan/${id}`, data);
      await fetchPemasukan();
    } catch (e) {
      if (e.response && e.response.status === 422) {
        errors.value.updatePemasukan = e.response.data.errors;
      } else {
        errors.value.updatePemasukan = 'Terjadi kesalahan saat mengubah data.';
      }
      throw e;
    } finally {
      loading.value = false;
    }
  };

  const updatePengeluaran = async (id, data) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.put(`/pengeluaran/${id}`, data);
      await fetchPengeluaran();
    } catch (e) {
      if (e.response && e.response.status === 422) {
        errors.value.updatePengeluaran = e.response.data.errors;
      } else {
        errors.value.updatePengeluaran = 'Terjadi kesalahan saat mengubah data.';
      }
      throw e;
    } finally {
      loading.value = false;
    }
  };

  const deletePemasukan = async (id) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.delete(`/pemasukan/${id}`);
      await fetchPemasukan();
    } catch (e) {
      errors.value.deletePemasukan = 'Terjadi kesalahan saat menghapus data.';
      throw e;
    } finally {
      loading.value = false;
    }
  };

  const deletePengeluaran = async (id) => {
    loading.value = true;
    errors.value = {};
    try {
      await api.delete(`/pengeluaran/${id}`);
      await fetchPengeluaran();
    } catch (e) {
      errors.value.deletePengeluaran = 'Terjadi kesalahan saat menghapus data.';
      throw e;
    } finally {
      loading.value = false;
    }
  };

  return {
    pemasukan,
    pengeluaran,
    loading,
    errors,
    fetchPemasukan,
    fetchPengeluaran,
    addPemasukan,
    addPengeluaran,
    updatePemasukan,
    updatePengeluaran,
    deletePemasukan,
    deletePengeluaran,
    clearKeuanganState,
  };
}
