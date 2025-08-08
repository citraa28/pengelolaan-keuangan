<template>
  <div>
    <!-- Header -->
    <header
      class="bg-gradient-to-r from-blue-200 via-blue-500 to-purple-600 text-white px-6 py-4 md:px-10 md:py-6 shadow transition duration-300 ease-in-out hover:from-blue-600 hover:to-cyan-500"
    >
      <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
      >
        <!-- Judul -->
        <h1
          class="text-2xl md:text-4xl font-bold font-inter flex items-center gap-2 text-center sm:text-left"
        >
          Pengelolaan Keuangan 💰
        </h1>

        <!-- Profil -->
        <div class="flex items-center gap-3 bg-white/20 px-3 py-1 rounded-full">
          <img
            src="https://www.gravatar.com/avatar/?d=mp"
            alt="User Avatar"
            class="w-10 h-10 rounded-full border-2 border-gray-300"
          />
          <span
            class="text-sm md:text-base font-medium truncate max-w-[120px] sm:max-w-none"
          >
            maytra2803@email.com
          </span>
        </div>
      </div>
    </header>

    <section
      class="flex flex-col-reverse md:flex-row mb-6 items-center justify-between px-6 md:px-20 py-12 bg-white"
    >
      <!-- Kiri: Teks -->
      <div class="text-center md:text-left md:w-1/2 space-y-5">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-700">
          Mulai Kelola Keuanganmu<br />
          Sekarang!
        </h1>
        <p class="text-gray-500 text-lg">
          Dengan sistem yang mudah di gunakan dan dipahami
        </p>
        <div class="flex justify-start mt-10 mb-15">
          <router-link to="/beranda" class="button">
            Get Started
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
      <div class="md:w-1/2 mb-10 md:mb-0 flex justify-center">
        <img
          src="https://media2.giphy.com/media/v1.Y2lkPTc5MGI3NjExdG44bmV0bnc1ZHcyczJldWIyMGp2NW9rZG9kYzcyb3RvcmRjbW11OSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/l1Kueohu5kPhR8P6g/giphy.gif"
          alt="Karakter Keuangan"
          class="max-w-[450px] w-full h-auto"
        />
      </div>
    </section>

    <!-- Cards Section -->
    <div
      class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl mx-auto px-4 pb-10"
    >
      <!-- Card 1 -->
      <div
        class="relative bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300"
      >
        <div class="text-2xl mb-3">📊</div>
        <h2 class="text-xl font-semibold mb-1">
          1. Apa itu pengelolaan keuangan, dan mengapa itu penting?
        </h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Mengelola keuangan itu seperti menjadi bos atas uang Anda. Intinya
          adalah mengetahui berapa banyak uang yang Anda miliki, ke mana
          perginya, dan membuat keputusan cerdas untuk menggunakannya dengan
          baik. Hal ini penting karena membantu Anda terhindar dari utang,
          menabung untuk masa depan, dan merasa lebih aman dengan keuangan Anda.
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>

      <!-- Card 2 -->
      <div
        class="relative bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300"
      >
        <div class="text-2xl mb-3">💵</div>
        <h2 class="text-xl font-semibold mb-1">
          2. Mengapa mencatat pemasukan dan pengeluaran itu penting?
        </h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Karena dengan mencatat pemasukan dan pengeluaran, kita bisa tahu ke
          mana uang pergi, mengidentifikasi kebocoran keuangan, dan membuat
          keputusan yang lebih baik terkait anggaran.
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>
      <!-- Card 3 -->
      <div
        class="relative bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300"
      >
        <div class="text-2xl mb-3">📊</div>
        <h2 class="text-xl font-semibold mb-1">
          3. Apa tips agar tidak boros dalam pengeluaran harian?
        </h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Buat anggaran bulanan,Catat pengeluaran harian,Bedakan antara
          kebutuhan dan keinginan,Belanja dengan daftar,Gunakan metode cash
          envelope atau aplikasi keuangan
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>
      <!-- Card 4 -->
      <div
        class="relative bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300"
      >
        <div class="text-2xl mb-3">💵</div>
        <h2 class="text-xl font-semibold mb-1">
          4. Apa itu pengelolaan uang pribadi?
        </h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Pengelolaan uang pribadi adalah proses merencanakan, mengatur, dan
          mengendalikan keuangan pribadi untuk mencapai tujuan keuangan jangka
          pendek maupun jangka panjang. Ini mencakup penghasilan, pengeluaran,
          tabungan, investasi, dan pengelolaan utang.
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>

      <!-- Card 5 -->
      <div
        class="relative bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300"
      >
        <div class="text-2xl mb-3">📊</div>
        <h2 class="text-xl font-semibold mb-1">
          5. Apa cara terbaik untuk melacak pengeluaran saya?
        </h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Anda bisa melacak pengeluaran dengan mencatatnya, menggunakan
          spreadsheet, atau aplikasi penganggaran di ponsel. Ini seperti membuat
          buku harian makanan, tetapi untuk uang Anda. Ini membantu Anda melihat
          ke mana uang Anda pergi dan bisa membuka mata untuk mengetahui
          seberapa besar hal-hal kecil dapat bertambah.
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>

      <!-- Card 6 -->
      <div
        class="relative bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300"
      >
        <div class="text-2xl mb-3">💵</div>
        <h2 class="text-xl font-semibold mb-1">
          6. Bagaimana saya dapat meningkatkan keterampilan pengelolaan keuangan
          saya?
        </h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Untuk meningkatkan kemampuan mengelola keuangan, pelajarilah buku,
          situs web, atau bahkan kelas keuangan pribadi lokal. Latihan
          menjadikan sempurna, jadi teruslah menyusun anggaran, lacak
          pengeluaran, dan sesuaikan kebiasaan Anda seiring bertambahnya
          pengetahuan Anda. Dan jangan ragu untuk meminta saran dari teman atau
          profesional yang ahli dalam hal keuangan.
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import BerandaPage from "../pages/BerandaPage.vue";
import { useRouter } from "vue-router";

