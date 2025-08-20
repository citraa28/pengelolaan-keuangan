<template>
  <LayoutPage>
    <!-- Konten Utama -->
    <header
      class="bg-white border border-blue-400 font-fredoka animate-bounce p-3 mb-6 mx-3 text-center shadow-lg rounded-xl"
    >
      <div class="flex flex-col items-center justify-center">
        <img
          src="../assets/pengeluaran.png"
          alt="Icon pengeluaran"
          class="w-21 h-21 object-contain"
        />
        <h1
          class="text-3xl font-bold font-inter pb-2 text-gray-800 flex items-center gap-2"
        >
          Pengeluaran Uang
        </h1>
        <p><i>Awali hari dengan mencatat pengeluaran secara rapi</i></p>
      </div>
    </header>

    <div class="p-1 rounded-lg shadow-md">
      <!-- Flex container untuk tombol + filter -->
      <div class="flex flex-wrap items-center justify-between mb-5 gap-3">
        <!-- Tombol tambah data -->
        <button
          @click="tambahData"
          class="bg-gradient-to-r from-sky-300 via-blue-400 to-indigo-700 text-white px-4 py-2 rounded hover:bg-blue-950"
        >
          + Tambah Data
        </button>

        <!-- Filter bulan & tahun -->
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2">
            <label for="bulan" class="text-sm text-gray-800">Bulan</label>
            <select
              id="bulan"
              v-model="filterBulan"
              class="w-24 px-2 py-1 border border-gray-400 rounded text-sm"
            >
              <option v-for="(nama, i) in namaBulan" :key="i" :value="i">
                {{ nama }}
              </option>
            </select>
          </div>

          <div class="flex items-center gap-2">
            <label for="tahun" class="text-sm text-gray-800">Tahun</label>
            <select
              id="tahun"
              v-model="filterTahun"
              class="w-28 px-2 py-1 border border-gray-400 rounded text-sm"
            >
              <option v-for="tahun in tahunOptions" :key="tahun" :value="tahun">
                {{ tahun }}
              </option>
            </select>
          </div>
        </div>
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
                <th class="px-4 py-2 border">Harga</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in paginatedPengeluaran"
                :key="item.id"
                class="text-center"
              >
                <td class="px-4 py-2 border">
                  {{ (currentPage - 1) * entriesToShow + index + 1 }}
                </td>
                <td class="px-4 py-2 border">
                  {{ item.keterangan }} <br />
                  <span
                    class="rounded-full bg-purple-200 px-2.5 py-0.5 text-sm whitespace-nowrap text-blue-800"
                  >
                    {{ item.kategori }}
                  </span>
                </td>
                <td class="px-4 py-2 border">{{ item.tanggal }}</td>
                <td class="px-4 py-2 border">
                  Rp {{ formatRupiah(item.harga) }}
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
              <tr v-if="paginatedPengeluaran.length === 0">
                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                  Tidak ada data
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <ul class="flex justify-center gap-1 text-gray-900 mt-8">
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
      </div>

      <!-- Total Pengeluaran Bulan Ini -->
      <div
        class="flex flex-col md:flex-row items-center justify-center mt-2 px-4 md:px-10 py-8 gap-8 md:gap-10"
      >
        <!-- Card -->
        <div class="card w-full md:w-[350px]">
          <p class="text-white font-bold text-xl text-center">
            Total Pengeluaran Bulan Ini :
          </p>
          <div class="card__content text-center">
            <p class="card__description">
              <span class="text-blue-700 font-bold text-3xl">
                {{ formatRupiah(totalPengeluaranBulanIni) }}
              </span>
            </p>
            <div class="text-6xl mt-5">💵</div>
          </div>
        </div>
        <!-- Gambar -->
        <img
          src="../assets/orang.gif"
          alt="Kartun imut"
          class="w-64 h-64 md:w-80 md:h-80 object-contain"
        />

        <!-- Motivational or informational message -->
        <div
          class="flex flex-col justify-center max-w-sm text-gray-800 text-center md:text-left"
        >
          <h2 class="text-4xl font-semibold mb-2">Cerdas dalam Pengeluaran!</h2>
          <p class="text-lg leading-relaxed">
            Catat semua pengeluaran, sekecil apapun, agar kamu tahu kemana
            uangmu pergi. Jangan biarkan pengeluaran tak tercatat membuatmu
            boros. 📉
          </p>
          <p class="mt-4 text-lg italic text-red-600">#BijakKelolaUang</p>
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
      <!-- Hapus Data -->
      <DeleteData
        v-if="showDeleteConfirmation"
        @confirm="confirmDelete"
        @close="closeDeleteConfirmation"
      />
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

