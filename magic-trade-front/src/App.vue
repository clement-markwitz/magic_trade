<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-800">
    <!-- Hero Section -->
    
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-3">
        <div class="absolute inset-0 bg-pattern"></div>
      </div>
      
      <!-- Header -->
      <Header />

      <RouterView />

    <!-- Footer -->
     <Footer />
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import { RouterView } from 'vue-router'




onMounted(() => {
  // Logique d'animation ou autres initialisations
})
</script>

<style scoped>
/* Pattern background très discret */
.bg-pattern {
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23374151' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Animations personnalisées */
@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
}

.float-animation {
  animation: float 3s ease-in-out infinite;
}
</style>