const router = useRouter();

function goToBeranda() {
  router.push("/beranda");
}
</script>

<style scoped>
.go-corner {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 55px;
  height: 32px;
  top: 0;
  right: 0;
  background-color: #00838d;
  border-radius: 0 4px 0 32px;
}

.go-arrow {
  font-family: courier, sans-serif;
  font-size: 16px;
}

.button {
  position: relative;
  transition: all 0.3s ease-in-out;
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
  padding-block: 0.85rem; /* tinggi lebih besar */
  padding-inline: 3rem; /* lebar lebih besar */
  font-size: 35px; /* teks lebih besar */
  background-image: linear-gradient(to right, #007cf0, #00dfd8);
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #fff;
  gap: 10px;
  font-weight: bold;
  border: 3px solid #ffffff4d;
  outline: none;
  overflow: hidden;
}

.icon {
  width: 24px;
  height: 24px;
  transition: all 0.3s ease-in-out;
}

.button:hover {
  transform: scale(1.05);
  border-color: #fff9;
}

.button:hover .icon {
  transform: translate(4px);
}

.button:hover::before {
  animation: shine 1.5s ease-out infinite;
}

.button::before {
  content: "";
  position: absolute;
  width: 100px;
  height: 100%;
  background-image: linear-gradient(
    120deg,
    rgba(255, 255, 255, 0) 30%,
    rgba(255, 255, 255, 0.8),
    rgba(255, 255, 255, 0) 70%
  );
  top: 0;
  left: -100px;
  opacity: 0.6;
}

@keyframes shine {
  0% {
    left: -100px;
  }

  60% {
    left: 100%;
  }

  to {
    left: 100%;
  }
}
</style>
