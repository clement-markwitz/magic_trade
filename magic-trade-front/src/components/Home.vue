 <template>
 <!-- Hero Content -->
  <section class="relative overflow-hidden">
      <div class="relative z-10 px-6 py-20">
        <div class="max-w-7xl mx-auto text-center">
          <h2 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
            Échangez vos cartes
            <span class="bg-gradient-to-r from-red-400 to-orange-400 bg-clip-text text-transparent block py-3">
  Magic: The Gathering
</span>
          </h2>
          
          <p class="text-xl text-gray-100 max-w-3xl mx-auto mb-12 leading-relaxed font-medium">
            Rejoignez la plus grande communauté d'échangeurs de cartes MTG. 
            Trouvez les cartes que vous cherchez et échangez celles dont vous n'avez plus besoin.
          </p>
          
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:from-red-700 hover:to-orange-700 transform hover:scale-105 transition-all shadow-xl">
              Commencer à échanger
            </button>
            <button class="border-2 border-red-500 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-red-600 hover:border-red-600 transition-all">
              Explorer les collections
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 px-6 bg-gray-900">
      <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
          <div class="bg-gray-800 backdrop-blur-sm rounded-2xl p-8 hover:bg-gray-700 transition-all border border-gray-700 shadow-lg">
            <div class="text-4xl font-bold text-red-400 mb-2">{{ stats.users.toLocaleString() }}+</div>
            <div class="text-gray-100 text-lg font-medium">Utilisateurs actifs</div>
          </div>
          <div class="bg-gray-800 backdrop-blur-sm rounded-2xl p-8 hover:bg-gray-700 transition-all border border-gray-700 shadow-lg">
            <div class="text-4xl font-bold text-orange-400 mb-2">{{ stats.trades.toLocaleString() }}+</div>
            <div class="text-gray-100 text-lg font-medium">Échanges réalisés</div>
          </div>
          <div class="bg-gray-800 backdrop-blur-sm rounded-2xl p-8 hover:bg-gray-700 transition-all border border-gray-700 shadow-lg">
            <div class="text-4xl font-bold text-red-300 mb-2">{{ stats.cards.toLocaleString() }}+</div>
            <div class="text-gray-100 text-lg font-medium">Cartes disponibles</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6 bg-black">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h3 class="text-4xl font-bold text-white mb-6">
            Pourquoi choisir Magic Trade ?
          </h3>
          <p class="text-xl text-gray-100 max-w-3xl mx-auto font-medium">
            Notre plateforme vous offre tous les outils nécessaires pour des échanges sécurisés et équitables.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <div v-for="feature in features" :key="feature.id" class="text-center group">
            <div class="w-20 h-20 bg-gradient-to-r from-red-600 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
              <component :is="feature.icon" class="w-8 h-8 text-white" />
            </div>
            <h4 class="text-2xl font-semibold text-white mb-4">{{ feature.title }}</h4>
            <p class="text-gray-200 leading-relaxed font-medium">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Cards Section -->
    <section class="py-20 px-6 bg-gray-900">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h3 class="text-4xl font-bold text-white mb-6">
            Cartes populaires du moment
          </h3>
          <p class="text-xl text-gray-100 font-medium">
            Découvrez les cartes les plus recherchées par la communauté
          </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="card in popularCards" :key="card.id" class="bg-gray-800 backdrop-blur-sm rounded-2xl p-6 hover:bg-gray-700 transition-all transform hover:scale-105 border border-gray-700 shadow-lg">
            <div class="aspect-[3/4] bg-gradient-to-b from-gray-700 to-gray-800 rounded-xl mb-4 flex items-center justify-center border border-gray-600">
              <span class="text-gray-300 text-sm text-center px-2 font-medium">{{ card.name }}</span>
            </div>
            <h5 class="font-semibold text-white mb-2 text-center">{{ card.name }}</h5>
            <div class="flex justify-between items-center">
              <span class="text-red-400 font-bold">{{ card.price }}€</span>
              <span class="text-gray-300 text-sm font-medium">{{ card.set }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6 bg-black">
      <div class="max-w-4xl mx-auto text-center">
        <h3 class="text-4xl font-bold text-white mb-6">
          Prêt à commencer votre collection ?
        </h3>
        <p class="text-xl text-gray-100 mb-12 font-medium">
          Rejoignez des milliers d'autres joueurs et commencez à échanger dès aujourd'hui.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
          <button class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-10 py-5 rounded-xl text-xl font-semibold hover:from-red-700 hover:to-orange-700 transform hover:scale-105 transition-all shadow-xl">
            Créer mon compte gratuitement
          </button>
          <button class="border-2 border-red-500 text-white px-10 py-5 rounded-xl text-xl font-semibold hover:bg-red-600 hover:border-red-600 transition-all">
            En savoir plus
          </button>
        </div>
      </div>
    </section>
    </template>

<script setup lang="ts">
import { ref }from 'vue'
import { 
  ShieldCheckIcon, 
  CircleStackIcon, 
  UsersIcon 
} from '@heroicons/vue/24/outline'
    interface Stats {
  users: number
  trades: number
  cards: number
}

interface Feature {
  id: number
  title: string
  description: string
  icon: any
}

interface Card {
  id: number
  name: string
  price: string
  set: string
}

const stats = ref<Stats>({
  users: 15420,
  trades: 89650,
  cards: 245890
})

const features = ref<Feature[]>([
  {
    id: 1,
    title: "Échanges sécurisés",
    description: "Système de validation et de notation pour des échanges en toute confiance.",
    icon: ShieldCheckIcon
  },
  {
    id: 2,
    title: "Catalogue complet",
    description: "Accédez à l'intégralité des cartes Magic mis à jour en temps réel grâce à l'api scryfall.",
    icon: CircleStackIcon
  },
  {
    id: 3,
    title: "Communauté active",
    description: "Rejoignez une communauté passionnée et bienveillante de joueurs MTG.",
    icon: UsersIcon
  }
])

const popularCards = ref<Card[]>([
  { id: 1, name: "Jace, the Mind Sculptor", price: "89.99", set: "Worldwake" },
  { id: 2, name: "Tarmogoyf", price: "67.50", set: "Modern Masters" },
  { id: 3, name: "Liliana of the Veil", price: "78.00", set: "Innistrad" },
  { id: 4, name: "Snapcaster Mage", price: "45.99", set: "Innistrad" }
])

</script>