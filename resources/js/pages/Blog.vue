<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { CalendarIcon, ClockIcon, UserIcon } from '@heroicons/vue/24/outline';
import { ArrowRightIcon } from '@heroicons/vue/24/solid';
import { Menu, X, TrendingUpIcon } from 'lucide-vue-next';

const blogPosts = ref([
  {
    id: 1,
    title: "Total Energies improves its CSR score through renewable energy investments",
    excerpt: "The French energy giant has seen its sustainability score increase by 15 points this year thanks to significant investments in wind and solar power.",
    content: "Total Energies invested more than 3 billion euros in renewable energy in 2024...",
    author: "Marie Dubois",
    date: "2024-12-10",
    readTime: "5 min",
    category: "Energy",
    featured: true,
    image: "https://picsum.photos/600/300?random=1"
  },
  {
    id: 2,
    title: "Carrefour launches its zero food waste program",
    excerpt: "The retail chain announces ambitious measures to reduce food waste by 50% by 2025.",
    content: "Carrefour is committed to a major environmental initiative...",
    author: "Thomas Martin",
    date: "2024-12-08",
    readTime: "3 min",
    category: "Retail",
    featured: false,
    image: "https://picsum.photos/600/300?random=2"
  },
  {
    id: 3,
    title: "L'Oréal pioneers sustainable packaging",
    excerpt: "The global cosmetics leader develops 100% recyclable and biodegradable packaging for its entire range.",
    content: "L'Oréal invests heavily in sustainable packaging research...",
    author: "Sophie Bernard",
    date: "2024-12-05",
    readTime: "4 min",
    category: "Cosmetics",
    featured: false,
    image: "https://picsum.photos/600/300?random=3"
  },
  {
    id: 4,
    title: "Renault accelerates its transition to electric",
    excerpt: "The automaker announces that 80% of its production will be electric by 2026, exceeding European targets.",
    content: "Renault is betting everything on electric with new models...",
    author: "Jean Dupont",
    date: "2024-12-03",
    readTime: "6 min",
    category: "Automotive",
    featured: true,
    image: "https://picsum.photos/600/300?random=4"
  },
  {
    id: 5,
    title: "Danone certified B-Corp for its social approach",
    excerpt: "The food group obtains B-Corp certification, recognizing its social and environmental commitment.",
    content: "Danone becomes one of the largest B-Corp certified companies...",
    author: "Claire Rousseau",
    date: "2024-12-01",
    readTime: "4 min",
    category: "Food & Agriculture",
    featured: false,
    image: "https://picsum.photos/600/300?random=5"
  },
  {
    id: 6,
    title: "BNP Paribas stops financing fossil fuels",
    excerpt: "The French bank announces the gradual cessation of financing oil and gas projects by 2030.",
    content: "BNP Paribas commits to climate action by excluding fossil fuels...",
    author: "Pierre Moreau",
    date: "2024-11-28",
    readTime: "5 min",
    category: "Finance & Banking",
    featured: false,
    image: "https://picsum.photos/600/300?random=6"
  }
]);

const categories = ref([
  "All",
  "Energy",
  "Retail", 
  "Cosmetics",
  "Automotive",
  "Food & Agriculture",
  "Finance & Banking"
]);

const selectedCategory = ref("All");

const filteredPosts = computed(() => {
  if (selectedCategory.value === "All") {
    return blogPosts.value;
  }
  return blogPosts.value.filter(post => post.category === selectedCategory.value);
});

const featuredPosts = computed(() => {
  return blogPosts.value.filter(post => post.featured);
});

const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('fr-FR', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  });
};

const isMobileMenuOpen = ref(false);
</script>

