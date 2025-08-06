<template>
  <LayoutPage>
    <div class="flex-1 p-6 md:p-8 overflow-auto">
      <!-- Welcome -->
      <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow text-2xl font-semibold text-gray-700 dark:text-gray-100 border border-gray-200 dark:border-gray-700">

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
            <p class="text-gray-500 dark:text-gray-300 text-sm">Total Pemasukan Bulan Ini</p>
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
            <p class="text-gray-500 text-sm">Total Pengeluaran Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-800">
              {{ formatRupiah(totalPengeluaranBulanIni) }}
            </p>
          </div>
        </div>
      </div>

      <div
        class="relative mx-4 my-10 flex-1 min-w-[600px] bg-white"
        style="height: 400px"
      >
        <!-- Chart -->
        <div
          class="relative mx-4 my-10 flex-1 p-5 bg-white"
          style="height: 400px"
        >
          <BarChart
            v-if="dataChart.data.datasets.length"
            :chartData="dataChart.data"
            :chartOptions="dataChart.options"
          />
        </div>
        <hr />

        <!-- Pie Chart -->
        <div
          class="relative mx-4 my-10 p-5 flex-1 bg-white"
          style="height: 400px"
        >
          <PieChart
            v-if="dataChart.data.datasets.length"
            :chartData="dataChart.data"
            :chartOptions="dataChart.options"
          />
        </div>
      </div>
    </div>
  </LayoutPage>
</template>

<script setup>
import LayoutPage from "../layout/LayoutPage.vue";
import { ref, computed, onMounted } from "vue";
import BarChart from "../components/BarChart.vue";
import PieChart from "../components/PieChart.vue";

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
    dataPemasukanBulanan[bulan] += Number(item.jumlah);
  });
  dataPengeluaran.value.forEach((item) => {
    const date = new Date(item.tanggal);
    const bulan = date.getMonth();
    dataPengeluaranBulanan[bulan] += Number(item.jumlah);
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
      backgroundColor: "#FF6384",
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
    .reduce((total, item) => total + Number(item.jumlah), 0);
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
    .reduce((total, item) => total + Number(item.jumlah), 0);
});

function formatRupiah(angka) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(Number(angka) || 0);
}
</script>
