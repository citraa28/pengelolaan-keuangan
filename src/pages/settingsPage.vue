<template>
  <div
    :class="[
      'max-w-3xl mx-auto rounded-2xl p-10 mt-10 space-y-12 transition-all duration-500',
      form.darkMode
        ? 'bg-gradient-to-br from-gray-900 to-gray-800 text-gray-100 shadow-2xl'
        : 'bg-neutral-100 text-gray-800 shadow-xl'
    ]"
  >
    <!-- Navigasi Balik -->
    <RouterLink to="/beranda" class="text-blue-600 hover:underline flex items-center gap-2 mb-6 font-medium">
      <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </RouterLink>

    <!-- Header -->
    <div class="flex items-center gap-3 mb-4">
      <i class="fas fa-cog text-blue-500 text-3xl animate-spin-slow"></i>
      <h1 class="text-4xl font-bold tracking-wide">Pengaturan Akun</h1>
    </div>
    <hr class="border-gray-300 dark:border-gray-600" />

    <!-- PROFIL-->
    <section>
      <h2 class="text-2xl font-semibold flex items-center gap-2 mb-4">
        <i class="fas fa-user text-purple-500"></i> Profil
        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full">Data Utama</span>
      </h2>
      <div class="grid gap-5">
        <div>
          <label class="block font-medium mb-1">Nama Lengkap</label>
          <input type="text" class="input" v-model="form.name" placeholder="Masukkan nama lengkap" />
        </div>
        <div>
          <label class="block font-medium mb-1">Email</label>
          <input type="email" class="input" v-model="form.email" placeholder="email@example.com" />
        </div>
        <button class="w-175 h-10 rounded-md bg-gradient-to-r from-sky-300 via-blue-400 to-indigo-700 text-white font-bold" @click="saveProfile">
          <i class="fas fa-save mr-1"></i> Simpan Perubahan
        </button>
      </div>
    </section>

    <!-- PREFERENSI -->
    <section>
      <h2 class="text-2xl font-semibold flex items-center gap-2 mb-4">
        <i class="fas fa-sliders-h text-green-500"></i> Preferensi
        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Personalisasi</span>
      </h2>
      <div class="grid gap-5">
        <div>
          <label class="block font-medium mb-1">Bahasa</label>
          <select class="input" v-model="form.language">
            <option value="id">Bahasa Indonesia</option>
            <option value="en">English</option>
          </select>
        </div>
        <div>
          <label class="block font-medium mb-1">Mata Uang</label>
          <select class="input" v-model="form.currency">
            <option value="IDR">Rupiah (IDR)</option>
            <option value="USD">Dollar (USD)</option>
            <option value="EUR">Euro (EUR)</option>
          </select>
        </div>
        <div>
          <label class="block font-medium mb-1">Batas Anggaran Bulanan</label>
          <input type="number" class="input" v-model.number="form.monthlyLimit" placeholder="Rp 2.000.000" />
        </div>
        <button class="w-175 h-10 rounded-md bg-gradient-to-r from-green-300 via-green-400 to-green-700 text-white font-bold" @click="updatePreferences">
          <i class="fas fa-sync-alt mr-1"></i> Perbarui Preferensi
        </button>
      </div>
    </section>

    <!-- NOTIFIKASI -->
    <section>
      <h2 class="text-2xl font-semibold flex items-center gap-2 mb-4">
        <i class="fas fa-bell text-yellow-500"></i> Notifikasi
        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">Pengingat</span>
      </h2>
      <div class="space-y-2">
        <label class="flex items-center gap-2">
          <input type="checkbox" v-model="form.notifyOverBudget" />
          Kirim notifikasi jika melebihi anggaran
        </label>
        <label class="flex items-center gap-2">
          <input type="checkbox" v-model="form.emailSummary" />
          Kirim ringkasan bulanan ke email
        </label>
      </div>
    </section>

    <!-- KEAMANAN -->
    <section>
      <h2 class="text-2xl font-semibold flex items-center gap-2 mb-4">
        <i class="fas fa-lock text-red-500"></i> Keamanan
      </h2>
      <div>
        <label class="block font-medium mb-1">Password Baru</label>
        <input type="password" class="input" v-model="form.newPassword" placeholder="••••••••" />
      </div>
      <button class="btn-danger mt-3" @click="changePassword">
        <i class="fas fa-key mr-1"></i> Ubah Password
      </button>
    </section>

    <!-- Aksi Lanjut -->
    <div class="text-right mt-8">
      <button class="bg-gradient-to-r from-sky-300 via-blue-400 to-indigo-700 text-white font-bold  w-40 h-12 rounded-md " @click="goToDashboard">
        <i class="fas fa-arrow-right mr-1"></i> Ke Dashboard
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, RouterLink } from 'vue-router'

