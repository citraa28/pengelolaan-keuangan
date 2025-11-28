<template>
  <LayoutPage>
    <div class="flex-1 md:p-8 overflow-auto">
      <div class="welcome-title">
        💸 Selamat Datang di Pengelolaan Keuangan Ajaib! ✨
      </div>

      <!-- Notifikasi Pengingat -->
      <div v-if="!adaTransaksiHariIni" class="notification-reminder">
        🤔 Jangan lupa catat transaksi keuanganmu hari ini ya!
      </div>

      <!-- Notifikasi Transaksi Hari Ini -->
      <div v-if="adaTransaksiHariIni" class="notification-today">
        🎉 Hebat! Kamu sudah mencatat transaksi hari ini. Terus lanjutkan!
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div
          @click="showDetailPemasukan = true"
          class="cursor-pointer bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-600 p-6 rounded-xl shadow-xl flex items-center text-white hover:opacity-90 transition transform hover:scale-[1.02]"
        >
          <div class="bg-white/20 p-4 rounded-full mr-4 backdrop-blur-sm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-green-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              />
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium opacity-80">
              Total Pemasukan Bulan Ini
            </p>
            <p class="text-3xl font-extrabold">
              {{ formatRupiah(totalPemasukanBulanIni) }}
            </p>
          </div>
        </div>

        <div
          @click="showDetailPengeluaran = true"
          class="cursor-pointer bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-600 p-6 rounded-xl shadow-xl flex items-center text-white hover:opacity-90 transition transform hover:scale-[1.02]"
        >
          <div class="bg-white/20 p-4 rounded-full mr-4 backdrop-blur-sm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-red-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M18 12H6"
              />
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium opacity-80">
              Total Pengeluaran Bulan Ini
            </p>
            <p class="text-3xl font-extrabold">
              {{ formatRupiah(totalPengeluaranBulanIni) }}
            </p>
          </div>
        </div>
      </div>

      <div
        v-if="showDetailPemasukan"
        class="fixed inset-0 bg-blue-950 bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
          <h2 class="text-lg font-bold mb-4">Detail Pemasukan</h2>
          <ul>
            <li
              v-for="(item, index) in pemasukanPerBulan"
              :key="index"
              class="flex justify-between border-b py-2"
            >
              <span>{{ item.bulan }}</span>
              <span class="font-semibold">{{ formatRupiah(item.total) }}</span>
            </li>
          </ul>
          <button
            @click="showDetailPemasukan = false"
            class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
          >
            Tutup
          </button>
        </div>
      </div>

      <div
        v-if="showDetailPengeluaran"
        class="fixed inset-0 bg-blue-950 bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
          <h2 class="text-lg font-bold mb-4">Detail Pengeluaran</h2>
          <ul>
            <li
              v-for="(item, index) in pengeluaranPerBulan"
              :key="index"
              class="flex justify-between border-b py-2"
            >
              <span>{{ item.bulan }}</span>
              <span class="font-semibold">{{ formatRupiah(item.total) }}</span>
            </li>
          </ul>
          <button
            @click="showDetailPengeluaran = false"
            class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
          >
            Tutup
          </button>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow my-3 md:my-10 p-4">
        <h1
          class="text-center text-xl md:text-3xl font-bold font-sans py-5 text-gray-700"
        >
          Grafik Perbandingan Pemasukan dan Pengeluaran
        </h1>
        <div class="overflow-x-auto">
          <div style="min-width: 400px; height: 400px">
            <BarChart
              v-if="dataChart.data.datasets.length"
              :chartData="dataChart.data"
              :chartOptions="dataChart.options"
            />
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div class="bg-white rounded-lg shadow p-4">
          <h1
            class="text-center text-xl md:text-2xl font-bold font-sans py-5 text-gray-700"
          >
            Distribusi Pemasukan per Kategori
          </h1>
          <div class="flex justify-center">
            <div class="w-full h-80 md:w-full md:h-96">
              <PieChart
                v-if="dataPieChartPemasukan.data.datasets.length"
                :chartData="dataPieChartPemasukan.data"
                :chartOptions="dataPieChartPemasukan.options"
              />
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
          <h1
            class="text-center text-xl md:text-2xl font-bold font-sans py-5 text-gray-700"
          >
            Distribusi Pengeluaran per Kategori
          </h1>
          <div class="flex justify-center">
            <div class="w-full h-80 md:w-full md:h-96">
              <PieChart
                v-if="dataPieChartPengeluaran.data.datasets.length"
                :chartData="dataPieChartPengeluaran.data"
                :chartOptions="dataPieChartPengeluaran.options"
              />
            </div>
          </div>
        </div>
      </div>

      <div
        class="mt-10 mb-15 text-center text-gray-600 font-sans text-base md:text-xl font-semibold px-4"
      >
        Mengelola keuangan bukan hanya tentang mencatat pemasukan dan
        pengeluaran, tapi tentang membangun kebiasaan yang membawa kita lebih
        dekat pada stabilitas dan impian finansial. Dengan langkah kecil yang
        konsisten, kamu sudah selangkah lebih maju menuju masa depan yang lebih
        aman dan terencana. Terus lanjutkan, karena setiap rupiah yang kamu
        kelola hari ini akan menentukan kenyamanan hidupmu esok hari.
      </div>

      <section class="bg-blue-200 rounded-2xl py-16 px-4 my-10">
        <div class="text-center mb-20">
          <h2 class="text-3xl md:text-5xl font-extrabold text-blue-900">
            Fitur gratis untuk semua<br />kebutuhan finansial
          </h2>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
          <div
            class="bg-blue-700 text-white p-6 rounded-2xl shadow-xl relative transform hover:scale-[1.05] transition duration-300"
          >
            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
              <div class="bg-white p-3 rounded-xl shadow-md">
                <img
                  src="../assets/money.png"
                  alt="Icon Tujuan"
                  class="w-12 h-12 object-contain"
                />
              </div>
            </div>
            <div class="pt-12">
              <h3 class="text-xl font-bold text-green-400 mb-2">
                Tujuan Keuangan
              </h3>
              <p class="text-sm">
                Ambil aksi untuk gapai mimpi.<br />
                Wujudkan impian dengan jangka waktu nabung yang kamu tentukan.
              </p>
            </div>
          </div>

          <div
            class="bg-blue-700 text-white p-6 rounded-2xl shadow-xl relative transform hover:scale-[1.05] transition duration-300"
          >
            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
              <div class="bg-white p-3 rounded-xl shadow-md">
                <img
                  src="../assets/note.png"
                  alt="Icon Transaksi"
                  class="w-12 h-12 object-contain"
                />
              </div>
            </div>
            <div class="pt-12">
              <h3 class="text-xl font-bold text-green-400 mb-2">
                Catat Transaksi
              </h3>
              <p class="text-sm">
                Otomatis atau manual, catat tiap pengeluaran untuk hari-hari
                anti boncos mendatang.
              </p>
            </div>
          </div>

          <div
            class="bg-blue-700 text-white p-6 rounded-2xl shadow-xl relative transform hover:scale-[1.05] transition duration-300"
          >
            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
              <div class="bg-white p-3 rounded-xl shadow-md">
                <img
                  src="../assets/budget.png"
                  alt="Icon Budget"
                  class="w-12 h-12 object-contain"
                />
              </div>
            </div>
            <div class="pt-12">
              <h3 class="text-xl font-bold text-green-400 mb-2">Budgeting</h3>
              <p class="text-sm">
                Semua ada budgetnya, kok!<br />
                Atur anggaran keuangan kamu untuk segala kebutuhan bareng
                Sribuu.
              </p>
            </div>
          </div>
        </div>
      </section>

      <div
        class="flex flex-col-reverse md:flex-row items-center justify-between mt-10 px-6 md:px-20 py-12 gap-10 bg-white rounded-xl shadow-xl"
      >
        <img
          src="../assets/keuangan.jpeg"
          alt="Ilustrasi Keuangan Cerdas"
          class="w-full md:w-5/12 h-auto object-contain rounded-xl shadow-lg"
        />

        <div class="w-full md:w-6/12 flex flex-col items-start text-left gap-4">
          <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800">
            Cerdas berfinansial dengan rekomendasi pintar
          </h1>
          <p class="text-gray-600 text-sm md:text-base">
            Dapatkan insight dan rekomendasi bulanan yang bisa ngasih kamu
            arahan biar lebih bijak dalam ngatur uang.
          </p>
        </div>
      </div>

      <div class="md:justify-center mt-10 pt-10 pb-20 bg-blue-50/50">
        <h1
          class="text-3xl text-center md:text-4xl font-extrabold font-sans text-blue-800 mb-16"
        >
          Ringkas dan Rapi dengan<br />
          Website Keuangan MAYTRA Finance
        </h1>

        <div
          class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto px-4"
        >
          <div class="feature-card-fun border-blue-400">
            <div class="icon-bubble bg-blue-100">
              <img
                src="../assets/ready.png"
                alt="Siap Pakai"
                class="w-16 h-16 object-contain"
              />
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-blue-700 mb-2">
              🚀 Siap Pakai!
            </h2>
            <p class="text-base md:text-base text-gray-600">
              Tanpa perlu buat program dari awal, tinggal daftar dan langsung
              siap digunakan.
            </p>
          </div>

          <div class="feature-card-fun border-green-400">
            <div class="icon-bubble bg-green-100">
              <img
                src="../assets/free.png"
                alt="Gratis"
                class="w-16 h-16 object-contain"
              />
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-2">
              💸 Gratis dan Praktis
            </h2>
            <p class="text-base md:text-base text-gray-600">
              Bebas biaya, pencatatan otomatis terintegrasi dengan setiap
              transaksi keuanganmu
            </p>
          </div>

          <div class="feature-card-fun border-yellow-400">
            <div class="icon-bubble bg-yellow-100">
              <img
                src="../assets/pemula.png"
                alt="Pemula"
                class="w-16 h-16 object-contain"
              />
            </div>
            <h2
              class="text-2xl md:text-3xl font-extrabold text-yellow-700 mb-2"
            >
              👶 Cocok untuk Pemula
            </h2>
            <p class="text-base md:text-lg text-gray-600">
              Website yang super simple dan sangat bermanfaat, dirancang agar
              mudah digunakan siapa saja!
            </p>
          </div>

          <div class="feature-card-fun border-red-400">
            <div class="icon-bubble bg-red-100">
              <img
                src="../assets/safety.png"
                alt="Safety"
                class="w-16 h-16 object-contain"
              />
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-red-700 mb-2">
              🔒 Jaminan Keamanan Data
            </h2>
            <p class="text-base md:text-lg text-gray-600">
              Data Anda terenkripsi dan terjaga dengan **standar keamanan
              informasi** tertinggi.
            </p>
          </div>
        </div>
      </div>
    </div>
  </LayoutPage>
