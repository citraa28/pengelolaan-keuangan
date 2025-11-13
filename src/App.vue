<script setup>
import { ref } from 'vue'
// import { useAuth } from './composables/useAuth.js'

// const { user, loading } = useAuth()
const isDarkMode = ref(true) // toggle dark mode di sini
</script>

<template>
  <!-- Root div yang akan mengatur dark mode -->
  <div :class="{ dark: isDarkMode }" id="app">
    <!-- Loading screen -->
    <div v-if="loading" class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
      <div class="text-xl">Loading...</div>
    </div>

    <!-- Main App -->
    <router-view v-else :user="user" />
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
