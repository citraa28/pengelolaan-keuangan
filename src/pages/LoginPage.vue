<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 space-y-8 border border-gray-100">
      
      <!-- Header -->
      <div class="text-center space-y-2">
        <div class="w-16 h-16 mx-auto bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 11c0-3 4-5 4-8a4 4 0 10-8 0c0 3 4 5 4 8zm0 0v1a4 4 0 104 4H8a4 4 0 104-4v-1z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h1>
        <p class="text-sm text-gray-500">Gunakan email dan kata sandi yang terdaftar</p>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleLogin" class="space-y-5">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="email"
            type="email"
            id="email"
            required
            placeholder="contoh@email.com"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
          <input
            v-model="password"
            type="password"
            id="password"
            required
            placeholder="••••••••"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
          />
        </div>

        <!-- Error -->
        <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg">
          {{ error }}
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg hover:scale-[1.02] transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
        >
          <span v-if="loading" class="flex items-center justify-center space-x-2">
            <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8V0C5 0 0 5 0 12h4z"></path>
            </svg>
            <span>Memproses...</span>
          </span>
          <span v-else>Masuk</span>
        </button>
      </form>

      <!-- Footer -->
      <p class="text-center text-sm text-gray-500">
        Belum punya akun?
        <router-link to="/register" class="text-indigo-600 hover:underline">Daftar Sekarang</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
// import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref("");

// Ganti URL API sesuai endpoint JWT-mu di Laravel
const API_URL = "http://localhost:8000/api/login";

const handleLogin = async () => {
  loading.value = true;
  error.value = "";

  try {
    const response = await axios.post(API_URL, {
      email: email.value,
      password: password.value,
    });

    // Simpan token JWT ke localStorage
    localStorage.setItem("token", response.data.token);

    // Redirect ke halaman beranda
    router.push("/beranda");
  } catch (err) {
    console.error("Login error:", err);
    error.value =
      err.response?.data?.message || "Login gagal. Periksa email dan kata sandi.";
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
body {
  font-family: 'Inter', sans-serif;
}
</style>