</template>

<script setup>
import LayoutPage from "../layout/LayoutPage.vue";
import { ref, computed, onMounted, watch } from "vue";
import BarChart from "../components/BarChart.vue";
import PieChart from "../components/PieChart.vue";
import { useKeuangan } from "../composables/useKeuangan.js";

// Get the centralized state and fetch functions
const {
  pemasukan,
  pengeluaran,
  ringkasanChart,
  fetchPemasukan,
  fetchPengeluaran,
  fetchChartSummary,
  adaTransaksiHariIni,
} = useKeuangan();

const showDetailPemasukan = ref(false);
const showDetailPengeluaran = ref(false);

// Fetch data on mount if not already present
onMounted(() => {
  if (pemasukan.value.length === 0) {
    fetchPemasukan();
  }
  if (pengeluaran.value.length === 0) {
    fetchPengeluaran();
  }
  fetchChartSummary();
});

// --- Computed Properties for Display ---

const totalPemasukanBulanIni = computed(() => {
  const now = new Date();
  return pemasukan.value
    .filter((item) => {
      const date = new Date(item.tanggal);
      return (
        date.getMonth() === now.getMonth() &&
        date.getFullYear() === now.getFullYear()
      );
    })
    .reduce((total, item) => total + Number(item.jumlah), 0);
});

