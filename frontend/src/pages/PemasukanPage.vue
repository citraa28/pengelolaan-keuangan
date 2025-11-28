<template>
  <LayoutPage>
    <!-- Konten Utama -->
    <header
      class="bg-white border border-blue-400 p-6 md:p-10 mb-6 mx-4 text-center shadow-lg rounded-xl"
    >
      <div class="flex flex-col items-center justify-center relative">
        <!-- Gambar mobile di atas judul -->
        <img
          src="/src/assets/moneyIcon.png"
          class="w-12 h-12 mb-2 block lg:hidden"
          alt="Finance Icon"
        />

        <!-- Gambar kiri - hanya tampil di layar besar -->
        <img
          src="/src/assets/moneyIcon.png"
          class="w-20 h-20 hidden lg:block absolute left-10 top-1/2 -translate-y-1/2"
          alt="Finance Icon"
        />

        <!-- Judul HP -->
        <h1 class="text-xl font-bold font-serif text-blue-600 lg:hidden">
          Pemasukan Uang
        </h1>
        <!-- Judul Dekstop -->
        <h1
          class="text-3xl font-extrabold font-serif text-blue-600 hidden lg:block"
        >
          💰 Pemasukan Uang 💰
        </h1>

        <!-- Subtitle -->
        <p class="font-pacifico text-sm md:text-base text-gray-700 mt-2">
          <i>Ayo Kendalikan Uangmu ✨</i>
        </p>

        <!-- Gambar kanan - hanya tampil di layar besar -->
        <img
          src="/src/assets/money-3.png"
          class="w-26 h-25 hidden lg:block absolute right-10 top-1/2 -translate-y-1/2"
          alt="Finance Icon"
        />
      </div>
    </header>

    <div class="p-4 md:p-6 rounded-lg">
      <!-- Flex container untuk tombol + filter -->
      <div class="flex flex-wrap items-center justify-between mb-5 gap-4">
        <!-- Tombol tambah data -->
        <button
          @click="showForm = true"
          class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold shadow-md w-full sm:w-auto"
        >
          + Tambah Data
        </button>

        <!-- Filter bulan & tahun -->
        <div class="flex flex-wrap items-center gap-4">
          <div class="flex items-center gap-2">
            <label for="bulan" class="text-sm text-gray-800">Bulan</label>
            <select
              id="bulan"
              v-model="filterBulan"
              class="w-full sm:w-28 px-2 py-1 border border-gray-400 rounded text-sm"
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
              class="w-full sm:w-28 px-2 py-1 border border-gray-400 rounded text-sm"
            >
              <option v-for="tahun in tahunOptions" :key="tahun" :value="tahun">
                {{ tahun }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <div class="p-4 bg-white rounded-lg shadow-md">
        <!-- Pesan Sukses -->
        <div
          v-if="successMessage"
          class="mb-4 px-4 py-2 rounded-lg bg-green-500 text-white font-medium shadow"
        >
          {{ successMessage }}
        </div>

        <!-- Pesan Error -->
        <div
          v-if="errorMessage.text"
          :class="[
            'mb-4 px-4 py-2 rounded-lg text-white font-medium shadow',
            {
              'bg-red-500': errorMessage.type === 'error',
              'bg-yellow-500': errorMessage.type === 'warning',
              'bg-blue-500': errorMessage.type === 'info',
            },
          ]"
        >
          {{ errorMessage.text }}
        </div>

        <!-- Show entries & Search -->
        <div
          class="mb-4 flex flex-col sm:flex-row items-center justify-between gap-4"
        >
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
            placeholder="Cari data..."
            class="px-3 py-2 border border-gray-400 rounded text-sm w-full sm:w-auto md:w-64"
          />
        </div>

        <div class="w-full overflow-x-auto">
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
              <tr v-if="loading">
                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                  <span class="animate-pulse">Memuat data...</span>
                </td>
              </tr>
              <tr
                v-else-if="paginatedPemasukan.length > 0"
                v-for="(item, index) in paginatedPemasukan"
                :key="item.id"
                class="text-center"
              >
                <td class="px-4 py-2 border">
                  {{ (currentPage - 1) * entriesToShow + index + 1 }}
                </td>
                <td class="px-4 py-2 border text-center">
                  {{ item.keterangan }} <br />
                  <span
                    v-if="item.kategori"
                    class="rounded-full bg-purple-200 px-2.5 py-0.5 text-xs whitespace-nowrap text-blue-800 font-medium"
                  >
                    {{ item.kategori.nama_kategori }}
                  </span>
                </td>
                <td class="px-4 py-2 border">{{ item.tanggal }}</td>
                <td class="px-4 py-2 border text-center">
                  {{ formatRupiah(item.jumlah) }}
                </td>
                <td class="px-4 py-2 border">
                  <div
                    class="flex flex-col sm:flex-row items-center justify-center gap-2"
                  >
                    <button
                      @click="handleEdit(item)"
                      class="bg-blue-500 rounded-lg px-4 py-1 text-white hover:bg-blue-600 transition-colors w-full sm:w-auto text-sm"
                    >
                      Edit
                    </button>
                    <button
                      @click="handleDelete(item.id)"
                      class="bg-red-600 rounded-lg px-4 py-1 text-white hover:bg-red-700 transition-colors w-full sm:w-auto text-sm"
                    >
                      Hapus
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-else>
                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                  Tidak ada data untuk periode ini.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <ul
          v-if="totalPages > 1"
          class="flex flex-wrap justify-center gap-2 text-gray-900 mt-8"
        >
          <li>
            <button
              @click.prevent="prevPage"
              class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 disabled:opacity-50"
              :disabled="currentPage === 1"
            >
              &lt;
            </button>
          </li>

          <li v-for="page in totalPages" :key="page">
            <button
              @click.prevent="goToPage(page)"
              class="block size-8 rounded border text-sm font-medium text-center transition-colors"
              :class="{
                'border-blue-600 bg-blue-600 text-white': currentPage === page,
                'border-gray-200 hover:bg-gray-50': currentPage !== page,
              }"
            >
              {{ page }}
            </button>
          </li>

          <li>
            <button
              @click.prevent="nextPage"
              class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 disabled:opacity-50"
              :disabled="currentPage === totalPages"
            >
              &gt;
            </button>
          </li>
        </ul>
      </div>

      <!-- Total Pemasukan & Tips -->
      <div
        class="flex flex-col lg:flex-row items-center justify-center mt-8 px-4 sm:px-6 md:px-10 pt-8 gap-12"
      >
        <!-- Card -->
        <div class="order-1 w-full lg:w-auto bg-blue-500 card">
          <div class="card__content">
            <p class="text-white font-semibold text-lg">Total Pemasukan</p>
            <p class="card__description mt-2">
              <span>
                {{ formatRupiah(totalPemasukanBulanIni) }}
              </span>
            </p>
          </div>
        </div>
        <!-- Tips Hemat -->
        <div
          class="order-2 lg:order-2 flex flex-col justify-center max-w-md text-gray-800 text-center lg:text-left"
        >
          <h2 class="text-2xl md:text-3xl font-semibold mb-3">
            Tips Hemat Bulan Ini!
          </h2>
          <p class="text-base md:text-lg leading-relaxed">
            Coba alokasikan minimal <strong>20%</strong> dari pemasukan kamu
            untuk ditabung. Buat prioritas belanja, dan hindari pembelian
            impulsif. 💰
          </p>
          <p class="mt-4 text-base md:text-lg italic text-blue-600">
            #UangmuKendalikan
          </p>
        </div>
      </div>

      <!-- Form Modals -->
      <TambahData
        v-if="showForm"
        @close="showForm = false"
        @simpan="handleTambah"
        jenis-transaksi="pemasukan"
      />
      <EditData
        v-if="showEdit"
        :model-value="dataSedangDiedit"
        @update="handleUpdate"
        @close="showEdit = false"
        jenis-transaksi="pemasukan"
      />
      <DeleteData
        v-if="showDeleteConfirmation"
        @confirm="handleConfirmDelete"
        @close="showDeleteConfirmation = false"
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
import { useKeuangan } from "../composables/useKeuangan.js";

