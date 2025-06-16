  <template>
  <nav class="relative z-10 px-6 py-4 bg-black/60 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
        <RouterLink to="/">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-red-600 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
              <span class="text-white font-bold text-xl">M</span>
            </div>
            <h1 class="text-2xl font-bold text-white">Magic Trade</h1>
          </div>
          </RouterLink>
          <div class="hidden md:flex items-center space-x-6">
            <RouterLink to="/" class="text-gray-200 hover:text-orange-400 transition-colors font-medium">Acceuil</RouterLink>
            <a href="#" class="text-gray-200 hover:text-orange-400 transition-colors font-medium">Trades</a>
            <a href="#" class="text-gray-200 hover:text-orange-400 transition-colors font-medium">Ajouer une carte</a>
            <a href="#" class="text-gray-200 hover:text-orange-400 transition-colors font-medium">Ma collection</a>
            <a href="#" class="text-gray-200 hover:text-orange-400 transition-colors font-medium">À propos</a>
          </div>
          
          <div class="flex items-center space-x-4">
            <button class="text-gray-100 hover:text-orange-400 transition-colors font-medium">
              Connexion
            </button>
            <RouterLink to="/register">
            <button class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-orange-700 transition-all shadow-lg font-medium">
              S'inscrire
            </button>
            </RouterLink>
          </div>
        </div>
      </nav>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router';

</script>