const totalPengeluaranBulanIni = computed(() => {
  const now = new Date();
  return pengeluaran.value
    .filter((item) => {
      const date = new Date(item.tanggal);
      return (
        date.getMonth() === now.getMonth() &&
        date.getFullYear() === now.getFullYear()
      );
    })
    .reduce((total, item) => total + Number(item.jumlah), 0);
});

const pemasukanPerBulan = computed(() => {
  const grouped = {};
  pemasukan.value.forEach((item) => {
    const date = new Date(item.tanggal);
    const bulan = date.toLocaleString("id-ID", {
      month: "long",
      year: "numeric",
    });
    if (!grouped[bulan]) grouped[bulan] = 0;
    grouped[bulan] += Number(item.jumlah);
  });
  return Object.entries(grouped)
    .map(([bulan, total]) => ({ bulan, total }))
    .sort((a, b) => new Date(b.bulan) - new Date(a.bulan))
    .reverse();
});

const pengeluaranPerBulan = computed(() => {
  const grouped = {};
  pengeluaran.value.forEach((item) => {
    const date = new Date(item.tanggal);
    const bulan = date.toLocaleString("id-ID", {
      month: "long",
      year: "numeric",
    });
    if (!grouped[bulan]) grouped[bulan] = 0;
    grouped[bulan] += Number(item.jumlah);
  });
  return Object.entries(grouped)
    .map(([bulan, total]) => ({ bulan, total }))
    .sort((a, b) => new Date(b.bulan) - new Date(a.bulan))
    .reverse();
});

