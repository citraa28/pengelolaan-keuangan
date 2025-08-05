<template>
  <!-- Overlay -->
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <!-- Card -->
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
      <!-- Judul -->
      <h2 class="text-xl font-semibold mb-4">Tambah Data Keuangan</h2>

      <!-- Input Keterangan -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium text-gray-700"
          >Keterangan</label
        >
        <input
          v-model="form.keterangan"
          type="text"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
        />
      </div>

      <!-- Pilih Jenis -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium text-gray-700"
          >Jenis Keuangan</label
        >
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
      </div>

      <!-- Jumlah -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium text-gray-700"
          >Jumlah (Rp)</label
        >
        <input
          v-model="form.jumlah"
          type="number"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
        />
      </div>

      <!-- Tanggal -->
      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700"
          >Tanggal</label
        >
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
          class="px-4 py-2 rounded text-gray-600 hover:underline"
        >
          Batal
        </button>
        <button
          @click="kirimData"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          + Simpan Data
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const form = ref({
  keterangan: "",
  jenis: "pemasukan",
  jumlah: "",
  tanggal: "",
});

const emit = defineEmits(["close", "simpan"]);

function kirimData() {
  if (!form.value.keterangan || !form.value.jumlah || !form.value.tanggal) {
    alert("Lengkapi semua field!");
    return;
  }
  emit("simpan", form.value);
  emit("close"); // Tutup form
}
</script>
