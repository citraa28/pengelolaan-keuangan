<template>
  <div class="relative min-h-screen w-full bg-blue-100 font-sans">
    <!-- Overlay Saat Sidebar Terbuka -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 bg-black/40 z-40"
    ></div>

    <!-- Sidebar -->
    <aside
      class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-gray-100 z-50 transition-transform duration-300 ease-in-out overflow-y-auto"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <!-- Tombol Close -->
      <button
        @click="sidebarOpen = false"
        class="absolute top-3 right-3 text-white hover:text-gray-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-4 h-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>

      <div class="h-full flex flex-col">
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
              {{ user?.email || "Guest" }}
            </span>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-2">
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

          <!-- Dropdown -->
          <div>
            <button
              @click="toggleDropdown"
              :class="linkClass + ' w-full flex justify-between items-center'"
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

            <div v-if="open" class="mt-2 pl-8 space-y-1">
              <router-link
                to="/pemasukan"
                :class="linkClass"
                :active-class="activeLinkClass"
              >
                ➕ Pemasukan
              </router-link>
              <router-link
                to="/pengeluaran"
                :class="linkClass"
                :active-class="activeLinkClass"
              >
                ➖ Pengeluaran
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

        <!-- Logout -->
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

          <a href="#" @click.prevent="handleLogout" :class="linkClass">
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
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <header
        class="bg-blue-400 p-4 flex flex-wrap items-center justify-between shadow-md"
      >
        <!-- Kiri: Hamburger + Logo -->
        <div class="flex items-center gap-3">
          <!-- Hamburger -->
          <button @click="sidebarOpen = true" class="text-white">
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
          <img src="../assets/note2.png" class="w-12 h-12 object-contain" />
          <h1 class="text-xl md:text-2xl font-bold text-white drop-shadow-md">
            <span class="font-cursive">MAY</span>TRA Finance ✨
          </h1>
        </div>

        <!-- Tanggal -->
        <div class="text-white text-sm md:text-base pr-8">
          📆 {{ tanggalHariIni }}
        </div>
      </header>

      <!-- Slot Konten -->
      <main class="flex-1 p-6 pb-20">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuth } from "../composables/useAuth";

const sidebarOpen = ref(false);
const open = ref(false);

const { user, logout } = useAuth();

const linkClass =
  "flex items-center gap-3 rounded-lg px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors";
const activeLinkClass = "bg-blue-600 text-white";

const toggleDropdown = () => {
  open.value = !open.value;
};

const handleLogout = async () => {
  await logout();
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
</script>
