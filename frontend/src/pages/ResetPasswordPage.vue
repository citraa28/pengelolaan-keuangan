<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-900">Reset Password</h2>
            <form @submit.prevent="handleResetPassword" class="space-y-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="mt-1">
                        <input id="password" v-model="form.password" type="password" required
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Enter new password" />
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New
                        Password</label>
                    <div class="mt-1">
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" required
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Confirm new password" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset Password
                    </button>
                </div>
            </form>
            <div v-if="message" class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ message }}
            </div>
            <div v-if="error" class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ error }}
            </div>
             <div v-if="message" class="text-sm text-center">
                <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Proceed to Login
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from '../api/axios';

const route = useRoute();
const form = reactive({
    token: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const message = ref('');
const error = ref('');

onMounted(() => {
    form.token = route.params.token;
    form.email = route.query.email;
});

const handleResetPassword = async () => {
    message.value = '';
    error.value = '';
    try {
        const response = await axios.post('/auth/reset-password', form);
        message.value = response.data.message;
    } catch (err) {
        if (err.response && err.response.data && err.response.data.errors) {
            error.value = Object.values(err.response.data.errors).flat().join(' ');
        } else {
            error.value = err.response?.data?.message || 'An error occurred. Please try again.';
        }
    }
};
</script>
