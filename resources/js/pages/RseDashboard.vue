<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Bar, Doughnut } from 'vue-chartjs';
import { TrendingUpIcon, BuildingIcon, BarChart3Icon, StarIcon, AlertTriangleIcon, ChevronUpIcon, ChevronDownIcon } from 'lucide-vue-next';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';

// Configuration Chart.js
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend
);

interface Props {
  stats: {
    total_companies: number;
    avg_global_score: number;
    top_performers: number;
    need_improvement: number;
  };
  topCompanies: Array<{
    id: number;
    name: string;
    sector: string;
    global_score: number;
    rating_letter: string;
  }>;
  scoreDistribution: Record<string, number>;
  sectorPerformance: Array<{
    sector: string;
    avg_score: number;
    company_count: number;
  }>;
  currentSort?: {
    field: string;
    order: string;
  };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'CSR Assessment',
    href: '/rse',
  },
];

const searchQuery = ref('');
const sortBy = ref(props.currentSort?.field || 'global_score');
const sortOrder = ref(props.currentSort?.order || 'desc');

// Enhanced chart configurations with your color scheme
const scoreDistributionChart = computed(() => ({
  labels: Object.keys(props.scoreDistribution),
  datasets: [
    {
      label: 'Number of companies',
      data: Object.values(props.scoreDistribution),
      backgroundColor: [
        '#10B981', // Emerald for excellent
        '#06B6D4', // Cyan for good
        '#F59E0B', // Amber for average
        '#EF4444', // Red for poor
      ],
      borderWidth: 0,
      hoverOffset: 4,
    },
  ],
}));

const sectorPerformanceChart = computed(() => ({
  labels: props.sectorPerformance.map(s => s.sector),
  datasets: [
    {
      label: 'Average CSR Score',
      data: props.sectorPerformance.map(s => s.avg_score),
      backgroundColor: 'rgba(6, 182, 212, 0.8)', // Cyan with transparency
      borderColor: '#0891B2',
      borderWidth: 2,
      borderRadius: 6,
      borderSkipped: false,
    },
  ],
}));

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top' as const,
      labels: {
        usePointStyle: true,
        padding: 20,
        font: {
          size: 12,
          weight: 'normal' // Changed from '500' to 'bold' to match allowed values
        },
      },
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      max: 100,
      grid: {
        color: 'rgba(0, 0, 0, 0.05)',
      },
      ticks: {
        font: {
          size: 11,
        },
      },
    },
    x: {
      grid: {
        display: false,
      },
      ticks: {
        font: {
          size: 11,
        },
      },
    },
  },
};

const doughnutOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom' as const,
      labels: {
        usePointStyle: true,
        padding: 15,
        font: {
          size: 12,
          weight: 'normal' // Changed from '500' to 'bold' to match allowed values
        },
      },
    },
  },
  cutout: '60%',
};

// Enhanced rating colors with your color scheme
const getRatingColor = (letter: string) => {
  const colors = {
    'A+': 'text-emerald-700 bg-emerald-100 border-emerald-200',
    'A': 'text-emerald-600 bg-emerald-50 border-emerald-200',
    'B': 'text-cyan-600 bg-cyan-50 border-cyan-200',
    'C': 'text-yellow-600 bg-yellow-50 border-yellow-200',
    'D': 'text-orange-600 bg-orange-50 border-orange-200',
    'E': 'text-red-700 bg-red-100 border-red-200',
  };
  return colors[letter as keyof typeof colors] || 'text-gray-600 bg-gray-50 border-gray-200';
};

const handleSearch = () => {
  console.log('Searching for:', searchQuery.value);
  // Implement search functionality using Inertia
  router.get('/rse/search', { q: searchQuery.value }, {
    preserveState: true,
    preserveScroll: true,
  });
};

const handleSort = (column: string) => {
  if (sortBy.value === column) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortBy.value = column;
    sortOrder.value = 'desc';
  }
  
  // Trigger data refresh with new sorting using Inertia
  refreshDashboardData();
};

const refreshDashboardData = () => {
  router.get('/rse', {
    sort: sortBy.value,
    order: sortOrder.value,
  }, {
    preserveState: true,
    preserveScroll: true,
    only: ['topCompanies', 'currentSort'], // Only reload these props
  });
};

