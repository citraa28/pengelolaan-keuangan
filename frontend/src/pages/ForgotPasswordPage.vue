<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-gray-900">Forgot Password</h2>
      <form @submit.prevent="handleForgotPassword" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
          <div class="mt-1">
            <input id="email" v-model="email" type="email" autocomplete="email" required
              class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="Enter your email" />
          </div>
        </div>

        <div>
          <button type="submit"
            class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Send Password Reset Link
          </button>
        </div>
      </form>
      <div v-if="message" class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        {{ message }}
      </div>
      <div v-if="error" class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
        {{ error }}
      </div>
       <div class="text-sm text-center">
          <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
            Back to Login
          </router-link>
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from '../api/axios';

const email = ref('');
const message = ref('');
const error = ref('');

const handleForgotPassword = async () => {
  message.value = '';
  error.value = '';
  try {
    const response = await axios.post('/auth/forgot-password', {
      email: email.value,
    });
    message.value = response.data.message;
  } catch (err) {
    error.value = err.response?.data?.message || 'An error occurred. Please try again.';
  }
};
</script>
