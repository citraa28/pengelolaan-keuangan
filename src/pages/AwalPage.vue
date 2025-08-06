<template>
  <div>
    <!-- Header -->
    <header class="bg-white p-6 md:p-10 mb-6 mx-3 text-center shadow rounded-md flex justify-between items-center">
      <div class="flex flex-col items-center justify-center w-full">
        <h1 class="text-3xl font-bold font-inter text-gray-800 flex items-center gap-2">
          Pengelolaan Keuangan 💰
        </h1>
      </div>
      <!-- Profil di pojok kanan atas -->
      <div class="absolute top-4 right-4">
        <div class="flex items-center gap-2">
          <img
            src="https://www.gravatar.com/avatar/?d=mp"
            alt="User Avatar"
            class="w-10 h-10 rounded-full border-2 border-gray-300"
          />
          <span class="text-sm font-medium text-gray-700">user@email.com</span>
        </div>
      </div>
    </header>

    <!-- Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-4 pb-10">
      <div v-for="n in 6" :key="n" class="relative max-w-sm bg-white p-6 rounded-lg shadow group hover:bg-[#00838d] hover:text-white transition duration-300">
        <!-- Emoji besar -->
        <div class="text-5xl mb-3">📊</div>
        <h2 class="text-xl font-semibold mb-1">This is heading</h2>
        <p class="text-sm text-gray-600 group-hover:text-white">
          Card description with lots of great facts and interesting details.
        </p>
        <div class="go-corner absolute top-0 right-0">
          <div class="go-arrow text-white">→</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Optional - kalau nanti ambil email login
</script>

<style scoped>
.go-corner {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 32px;
  height: 32px;
  top: 0;
  right: 0;
  background-color: #00838d;
  border-radius: 0 4px 0 32px;
}

.go-arrow {
  font-family: courier, sans-serif;
  font-size: 16px;
}
</style>