<template>
  <Head title="CSR Blog - EcoScope" />
  
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-cyan-50">
    <!-- Navigation Header -->
    <header class="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/20">
      <nav class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <Link :href="route('home')" class="flex-shrink-0 flex items-center space-x-2">
              <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
                <TrendingUpIcon class="h-5 w-5 text-white" />
              </div>
              <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
                EcoScope
              </h1>
            </Link>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex items-center space-x-4">
            <Link
              :href="route('home')"
              class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
            >
              Home
            </Link>
            <template v-if="$page.props.auth.user">
              <Link
                :href="route('dashboard')"
                class="inline-flex items-center rounded-lg border border-transparent bg-gradient-to-r from-emerald-600 to-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200"
              >
                Dashboard
              </Link>
            </template>
            <template v-else>
              <Link
                :href="route('login')"
                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
              >
                Sign In
              </Link>
              <Link
                :href="route('register')"
                class="inline-flex items-center rounded-lg border border-transparent bg-gradient-to-r from-emerald-600 to-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200"
              >
                Get Started
              </Link>
            </template>
          </div>

          <!-- Mobile menu button -->
          <div class="md:hidden">
            <button
              @click="isMobileMenuOpen = !isMobileMenuOpen"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition-colors duration-200"
              aria-expanded="false"
            >
              <span class="sr-only">Open main menu</span>
              <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
              <X v-else class="h-6 w-6" />
            </button>
          </div>
        </div>

        <!-- Mobile menu -->
        <div v-show="isMobileMenuOpen" class="md:hidden">
          <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200/20">
            <Link
              :href="route('home')"
              class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
              @click="isMobileMenuOpen = false"
            >
              Home
            </Link>
            <template v-if="$page.props.auth.user">
              <Link
                :href="route('dashboard')"
                class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
                @click="isMobileMenuOpen = false"
              >
                Dashboard
              </Link>
            </template>
            <template v-else>
              <Link
                :href="route('login')"
                class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
                @click="isMobileMenuOpen = false"
              >
                Sign In
              </Link>
              <div class="px-3 py-2">
                <Link
                  :href="route('register')"
                  class="w-full inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-emerald-600 to-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200"
                  @click="isMobileMenuOpen = false"
                >
                  Get Started
                </Link>
              </div>
            </template>
          </div>
        </div>
      </nav>
    </header>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 to-cyan-600 py-16">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
            CSR News
          </h1>
          <p class="mt-6 text-lg leading-8 text-emerald-100">
            Follow the latest news on sustainable performance of French companies
          </p>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8 py-12">
      
      <!-- Featured Articles -->
      <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <article 
            v-for="post in featuredPosts" 
            :key="post.id"
            class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]"
          >
            <div class="aspect-[16/9] overflow-hidden">
              <img 
                :src="post.image" 
                :alt="post.title"
                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 mb-3">
                <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                  {{ post.category }}
                </span>
                <div class="flex items-center text-sm text-gray-500">
                  <CalendarIcon class="h-4 w-4 mr-1" />
                  {{ formatDate(post.date) }}
                </div>
                <div class="flex items-center text-sm text-gray-500">
                  <ClockIcon class="h-4 w-4 mr-1" />
                  {{ post.readTime }}
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors duration-200">
                {{ post.title }}
              </h3>
              <p class="text-gray-600 mb-4 line-clamp-3">
                {{ post.excerpt }}
              </p>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <UserIcon class="h-4 w-4 text-gray-400 mr-1" />
                  <span class="text-sm text-gray-600">{{ post.author }}</span>
                </div>
                <button class="inline-flex items-center text-emerald-600 font-medium hover:text-emerald-700 transition-colors duration-200">
                  Read more
                  <ArrowRightIcon class="ml-1 h-4 w-4" />
                </button>
              </div>
            </div>
          </article>
        </div>
      </div>

      <!-- Category Filter -->
      <div class="mb-8">
        <div class="flex flex-wrap gap-2">
          <button
            v-for="category in categories"
            :key="category"
            @click="selectedCategory = category"
            class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200"
            :class="selectedCategory === category 
              ? 'bg-emerald-600 text-white shadow-md' 
              : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            {{ category }}
          </button>
        </div>
      </div>

      <!-- Articles Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <article 
          v-for="post in filteredPosts" 
          :key="post.id"
          class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden hover:scale-[1.02]"
        >
          <div class="aspect-[16/9] overflow-hidden">
            <img 
              :src="post.image" 
              :alt="post.title"
              class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
          </div>
          <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
              <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ post.category }}
              </span>
              <div class="flex items-center text-sm text-gray-500">
                <CalendarIcon class="h-4 w-4 mr-1" />
                {{ formatDate(post.date) }}
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200">
              {{ post.title }}
            </h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
              {{ post.excerpt }}
            </p>
            <div class="flex items-center justify-between">
              <div class="flex items-center text-sm text-gray-500">
                <UserIcon class="h-4 w-4 mr-1" />
                {{ post.author }}
              </div>
              <div class="flex items-center text-sm text-gray-500">
                <ClockIcon class="h-4 w-4 mr-1" />
                {{ post.readTime }}
              </div>
            </div>
          </div>
        </article>
      </div>

      <!-- Load More Button -->
      <div class="text-center mt-12">
        <button class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-emerald-600 to-cyan-600 hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
          Load more articles
          <ArrowRightIcon class="ml-2 h-5 w-5" />
        </button>
      </div>
    </div>

    <!-- Newsletter Section -->
    <div class="bg-gradient-to-r from-emerald-600 to-cyan-600 py-16">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Stay informed about the latest CSR news
          </h2>
          <p class="mt-4 text-lg leading-8 text-emerald-100">
            Receive our weekly newsletter with the latest news on corporate sustainability.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row max-w-md mx-auto gap-4">
            <input
              type="email"
              placeholder="Your email address"
              class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-white focus:border-transparent"
            />
            <button class="px-6 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-emerald-50 transition-colors duration-200">
              Subscribe
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
      <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
        <div class="flex justify-center space-x-6 md:order-2">
          <div class="text-center md:text-left">
            <p class="text-sm leading-5 text-gray-400 mb-2">
              Official data sources
            </p>
            <p class="text-xs leading-5 text-gray-500">
              ADEME • Data.gouv.fr • CSRD Reports • EcoVadis • INSEE
            </p>
          </div>
        </div>
        <div class="mt-8 md:order-1 md:mt-0">
          <div class="flex items-center space-x-2 justify-center md:justify-start">
            <div class="h-6 w-6 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded flex items-center justify-center">
              <TrendingUpIcon class="h-4 w-4 text-white" />
            </div>
            <span class="text-lg font-bold bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">
              EcoScope
            </span>
          </div>
          <p class="mt-2 text-center md:text-left text-xs leading-5 text-gray-500">
            &copy; {{ new Date().getFullYear() }} EcoScope. CSR news and corporate sustainability.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
