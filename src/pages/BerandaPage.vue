<template>
  <LayoutPage>
    <div class="flex-1 md:p-8 overflow-auto">
      <!-- Welcome -->
      <div
        class="text-center text-shadow font-serif md:font-mono animate-bounce p-6 bg-white rounded-lg shadow text-2xl md:text-3xl font-semibold text-blue-900 border border-blue-300"
      >
        SELAMAT DATANG DI PENGELOLAAN KEUANGAN ANDA!
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <!-- Pemasukan -->
        <div
          class="bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-600 p-6 rounded-lg shadow-lg flex items-center text-white"
        >
          <div class="bg-green-100 p-4 rounded-full mr-4">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-green-500"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              />
            </svg>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-300 text-sm">
              Total Pemasukan Bulan Ini
            </p>
            <p class="text-2xl font-bold text-gray-800">
              {{ formatRupiah(totalPemasukanBulanIni) }}
            </p>
          </div>
        </div>

        <!-- Pengeluaran -->
        <div
          class="bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-600 p-6 rounded-lg shadow flex items-center"
        >
          <div class="bg-red-100 p-4 rounded-full mr-4">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-red-500"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M18 12H6"
              />
            </svg>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-300 text-sm">
              Total Pengeluaran Bulan Ini
            </p>
            <p class="text-2xl font-bold text-gray-800">
              {{ formatRupiah(totalPengeluaranBulanIni) }}
            </p>
          </div>
        </div>
      </div>

      <!-- Bar Chart -->
      <div class="bg-white rounded-lg shadow gap-5 my-10 p-4">
        <h1 class="text-center text-lg md:text-2xl font-bold font-serif py-5">
          Data Pemasukan Dan Pengeluaran
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

      <div
        class="mt-10 mb-15 text-center text-gray-800 dark:text-black text-lg"
      >
        Mengelola keuangan bukan hanya tentang mencatat pemasukan dan
        pengeluaran, tapi tentang membangun kebiasaan yang membawa kita lebih
        dekat pada stabilitas dan impian finansial. Dengan langkah kecil yang
        konsisten, kamu sudah selangkah lebih maju menuju masa depan yang lebih
        aman dan terencana. Terus lanjutkan, karena setiap rupiah yang kamu
        kelola hari ini akan menentukan kenyamanan hidupmu esok hari. 💰📈
      </div>

      <section class="bg-blue-200 rounded-lg py-16 px-4">
        <div class="text-center mb-20">
          <h2 class="text-3xl md:text-5xl font-bold text-blue-900">
            Fitur gratis untuk semua<br />kebutuhan finansial
          </h2>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Card 1 -->
          <div
            class="bg-blue-700 text-white p-6 rounded-2xl shadow-md relative"
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

          <!-- Card 2 -->
          <div
            class="bg-blue-700 text-white p-6 rounded-2xl shadow-md relative"
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

          <!-- Card 3 -->
          <div
            class="bg-blue-700 text-white p-6 rounded-2xl shadow-md relative"
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
        class="flex flex-col-reverse md:flex-row items-center justify-between mt-10 px-6 md:px-20 py-12 gap-15"
      >
        <!-- Gambar di sebelah kiri -->
        <img
          src="../assets/keuangan.jpeg"
          alt="Icon Budget"
          class="w-full md:w-md h-auto object-contain"
        />

        <!-- Teks di sebelah kanan -->
        <div class="w-full md:w-1/2 flex flex-col items-start text-left gap-4">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-700">
            Cerdas berfinansial dengan rekomendasi pintar
          </h1>
          <p class="text-gray-500 text-lg">
            Dapatkan insight dan rekomendasi bulanan yang bisa ngasih kamu
            arahan biar lebih bijak dalam ngatur uang.
          </p>
        </div>
      </div>

      <div class="md:justify-center mt-10">
        <!-- Judul -->
        <h1
          class="text-3xl text-center md:text-4xl font-serif font-bold text-gray-700 mb-10"
        >
          Ringkas dan Rapi dengan<br />
          Website Keuangan MAYTRA Finance
        </h1>

        <!-- Grid 2x2 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Item 1 -->
          <div class="flex flex-col items-center text-center">
            <img
              src="../assets/ready.png"
              alt="Ready"
              class="w-14 md:w-23 h-auto object-contain mb-4"
            />
            <h2 class="text-xl md:text-2xl font-bold text-gray-700">
              Siap Pakai
            </h2>
            <p class="text-base md:text-lg text-gray-700">
              Tanpa perlu buat program dari awal, tinggal daftar dan langsung
              gunakan
            </p>
          </div>

          <!-- Item 2 -->
          <div class="flex flex-col items-center text-center">
            <img
              src="../assets/free.png"
              alt="Ready"
              class="w-14 md:w-25 h-auto object-contain mb-4"
            />
            <h2 class="text-xl md:text-2xl font-bold text-gray-700">
              Gratis dan Praktis
            </h2>
            <p class="text-base md:text-lg text-gray-700">
              Bebas biaya, pencatatan otomatis terintegrasi dengan setiap
              invoice pembelian dan penjualan di Website MAYTRA Finance
            </p>
          </div>

          <!-- Item 3 -->
          <div class="flex flex-col items-center text-center">
            <img
              src="../assets/pemula.png"
              alt="Ready"
              class="w-14 md:w-25 h-auto object-contain mb-4"
            />
            <h2 class="text-xl md:text-2xl font-bold text-gray-700">
              Cocok Digunakan untuk Pemula
            </h2>
            <p class="text-base md:text-lg text-gray-700">
              Website yang simple, tapi sangat bermanfaat dan mudah digunakan
              untuk pemula
            </p>
          </div>

          <!-- Item 4 -->
          <div class="flex flex-col items-center text-center">
            <img
              src="../assets/safety.png"
              alt="Ready"
              class="w-14 md:w-25 h-auto object-contain mb-4"
            />
            <h2 class="text-xl md:text-2xl font-bold text-gray-700">
              Jaminan Keamanan Data
            </h2>
            <p class="text-base md:text-lg text-gray-700">
              Data Anda terjaga dengan standar keamanan informasi
            </p>
          </div>
        </div>
      </div>
    </div>
  </LayoutPage>