// --- Chart Data ---

const dataChart = ref({
  data: {
    labels: [
      "Januari", 
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ],
    datasets: [],
  },
  options: { responsive: true, maintainAspectRatio: false },
});

const dataPieChartPemasukan = ref({
  data: { labels: [], datasets: [] },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: true, position: "bottom" } },
  },
});

const dataPieChartPengeluaran = ref({
  data: { labels: [], datasets: [] },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: true, position: "bottom" } },
  },
});

// Watch for data changes to update charts
watch(
  [ringkasanChart, pemasukan, pengeluaran],
  () => {
    if (!ringkasanChart.value.data_pemasukan || !ringkasanChart.value.data_pengeluaran) {
        return; 
    }
    const currentYear = new Date().getFullYear();

    const dataPemasukan = ringkasanChart.value.data_pemasukan;
    const dataPengeluaran = ringkasanChart.value.data_pengeluaran;

    dataChart.value.data.datasets = [
      {
        label: "Pemasukan",
        data: dataPemasukan,
        backgroundColor: "rgba(75, 192, 192, 0.2)",
        borderColor: "rgba(75, 192, 192, 1)",
        borderWidth: 1,
      },
      {
        label: "Pengeluaran",
        data: dataPengeluaran,
        backgroundColor: "#FF6389",
        borderColor: "rgba(255, 99, 132, 1)",
        borderWidth: 1,
      },
    ];

    // Pie Chart Pemasukan
    if (pemasukan.value.length > 0) {
        const kategoriPemasukanMap = {};
        pemasukan.value.forEach((item) => {
          const kategori = item.kategori?.nama_kategori || "Lainnya";
          if (!kategoriPemasukanMap[kategori]) kategoriPemasukanMap[kategori] = 0;
          kategoriPemasukanMap[kategori] += Number(item.jumlah);
        });

    dataPieChartPemasukan.value.data = {
      labels: Object.keys(kategoriPemasukanMap),
      datasets: [
        {
          data: Object.values(kategoriPemasukanMap),
          backgroundColor: [
            "#36A2EB",
            "#FF6384",
            "#FFCE56",
            "#4BC0C0",
            "#9966FF",
            "#FF9F40",
            "#8BC34A",
            "#F44336",
          ],
        },
      ],
    };
    } else {
        // Kosongkan jika tidak ada data
        dataPieChartPemasukan.value.data.datasets = [];
    }

    // Pie Chart Pengeluaran
    const kategoriPengeluaranMap = {};
    pengeluaran.value.forEach((item) => {
      const kategori = item.kategori?.nama_kategori || "Lainnya";
      if (!kategoriPengeluaranMap[kategori])
        kategoriPengeluaranMap[kategori] = 0;
      kategoriPengeluaranMap[kategori] += Number(item.jumlah);
    });

    dataPieChartPengeluaran.value.data = {
      labels: Object.keys(kategoriPengeluaranMap),
      datasets: [
        {
          data: Object.values(kategoriPengeluaranMap),
          backgroundColor: [
            "#FF6384",
            "#36A2EB",
            "#FFCE56",
            "#4BC0C0",
            "#9966FF",
            "#FF9F40",
            "#8BC34A",
            "#F44336",
          ],
        },
      ],
    };
  },
  { deep: true, immediate: true }
);

