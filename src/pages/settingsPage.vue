<template>
  <div class="flex h-screen flex-col bg-gray-50">
    <!-- Header -->
    <header
      class="flex items-center bg-blue-600 text-white px-4 py-5 shadow-md"
    >
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
      <h1 class="ml-3 text-xl font-semibold">Settings</h1>
    </header>

    <div class="flex flex-1">
      <!-- Sidebar -->
      <div
        class="fixed top-0 left-0 h-full w-64 bg-white border-r shadow-lg p-6 z-20 transform transition-transform duration-300 md:relative md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
      >
        <!-- Tombol Tutup (hanya di HP) -->
        <button
          class="absolute top-4 right-4 text-gray-600 md:hidden"
          @click="sidebarOpen = false"
        >
          <i class="fas fa-times text-xl"></i>
        </button>

        <h2 class="text-2xl font-bold mb-6">Menu</h2>
        <ul class="space-y-3">
          <RouterLink
            to="/beranda"
            class="text-blue-600 hover:underline flex items-center gap-2 mb-6 font-medium"
            @click="sidebarOpen = false"
          >
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
          </RouterLink>

          <li>
            <button @click="setTab('profil')" :class="buttonClass('profil')">
              Profil
            </button>
          </li>
          <li>
            <button
              @click="setTab('keamanan')"
              :class="buttonClass('keamanan')"
            >
              Keamanan
            </button>
          </li>
          <li>
            <button
              @click="setTab('preferensi')"
              :class="buttonClass('preferensi')"
            >
              Preferensi
            </button>
          </li>
        </ul>
      </div>

      <!-- Overlay -->
      <div
        v-if="sidebarOpen"
        class="fixed inset-0 bg-black bg-opacity-50 z-10 md:hidden"
        @click="sidebarOpen = false"
      ></div>

      <!-- Konten -->
      <div class="flex-1 p-5 md:p-10 overflow-y-auto w-full">
        <!-- Profil -->
        <div
          v-if="activeTab === 'profil'"
          class="bg-white p-6 rounded-lg shadow"
        >
          <h3 class="text-xl font-bold mb-4">Pengaturan Profil</h3>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama</label>
            <input
              v-model="form.nama"
              type="text"
              class="w-full border px-3 py-2 rounded"
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full border px-3 py-2 rounded"
            />
          </div>
          <button
            @click="simpan"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Simpan Perubahan
          </button>
        </div>

        <!-- Keamanan -->
        <div
          v-if="activeTab === 'keamanan'"
          class="bg-white p-6 rounded-lg shadow"
        >
          <h3 class="text-xl font-bold mb-4">Pengaturan Keamanan</h3>
          <p class="text-gray-600">Atur password dan verifikasi keamanan.</p>
        </div>

        <!-- Preferensi -->
        <div
          v-if="activeTab === 'preferensi'"
          class="bg-white p-6 rounded-lg shadow"
        >
          <h3 class="text-xl font-bold mb-4">Preferensi</h3>
          <p class="text-gray-600">Sesuaikan tema dan tampilan aplikasi.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const activeTab = ref("profil");
const sidebarOpen = ref(false);

const form = ref({
  nama: "",
  email: "",
});

const setTab = (tab) => {
  activeTab.value = tab;
  sidebarOpen.value = false;
};

const buttonClass = (tab) => {
  return [
    "w-full text-left px-3 py-2 rounded-md",
    activeTab.value === tab
      ? "bg-blue-600 text-white"
      : "hover:bg-gray-100 text-gray-700",
  ];
};

const simpan = () => {
  alert(`Data disimpan:\nNama: ${form.value.nama}\nEmail: ${form.value.email}`);
};
</script>
