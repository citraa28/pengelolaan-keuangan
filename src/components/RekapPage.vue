<template>
  <LayoutPage>
    <!-- Konten Utama -->
    <div class="flex-1 p-8 overflow-auto">
      <h1 class="text-3xl font-bold text-center mb-10 text-gray-800">
        Rekap Data Keuangan
      </h1>
      <!-- Form Horizontal (Tengah dan Horizontal) -->
      <div class="p-6 mx-2.5 m-7 bg-white rounded-xl shadow-2xl">
        <div class="flex justify-center w-full mb-6">
          <div class="flex flex-wrap gap-6 space-x-15">
            <!-- Jenis Keuangan -->
            <div class="flex flex-col">
              <label class="text-sm font-bold text-black mb-1"
                >Jenis Keuangan</label
              >
              <select
                v-model="form.jenis"
                class="border rounded px-3 py-2 w-44 focus:outline-none focus:ring bg-amber-100 focus:ring-blue-200"
              >
                <option value="" disabled>Pilih Jenis</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
              </select>
            </div>

            <!-- Tanggal Awal -->
            <div class="flex flex-col">
              <label class="text-sm font-bold text-black mb-1"
                >Tanggal Awal</label
              >
              <input
                v-model="form.tanggalAwal"
                type="date"
                class="border rounded bg-amber-100 px-3 py-2 w-44"
              />
            </div>

            <!-- Tanggal Akhir -->
            <div class="flex flex-col">
              <label class="text-sm font-bold text-black mb-1"
                >Tanggal Akhir</label
              >
              <input
                v-model="form.tanggalAkhir"
                type="date"
                class="border rounded bg-amber-100 px-3 py-2 w-44"
              />
            </div>

            <button
              @click="kirimData"
              class="bg-blue-500 text-white h-10 w-50 my-6 rounded-lg hover:bg-blue-600"
            >
              + Simpan Data
            </button>
          </div>
        </div>

        <div class="w-full overflow-x-scroll">
          <table class="min-w-full bg-white border rounded-2xl">
            <thead class="bg-gray-300 text-gray-700">
              <tr>
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Jenis Keuangan</th>
                <th class="px-4 py-2 border">Keterangan</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in dataFilter"
                :key="index"
                class="text-center"
              >
                <td class="px-4 py-2 border">{{ index + 1 }}</td>
                <td class="px-4 py-2 border">{{ item.jenis }}</td>
                <td class="px-4 py-2 border">{{ item.keterangan }}</td>
                <td class="px-4 py-2 border">{{ item.tanggal }}</td>
                <td class="px-4 py-2 border">
                  Rp {{ formatRupiah(item.jumlah) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <footer class="bg-amber-50">
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
import LayoutPage from "./LayoutPage.vue";
import { ref } from "vue";

// Form kosong
const form = ref({
  jenis: "",
  tanggalAwal: "",
  tanggalAkhir: "",
  keterangan: "",
  jumlah: "",
});

// Array penyimpanan data
const dataFilter = ref([]);

// Fungsi format rupiah
function formatRupiah(angka) {
  return Number(angka).toLocaleString("id-ID");
}

// Fungsi tambah data
function kirimData() {
  let pemasukan = JSON.parse(localStorage.getItem("dataPemasukan")) || [];
  let pengeluaran = JSON.parse(localStorage.getItem("dataPengeluaran")) || [];

  let semuaData = [...pemasukan, ...pengeluaran];

  let hasil = semuaData.filter((item) => {
    const pilihJenis =
      form.value.jenis === "" || item.jenis === form.value.jenis;

    const tanggalItem = new Date(item.tanggal);
    const tanggalAwal = form.value.tanggalAwal
      ? new Date(form.value.tanggalAwal)
      : null;
    const tanggalAkhir = form.value.tanggalAkhir
      ? new Date(form.value.tanggalAkhir)
      : null;

    const pilihTanggalAwal = !tanggalAwal || tanggalItem >= tanggalAwal;
    const pilihTanggalAkhir = !tanggalAkhir || tanggalItem <= tanggalAkhir;

    return pilihJenis && pilihTanggalAwal && pilihTanggalAkhir;
  });
  dataFilter.value = hasil;
}
</script>