const getSortIcon = (column: string) => {
  if (sortBy.value !== column) return null;
  return sortOrder.value === 'asc' ? ChevronUpIcon : ChevronDownIcon;
};
</script>

<template>
  <Head title="CSR Dashboard - EcoScope">
    <meta name="description" content="Corporate Sustainability Assessment Dashboard - Discover the sustainability performance of French companies with detailed CSR scores and analytics." />
  </Head>

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-8">
      <!-- Enhanced Header -->
      <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 rounded-2xl shadow-lg border border-gray-200/20 p-8">
        <div class="flex items-center space-x-4 mb-4">
          <div class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-xl flex items-center justify-center">
            <TrendingUpIcon class="h-7 w-7 text-white" />
          </div>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
              Corporate Sustainability Assessment
            </h1>
            <p class="text-gray-600 mt-1">
              Discover the sustainability performance of French companies based on official data sources
            </p>
          </div>
        </div>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-medium">
            CSRD 2024 Compliant
          </span>
          <span>•</span>
          <span>Real-time data from ADEME, Data.gouv.fr, INSEE</span>
        </div>
      </div>

      <!-- Enhanced Metrics -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center">
                <BuildingIcon class="w-6 h-6 text-white" />
              </div>
            </div>
            <div class="ml-4 flex-1">
              <dt class="text-sm font-medium text-gray-600">
                Companies Assessed
              </dt>
              <dd class="text-2xl font-bold text-gray-900 mt-1">
                {{ props.stats.total_companies.toLocaleString() }}
              </dd>
            </div>
          </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <BarChart3Icon class="w-6 h-6 text-white" />
              </div>
            </div>
            <div class="ml-4 flex-1">
              <dt class="text-sm font-medium text-gray-600">
                Average Score
              </dt>
              <dd class="text-2xl font-bold text-gray-900 mt-1">
                {{ Math.round(props.stats.avg_global_score) }}/100
              </dd>
            </div>
          </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <StarIcon class="w-6 h-6 text-white" />
              </div>
            </div>
            <div class="ml-4 flex-1">
              <dt class="text-sm font-medium text-gray-600">
                Top Performers (80+)
              </dt>
              <dd class="text-2xl font-bold text-gray-900 mt-1">
                {{ props.stats.top_performers }}
              </dd>
            </div>
          </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                <AlertTriangleIcon class="w-6 h-6 text-white" />
              </div>
            </div>
            <div class="ml-4 flex-1">
              <dt class="text-sm font-medium text-gray-600">
                Need Improvement (&lt;60)
              </dt>
              <dd class="text-2xl font-bold text-gray-900 mt-1">
                {{ props.stats.need_improvement }}
              </dd>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Charts -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Distribution des scores -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-8">
          <div class="flex items-center space-x-3 mb-6">
            <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
              <TrendingUpIcon class="h-4 w-4 text-white" />
            </div>
            <h3 class="text-xl font-bold text-gray-900">
              CSR Score Distribution
            </h3>
          </div>
          <div class="h-80">
            <Doughnut :data="scoreDistributionChart" :options="doughnutOptions" />
          </div>
        </div>

        <!-- Performance par secteur -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-8">
          <div class="flex items-center space-x-3 mb-6">
            <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
              <BarChart3Icon class="h-4 w-4 text-white" />
            </div>
            <h3 class="text-xl font-bold text-gray-900">
              Average Performance by Sector
            </h3>
          </div>
          <div class="h-80">
            <Bar :data="sectorPerformanceChart" :options="chartOptions" />
          </div>
        </div>
      </div>

      <!-- Enhanced Top Companies Table -->
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-200/50 bg-gradient-to-r from-emerald-50 to-cyan-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
                <StarIcon class="h-4 w-4 text-white" />
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900">
                  Top CSR Performers
                </h3>
                <p class="text-gray-600 text-sm mt-1">Companies leading in sustainability practices</p>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-sm text-gray-500">Sort by:</span>
              <select 
                v-model="sortBy" 
                @change="refreshDashboardData"
                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:border-emerald-500 focus:outline-none"
              >
                <option value="global_score">Score</option>
                <option value="name">Name</option>
                <option value="sector">Sector</option>
                <option value="rating_letter">Rating</option>
              </select>
              <button 
                @click="handleSort(sortBy)"
                class="p-1 hover:bg-gray-100 rounded transition-colors"
                :class="{ 'bg-emerald-50 text-emerald-600': sortBy === sortBy }"
              >
                <component 
                  :is="getSortIcon(sortBy) || ChevronDownIcon" 
                  class="h-4 w-4 text-gray-600"
                />
              </button>
            </div>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200/50">
            <thead class="bg-gray-50/50">
              <tr>
                <th class="px-8 py-4 text-left">
                  <button 
                    @click="handleSort('name')"
                    class="flex items-center space-x-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-emerald-600 transition-colors"
                  >
                    <span>Company</span>
                    <component 
                      v-if="getSortIcon('name')" 
                      :is="getSortIcon('name')" 
                      class="h-3 w-3"
                    />
                  </button>
                </th>
                <th class="px-8 py-4 text-left">
                  <button 
                    @click="handleSort('sector')"
                    class="flex items-center space-x-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-emerald-600 transition-colors"
                  >
                    <span>Sector</span>
                    <component 
                      v-if="getSortIcon('sector')" 
                      :is="getSortIcon('sector')" 
                      class="h-3 w-3"
                    />
                  </button>
                </th>
                <th class="px-8 py-4 text-left">
                  <button 
                    @click="handleSort('global_score')"
                    class="flex items-center space-x-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-emerald-600 transition-colors"
                  >
                    <span>Score</span>
                    <component 
                      v-if="getSortIcon('global_score')" 
                      :is="getSortIcon('global_score')" 
                      class="h-3 w-3"
                    />
                  </button>
                </th>
                <th class="px-8 py-4 text-left">
                  <button 
                    @click="handleSort('rating_letter')"
                    class="flex items-center space-x-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-emerald-600 transition-colors"
                  >
                    <span>Rating</span>
                    <component 
                      v-if="getSortIcon('rating_letter')" 
                      :is="getSortIcon('rating_letter')" 
                      class="h-3 w-3"
                    />
                  </button>
                </th>
                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white/50 divide-y divide-gray-200/30">
              <tr v-for="company in props.topCompanies" :key="company.id" class="hover:bg-gray-50/50 transition-colors duration-200">
                <td class="px-8 py-4 whitespace-nowrap">
                  <div class="text-sm font-semibold text-gray-900">
                    {{ company.name }}
                  </div>
                </td>
                <td class="px-8 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-600">
                    {{ company.sector }}
                  </div>
                </td>
                <td class="px-8 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 mb-1">
                    {{ Math.round(company.global_score) }}/100
                  </div>
                  <div class="w-20 bg-gray-200 rounded-full h-2">
                    <div 
                      class="bg-gradient-to-r from-emerald-500 to-cyan-500 h-2 rounded-full transition-all duration-500"
                      :style="`width: ${company.global_score}%`"
                    ></div>
                  </div>
                </td>
                <td class="px-8 py-4 whitespace-nowrap">
                  <span 
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border"
                    :class="getRatingColor(company.rating_letter)"
                  >
                    {{ company.rating_letter }}
                  </span>
                </td>
                <td class="px-8 py-4 whitespace-nowrap text-sm font-medium">
                  <a :href="`/rse/company/${company.id}`" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors duration-200">
                    View Details →
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Enhanced Search Section -->
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-8">
        <div class="flex items-center space-x-3 mb-6">
          <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
            <TrendingUpIcon class="h-4 w-4 text-white" />
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">
              Search for a Company
            </h3>
            <p class="text-gray-600 text-sm mt-1">Find detailed CSR assessment for any French company</p>
          </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-4">
          <div class="flex-1">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Company name or SIREN number..."
              class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 transition-colors duration-200"
              @keyup.enter="handleSearch"
            />
          </div>
          <button 
            @click="handleSearch"
            class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-emerald-600 to-cyan-600 px-8 py-3 text-sm font-semibold text-white shadow-lg hover:from-emerald-700 hover:to-cyan-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all duration-200"
          >
            Search Company
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
