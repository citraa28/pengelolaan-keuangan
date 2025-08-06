<template>
  <LayoutPage>
    <!-- Konten Utama -->
    <header class="bg-white p-8 mx-3 text-center shadow rounded-md mb-6">
      <div class="flex flex-col items-center justify-center">
        <h1
          class="text-3xl font-bold font-inter pb-1/ \ text-gray-800 flex items-center gap-2"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-8 h-8"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"
            />
          </svg>
          Pemasukan Uang
        </h1>
        <p><i>Ayo Kendalikan Uangmu</i></p>
      </div>
    </header>

    <div class="p-5 m-2.5 bg-white rounded-lg shadow-md">
      <div class="mb-4 flex justify-start">
        <button
          @click="tambahData"
          class="bg-gradient-to-r from-sky-300 via-blue-400 to-indigo-700 text-white px-4 py-2 mb-5 rounded hover:bg-blue-950"
        >
          + Tambah Data
        </button>
      </div>

      <div class="p-5 m-2.5 bg-white rounded-lg shadow-md">
        <!-- Show entries control -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
          <div class="flex items-center space-x-2">
            <label for="entries" class="text-sm text-gray-800">Show</label>
            <select
              id="entries"
              v-model="entriesToShow"
              class="w-20 px-2 py-1 border border-gray-400 rounded text-sm"
            >
              <option v-for="num in entryOptions" :key="num" :value="num">
                {{ num }}
              </option>
            </select>
            <span class="text-sm text-gray-700">entries</span>
          </div>

          <!-- Kotak pencarian -->
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari keterangan atau tanggal..."
            class="px-3 py-2 border border-gray-400 rounded text-sm w-64"
          />
        </div>

        <div class="w-full overflow-x-scroll">
          <table class="min-w-full bg-white border-gray-800 overflow-hidden">
            <thead class="bg-gray-300 text-gray-800">
              <tr>
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Keterangan</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Jumlah</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in paginatedPemasukan"
                :key="item.id"
                class="text-center"
              >
                <td class="px-4 py-2 border">
                  {{ (currentPage - 1) * entriesToShow + index + 1 }}
                </td>
                <td class="px-4 py-2 border">{{ item.keterangan }}</td>
                <td class="px-4 py-2 border">{{ item.tanggal }}</td>
                <td class="px-4 py-2 border">
                  {{ formatRupiah(item.jumlah) }}
                </td>
                <td class="px-4 py-2 border">
                  <button
                    @click="editData(item.id)"
                    class="bg-blue-500 rounded-2xl px-5 py-1 text-white hover:underline mr-2"
                  >
                    Edit
                  </button>
                  <button
                    @click="hapusData(item.id)"
                    class="bg-red-600 rounded-2xl px-3 py-1 text-white hover:underline"
                  >
                    Hapus
                  </button>
                </td>
              </tr>
              <tr v-if="paginatedPemasukan.length === 0">
                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                  Tidak ada data
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <ul class="flex justify-center gap-1 text-gray-900 mt-8 mb-17">
          <li>
            <button
              @click.prevent="prevPage"
              class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50"
              :disabled="currentPage === 1"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="size-4"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </li>

          <li v-for="page in totalPages" :key="page">
            <button
              @click.prevent="goToPage(page)"
              class="block size-8 rounded border text-sm font-medium text-center transition-colors"
              :class="{
                'border-indigo-600 bg-indigo-600 text-white':
                  currentPage === page,
                'border-gray-200 hover:bg-gray-50': currentPage !== page,
              }"
            >
              {{ page }}
            </button>
          </li>

          <li>
            <button
              @click.prevent="nextPage"
              class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50"
              :disabled="currentPage === totalPages"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="size-4"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </li>
        </ul>

        <!-- Total Pemasukan Bulan Ini -->
        <div class="flex items-center justify-start gap-6 mt-6">
          <!-- Card -->
          <div class="card">
            <p class="text-white font-bold text-lg">
              Total Pemasukan Bulan Ini :
            </p>
            <div class="card__content text-center">
              <p class="card__description">
                <span class="text-blue-700 text-center font-bold text-3xl">
                  {{ formatRupiah(totalPemasukanBulanIni) }}
                </span>
              </p>
            </div>
          </div>

          <!-- Motivational or informational message -->
          <div class="ml-6 flex flex-col justify-center max-w-sm text-gray-800">
            <h2 class="text-xl font-semibold mb-2">Tips Hemat Bulan Ini!</h2>
            <p class="text-sm leading-relaxed">
              Coba alokasikan minimal <strong>20%</strong> dari pemasukan kamu
              untuk ditabung. Buat prioritas belanja, dan hindari pembelian
              impulsif. 💰
            </p>
            <p class="mt-4 text-sm italic text-blue-600">#UangmuKendalikan</p>
          </div>
        </div>

        <!-- Form Tambah -->
        <TambahData
          v-if="showForm"
          @close="showForm = false"
          @simpan="tambahKeData"
        />
        <!-- Form Edit -->
        <EditData
          v-if="showEdit"
          :model-value="dataSedangDiedit"
          @update="perbaruiData"
          @close="showEdit = false"
        />
        <!-- Dialog Konfirmasi Hapus -->
        <DeleteData
          v-if="showDeleteConfirmation"
          @confirm="confirmDelete"
          @close="closeDeleteConfirmation"
        />
        <footer class="bg-gray-50">
          <div class="mt-7 mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between">
              <p
                class="mt-4 text-center text-sm text-gray-500 lg:mt-0 lg:text-right"
              >
                Copyright &copy; 2025 CitraMaya. All rights reserved.
              </p>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </LayoutPage>
