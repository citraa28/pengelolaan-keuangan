import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './style.css'
import App from './App.vue'
import LoginPage from './pages/LoginPage.vue'
import RegisterPage from './pages/RegisterPage.vue' // <-- Impor halaman registrasi
import ForgotPasswordPage from './pages/ForgotPasswordPage.vue'
import ResetPasswordPage from './pages/ResetPasswordPage.vue'
import AwalPage from './pages/AwalPage.vue'
import BerandaPage from './pages/BerandaPage.vue'
import PemasukanPage from './pages/PemasukanPage.vue'
import PengeluaranPage from './pages/PengeluaranPage.vue'
import RekapPage from './pages/RekapPage.vue'
import settingsPage from './pages/settingsPage.vue'
import { useAuth } from './composables/useAuth.js'

const routes = [
  {
    path: '/',
    name: 'HalamanAwal',
    component: AwalPage
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage
  },
  {
    path: '/register', 
    name: 'Register',
    component: RegisterPage
  },
   {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPasswordPage
  },
  {
    path: '/reset-password/:token',
    name: 'ResetPassword',
    component: ResetPasswordPage
  },
  {
    path: '/beranda',
    name: 'Beranda',
    component: BerandaPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/pemasukan',
    name: 'Pemasukan',
    component: PemasukanPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/pengeluaran',
    name: 'Pengeluaran',
    component: PengeluaranPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/rekap',
    name: 'RekapData',
    component: RekapPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/settings',
    name: 'Settings',
    component: settingsPage,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation Guard baru untuk JWT
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token');
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !isAuthenticated) {
    // Jika rute butuh login dan user belum login, redirect ke halaman login
    next({ name: 'Login' });
  } else if (!requiresAuth && isAuthenticated && (to.name === 'Login' || to.name === 'Register')) {
    // Jika user sudah login dan mencoba mengakses halaman login/register, redirect ke beranda
    next({ name: 'Beranda' });
  } else {
    // Lanjutkan navigasi
    next();
  }
});

const app = createApp(App);
app.use(router);
app.mount('#app');

// Coba ambil data user jika ada token saat aplikasi pertama kali dimuat
const { attempt } = useAuth();
attempt();
