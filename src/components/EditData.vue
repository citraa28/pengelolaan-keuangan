<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
    <div class="bg-white w-full max-w-md rounded shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Edit Data Keuangan</h2>

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Keterangan</label>
        <input
          v-model="form.keterangan"
          type="text"
          class="w-full border px-3 py-2 rounded"
        />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Jenis Keuangan</label>
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
        <label class="block text-gray-700 font-semibold mb-1">Jumlah (Rp)</label>
        <input
          v-model="form.jumlah"
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
        <button @click="$emit('close')" class="px-4 py-2 border rounded text-gray-700">
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
import { reactive, toRefs, watch } from 'vue';

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  }, 
});

const emit = defineEmits(['update', 'close']);

const form = reactive({
  id: null, 
  keterangan: '',
  jenis: '',
  jumlah: '',
  tanggal: '',
  index: null,
});

// Sync prop to local form
watch(
  () => props.modelValue,
  (val) => {
    if (val) {
      form.id = val.id;
      form.keterangan = val.keterangan;
      form.jenis = val.jenis;
      form.jumlah = val.jumlah;
      form.tanggal = val.tanggal;
      form.index = val.index;
    }
  },
  { immediate: true }
);

function simpanPerubahan() {
  emit('update', { ...form });
  emit('close');
}
</script>