const {
  pemasukan,
  loading,
  fetchPemasukan,
  addPemasukan,
  updatePemasukan,
  deletePemasukan,
} = useKeuangan();

// UI State
const showForm = ref(false);
const showEdit = ref(false);
const showDeleteConfirmation = ref(false);
const itemToDeleteId = ref(null);
const dataSedangDiedit = ref({});

// Filtering and Pagination state
const entriesToShow = ref(5);
const entryOptions = [5, 10, 25, 50, 100];
const searchQuery = ref("");
const currentPage = ref(1);
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
const filterBulan = ref(sekarang.getMonth());
const filterTahun = ref(sekarang.getFullYear());

const successMessage = ref("");
const errorMessage = ref({
  text: "",
  type: "",
});

onMounted(() => {
  fetchPemasukan();
});

// Computed properties for filtering, pagination, and totals
const filteredPemasukan = computed(() => {
  if (loading.value) return [];
  const query = searchQuery.value.toLowerCase();
  return pemasukan.value.filter((item) => {
    const tanggal = new Date(item.tanggal);
    const cocokBulan = tanggal.getMonth() === filterBulan.value;
    const cocokTahun = tanggal.getFullYear() === filterTahun.value;
    const cocokCari =
      (item.keterangan && item.keterangan.toLowerCase().includes(query)) ||
      (item.tanggal && item.tanggal.toLowerCase().includes(query)) ||
      (item.kategori?.nama_kategori &&
        item.kategori.nama_kategori.toLowerCase().includes(query));
    return cocokBulan && cocokTahun && cocokCari;
  });
});