</template>

<script setup>
import LayoutPage from "../layout/LayoutPage.vue";
import { ref, computed, onMounted } from "vue";
import BarChart from "../components/BarChart.vue";

const dataPemasukan = ref([]);
const dataPengeluaran = ref([]);
const dataChart = ref({
  data: {
    labels: [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ],
    datasets: [],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
  },
});

onMounted(() => {
  const pemasukanSaved = localStorage.getItem("dataPemasukan");
  dataPemasukan.value = pemasukanSaved ? JSON.parse(pemasukanSaved) : [];

  const pengeluaranSaved = localStorage.getItem("dataPengeluaran");
  dataPengeluaran.value = pengeluaranSaved ? JSON.parse(pengeluaranSaved) : [];

  // Looping untuk menjumlahkan per bulan
  const dataPemasukanBulanan = Array(12).fill(0);
  const dataPengeluaranBulanan = Array(12).fill(0);

  dataPemasukan.value.forEach((item) => {
    const date = new Date(item.tanggal);
    const bulan = date.getMonth();
    dataPemasukanBulanan[bulan] += Number(item.harga);
  });
  dataPengeluaran.value.forEach((item) => {
    const date = new Date(item.tanggal);
    const bulan = date.getMonth();
    dataPengeluaranBulanan[bulan] += Number(item.harga);
  });

  // Update datachart dengan hasil looping
  dataChart.value.data.datasets = [
    {
      label: "Pemasukan",
      data: dataPemasukanBulanan,
      backgroundColor: "rgba(75, 192, 192, 0.2)",
      borderColor: "rgba(75, 192, 192, 1)",
      borderWidth: 1,
    },
    {
      label: "Pengeluaran",
      data: dataPengeluaranBulanan,
      backgroundColor: "#FF6389",
      borderColor: "rgba(255, 99, 132, 1)",
      borderWidth: 1,
    },
  ];
});

const totalPemasukanBulanIni = computed(() => {
  const now = new Date();
  return dataPemasukan.value
    .filter((item) => {
      const date = new Date(item.tanggal);
      return (
        date.getMonth() === now.getMonth() &&
        date.getFullYear() === now.getFullYear()
      );
    })
    .reduce((total, item) => total + Number(item.harga), 0);
});

const totalPengeluaranBulanIni = computed(() => {
  const now = new Date();
  return dataPengeluaran.value
    .filter((item) => {
      const date = new Date(item.tanggal);
      return (
        date.getMonth() === now.getMonth() &&
        date.getFullYear() === now.getFullYear()
      );
    })
    .reduce((total, item) => total + Number(item.harga), 0);
});

function formatRupiah(angka) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(Number(angka) || 0);
}
</script>

<style>
.text-shadow {
  text-shadow: 2px 3px 4px rgba(0, 0, 0, 0.3);
}
</style>
