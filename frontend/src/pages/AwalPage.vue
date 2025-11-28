<template>
  <div class="bg-gray-50 font-sans">
    <!-- Header -->
    <header
      class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white px-4 sm:px-6 lg:px-8 py-4 shadow-md sticky top-0 z-50"
    >
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Judul -->
        <h1
          class="text-xl sm:text-2xl md:text-3xl font-bold flex items-center gap-2"
        >
          Pengelolaan Keuangan 💰
        </h1>

        <!-- Tanggal -->
        <div class="text-white text-sm md:text-base hidden sm:block">
          📆 {{ tanggalHariIni }}
        </div>
      </div>
    </header>

    <main>
      <!-- Hero Section -->
      <section class="px-4 sm:px-6 lg:px-8 py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
          <!-- Kiri: Teks -->
          <div class="text-center md:text-left space-y-6 order-last md:order-first">
            <h1
              class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-800"
            >
              Mulai Kelola Keuanganmu<br />
              Sekarang!
            </h1>
            <p
              class="text-gray-600 text-lg md:text-xl max-w-md mx-auto md:mx-0"
            >
              Dengan sistem yang mudah di gunakan dan dipahami.
            </p>
            <div class="pt-4">
              <router-link to="/beranda" class="button-get-started">
                <span>Get Started</span>
                <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
                  <path
                    clip-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    fill-rule="evenodd"
                  ></path>
                </svg>
              </router-link>
            </div>
          </div>

          <!-- Kanan: Gambar/GIF -->
          <div class="flex justify-center">
            <img
              src="https://media2.giphy.com/media/v1.Y2lkPTc5MGI3NjExdG44bmV0bnc1ZHcyczJldWIyMGp2NW9rZG9kYzcyb3RvcmRjbW11OSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/l1Kueohu5kPhR8P6g/giphy.gif"
              alt="Karakter Keuangan"
              class="w-full max-w-xs sm:max-w-sm md:max-w-md rounded-lg"
            />
          </div>
        </div>
      </section>

      <!-- Section 1 -->
      <section class="px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
          <div class="text-center">
            <img
              src="../assets/beranda.png"
              alt="Halaman Beranda"
              class="w-full max-w-lg mx-auto rounded-lg shadow-blue-glow float-animation"
            />
          </div>
          <div class="space-y-4 text-center md:text-left">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
              Website Keuangan Gratis All In One
            </h2>
            <p class="text-gray-600 text-base md:text-lg leading-relaxed">
              Atur keuangan Anda dengan lebih mudah, cepat, dan terencana
              melalui website ini. Catat setiap pemasukan dan pengeluaran,
              pantau laporan secara real-time, dan nikmati visualisasi data yang
              memudahkan Anda memahami kondisi finansial.
            </p>
          </div>
        </div>
      </section>

      <!-- Section 2 -->
      <section class="px-4 sm:px-6 lg:px-8 py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
          <div class="space-y-4 md:order-last text-center md:text-left">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
              Salah Satu Fitur Website
            </h2>
            <p class="text-gray-600 text-base md:text-lg leading-relaxed">
              Catat setiap pemasukan dan pengeluaranmu di
              <span class="font-semibold text-blue-600">MAYTRA Finance</span>
              biar uang nggak hilang tanpa jejak! Dengan tampilan yang rapi,
              imut, dan mudah dipahami, kamu bisa tahu kemana uangmu pergi dan
              mulai merencanakan masa depan yang lebih aman.
            </p>
          </div>
          <div class="text-center">
            <img
              src="../assets/rekap.jpeg"
              alt="Rekap Keuangan"
              class="w-full max-w-sm mx-auto rounded-lg shadow-blue-glow float-animation"
            />
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="bg-gradient-to-r from-blue-700 to-teal-500">
        <div
          class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 flex flex-col md:flex-row items-center justify-center text-center md:text-left gap-8"
        >
          <img
            src="../assets/uang2.png"
            alt="Banyak Uang"
            class="w-32 h-32 md:w-48 md:h-48 object-contain flex-shrink-0"
          />
          <div class="space-y-3">
            <h2 class="text-white text-3xl md:text-4xl font-bold font-serif">
              Uang rapi, hidup happy
            </h2>
            <p
              class="text-blue-100 text-base md:text-lg leading-relaxed max-w-2xl"
            >
              Kelola semua pemasukan dan pengeluaranmu secara otomatis, cepat,
              dan aman, langsung dari satu platform yang mudah digunakan.
            </p>
          </div>
        </div>
      </section>

      <!-- FAQ Section -->
      <section class="px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="max-w-5xl mx-auto">
          <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
              Tanya Jawab Pengelolaan Uang
            </h2>
            <p class="text-gray-600 mt-2">
              Beberapa pertanyaan yang sering diajukan.
            </p>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="faq-card">
              <div class="text-2xl mb-3">📊</div>
              <h3 class="text-lg font-semibold mb-2">
                1. Apa itu pengelolaan keuangan, dan mengapa itu penting?
              </h3>
              <p class="text-sm text-gray-900 group-hover:text-white">
                Mengelola keuangan itu seperti menjadi bos atas uang Anda.
                Intinya adalah mengetahui berapa banyak uang yang Anda miliki,
                ke mana perginya, dan membuat keputusan cerdas untuk
                menggunakannya dengan baik.
              </p>
              <div class="go-corner"><div class="go-arrow">→</div></div>
            </div>
            <div class="faq-card">
              <div class="text-2xl mb-3">💵</div>
              <h3 class="text-lg font-semibold mb-2">
                2. Mengapa mencatat pemasukan dan pengeluaran itu penting?
              </h3>
              <p class="text-sm text-gray-900 group-hover:text-white">
                Karena dengan mencatat, kita bisa tahu ke mana uang pergi,
                mengidentifikasi kebocoran keuangan, dan membuat keputusan yang
                lebih baik terkait anggaran.
              </p>
              <div class="go-corner"><div class="go-arrow">→</div></div>
            </div>
            <div class="faq-card">
              <div class="text-2xl mb-3">🤔</div>
              <h3 class="text-lg font-semibold mb-2">
                3. Apa tips agar tidak boros dalam pengeluaran harian?
              </h3>
              <p class="text-sm text-gray-900 group-hover:text-white">
                Buat anggaran bulanan, catat pengeluaran, bedakan kebutuhan dan
                keinginan, belanja dengan daftar, dan gunakan aplikasi
                keuangan.
              </p>
              <div class="go-corner"><div class="go-arrow">→</div></div>
            </div>
            <div class="faq-card">
              <div class="text-2xl mb-3">💼</div>
              <h3 class="text-lg font-semibold mb-2">
                4. Apa itu pengelolaan uang pribadi?
              </h3>
              <p class="text-sm text-gray-900 group-hover:text-white">
                Proses merencanakan, mengatur, dan mengendalikan keuangan
                pribadi untuk mencapai tujuan keuangan jangka pendek maupun
                jangka panjang.
              </p>
              <div class="go-corner"><div class="go-arrow">→</div></div>
            </div>
            <div class="faq-card">
              <div class="text-2xl mb-3">📈</div>
              <h3 class="text-lg font-semibold mb-2">
                5. Apa cara terbaik untuk melacak pengeluaran saya?
              </h3>
              <p class="text-sm text-gray-900 group-hover:text-white">
                Anda bisa mencatatnya, menggunakan spreadsheet, atau aplikasi
                penganggaran. Ini membantu Anda melihat ke mana uang Anda pergi
                dan bisa membuka mata.
              </p>
              <div class="go-corner"><div class="go-arrow">→</div></div>
            </div>
            <div class="faq-card">
              <div class="text-2xl mb-3">💡</div>
              <h3 class="text-lg font-semibold mb-2">
                6. Bagaimana saya dapat meningkatkan keterampilan keuangan?
              </h3>
              <p class="text-sm text-gray-900 group-hover:text-white">
                Pelajarilah dari buku atau situs web. Latihan menjadikan
                sempurna, jadi teruslah menyusun anggaran, lacak pengeluaran,
                dan sesuaikan kebiasaan Anda.
              </p>
              <div class="go-corner"><div class="go-arrow">→</div></div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4"
      >
        <div class="flex items-center gap-3">
          <img
            src="../assets/note2.png"
            alt="note"
            class="w-12 h-12 object-contain"
          />
          <h1
            class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500"
          >
            <span class="font-serif">MAY</span
            ><span class="font-sans font-extrabold">TRA</span>
            <span class="text-yellow-500">Finance</span> ✨
          </h1>
        </div>
        <p class="text-sm text-gray-500 text-center sm:text-left">
          © 2025 MAYTRA Finance. All rights reserved.
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const tanggalHariIni = ref("");
const now = new Date();
const days = [
  "Minggu",
  "Senin",
  "Selasa",
  "Rabu",
  "Kamis",
  "Jumat",
  "Sabtu",
];
const dayName = days[now.getDay()];
const day = String(now.getDate()).padStart(2, "0");
const month = String(now.getMonth() + 1).padStart(2, "0");
const year = now.getFullYear();
tanggalHariIni.value = `${dayName}, ${day}/${month}/${year}`;

