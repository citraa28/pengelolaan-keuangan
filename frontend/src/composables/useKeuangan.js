import { ref, computed } from 'vue';
import api from '../api/axios';

// State reaktif di luar fungsi agar menjadi singleton
const pemasukan = ref([]);
const pengeluaran = ref([]);
// untuk menyimpan data chart 
const ringkasanChart = ref({
    data_pemasukan: Array(12).fill(0), // Default 12 bulan
    data_pengeluaran: Array(12).fill(0),
});
const loading = ref(false);
const errors = ref({});

export function useKeuangan() {

    const clearKeuanganState = () => {
        pemasukan.value = [];
        pengeluaran.value = [];
        ringkasanChart.value = {
            data_pemasukan: Array(12).fill(0),
            data_pengeluaran: Array(12).fill(0),
        };
        errors.value = {};
    };

    // --- FUNGSI BARU UNTUK BAR CHART ---
    const fetchChartSummary = async (year = new Date().getFullYear()) => {
        loading.value = true;
        errors.value = {};
        try {
            // Memanggil endpoint baru: /api/chart/summary?year=YYYY
            const response = await api.get(`/chart/summary?year=${year}`);
            
            // Langsung menyimpan data yang sudah diringkas
            ringkasanChart.value = {
                data_pemasukan: response.data.data_pemasukan || Array(12).fill(0),
                data_pengeluaran: response.data.data_pengeluaran || Array(12).fill(0),
            };
        } catch (e) {
            errors.value.fetchChartSummary = 'Gagal mengambil data ringkasan chart.';
            console.error(e);
        } finally {
            loading.value = false;
        }
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
      await fetchPemasukan(); // Re-fetch data list
      await fetchChartSummary(); // Update Bar Chart
    } catch (e) {
        if (e.response && e.response.status === 422) {
          errors.value.addPemasukan = e.response.data.errors;
          } else {
          errors.value.addPemasukan = 'Terjadi kesalahan saat menambah data.';
          }
          throw e; 
    } finally {
        loading.value = false;
    }
  };

  const addPengeluaran = async (data) => {
        loading.value = true;
        errors.value = {};
        try {
            await api.post('/pengeluaran', data);
            await fetchPengeluaran(); // Re-fetch data list
            await fetchChartSummary(); // Update Bar Chart
        } catch (e) {
             if (e.response && e.response.status === 422) {
                errors.value.addPengeluaran = e.response.data.errors;
            } else {
                errors.value.addPengeluaran = 'Terjadi kesalahan saat menambah data.';
            }
            throw e; 
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
      await fetchChartSummary();
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
      await fetchChartSummary();
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
      await fetchChartSummary();
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
      await fetchChartSummary();
    } catch (e) {
      errors.value.deletePengeluaran = 'Terjadi kesalahan saat menghapus data.';
      throw e;
    } finally {
      loading.value = false;
    }
  };

  const adaTransaksiHariIni = computed(() => {
    const today = new Date().toDateString(); // Compare date parts only
    
    const todayPemasukan = pemasukan.value.some(
      (item) => new Date(item.tanggal).toDateString() === today
    );
    const todayPengeluaran = pengeluaran.value.some(
      (item) => new Date(item.tanggal).toDateString() === today
    );

    return todayPemasukan || todayPengeluaran;
  });

  return {
    pemasukan,
    pengeluaran,
    ringkasanChart,
    loading,
    errors,
    adaTransaksiHariIni,
    fetchPemasukan,
    fetchPengeluaran,
    fetchChartSummary,
    addPemasukan,
    addPengeluaran,
    updatePemasukan,
    updatePengeluaran,
    deletePemasukan,
    deletePengeluaran,
    clearKeuanganState,
  };
}