</template>

<script setup>
import { ref, onMounted, watch, computed } from "vue";
import LayoutPage from "../layout/LayoutPage.vue";
import TambahData from "../components/TambahData.vue";
import EditData from "../components/EditData.vue";
import DeleteData from "../components/DeleteData.vue";

// State
const showForm = ref(false);
const showEdit = ref(false);
const showDeleteConfirmation = ref(false);
const itemToDeleteId = ref(null);
const dataSedangDiedit = ref({});

const dataPemasukan = ref([]); // semua data
const dataBulanIni = ref([]); // hanya data bulan ini
const dataRekap = ref([]); // data bulan lalu

// Show entries
const entriesToShow = ref(5);
const entryOptions = [5, 10, 25, 50, 100];

const searchQuery = ref("");
const currentPage = ref(1);

// Menghitung total pemasukan bulan ini
const totalPemasukanBulanIni = computed(() => {
  const sekarang = new Date();
  const bulanIni = sekarang.getMonth();
  const tahunIni = sekarang.getFullYear();

  const dataBulanIni = dataPemasukan.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() === bulanIni && tanggal.getFullYear() === tahunIni
    );
  });

  return dataBulanIni.reduce((total, item) => total + Number(item.jumlah), 0);
});

// Ambil data dari localStorage saat mounted

onMounted(() => {
  const saved = localStorage.getItem("dataPemasukan");
  const parsed = saved ? JSON.parse(saved) : [];

  const sekarang = new Date();
  const bulanIni = sekarang.getMonth();
  const tahunIni = sekarang.getFullYear();

  // Pisahkan data bulan ini dan rekap
  dataBulanIni.value = parsed.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() === bulanIni && tanggal.getFullYear() === tahunIni
    );
  });

  dataRekap.value = parsed.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() !== bulanIni || tanggal.getFullYear() !== tahunIni
    );
  });

  dataPemasukan.value = parsed; // tetap simpan semuanya jika ingin akses rekap
});

// Reset ke halaman 1 saat show entries atau pencarian berubah
watch([entriesToShow, searchQuery], () => {
  currentPage.value = 1;
});

watch(
  dataPemasukan,
  () => {
    // Gabungkan kembali rekap + data bulan ini untuk simpan ke localStorage
    const semua = [...dataRekap.value, ...dataBulanIni.value];
    localStorage.setItem("dataPemasukan", JSON.stringify(semua));
  },
  { deep: true }
);