function goToBeranda() {
  router.push("/beranda");
}
</script>

<style scoped>
.shadow-blue-glow {
  box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4),
    0 8px 10px -6px rgba(59, 130, 246, 0.4);
}

@keyframes float {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(0px);
  }
}

.float-animation {
  animation: float 4s ease-in-out infinite;
}

.faq-card {
  position: relative;
  background-color: white;
  padding: 1.5rem;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -2px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out;
  overflow: hidden;
}

.faq-card:hover {
  background-color: #00838d;
  color: white;
  transform: translateY(-5px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
    0 4px 6px -4px rgba(0, 0, 0, 0.1);
}

.go-corner {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 2rem;
  height: 2rem;
  top: 0;
  right: 0;
  background-color: #00838d;
  border-radius: 0 0.5rem 0 2rem;
  transition: background-color 0.3s;
}

.faq-card:hover .go-corner {
  background-color: #006064;
}

.go-arrow {
  color: white;
  font-family: sans-serif;
  font-size: 1rem;
}

.button-get-started {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  padding: 0.75rem 2rem;
  font-size: 1.125rem; /* text-lg */
  font-weight: 700;
  color: white;
  background-image: linear-gradient(to right, #007cf0, #00dfd8);
  border-radius: 9999px;
  border: 2px solid transparent;
  outline: none;
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease-in-out;
}

.button-get-started .icon {
  width: 1.5rem;
  height: 1.5rem;
  transition: transform 0.3s ease-in-out;
}

.button-get-started:hover {
  transform: scale(1.05);
  border-color: rgba(255, 255, 255, 0.6);
  box-shadow: 0 15px 25px rgba(0, 124, 240, 0.3);
}

.button-get-started:hover .icon {
  transform: translateX(4px);
}

.button-get-started::before {
  content: "";
  position: absolute;
  width: 120px;
  height: 100%;
  background-image: linear-gradient(
    120deg,
    rgba(255, 255, 255, 0) 30%,
    rgba(255, 255, 255, 0.8),
    rgba(255, 255, 255, 0) 70%
  );
  top: 0;
  left: -120px;
  opacity: 0.6;
  transition: left 0.7s cubic-bezier(0.23, 1, 0.32, 1);
}

.button-get-started:hover::before {
  left: 100%;
}
</style>
