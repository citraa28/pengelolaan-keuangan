<template>
  <!-- Overlay -->
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-blue-100 bg-opacity-40"
  >
    <!-- Card -->
    <div
      class="bg-blue-200 w-full max-w-md rounded-lg shadow-lg p-6 relative"
    >
      <!-- Judul -->
      <h2 class="text-xl font-semibold mb-4">Tambah Data Keuangan</h2>

      <!-- Input Keterangan -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium text-black">
          Keterangan
        </label>
        <input
          v-model="form.keterangan"
          type="text"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
        />
      </div>

      <!-- Input Kategori -->
      <div class="mb-3 relative">
        <label class="block mb-1 text-sm font-medium text-black">
          Kategori Keperluan
        </label>
        <input
          v-model="form.kategori"
          @input="filterKategori"
          @focus="showAllKategori"
          type="text"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
          autocomplete="off"
        />

        <!-- Dropdown History -->
        <div
          v-if="filteredKategori.length > 0"
          class="absolute z-10 w-full bg-blue-200 border border-gray-400 rounded shadow max-h-40 overflow-y-auto"
        >
          <div
            v-for="(item, index) in filteredKategori"
            :key="index"
            class="px-3 py-2 hover:bg-blue-500 cursor-pointer"
            @click="pilihKategori(item)"
          >
            {{ item }}
          </div>
        </div>
      </div>

      <!-- Pilih Jenis -->
      <!-- <div class="mb-3">
        <label class="block mb-1 text-sm font-medium text-black">
          Jenis Keuangan
        </label>
        <div class="flex gap-4">
          <label class="flex items-center gap-2">
            <input type="radio" value="pemasukan" v-model="form.jenis" />
            <span>Pemasukan</span>
          </label>
          <label class="flex items-center gap-2">
            <input type="radio" value="pengeluaran" v-model="form.jenis" />
            <span>Pengeluaran</span>
          </label>
        </div>
      </div> -->

      <!-- Jumlah -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium text-black">
          Jumlah (Rp)
        </label>
        <input
          v-model="form.jumlah"
          type="number"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
        />
      </div>

      <!-- Tanggal -->
      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-black">
          Tanggal
        </label>
        <input
          v-model="form.tanggal"
          type="date"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
        />
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-2">
        <button
          @click="$emit('close')"
          class="px-4 py-2 border rounded bg-blue-50 text-black hover:underline"
        >
          Batal
        </button>
        <button
          @click="kirimData"
          class="bg-blue-700 text-white px-4 py-2 rounded"
        >
          + Simpan Data
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, defineProps, defineEmits } from "vue";
import { useKeuangan } from "../composables/useKeuangan.js";

const props = defineProps({
  jenisTransaksi: {
    type: String,
    required: true, // 'pemasukan' or 'pengeluaran'
  },
});

const emit = defineEmits(["close", "simpan"]);

const { pemasukan, pengeluaran } = useKeuangan();

const form = ref({
  keterangan: "",
  kategori: "",
  jenis: props.jenisTransaksi,
  jumlah: "",
  tanggal: new Date().toISOString().slice(0, 10), // Default to today
});

const filteredKategori = ref([]);

// Create a combined, unique list of categories from the central state
const kategoriHistory = computed(() => {
  const allKategori = [
    ...pemasukan.value.map(p => p.kategori?.nama_kategori),
    ...pengeluaran.value.map(p => p.kategori?.nama_kategori)
  ];
  // Filter out null/undefined and get unique values
  return [...new Set(allKategori.filter(Boolean))];
});

function filterKategori() {
  const query = form.value.kategori.toLowerCase();
  if (query === "") {
    filteredKategori.value = [];
  } else {
    filteredKategori.value = kategoriHistory.value.filter(
      (item) => item.toLowerCase().includes(query)
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

function kirimData() {
  if (!form.value.keterangan || !form.value.jumlah || !form.value.tanggal) {
    alert("Lengkapi semua field!");
    return;
  }
  
  // The 'jenis' is already set from the prop
  emit("simpan", { ...form.value });
  emit("close");
}
</script>
