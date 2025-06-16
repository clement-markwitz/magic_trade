import { createRouter, createWebHistory,  } from 'vue-router'
import register from '../components/Register.vue'
import Home from '../components/Home.vue'
// Définition des routes avec typage
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/register',
    name: 'About',
    component: register
  },
]

const router = createRouter({
  history: createWebHistory("http://127.0.0.1:8000"),
  routes
})

export default router