// Total halaman berdasarkan data terfilter
const filteredPemasukan = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return dataBulanIni.value.filter(
    (item) =>
      item.keterangan.toLowerCase().includes(query) ||
      item.tanggal.toLowerCase().includes(query)
  );
});

const totalPages = computed(() => {
  return Math.ceil(filteredPemasukan.value.length / entriesToShow.value);
});

// Data yang ditampilkan per halaman
const paginatedPemasukan = computed(() => {
  const start = (currentPage.value - 1) * entriesToShow.value;
  return filteredPemasukan.value.slice(start, start + entriesToShow.value);
});

// Fungsi tambah data
function tambahData() {
  showForm.value = true;
}

function tambahKeData(dataBaru) {
  dataBaru.id = Date.now();
  dataPemasukan.value.push(dataBaru);

  const tanggal = new Date(dataBaru.tanggal);
  const sekarang = new Date();
  if (
    tanggal.getMonth() === sekarang.getMonth() &&
    tanggal.getFullYear() === sekarang.getFullYear()
  ) {
    dataBulanIni.value.push(dataBaru);
  } else {
    dataRekap.value.push(dataBaru);
  }
}

// Format angka ke rupiah
function formatRupiah(angka) {
  return "Rp " + new Intl.NumberFormat("id-ID").format(Number(angka) || 0);
}

function updateDataBulanIni() {
  const sekarang = new Date();
  const bulanIni = sekarang.getMonth();
  const tahunIni = sekarang.getFullYear();

  dataBulanIni.value = dataPemasukan.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() === bulanIni && tanggal.getFullYear() === tahunIni
    );
  });

  dataRekap.value = dataPemasukan.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() !== bulanIni || tanggal.getFullYear() !== tahunIni
    );
  });
}

// Fungsi edit data
function editData(id) {
  const item = dataPemasukan.value.find((item) => item.id === id);
  if (item) {
    dataSedangDiedit.value = { ...item };
    showEdit.value = true;
  }
}

// Fungsi update setelah diedit
function perbaruiData(updated) {
  const index = dataPemasukan.value.findIndex((item) => item.id === updated.id);
  if (index !== -1) {
    dataPemasukan.value.splice(index, 1, { ...updated });

    updateDataBulanIni();
  }
}

// Fungsi untuk menampilkan dialog konfirmasi hapus
function hapusData(id) {
  itemToDeleteId.value = id;
  showDeleteConfirmation.value = true;
}

// Fungsi yang dijalankan setelah konfirmasi hapus
function confirmDelete() {
  const index = dataPemasukan.value.findIndex(
    (item) => item.id === itemToDeleteId.value
  );
  if (index !== -1) {
    dataPemasukan.value.splice(index, 1);
  }
  closeDeleteConfirmation();
  updateDataBulanIni();
}

// Fungsi untuk menutup dialog konfirmasi
function closeDeleteConfirmation() {
  showDeleteConfirmation.value = false;
  itemToDeleteId.value = null;
}
// Pagination
function prevPage() {
  if (currentPage.value > 1) currentPage.value--;
}
function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++;
}
function goToPage(page) {
  currentPage.value = page;
}
</script>

<style scoped>
.card {
  position: relative;
  width: 300px;
  height: 200px;
  background: linear-gradient(-45deg, #38bdf8, #3b82f6, #6366f1);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.card svg {
  width: 48px;
  fill: #333;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.card:hover {
  transform: rotate(-5deg) scale(1.1);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card__content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-45deg);
  width: 100%;
  height: 100%;
  padding: 20px;
  text: center;
  box-sizing: border-box;
  background-color: #fff;
  opacity: 0;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.card:hover .card__content {
  transform: translate(-50%, -50%) rotate(0deg);
  opacity: 1;
}

.card__title {
  margin: 0;
  font-size: 24px;
  color: #333;
  font-weight: 700;
}

.card__description {
  margin: 10px 0 0;
  font-size: 14px;
  text: center;
  color: #777;
  line-height: 1.4;
}

.card:hover svg {
  scale: 0;
  transform: rotate(-45deg);
}
</style>
