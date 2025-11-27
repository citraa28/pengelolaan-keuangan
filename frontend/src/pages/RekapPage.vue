<template>
  <LayoutPage>
    <div class="flex-1 p-2 overflow-y-auto overflow-x-hidden">
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
          <div class="flex items-center gap-4">
            <button
              @click="applyFilter"
              class="px-6 py-2 rounded-lg text-white font-semibold shadow-md bg-blue-500 hover:bg-blue-600 transition"
            >
              Terapkan Filter
            </button>
            <button
              id="download-pdf-btn"
              @click="triggerBackendPdfDownload"
              :disabled="dataFilter.length === 0"
              class="px-6 py-2 rounded-lg text-white font-semibold shadow-md bg-red-500 hover:bg-red-600 transition disabled:bg-gray-400 disabled:cursor-not-allowed"
            >
              Download PDF
            </button>
          </div>
        </div>
      </div>

      <!-- Tabel -->
      <div
        class="mx-auto max-w-5xl bg-white rounded-xl shadow-md overflow-hidden"
      >
        <div class="overflow-x-auto w-full">
          <table class="w-full text-sm">
            <thead
              class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white"
            >
              <tr>
                <th class="px-2 md:px-4 py-3 text-left">No</th>
                <th class="px-2 md:px-4 py-3 text-left">Jenis</th>
                <th class="px-2 md:px-4 py-3 text-left">Keterangan</th>
                <th class="px-2 md:px-4 py-3 text-left">Kategori</th>
                <th class="px-2 md:px-4 py-3 text-left">Tanggal</th>
                <th class="px-2 md:px-4 py-3 text-left">Jumlah</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-if="dataFilter.length === 0"
                class="bg-white text-center"
              >
                <td colspan="6" class="px-4 py-8 text-gray-500">
                  Tidak ada data untuk ditampilkan. Silakan atur filter Anda dan
                  klik "Terapkan Filter".
                </td>
              </tr>
              <tr
                v-else
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
import { useKeuangan } from "../composables/useKeuangan.js";
import api from "../api/axios";

const { pemasukan, pengeluaran, fetchPemasukan, fetchPengeluaran } =
  useKeuangan();

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
  console.log("Menerapkan filter...");
  let semuaData = [
    ...pemasukan.value.map((p) => ({
      jenis: "pemasukan",
      keterangan: p.keterangan,
      kategori: p.kategori?.nama_kategori,
      tanggal: p.tanggal,
      jumlah: p.jumlah,
    })),
    ...pengeluaran.value.map((p) => ({
      jenis: "pengeluaran",
      keterangan: p.keterangan,
      kategori: p.kategori?.nama_kategori,
      tanggal: p.tanggal,
      jumlah: p.jumlah,
    })),
  ];

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
  console.log(`Data difilter: ${hasil.length} entri ditemukan.`);
}

async function triggerBackendPdfDownload() {
  const downloadButton = document.querySelector("#download-pdf-btn");
  const originalButtonText = downloadButton.textContent;
  
  try {
    downloadButton.textContent = "Membuat PDF...";
    downloadButton.disabled = true;

    const params = {
      jenis: form.value.jenis || null,
      tanggalAwal: form.value.tanggalAwal || null,
      tanggalAkhir: form.value.tanggalAkhir || null,
    };

    const response = await api.get("/rekap/download", {
      params,
      responseType: "blob",
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;

    const contentDisposition = response.headers["content-disposition"];
    let fileName = "rekap_keuangan.pdf";
    if (contentDisposition) {
      const fileNameMatch = contentDisposition.match(/filename="(.+)"/);
      if (fileNameMatch && fileNameMatch.length === 2) {
        fileName = fileNameMatch[1];
      }
    }

    link.setAttribute("download", fileName);
    document.body.appendChild(link);
    link.click();
    link.remove();
    window.URL.revokeObjectURL(url);
  } catch (error) {
    console.error("Error downloading PDF:", error);
    alert("Gagal mengunduh PDF. Pastikan Anda sudah login dan coba lagi.");
  } finally {
    downloadButton.textContent = originalButtonText;
    downloadButton.disabled = dataFilter.value.length === 0;
  }
}

onMounted(async () => {
  await fetchPemasukan();
  await fetchPengeluaran();
});
</script>
