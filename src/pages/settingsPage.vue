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
      <h1 class="ml-3 text-xl font-semibold">{{ t.settings }}</h1>
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
            <i class="fas fa-arrow-left"></i> {{ t.back }}
          </RouterLink>

          <li>
            <button @click="setTab('profil')" :class="buttonClass('profil')">
              {{ t.profile }}
            </button>
          </li>
          <li>
            <button
              @click="setTab('keamanan')"
              :class="buttonClass('keamanan')"
            >
              {{ t.security }}
            </button>
          </li>
          <li>
            <button
              @click="setTab('preferensi')"
              :class="buttonClass('preferensi')"
            >
              {{ t.preference }}
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
          <h3 class="text-xl font-bold mb-4">{{ t.profile }}</h3>
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
          <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tanggal Lahir</label>
            <input
              v-model="form.tanggalLahir"
              type="date"
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

          <div class="mb-4">
            <label class="block text-gray-700 mb-2">Username</label>
            <input
              v-model="form.username"
              type="text"
              class="w-full border px-3 py-2 rounded"
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2">Ganti Password</label>
            <input
              v-model="form.password"
              type="password"
              class="w-full border px-3 py-2 rounded"
            />
          </div>
          <button
            @click="save"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Simpan Perubahan
          </button>
        </div>

        <!-- Preferensi -->
        <div
          v-if="activeTab === 'preferensi'"
          class="bg-white p-6 rounded-lg shadow"
        >
          <h3 class="text-xl font-bold mb-4">Preferensi</h3>

          <!-- Pilihan Bahasa -->
          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Bahasa</label>
            <select
              v-model="form.language"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            >
              <option value="Indonesia" class="p-2 border-b">Indonesia</option>
              <option value="English" class="p-2">English</option>
            </select>
          </div>

          <!-- Pilihan Mata Uang -->
          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2"
              >Mata Uang</label
            >
            <select
              v-model="form.currency"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            >
              <option value="IDR" class="p-2 border-b">💰 Rupiah (IDR)</option>
              <option value="USD" class="p-2 border-b">💵 Dollar (USD)</option>
              <option value="EUR" class="p-2">💶 Euro (EUR)</option>
            </select>
          </div>
          <button
            @click="perbarui"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Perbarui Preferensi
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";

const activeTab = ref("profil");
const sidebarOpen = ref(false);

const form = ref({
  nama: "",
  email: "",
  tanggalLahir: "",
  username: "",
  password: "",
  language: "Indonesia",
  currency: "",
});

// Kamus Bahasa
const translate = {
  Indonesia: {
    settings: "Pengaturan",
    profile: "Profil",
    security: "Keamanan",
    preference: "Preferensi",
    back: "Kembali ke Beranda",
    menu: "Menu",
    save: "Simpan Perubahan",
    update: "Perbarui Preferensi",
    name: "Nama",
    email: "Email",
    birth: "Tanggal Lahir",
    language: "Bahasa",
    currency: "Mata Uang",
    birthday: "🎉 Selamat Ulang Tahun",
    password: "Kata Sandi",
    username: "Nama Pengguna",
  },
  English: {
    settings: "Settings",
    menu: "Menu",
    back: "Back to Home",
    profile: "Profile",
    security: "Security",
    preference: "Preferences",
    save: "Save Changes",
    update: "Update Preferences",
    name: "Name",
    email: "Email",
    birth: "Date of Birth",
    language: "Language",
    currency: "Currency",
    birthday: "🎉 Happy Birthday",
    password: "Password",
    username: "Username",
  },
};

// Getter teks sesuai bahasa
const t = computed(() => translate[form.value.language]);

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
  alert(
    `Data disimpan:\nNama: ${form.value.nama}\nEmail: ${form.value.email}\nTanggal Lahir:${form.value.tanggalLahir}`
  );

  localStorage.setItem("form", JSON.stringify(form.value));
};

const save = () => {
  alert(
    `${t.value.save}:\n${t.value.username}: ${form.value.username}\n${t.value.password}: ${form.value.password}`
  );

  localStorage.setItem("form", JSON.stringify(form.value));
};

const perbarui = () => {
  alert(
    `${t.value.update}:\n${t.value.language}: ${form.value.language}\n${t.value.currency}: ${form.value.currency}`
  );

  localStorage.setItem("form", JSON.stringify(form.value));
};

onMounted(() => {
  const saved = localStorage.getItem("form");
  if (saved) {
    form.value = JSON.parse(saved);

    if (form.value.tanggalLahir) {
      const today = new Date();
      const tglLahir = new Date(form.value.tanggalLahir);

      if (
        today.getDate() === tglLahir.getDate() &&
        today.getMonth() === tglLahir.getMonth()
      ) {
        alert(`🎉Selamat Ulang Tahun, ${form.value.nama}! 🎂`);
      }
    }
  }
});

// Simpan bahasa saat diganti
watch(
  () => form.value.language,
  () => {
    localStorage.setItem("form", JSON.stringify(form.value));
  }
);
</script>
