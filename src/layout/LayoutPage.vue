<template>
  <div class="h-screen flex bg-gray-200 font-sans">
    <!-- Sidebar -->
    <div
      class="transition-all duration-300 ease-in-out bg-gray-800 text-gray-100"
      :class="sidebarOpen ? 'w-64 relative' : 'w-0 absolute -left-64'"
      v-show="sidebarOpen"
    >
      <div class="w-64 h-full flex flex-col overflow-x-hidden">
        <!-- Sidebar Header -->
        <div
          class="flex flex-col items-center justify-center gap-3 h-24 bg-gradient-to-r from-sky-400 to-indigo-800 border-b border-gray-700 px-3 py-2"
        >
          <!-- Judul -->
          <h1 class="text-white text-lg font-bold">Manajemen Keuangan</h1>

          <!-- Profil User -->
          <div
            class="flex items-center gap-3 bg-white/20 px-3 py-1 rounded-full"
          >
            <img
              src="https://www.gravatar.com/avatar/?d=mp"
              alt="User Avatar"
              class="w-5 h-5 rounded-full border-2 border-gray-300"
            />
            <span
              class="text-xs md:text-sm text-white font-medium truncate max-w-[120px] sm:max-w-none"
            >
              {{ userEmail || "Guest" }}
            </span>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
          <router-link
            to="/beranda"
            :class="linkClass"
            :active-class="activeLinkClass"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
              />
            </svg>
            <span class="font-medium">Beranda</span>
          </router-link>

          <div>
            <button
              @click="toggleDropdown"
              :class="linkClass + ' w-full justify-between flex items-center'"
            >
              <div class="flex items-center gap-3">
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
                  />
                </svg>
                <span class="font-medium">Data Keuangan</span>
              </div>
              <svg
                :class="{ 'rotate-180': open }"
                class="h-5 w-5 transition-transform"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
            <div v-if="open" class="mt-2 space-y-1 pl-8">
              <router-link
                to="/pemasukan"
                :class="linkClass"
                :active-class="activeLinkClass"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                  />
                </svg>
                <span>Pemasukan</span>
              </router-link>
              <router-link
                to="/pengeluaran"
                :class="linkClass"
                :active-class="activeLinkClass"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"
                  />
                </svg>
                <span>Pengeluaran</span>
              </router-link>
            </div>
          </div>

          <router-link
            to="/rekap"
            :class="linkClass"
            :active-class="activeLinkClass"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
            <span class="font-medium">Rekap Data</span>
          </router-link>
        </nav>

        <!-- Logout dan Settings -->
        <div class="p-2 border-t border-gray-700">
          <router-link
            to="/"
            :class="linkClass"
            :active-class="activeLinkClass"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              class="size-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15"
              />
            </svg>

            <span class="font-medium">Kembali</span>
          </router-link>

          <a href="#" @click.prevent="logout" :class="linkClass">
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
              />
            </svg>
            <span class="font-medium">Logout</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header
        class="bg-blue-400 p-4 flex flex-wrap items-center justify-between shadow-md z-10"
      >
        <!-- Kiri: Hamburger + Logo -->
        <div class="flex items-center flex-shrink-0">
          <!-- Hamburger -->
          <button
            @click="sidebarOpen = !sidebarOpen"
            class="text-white focus:outline-none mr-3"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>

          <!-- Logo -->
          <img
            src="../assets/note2.png"
            alt="note"
            class="w-12 md:w-20 h-12 md:h-18 object-contain"
          />
          <h1
            class="text-2xl md:text-3xl font-bold text-center text-white drop-shadow-md tracking-wide"
          >
            <span class="font-cursive">MAY</span
            ><span class="font-bold">TRA</span>
            <span class="text-white">Finance</span> ✨
          </h1>
        </div>

        <!-- Tanggal -->
        <div class="text-white text-sm md:text-base pr-8">
          📆 {{ tanggalHariIni }}
        </div>
      </header>

      <!-- Slot Konten -->
      <main class="flex-1 p-6 overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
// import { auth } from "../firebase";
// import { signOut } from "firebase/auth";
// import { onAuthStateChanged } from "firebase/auth";

const sidebarOpen = ref(false);
const open = ref(false);
const router = useRouter();
const userEmail = ref(null);

const linkClass =
  "flex items-center gap-3 rounded-lg px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors";
const activeLinkClass = "bg-blue-600 text-white";

const toggleDropdown = () => {
  open.value = !open.value;
};

const logout = async () => {
  try {
    await signOut(auth);
    router.push("/login");
  } catch (error) {
    console.error("Gagal saat logout:", error);
  }
};

const tanggalHariIni = ref("");
const now = new Date();
const days = [
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
];
const dayName = days[now.getDay()];
const day = String(now.getDate()).padStart(2, "0");
const month = String(now.getMonth() + 1).padStart(2, "0");
const year = now.getFullYear();
tanggalHariIni.value = `${dayName}, ${day}/${month}/${year}`;

onMounted(() => {
  onAuthStateChanged(auth, (user) => {
    if (user) {
      userEmail.value = user.email; // ambil email user login
    } else {
      userEmail.value = null;
    }
  });
});
</script>
