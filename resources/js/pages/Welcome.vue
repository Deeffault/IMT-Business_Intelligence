<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { ChevronRightIcon, StarIcon, ArrowRightIcon } from '@heroicons/vue/24/outline';
import { BarChart3Icon, FilterIcon, FileTextIcon, ShieldCheckIcon, TrendingUpIcon } from 'lucide-vue-next';
import { Menu, X } from 'lucide-vue-next';

// Animation des statistiques
const stats = ref([
  { id: 1, name: 'Companies Assessed', value: 0, target: 50000, suffix: '+' },
  { id: 2, name: 'Data Sources', value: 0, target: 25, suffix: '+' },
  { id: 3, name: 'CSR Indicators', value: 0, target: 150, suffix: '+' }
]);

const isVisible = ref(false);
const isMobileMenuOpen = ref(false);

onMounted(() => {
  isVisible.value = true;
  // Animation des compteurs
  stats.value.forEach((stat, index) => {
    setTimeout(() => {
      animateValue(stat, stat.target, 2000);
    }, index * 200);
  });
});

const animateValue = (stat: any, target: number, duration: number) => {
  const increment = target / (duration / 16);
  const timer = setInterval(() => {
    stat.value += increment;
    if (stat.value >= target) {
      stat.value = target;
      clearInterval(timer);
    }
  }, 16);
};

const features = [
  {
    name: 'Real-time CSR Scoring',
    description: 'Get instant comprehensive sustainability scores based on environmental, social and governance criteria.',
    icon: BarChart3Icon,
    color: 'bg-emerald-500'
  },
  {
    name: 'Advanced Filtering',
    description: 'Filter and compare companies by sector, size, location and specific sustainability criteria.',
    icon: FilterIcon,
    color: 'bg-cyan-500'
  },
  {
    name: 'Detailed Reports',
    description: 'Access comprehensive sustainability reports with actionable insights and improvement recommendations.',
    icon: FileTextIcon,
    color: 'bg-emerald-600'
  },
  {
    name: 'Verified Sources',
    description: 'All data comes from official government databases, CSRD reports and verified public sources.',
    icon: ShieldCheckIcon,
    color: 'bg-cyan-600'
  }
];

const testimonials = [
  {
    body: "EcoScope helped us quickly identify the most sustainable companies for our investments. An essential tool for ESG.",
    author: {
      name: 'Marie Dubois',
      handle: 'CSR Director, Green Capital',
      imageUrl: 'https://picsum.photos/id/64/100/100'
    }
  },
  {
    body: "The data transparency and ease of use make EcoScope our reference for evaluating the CSR performance of our partners.",
    author: {
      name: 'Thomas Martin',
      handle: 'CEO, EcoTech Solutions',
      imageUrl: 'https://picsum.photos/id/349/100/100'
    }
  }
];
</script>

