<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 p-4 md:p-6"
  >
    <div
      class="w-full max-w-sm md:max-w-md bg-white rounded-2xl shadow-xl p-6 md:p-8 space-y-6 md:space-y-8 border border-gray-100"
    >
      <!-- Header -->
      <div class="text-center space-y-1 md:space-y-2">
        <div
          class="w-14 h-14 md:w-16 md:h-16 mx-auto bg-gradient-to-r from-indigo-500 to-blue-600 rounded-full flex items-center justify-center shadow-md"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-80 h-80 md:w-20 md:h-20"
            viewBox="0 0 64 64"
          >
            <path
              d="M22 32c0-5 4-9 9-9h5a6 6 0 1 1 0 12h-8"
              stroke="#ffffff"
              stroke-width="3"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <line
              x1="32"
              y1="23"
              x2="32"
              y2="41"
              stroke="#ffffff"
              stroke-width="3"
              stroke-linecap="round"
            />
          </svg>
        </div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
          Masuk ke Akun Anda
        </h1>
        <p class="text-xs md:text-sm text-gray-500">
          Gunakan email dan kata sandi yang terdaftar
        </p>
      </div>

      <!-- Alert Success -->
      <div
        v-if="successMessage"
        class="flex items-start p-4 mb-3 rounded-xl bg-green-50 border border-green-200 text-green-700 animate-fadeIn"
      >
        <svg
          class="w-5 h-5 mr-3 mt-0.5"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293A1 1 0 003.293 10.707l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"
            clip-rule="evenodd"
          />
        </svg>
        <span class="text-sm md:text-base font-medium">
          {{ successMessage }}
        </span>
      </div>

      <!-- Alert Error -->
      <div
        v-if="errors && (errors.general || errors.email || errors.password)"
        class="flex items-start p-4 mb-3 rounded-xl bg-red-50 border border-red-200 text-red-700 animate-fadeIn"
      >
        <svg
          class="w-5 h-5 mr-3 mt-0.5"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l6.518 11.605c.75 1.336-.213 2.996-1.742 2.996H3.48c-1.53 0-2.492-1.66-1.743-2.996L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V8a1 1 0 112 0v3a1 1 0 01-1 1z"
            clip-rule="evenodd"
          />
        </svg>
        <span class="text-sm md:text-base font-medium">
          {{ errors.general?.[0] || errors.email?.[0] || errors.password?.[0] }}
        </span>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleLogin" class="space-y-4 md:space-y-5">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Email</label
          >
          <input
            v-model="email"
            type="email"
            id="email"
            required
            placeholder="contoh@email.com"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 md:p-3"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700"
            >Kata Sandi</label
          >
          <div class="relative mt-1">
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              id="password"
              required
              placeholder="••••••••"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 md:p-3 pr-10"
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
            >
              <!-- Icon hidden -->
              <svg
                v-if="!showPassword"
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                />
              </svg>

              <!-- Icon show -->
              <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .653 0 1.286.059 1.908.175l-2.31 2.31a3 3 0 00-4.242 4.242l-2.31 2.31z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M21 21l-4.35-4.35M3 3l4.35 4.35"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Button -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full py-2.5 md:py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg hover:scale-[1.02] transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed text-sm md:text-base"
        >
          <span
            v-if="loading"
            class="flex items-center justify-center space-x-2"
          >
            <svg
              class="animate-spin h-4 w-4 md:h-5 md:w-5 text-white"
              viewBox="0 0 24 24"
              fill="none"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="white"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="white"
                d="M4 12a8 8 0 018-8V0C5 0 0 5 0 12h4z"
              ></path>
            </svg>
            <span>Memproses...</span>
          </span>
          <span v-else>Masuk</span>
        </button>
      </form>

      <!-- Footer -->
      <p class="text-center text-xs md:text-sm text-gray-500">
        Belum punya akun?
        <router-link to="/register" class="text-blue-800 hover:underline"
          >Daftar Sekarang</router-link
        >
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, toRefs } from "vue";
import { useRoute } from "vue-router";
import { useAuth } from "../composables/useAuth";

const { login, errors, loading } = useAuth();
const route = useRoute();

const email = ref("");
const password = ref("");
const showPassword = ref(false);
const successMessage = ref("");

const handleLogin = async () => {
  const result = await login({
    email: email.value,
    password: password.value,
  });

  if (result) {
    successMessage.value = "Login berhasil! Mengarahkan...";
    setTimeout(() => {
      window.location.href = "/beranda";
    }, 1200);
  }
};
</script>

<style scoped>
body {
  font-family: "Inter", sans-serif;
}
</style>
