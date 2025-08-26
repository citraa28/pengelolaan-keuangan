<template>
  <LayoutPage>
    <!-- Konten Utama -->
    <header
      class="bg-white border border-blue-400 font-fredoka animate-bounce p-3 mb-6 mx-3 text-center shadow-lg rounded-xl"
    >
      <div class="flex flex-col items-center justify-center">
        <img
          src="../assets/pemasukan.gif"
          alt="Icon pemasukan"
          class="w-20 h-20 object-contain"
        />
        <h1
          class="text-3xl font-bold font-inter pb-1/ \ text-gray-800 flex items-center gap-2"
        >
          Pemasukan Uang
        </h1>
        <p><i>Ayo Kendalikan Uangmu</i></p>
      </div>
    </header>

    <div class="p-1 rounded-lg shadow-md">
      <!-- Flex container untuk tombol + filter -->
      <div class="flex flex-wrap items-center justify-between mb-5 gap-3">
        <!-- Tombol tambah data -->
        <button
          @click="tambahData"
          class="bg-gradient-to-r from-sky-300 via-blue-400 to-indigo-700 text-white px-4 py-2 md:py-3 rounded-lg hover:bg-blue-950"
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

      <div class="p-3 bg-white rounded-lg shadow-md">
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
                v-for="(item, index) in paginatedPemasukan"
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
                  {{ formatRupiah(item.harga) }}
                </td>
                <td class="px-4 py-2 border">
                  <button
                    @click="editData(item.id)"
                    class="bg-blue-500 rounded-2xl px-6 m-1 py-1 text-white hover:underline mr-2"
                  >
                    Edit
                  </button>
                  <button
                    @click="hapusData(item.id)"
                    class="bg-red-600 rounded-2xl px-4 py-1 text-white hover:underline"
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
      </div>
      <!-- Total Pemasukan Bulan Ini -->
      <div
        class="flex flex-col md:flex-row items-center justify-center mt-2 px-4 md:px-10 py-8 gap-8 md:gap-10"
      >
        <!-- Card -->
        <div class="order-1 md:order-1 card">
          <div class="card__content">
            <p class="text-white font-semibold text-lg">Total Pemasukan</p>
            <p class="card__description mt-2">
              <span>
                {{ formatRupiah(totalPemasukanBulanIni) }}
              </span>
            </p>
            <div class="card__icon">💵</div>
          </div>
        </div>
        <!-- Gambar -->
        <img
          src="../assets/lucu.gif"
          alt="Kartun imut"
          class="order-2 md:order-2 w-64 h-64 md:w-80 md:h-80 object-contain"
        />

        <!-- Tips Hemat -->
        <div
          class="order-3 md:order-3 flex flex-col justify-center max-w-sm mb-10 md:mb-0 text-gray-800 text-center md:text-left"
        >
          <h2 class="text-3xl font-semibold mb-3">Tips Hemat Bulan Ini!</h2>
          <p class="text-lg leading-relaxed">
            Coba alokasikan minimal <strong>20%</strong> dari pemasukan kamu
            untuk ditabung. Buat prioritas belanja, dan hindari pembelian
            impulsif. 💰
          </p>
          <p class="mt-4 text-lg italic text-blue-600">#UangmuKendalikan</p>
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
  const semuaTahun = dataPemasukan.value
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

  return dataPemasukan.value.filter((item) => {
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
  width: 320px;
  height: 200px;
  background: linear-gradient(135deg, #2563eb, #4f46e5);
  border-radius: 18px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
  transition: all 0.4s ease;
}

.card:hover {
  transform: translateY(-8px) scale(1.05);
  box-shadow: 0 15px 30px rgba(79, 70, 229, 0.45);
}

.card__content {
  z-index: 2;
  text-align: center;
}

.card__description span {
  font-size: 2rem;
  font-weight: 700;
  color: #facc15; /* kuning emas */
}

.card__badge {
  position: absolute;
  top: 12px;
  right: 12px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(8px);
  color: white;
  font-size: 0.75rem;
  padding: 4px 10px;
  border-radius: 9999px;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.card__icon {
  font-size: 3rem;
  margin-top: 12px;
  animation: bounce 1.5s infinite;
}

@keyframes bounce {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-6px);
  }
}
</style>