<template>
  <Head title="EcoScope - Transparent CSR Assessment for Companies">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <meta name="description" content="Discover the sustainable performance of French companies. Access transparent CSR scores based on public data and help companies improve their ecological footprint." />
  </Head>
  
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-cyan-50">
    <!-- Navigation Header -->
    <header class="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/20">
      <nav class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center space-x-2">
              <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
                <TrendingUpIcon class="h-5 w-5 text-white" />
              </div>
              <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
                EcoScope
              </h1>
            </div>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex items-center space-x-4">
            <Link
              :href="route('blog')"
              class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
            >
              Blog
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
              :href="route('blog')"
              class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
              @click="isMobileMenuOpen = false"
            >
              Blog
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
    <main class="relative overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-r from-emerald-200/30 to-cyan-200/30 blur-3xl"></div>
        <div class="absolute top-1/2 right-0 w-[600px] h-[600px] rounded-full bg-gradient-to-l from-blue-200/20 to-purple-200/20 blur-3xl"></div>
      </div>

      <div class="mx-auto max-w-7xl px-6 py-20 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
          <!-- Badge -->
          <div 
            class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-sm font-medium text-emerald-800 mb-8 transition-all duration-700"
            :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-4': !isVisible }"
          >
            <StarIcon class="mr-2 h-4 w-4" />
            CSRD 2024 Compliant
          </div>

          <!-- Main Heading -->
          <h1 
            class="text-5xl font-bold tracking-tight text-gray-900 sm:text-7xl mb-8 transition-all duration-700 delay-150"
            :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-8': !isVisible }"
          >
            Transparent 
            <span class="bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
              CSR
            </span>
            <br />for Companies
          </h1>

          <!-- Subtitle -->
          <p 
            class="mx-auto mt-6 max-w-2xl text-xl leading-8 text-gray-600 mb-10 transition-all duration-700 delay-300"
            :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-8': !isVisible }"
          >
            Discover the environmental, social and governance performance of French companies. 
            Our platform aggregates public data to provide transparent CSR scores and help companies improve their sustainable footprint.
          </p>

          <!-- CTA Buttons -->
          <div 
            class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16 transition-all duration-700 delay-500"
            :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-8': !isVisible }"
          >
            <template v-if="$page.props.auth.user">
              <Link
                :href="route('dashboard')"
                class="group inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-600 to-cyan-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:from-emerald-700 hover:to-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all duration-200 hover:scale-105"
              >
                Access Dashboard
                <ArrowRightIcon class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" />
              </Link>
            </template>
            <template v-else>
              <Link
                :href="route('register')"
                class="group inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-600 to-cyan-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:from-emerald-700 hover:to-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all duration-200 hover:scale-105"
              >
                Explore for Free
                <ArrowRightIcon class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" />
              </Link>
            </template>
            <a 
              href="#features" 
              class="group inline-flex items-center text-lg font-semibold leading-7 text-gray-700 hover:text-gray-900 transition-colors duration-200"
            >
              Learn more 
              <ChevronRightIcon class="ml-1 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" />
            </a>
          </div>

          <!-- Trust Indicators -->
          <div 
            class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-center transition-all duration-700 delay-700"
            :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-8': !isVisible }"
          >
            <div class="flex flex-col items-center">
              <div class="text-sm text-gray-500 mb-1">Official sources</div>
              <div class="text-xs text-gray-400">ADEME • Data.gouv • CSRD</div>
            </div>
            <div class="flex flex-col items-center">
              <div class="text-sm text-gray-500 mb-1">Real-time updates</div>
              <div class="text-xs text-gray-400">Live API integration</div>
            </div>
            <div class="flex flex-col items-center">
              <div class="text-sm text-gray-500 mb-1">Compliance</div>
              <div class="text-xs text-gray-400">GDPR • EcoVadis</div>
            </div>
            <div class="flex flex-col items-center">
              <div class="text-sm text-gray-500 mb-1">Sectors</div>
              <div class="text-xs text-gray-400">220+ categories</div>
            </div>
          </div>
        </div>

        <!-- Stats Section -->
        <div class="mx-auto mt-20 max-w-2xl sm:mt-24 lg:mt-32 lg:max-w-none">
          <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
            <div 
              v-for="stat in stats" 
              :key="stat.id"
              class="flex flex-col gap-y-3 border-l-2 border-emerald-500 pl-6 transition-all duration-700"
              :class="{ 'opacity-100 translate-x-0': isVisible, 'opacity-0 -translate-x-8': !isVisible }"
              :style="{ transitionDelay: `${800 + stat.id * 100}ms` }"
            >
              <dt class="text-sm leading-6 text-gray-600">{{ stat.name }}</dt>
              <dd class="order-first text-4xl font-bold tracking-tight bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
                {{ Math.floor(stat.value).toLocaleString() }}{{ stat.suffix }}
              </dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Features Section -->
      <div id="features" class="mx-auto max-w-7xl px-6 lg:px-8 py-24 sm:py-32">
        <div class="mx-auto max-w-2xl lg:text-center mb-16">
          <h2 class="text-base font-semibold leading-7 text-emerald-600 mb-2">Complete Analysis</h2>
          <p class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl mb-6">
            Everything you need to assess sustainability
          </p>
          <p class="text-xl leading-8 text-gray-600">
            Our platform leverages official public data sources, including CSRD reports, 
            ADEME databases and government portals to provide accurate and up-to-date sustainability assessments.
          </p>
        </div>

        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
          <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
            <div 
              v-for="(feature) in features" 
              :key="feature.name"
              class="group relative pl-16 transition-all duration-500 hover:scale-105"
            >
              <dt class="text-base font-semibold leading-7 text-gray-900">
                <div 
                  class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-xl shadow-lg transition-all duration-300 group-hover:scale-110"
                  :class="feature.color"
                >
                  <component :is="feature.icon" class="h-6 w-6 text-white" />
                </div>
                {{ feature.name }}
              </dt>
              <dd class="mt-2 text-base leading-7 text-gray-600">
                {{ feature.description }}
              </dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Testimonials Section -->
      <div class="bg-gradient-to-br from-gray-50 to-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <div class="mx-auto max-w-xl text-center">
            <h2 class="text-lg font-semibold leading-8 tracking-tight text-emerald-600">Testimonials</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
              They trust us
            </p>
          </div>
          <div class="mx-auto mt-16 flow-root max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-2">
              <div 
                v-for="testimonial in testimonials" 
                :key="testimonial.author.handle"
                class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300"
              >
                <figure>
                  <blockquote class="text-gray-900">
                    <p class="text-lg leading-8">"{{ testimonial.body }}"</p>
                  </blockquote>
                  <figcaption class="mt-6 flex items-center gap-x-4">
                    <img class="h-10 w-10 rounded-full bg-gray-50" :src="testimonial.author.imageUrl" alt="" />
                    <div class="text-sm leading-6">
                      <p class="font-semibold text-gray-900">{{ testimonial.author.name }}</p>
                      <p class="text-gray-600">{{ testimonial.author.handle }}</p>
                    </div>
                  </figcaption>
                </figure>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="relative bg-gradient-to-br from-emerald-600 to-cyan-600 overflow-hidden">
        <div class="absolute inset-0">
          <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/90 to-cyan-600/90"></div>
        </div>
        <div class="relative px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
          <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">
              Ready to explore corporate sustainability?
            </h2>
            <p class="mx-auto mt-6 max-w-xl text-xl leading-8 text-emerald-100">
              Join thousands of users who rely on EcoScope for transparent, data-driven sustainability insights.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
              <template v-if="$page.props.auth.user">
                <Link
                  :href="route('dashboard')"
                  class="group inline-flex items-center rounded-xl bg-white px-8 py-4 text-lg font-semibold text-emerald-600 shadow-lg hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-200 hover:scale-105"
                >
                  Access Dashboard
                  <ArrowRightIcon class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" />
                </Link>
              </template>
              <template v-else>
                <Link
                  :href="route('register')"
                  class="group inline-flex items-center rounded-xl bg-white px-8 py-4 text-lg font-semibold text-emerald-600 shadow-lg hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-200 hover:scale-105"
                >
                  Start Free
                  <ArrowRightIcon class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform duration-200" />
                </Link>
                <Link
                  :href="route('login')"
                  class="inline-flex items-center text-xl font-semibold leading-7 text-white hover:text-emerald-100 transition-colors duration-200"
                >
                  Sign in 
                  <ArrowRightIcon class="ml-1 h-5 w-5" />
                </Link>
              </template>
            </div>
          </div>
        </div>
      </div>
    </main>

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
            &copy; {{ new Date().getFullYear() }} EcoScope. Promoting corporate transparency for a sustainable future.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>