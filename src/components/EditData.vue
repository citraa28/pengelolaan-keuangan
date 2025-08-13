<template>
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-blue-100 bg-opacity-30"
  >
    <!-- Card -->
    <div
      class="bg-gradient-to-r from-pink-300 via-blue-300 to-indigo-500 w-full max-w-md rounded shadow-lg p-6"
    >
      <!-- Judul -->
      <h2 class="text-xl font-bold mb-4">Edit Data Keuangan</h2>
      <!-- Edit Keterangan -->
      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Keterangan</label>
        <input
          v-model="form.keterangan"
          type="text"
          class="w-full border px-3 py-2 rounded"
        />
      </div>
      <!-- Edit Kategori -->
      <div class="mb-4 relative">
        <label class="block text-gray-700 font-semibold mb-1">
          Kategori Keperluan
        </label>
        <input
          v-model="form.kategori"
          @input="filterKategori"
          @focus="showAllKategori"
          type="text"
          class="w-full border px-3 py-2 rounded"
        />

        <!-- Dropdown History -->
        <div
          v-if="filteredKategori.length > 0"
          class="absolute z-10 w-full bg-blue-200 border border-gray-600 rounded shadow max-h-40 overflow-y-auto"
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

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1"
          >Jenis Keuangan</label
        >
        <div class="flex gap-4">
          <label class="flex items-center">
            <input
              type="radio"
              value="pemasukan"
              v-model="form.jenis"
              class="mr-2"
            />
            <span>Pemasukan</span>
          </label>
          <label class="flex items-center">
            <input
              type="radio"
              value="pengeluaran"
              v-model="form.jenis"
              class="mr-2"
            />
            <span>Pengeluaran</span>
          </label>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Harga (Rp)</label>
        <input
          v-model="form.harga"
          type="number"
          class="w-full border px-3 py-2 rounded"
        />
      </div>

      <div class="mb-6">
        <label class="block text-gray-700 font-semibold mb-1">Tanggal</label>
        <input
          v-model="form.tanggal"
          type="date"
          class="w-full border px-3 py-2 rounded"
        />
      </div>

      <div class="flex justify-end gap-2">
        <button
          @click="$emit('close')"
          class="px-4 py-2 border rounded text-gray-700"
        >
          Cancel
        </button>
        <button
          @click="simpanPerubahan"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800"
        >
          Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";

const props = defineProps({
  modelValue: Object,
});

const emit = defineEmits(["update", "close"]);

const form = ref({
  id: null,
  keterangan: "",
  kategori: "",
  jenis: "",
  harga: "",
  tanggal: "",
  index: null,
});

const kategoriHistory = ref([]);
const filteredKategori = ref([]);

onMounted(() => {
  kategoriHistory.value =
    JSON.parse(localStorage.getItem("kategoriHistory")) || [];
});

function filterKategori() {
  const query = form.value.kategori.toLowerCase();
  filteredKategori.value = kategoriHistory.value.filter(
    (item) => item.toLowerCase().includes(query) && query !== ""
  );
}

function showAllKategori() {
  filteredKategori.value = kategoriHistory.value;
}

function pilihKategori(item) {
  form.value.kategori = item;
  filteredKategori.value = [];
}

// Sync data dari props ke form
watch(
  () => props.modelValue,
  (val) => {
    if (val) {
      Object.assign(form.value, val);
    }
  },
  { immediate: true }
);

function simpanPerubahan() {
  // Simpan kategori baru ke localStorage
  if (
    form.value.kategori &&
    !kategoriHistory.value.includes(form.value.kategori)
  ) {
    kategoriHistory.value.push(form.value.kategori);
    localStorage.setItem(
      "kategoriHistory",
      JSON.stringify(kategoriHistory.value)
    );
  }

  emit("update", { ...form.value });
  emit("close");
}
</script>
