<template>
  <LayoutPage>
    <div class="flex-1 p-2 overflow-auto">
      <!-- Header -->
      <header
        class="bg-white border border-blue-400 font-fredoka p-6 mx-auto max-w-5xl text-center shadow-xl rounded-xl mb-8"
      >
        <div class="flex flex-col items-center gap-3 p-5">
          <h1
            class="text-2xl md:text-4xl font-bold text-gray-800 flex items-center gap-4"
          >
            💰 Rekap Data Keuangan 💰
          </h1>
          <p class="font-pacifico text-lg text-pink-500 italic">
            Hemat Pangkal Kaya
          </p>
        </div>
      </header>

      <!-- Form Filter -->
      <div class="p-6 mx-auto max-w-5xl bg-white rounded-xl shadow-md mb-8">
        <div class="flex flex-wrap items-end gap-6 justify-center">
          <!-- Jenis Keuangan -->
          <div class="flex flex-col">
            <label class="text-sm font-semibold mb-1">Jenis Keuangan</label>
            <select
              v-model="form.jenis"
              class="border rounded-lg px-3 py-2 w-48 bg-amber-50 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
              <option value="" disabled>Pilih Jenis</option>
              <option value="pemasukan">Pemasukan</option>
              <option value="pengeluaran">Pengeluaran</option>
            </select>
          </div>

          <!-- Tanggal Awal -->
          <div class="flex flex-col">
            <label class="text-sm font-semibold mb-1">Tanggal Awal</label>
            <input
              v-model="form.tanggalAwal"
              type="date"
              class="border rounded-lg bg-amber-50 px-3 py-2 w-48 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>

          <!-- Tanggal Akhir -->
          <div class="flex flex-col">
            <label class="text-sm font-semibold mb-1">Tanggal Akhir</label>
            <input
              v-model="form.tanggalAkhir"
              type="date"
              class="border rounded-lg bg-amber-50 px-3 py-2 w-48 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>

          <!-- Tombol -->
          <button
            @click="applyFilter"
            class="px-6 py-2 rounded-lg text-white font-semibold shadow-md bg-blue-500 transition"
          >
            + Simpan Data
          </button>
        </div>
      </div>

      <!-- Tabel -->
      <div
        class="mx-auto max-w-5xl bg-white rounded-xl shadow-md overflow-hidden"
      >
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead
              class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white"
            >
              <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Jenis Keuangan</th>
                <th class="px-4 py-3 text-left">Keterangan</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-left">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in dataFilter"
                :key="index"
                class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition"
              >
                <td class="px-4 py-2">{{ index + 1 }}</td>
                <td class="px-4 py-2">
                  <span
                    :class="
                      item.jenis === 'pemasukan'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-red-100 text-red-700'
                    "
                    class="px-2 py-1 rounded-full text-md font-semibold"
                  >
                    {{ item.jenis }}
                  </span>
                </td>
                <td class="px-4 py-2">{{ item.keterangan }}</td>
                <td class="px-4 py-2">{{ item.kategori }}</td>
                <td class="px-4 py-2">{{ item.tanggal }}</td>
                <td class="px-4 py-2 font-semibold">
                  Rp {{ formatRupiah(item.jumlah) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Faktanya -->
      <div
        class="mx-auto max-w-5xl mt-10 bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg shadow-md"
      >
        <h2 class="text-4xl font-bold text-yellow-800 mb-3">Faktanya!</h2>
        <p class="text-gray-700 leading-relaxed">
          Tahukah kamu usaha yang tidak memiliki pencatatan keuangan akan
          mengalami kerugian lebih besar? Di tengah pesatnya perkembangan UMKM
          di Indonesia, masih banyak usaha yang belum memahami pentingnya
          memiliki pembukuan yang baik untuk pengembangan usaha mereka.
        </p>
      </div>
    </div>
  </LayoutPage>
</template>

<script setup>
import LayoutPage from "../layout/LayoutPage.vue";
import { ref } from "vue";
import { onMounted } from "vue";

const form = ref({
  jenis: "",
  tanggalAwal: "",
  tanggalAkhir: "",
  keterangan: "",
  kategori: "",
});

const dataFilter = ref([]);

// Fungsi untuk format rupiah
function formatRupiah(angka) {
  // Pastikan angka adalah string atau number valid sebelum diolah
  const numericAngka = Number(angka) || 0;
  return numericAngka.toLocaleString("id-ID");
}

function applyFilter() {
  console.log("Menerapkan filter..."); // Mengambil data dari localStorage (sumber data saat ini)
  let pemasukan = JSON.parse(localStorage.getItem("dataPemasukan")) || [];
  let pengeluaran = JSON.parse(localStorage.getItem("dataPengeluaran")) || [];
  let semuaData = [...pemasukan, ...pengeluaran];

  let hasil = semuaData.filter((item) => {
    // Filter Jenis
    const pilihJenis =
      form.value.jenis === "" || item.jenis === form.value.jenis; // Filter Tanggal

    const tanggalItem = new Date(item.tanggal); // Konversi tanggal awal/akhir dari form menjadi objek Date
    const tanggalAwal = form.value.tanggalAwal
      ? new Date(form.value.tanggalAwal)
      : null;
    const tanggalAkhir = form.value.tanggalAkhir
      ? new Date(form.value.tanggalAkhir)
      : null; // Logika perbandingan tanggal

    const pilihTanggalAwal = !tanggalAwal || tanggalItem >= tanggalAwal; // Tambahkan satu hari ke tanggal akhir agar inklusif (opsional, tergantung kebutuhan)
    const pilihTanggalAkhir = !tanggalAkhir || tanggalItem <= tanggalAkhir;

    return pilihJenis && pilihTanggalAwal && pilihTanggalAkhir;
  });
  dataFilter.value = hasil;
  console.log(`Data difilter: ${hasil.length} entri ditemukan.`);
}

// Panggil filterData saat komponen pertama kali dimuat
onMounted(() => {
  // Untuk menampilkan data awal (tanpa filter)
  applyFilter();
});
</script>
