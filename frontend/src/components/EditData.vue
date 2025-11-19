<template>
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-blue-100 bg-opacity-30"
  >
    <!-- Card -->
    <div
      class="bg-blue-300 w-full max-w-md rounded shadow-lg p-6"
    >
      <!-- Judul -->
      <h2 class="text-xl font-bold mb-4">Edit Data Keuangan</h2>
      <!-- Edit Keterangan -->
      <div class="mb-4">
        <label class="block text-black font-semibold mb-1">Keterangan</label>
        <input
          v-model="form.keterangan"
          type="text"
          class="w-full border px-3 py-2 rounded"
        />
      </div>
      <!-- Edit Kategori -->
      <div class="mb-4 relative">
        <label class="block text-black font-semibold mb-1">
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
        <label class="block text-black font-semibold mb-1">Jumlah (Rp)</label>
        <input
          v-model="form.jumlah"
          type="number"
          class="w-full border px-3 py-2 rounded"
        />
      </div>

      <div class="mb-6">
        <label class="block text-black font-semibold mb-1">Tanggal</label>
        <input
          v-model="form.tanggal"
          type="date"
          class="w-full border px-3 py-2 rounded"
        />
      </div>

      <div class="flex justify-end gap-2">
        <button
          @click="$emit('close')"
          class="px-4 py-2 border rounded bg-blue-100 text-black"
        >
          Cancel
        </button>
        <button
          @click="simpanPerubahan"
          class="bg-blue-600 text-white px-4 py-2 rounded"
        >
          Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, defineProps, defineEmits } from "vue";
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
    ...pemasukan.value.map(p => p.kategori?.nama_kategori),
    ...pengeluaran.value.map(p => p.kategori?.nama_kategori)
  ];
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

function simpanPerubahan() {
  emit("update", { ...form.value });
  emit("close");
}
</script>
