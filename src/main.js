import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './style.css'
import App from './App.vue'
import LoginPage from './pages/LoginPage.vue'
import AwalPage from './pages/AwalPage.vue'
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
    name: 'HalamanAwal',
    component: AwalPage
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage
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

// Route guard untuk melindungi halaman yang memerlukan autentikasi
router.beforeEach((to, from, next) => {
  // Cek apakah halaman yang diakses memerlukan autentikasi
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  
  // Cek status autentikasi user
  onAuthStateChanged(auth, (user) => {
    // Jika halaman yang diakses memerlukan autentikasi
    if (requiresAuth) {
      // Jika user sudah login
      if (user) {
        if (to.path === '/login') {
          // Jika urlnya /login, redirect ke halaman beranda
          next('/beranda');
        } else {
          // Jika urlnya bukan /login, lanjutkan ke halaman yang diakses
          next();
        }
      } else {
        // Jika user belum login, redirect ke halaman login
        next('/login');
      }
    } else { // Jika halaman yang diakses tidak memerlukan autentikasi
      // Jika user sudah login dan urlnya /login, redirect ke halaman beranda
      if(user && to.path === '/login') {
        next('/beranda');
      } else {
        // Jika urlnya bukan /login, lanjutkan ke halaman yang diakses
        next();
      }
    }
  }, () => {
    // Error dalam pengecekan auth, redirect ke login
    next('/login');
  });
});

const app = createApp(App);
app.use(router);
app.mount('#app');