onMounted(() => {
  const savedProfile = localStorage.getItem('userProfile')
  const savedPreferences = localStorage.getItem('userPreferences')
  const savedPassword = localStorage.getItem('userPassword')

  if (savedProfile) {
    const profile = JSON.parse(savedProfile)
    form.value.name = profile.name || ''
    form.value.email = profile.email || ''
  }

  if (savedPreferences) {
    const prefs = JSON.parse(savedPreferences)
    form.value.language = prefs.language || 'id'
    form.value.currency = prefs.currency || 'IDR'
    form.value.monthlyLimit = prefs.monthlyLimit || null
    form.value.notifyOverBudget = prefs.notifyOverBudget || false
    form.value.emailSummary = prefs.emailSummary || false
  }

  if (savedPassword) {
    // Tidak ditampilkan di input demi keamanan
    form.value.newPassword = ''
  }
})

const router = useRouter()

const form = ref({
  name: '',
  email: '',
  language: 'id',
  currency: 'IDR',
  monthlyLimit: null,
  notifyOverBudget: false,
  emailSummary: false,
  newPassword: '',
  darkMode: false
})

const saveProfile = () => {
  localStorage.setItem('userProfile', JSON.stringify({
    name: form.value.name,
    email: form.value.email
  }))
  alert(`Profil disimpan!\nNama: ${form.value.name}\nEmail: ${form.value.email}`)
}

const updatePreferences = () => {
  localStorage.setItem('userPreferences', JSON.stringify({
    language: form.value.language,
    currency: form.value.currency,
    monthlyLimit: form.value.monthlyLimit,
    notifyOverBudget: form.value.notifyOverBudget,
    emailSummary: form.value.emailSummary
  }))
  alert(`Preferensi diperbarui!\nBahasa: ${form.value.language}\nMata Uang: ${form.value.currency}\nBatas Anggaran: ${form.value.monthlyLimit}`)
}

const changePassword = () => {
  if (form.value.newPassword.length < 6) {
    alert('Password harus minimal 6 karakter.')
    return
  }

  localStorage.setItem('userPassword', form.value.newPassword)
  alert('Password berhasil diubah!')
  form.value.newPassword = ''
}

const goToDashboard = () => {
  router.push('/dashboard')
}
</script>

<style scoped>
.input {
  width: 100%;
  padding: 0.6rem 0.75rem;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  background-color: #fff;
  color: #111827;
  transition: all 0.3s ease;
}
.input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
  outline: none;
}
.btn-primary {
  background: linear-gradient(to right, #3b82f6, #2563eb);
  color: white;
  padding: 0.6rem 1.4rem;
  border-radius: 0.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  background: #1d4ed8;
}
.btn-secondary {
  background-color: #10b981;
  color: white;
  padding: 0.6rem 1.4rem;
  border-radius: 0.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-secondary:hover {
  background-color: #059669;
}
.btn-danger {
  background-color: #ef4444;
  color: white;
  padding: 0.6rem 1.4rem;
  border-radius: 0.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-danger:hover {
  background-color: #dc2626;
}
.animate-spin-slow {
  animation: spin 3s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