const totalPages = computed(() =>
  Math.ceil(filteredPemasukan.value.length / entriesToShow.value)
);

const paginatedPemasukan = computed(() => {
  const start = (currentPage.value - 1) * entriesToShow.value;
  return filteredPemasukan.value.slice(start, start + entriesToShow.value);
});

const totalPemasukanBulanIni = computed(() => {
  return filteredPemasukan.value.reduce(
    (total, item) => total + Number(item.jumlah),
    0
  );
});

const tahunOptions = computed(() => {
  const semuaTahun = pemasukan.value.map((item) =>
    new Date(item.tanggal).getFullYear()
  );
  semuaTahun.push(new Date().getFullYear());
  return [...new Set(semuaTahun)].sort((a, b) => b - a);
});

// Watchers to reset pagination
watch([entriesToShow, searchQuery, filterBulan, filterTahun], () => {
  currentPage.value = 1;
});

// CRUD Handlers
async function handleTambah(dataBaru) {
  try {
    await addPemasukan(dataBaru);
    successMessage.value = "Data berhasil ditambahkan!";
    errorMessage.value = { text: "", type: "" };
    showForm.value = false;
    setTimeout(() => {
      successMessage.value = "";
    }, 3000);
  } catch (error) {
    errorMessage.value = {
      text: error?.response?.data?.message || "Gagal menambah data.",
      type: "error",
    };
    setTimeout(() => {
      errorMessage.value = { text: "", type: "" };
    }, 3000);
  }
}

function handleEdit(item) {
  dataSedangDiedit.value = { ...item, kategori: item.kategori?.nama_kategori };
  showEdit.value = true;
}

async function handleUpdate(updatedData) {
  try {
    await updatePemasukan(updatedData.id, updatedData);
    successMessage.value = "✔️ Data berhasil diperbarui!";
    showEdit.value = false;
    setTimeout(() => {
      successMessage.value = "";
    }, 3000);
  } catch (error) {
    errorMessage.value = {
      text: "❌ Gagal memperbarui data.",
      type: "error",
    };
    setTimeout(() => {
      errorMessage.value = { text: "", type: "" };
    }, 3000);
  }
}

function handleDelete(id) {
  itemToDeleteId.value = id;
  showDeleteConfirmation.value = true;
}

async function handleConfirmDelete() {
  if (!itemToDeleteId.value) return;

  try {
    await deletePemasukan(itemToDeleteId.value);
    successMessage.value = "Data berhasil dihapus!";
    showDeleteConfirmation.value = false;
    setTimeout(() => (successMessage.value = ""), 3000);
  } catch (error) {
    console.error("Gagal menghapus:", error);
    errorMessage.value = {
      text: "Gagal menghapus data.",
      type: "error",
    };
    setTimeout(() => {
      errorMessage.value = { text: "", type: "" };
    }, 3000);
  }
}

// Utility and Pagination Functions
function formatRupiah(angka) {
  return "Rp " + new Intl.NumberFormat("id-ID").format(Number(angka) || 0);
}

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
  width: 100%;
  max-width: 320px;
  height: auto;
  min-height: 150px;
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
