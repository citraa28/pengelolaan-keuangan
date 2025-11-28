<template>
  <!-- Overlay -->
  <div
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-60 backdrop-blur-sm"
  >
    <!-- Modal Card -->
    <div
      class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 sm:p-8 relative my-8 max-h-[90vh] overflow-y-auto"
    >
      <!-- Close Button -->
      <button
        @click="$emit('close')"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>

      <!-- Judul -->
      <div class="flex items-center mb-6">
        <div class="bg-blue-100 text-blue-600 p-3 rounded-full mr-4">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
            />
          </svg>
        </div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
          Edit Data Keuangan
        </h2>
      </div>

      <!-- Form Inputs -->
      <div class="space-y-4">
        <!-- Edit Keterangan -->
        <div>
          <label
            for="keterangan"
            class="block mb-2 text-sm font-medium text-gray-600"
            >Keterangan</label
          >
          <div class="relative">
            <div
              class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>
            </div>
            <input
              id="keterangan"
              v-model="form.keterangan"
              type="text"
              placeholder="Contoh: Gaji bulanan"
              class="w-full bg-gray-100 border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Edit Kategori -->
        <div class="relative">
          <label
            for="kategori"
            class="block mb-2 text-sm font-medium text-gray-600"
            >Kategori</label
          >
          <div class="relative">
            <div
              class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                />
              </svg>
            </div>
            <input
              id="kategori"
              v-model="form.kategori"
              @input="filterKategori"
              @focus="showAllKategori"
              type="text"
              placeholder="Contoh: Makanan"
              class="w-full bg-gray-100 border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              autocomplete="off"
            />
          </div>
          <!-- Dropdown History -->
          <div
            v-if="filteredKategori.length > 0"
            class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-40 overflow-y-auto"
          >
            <div
              v-for="(item, index) in filteredKategori"
              :key="index"
              class="px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
              @click="pilihKategori(item)"
            >
              {{ item }}
            </div>
          </div>
        </div>

        <!-- Jumlah -->
        <div>
          <label
            for="jumlah"
            class="block mb-2 text-sm font-medium text-gray-600"
            >Jumlah (Rp)</label
          >
          <div class="relative">
            <div
              class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
            >
              <span class="text-gray-500 sm:text-sm">Rp</span>
            </div>
            <input
              id="jumlah"
              v-model="form.jumlah"
              type="number"
              placeholder="0"
              class="w-full bg-gray-100 border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Tanggal -->
        <div>
          <label
            for="tanggal"
            class="block mb-2 text-sm font-medium text-gray-600"
            >Tanggal</label
          >
          <div class="relative">
            <div
              class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <input
              id="tanggal"
              v-model="form.tanggal"
              type="date"
              class="w-full bg-gray-100 border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>
      </div>

      <!-- Tombol -->
      <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-8">
        <button
          @click="$emit('close')"
          class="w-full sm:w-auto px-6 py-2.5 border rounded-lg bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
        >
          Batal
        </button>
        <button
          @click="simpanPerubahan"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-transparent rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
              clip-rule="evenodd"
            />
          </svg>
          Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { useKeuangan } from "../composables/useKeuangan.js";

const props = defineProps({
  modelValue: Object,
});

const emit = defineEmits(["update", "close"]);

const { pemasukan, pengeluaran } = useKeuangan();

const form = ref({
  id: null,
  keterangan: "",
  kategori: "",
  jumlah: "",
  tanggal: "",
});

// Sync data from props to local form state
watch(
  () => props.modelValue,
  (newData) => {
    if (newData) {
      form.value = { ...newData };
    }
  },
  { immediate: true, deep: true }
);

const filteredKategori = ref([]);

const kategoriHistory = computed(() => {
  const allKategori = [
    ...pemasukan.value.map((p) => p.kategori?.nama_kategori),
    ...pengeluaran.value.map((p) => p.kategori?.nama_kategori),
  ];
  return [...new Set(allKategori.filter(Boolean))];
});

function filterKategori() {
  const query = form.value.kategori.toLowerCase();
  if (query === "") {
    filteredKategori.value = [];
  } else {
    filteredKategori.value = kategoriHistory.value.filter((item) =>
      item.toLowerCase().includes(query)
    );
  }
}

function showAllKategori() {
  filteredKategori.value = kategoriHistory.value;
}

function pilihKategori(item) {
  form.value.kategori = item;
  filteredKategori.value = [];
}

function simpanPerubahan() {
  emit("update", { ...form.value });
  emit("close");
}
</script>
