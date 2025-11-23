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

      <!-- Notification Message -->
      <div v-if="message" :class="{
        'bg-green-50 border-green-200 text-green-700': messageType === 'success',
        'bg-blue-50 border-blue-200 text-blue-700': messageType === 'info',
        'bg-red-50 border-red-200 text-red-700': messageType === 'error'
        }" class="text-sm p-3 rounded-lg text-center">
        {{ message }}
      </div>

      <!-- Verification Resend Section -->
      <div v-if="needsVerification" class="bg-yellow-50 border-yellow-200 text-yellow-700 text-sm p-3 rounded-lg text-center space-y-3">
        <p>Akun Anda belum diverifikasi. Silakan cek email Anda untuk tautan verifikasi.</p>
        <p>Tidak menerima email? Anda bisa mengirim ulang di sini:</p>
        <button
          type="button"
          @click="handleResendVerification"
          :disabled="loading"
          class="w-full py-2 bg-yellow-500 text-white font-semibold rounded-lg hover:shadow-lg hover:scale-[1.02] transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
        >
          <span v-if="loading" class="flex items-center justify-center space-x-2">
            <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8V0C5 0 0 5 0 12h4z"></path>
            </svg>
            <span>Mengirim ulang...</span>
          </span>
          <span v-else>Kirim Ulang Email Verifikasi</span>
        </button>
        <div v-if="resendMessage" :class="{
          'bg-green-50 border-green-200 text-green-700': resendMessageType === 'success',
          'bg-red-50 border-red-200 text-red-700': resendMessageType === 'error'
          }" class="text-sm p-3 rounded-lg text-center mt-3">
          {{ resendMessage }}
        </div>
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
          <div class="relative mt-1">
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              id="password"
              required
              placeholder="••••••••"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 pr-10"
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
            >
              <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .653 0 1.286.059 1.908.175l-2.31 2.31a3 3 0 00-4.242 4.242l-2.31 2.31z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M3 3l4.35 4.35" />
              </svg>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-end">
          <div class="text-sm">
            <router-link to="/forgot-password" class="font-medium text-indigo-600 hover:text-indigo-500">
              Forgot your password?
            </router-link>
          </div>
        </div>

        <!-- Error -->
        <div v-if="errors.general && errors.general.length > 0" class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg">
          {{ errors.general[0] }}
        </div>
        <div v-else-if="errors.email && errors.email.length > 0" class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg">
          {{ errors.email[0] }}
        </div>
        <div v-else-if="errors.password && errors.password.length > 0" class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg">
          {{ errors.password[0] }}
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
import { ref, onMounted } from "vue";
import { useRoute } from 'vue-router';
import { useAuth } from '../composables/useAuth';

const { login, errors, loading, needsVerification, resendVerificationEmail } = useAuth();
const route = useRoute();

const email = ref('');
const password = ref('');
const showPassword = ref(false);
const message = ref('');
const messageType = ref(''); // 'success', 'info', 'error'
const resendMessage = ref('');
const resendMessageType = ref('');

onMounted(() => {
  const queryMessage = route.query.message;
  if (route.query.registered === 'true') {
    message.value = 'Pendaftaran berhasil! Silakan cek email Anda untuk verifikasi dan masuk.';
    messageType.value = 'success';
  } else if (queryMessage === 'verification_success') {
    message.value = 'Email berhasil diverifikasi! Silakan masuk.';
    messageType.value = 'success';
  } else if (queryMessage === 'already_verified') {
    message.value = 'Email Anda sudah terverifikasi. Silakan masuk.';
    messageType.value = 'info';
  } else if (queryMessage === 'verification_failed') {
    message.value = 'Verifikasi email gagal. Link tidak valid atau sudah kedaluwarsa.';
    messageType.value = 'error';
  }
});

const handleLogin = async () => {
  await login({ 
    email: email.value, 
    password: password.value 
  });
};

const handleResendVerification = async () => {
  resendMessage.value = '';
  resendMessageType.value = '';
  const response = await resendVerificationEmail(email.value);
  if (response) {
    resendMessage.value = response;
    resendMessageType.value = 'success';
  } else if (errors.value.general) {
    resendMessage.value = errors.value.general[0];
    resendMessageType.value = 'error';
  }
};
</script>

<style scoped>
body {
  font-family: 'Inter', sans-serif;
}
</style>