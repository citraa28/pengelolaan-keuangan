<template>
  <LayoutPage>
    <!-- Konten Utama -->
    <div class="p-6 mx-2.5 m-7 bg-blue-100 rounded-lg shadow-md">
      <h1 class="text-4xl font-bold text-left">Pengeluaran Uang</h1>
    </div>
    <div class="p-5 m-2.5 bg-blue-100 rounded-lg shadow-md">
      <div class="m-3 mb-6 flex justify-start">
        <button
          @click="tambahData"
          class="bg-gradient-to-r from-sky-300 via-blue-400 to-indigo-700 text-white px-4 py-2 rounded hover:bg-blue-950"
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
          <table class="min-w-full bg-white border rounded-lg overflow-hidden">
            <thead class="bg-gray-300 text-gray-700">
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
                v-for="(item, index) in paginatedPengeluaran"
                :key="item.id"
                class="text-center"
              >
                <td class="px-4 py-2 border">
                  {{ (currentPage - 1) * entriesToShow + index + 1 }}
                </td>
                <td class="px-4 py-2 border">{{ item.keterangan }}</td>
                <td class="px-4 py-2 border">{{ item.tanggal }}</td>
                <td class="px-4 py-2 border">
                  Rp {{ formatRupiah(item.jumlah) }}
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

        <!-- Total Pengeluaran Bulan Ini -->
        <div class="mt-15 mb-4 text-lg font-semibold text-gray-700">
          Total Pengeluaran Bulan Ini:
          <span class="text-blue-700">{{
            formatRupiah(totalPengeluaranBulanIni)
          }}</span>
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

  return dataBulanIni.reduce((total, item) => total + Number(item.jumlah), 0);
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
  return dataBulanIni.value.filter(
    (item) =>
      item.keterangan.toLowerCase().includes(query) ||
      item.tanggal.toLowerCase().includes(query)
  );
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