const dataPengeluaran = ref([]);
const dataBulanIni = ref([]);
const dataRekap = ref([]);

// Show entries state dan opsi
const entriesToShow = ref(5);
const entryOptions = [5, 10, 25, 50, 100];

const searchQuery = ref("");
const currentPage = ref(1);

// Menghitung total pemasukan bulan ini
const totalPengeluaranBulanIni = computed(() => {
  const sekarang = new Date();
  const bulanIni = sekarang.getMonth();
  const tahunIni = sekarang.getFullYear();

  const dataBulanIni = dataPengeluaran.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() === bulanIni && tanggal.getFullYear() === tahunIni
    );
  });

  return dataBulanIni.reduce((total, item) => total + Number(item.harga), 0);
});

const namaBulan = [
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
];

const sekarang = new Date();
const filterBulan = ref(sekarang.getMonth()); // default bulan ini
const filterTahun = ref(sekarang.getFullYear()); // default tahun ini

// Tahun tersedia (diambil dari data)
const tahunOptions = computed(() => {
  const semuaTahun = dataPengeluaran.value
    .map((item) => {
      if (!item.tanggal) return null;
      const tahun = new Date(item.tanggal).getFullYear();
      return isNaN(tahun) ? null : tahun;
    })
    .filter((t) => t !== null);

  // Pastikan tahun ini selalu ada dalam pilihan, bahkan jika belum ada datanya
  semuaTahun.push(new Date().getFullYear());

  return [...new Set(semuaTahun)].sort((a, b) => b - a);
});

// Ambil data dari localStorage
onMounted(() => {
  const saved = localStorage.getItem("dataPengeluaran");
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

  dataPengeluaran.value = parsed; // tetap simpan semuanya jika ingin akses rekap
});

// Simpan ke localStorage saat berubah
watch([entriesToShow, searchQuery], () => {
  currentPage.value = 1;
});

watch(
  dataPengeluaran,
  () => {
    const semua = [...dataRekap.value, ...dataBulanIni.value];
    localStorage.setItem("dataPengeluaran", JSON.stringify(semua));
  },
  { deep: true }
);

const filteredPengeluaran = computed(() => {
  const query = searchQuery.value.toLowerCase();

  return dataPengeluaran.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    const cocokBulan = tanggal.getMonth() === filterBulan.value;
    const cocokTahun = tanggal.getFullYear() === filterTahun.value;
    const cocokCari =
      item.keterangan.toLowerCase().includes(query) ||
      item.tanggal.toLowerCase().includes(query);

    return cocokBulan && cocokTahun && cocokCari;
  });
});

const totalPages = computed(() => {
  return Math.ceil(filteredPengeluaran.value.length / entriesToShow.value);
});

// Data yang ditampilkan per halaman
const paginatedPengeluaran = computed(() => {
  const start = (currentPage.value - 1) * entriesToShow.value;
  return filteredPengeluaran.value.slice(start, start + entriesToShow.value);
});

// Tambah data
function tambahData() {
  showForm.value = true;
}

function tambahKeData(dataBaru) {
  dataBaru.id = Date.now();
  dataPengeluaran.value.push(dataBaru);

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

// Format ke Rupiah
function formatRupiah(angka) {
  return new Intl.NumberFormat("id-ID").format(Number(angka) || 0);
}

function updateDataBulanIni() {
  const sekarang = new Date();
  const bulanIni = sekarang.getMonth();
  const tahunIni = sekarang.getFullYear();

  dataBulanIni.value = dataPengeluaran.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() === bulanIni && tanggal.getFullYear() === tahunIni
    );
  });

  dataRekap.value = dataPengeluaran.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    return (
      tanggal.getMonth() !== bulanIni || tanggal.getFullYear() !== tahunIni
    );
  });
}

// Edit data
function editData(id) {
  const item = dataPengeluaran.value.find((item) => item.id === id);
  if (item) {
    dataSedangDiedit.value = { ...item };
    showEdit.value = true;
  }
}

// Fungsi update setelah diedit
function perbaruiData(updated) {
  const index = dataPengeluaran.value.findIndex(
    (item) => item.id === updated.id
  );
  if (index !== -1) {
    dataPengeluaran.value.splice(index, 1, { ...updated });

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
  const index = dataPengeluaran.value.findIndex(
    (item) => item.id === itemToDeleteId.value
  );
  if (index !== -1) {
    dataPengeluaran.value.splice(index, 1);
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
  width: 310px;
  height: 190px;
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