// Utility function
function formatRupiah(angka) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(Number(angka) || 0);
}
</script>

<style>
/* Style Title Utama (welcome-title) */
.welcome-title {
  text-align: center;
  padding: 1.5rem; /* p-6 */
  background-color: white;
  border-radius: 1rem; /* rounded-2xl */
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
    0 10px 10px -5px rgba(0, 0, 0, 0.04); /* shadow-xl */
  font-size: 1.25rem; /* text-xl */
  font-weight: 800; /* font-extrabold */
  color: #2563eb; /* text-blue-600 */
  border: 1px solid #93c5fd; /* border-blue-400 */
  /* Font Family dan Text Shadow */
  font-family: "Comfortaa", sans-serif;
  text-shadow: 1px 1px 0px white, -1px -1px 0px white,
    0 0 5px rgba(59, 130, 246, 0.3);
}

/* Penyesuaian font-size responsive untuk welcome-title */
@media (min-width: 768px) {
  .welcome-title {
    font-size: 2rem; /* md:text-3xl */
  }
}

.text-shadow {
  text-shadow: 2px 3px 4px rgba(0, 0, 0, 0.3);
}
/* STYLE KARTU FITUR (Ringkas dan Rapi) */
.feature-card-fun {
  /* Tampilan Default */
  background-color: white;
  border-radius: 1.5rem; /* rounded-3xl */
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
    0 10px 10px -5px rgba(0, 0, 0, 0.04); /* shadow-xl */
  padding: 1.5rem; /* p-6 */
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;

  /* Animasi dan Border */
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
  border-bottom-width: 4px;
}

/* Efek Hover Lucu */
.feature-card-fun:hover {
  transform: scale(1.05); /* hover:scale-[1.05] */
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* shadow-2xl */
}

/* Style Gelembung Ikon */
.icon-bubble {
  padding: 0.75rem; /* p-3 */
  border-radius: 9999px; /* rounded-full */
  margin-bottom: 1.5rem; /* mb-6 */
}

.text-shadow {
  text-shadow: 2px 3px 4px rgba(0, 0, 0, 0.3);
}

/* Style untuk notifikasi pengingat */
.notification-reminder {
  background-color: #fef3c7; /* Tailwind amber-100 */
  color: #92400e; /* Tailwind amber-800 */
  padding: 1rem;
  border-radius: 0.5rem; /* rounded-lg */
  margin-top: 1.5rem;
  text-align: center;
  font-weight: 500;
  border: 1px solid #fcd34d; /* amber-300 */
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Style untuk notifikasi transaksi hari ini */
.notification-today {
  background-color: #d1fae5; /* Tailwind green-100 */
  color: #065f46; /* Tailwind green-800 */
  padding: 1rem;
  border-radius: 0.5rem; /* rounded-lg */
  margin-top: 1.5rem;
  text-align: center;
  font-weight: 500;
  border: 1px solid #6ee7b7; /* green-300 */
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>
