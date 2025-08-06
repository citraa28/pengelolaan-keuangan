import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './style.css'
import App from './App.vue'
import LoginPage from './pages/LoginPage.vue'
import DashboardPage from './pages/DashboardPage.vue'
import BerandaPage from './pages/BerandaPage.vue'
import PemasukanPage from './pages/PemasukanPage.vue'
import PengeluaranPage from './pages/PengeluaranPage.vue'
import RekapPage from './pages/RekapPage.vue'
import settingsPage from './pages/settingsPage.vue'
import { auth } from './firebase.js'
import { onAuthStateChanged } from 'firebase/auth'

const routes = [
  {
    path: '/',
    name: 'Login',
    component: LoginPage
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardPage,
    props: true,
    meta: { requiresAuth: true }
  },
  {
    path: '/beranda',
    name: 'Beranda',
    component: BerandaPage
  },
  {
    path: '/pemasukan',
    name: 'Pemasukan',
    component: PemasukanPage
  },
  {
    path: '/pengeluaran',
    name: 'Pengeluaran',
    component: PengeluaranPage
  },
  {
    path: '/rekap',
    name: 'RekapData',
    component: RekapPage
  },
  {
    path: '/settings',
    name: 'Settings',
    component: settingsPage
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Route guard untuk melindungi halaman yang memerlukan autentikasi
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  
  if (requiresAuth) {
    // Cek status autentikasi user
    onAuthStateChanged(auth, (user) => {
      if (user) {
        // User sudah login, izinkan akses ke dashboard
        next();
      } else {
        // User belum login, redirect ke halaman login
        next('/');
      }
    }, () => {
      // Error dalam pengecekan auth, redirect ke login
      next('/');
    });
  } else {
    // Halaman tidak memerlukan auth, izinkan akses
    next();
  }
});

const app = createApp(App);
app.use(router);
app.mount('#app');
