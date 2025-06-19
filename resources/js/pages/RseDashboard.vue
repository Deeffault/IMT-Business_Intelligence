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

interface TopCompany {
  id: number;
  name: string;
  sector: string;
  global_score: number;
  rating_letter: string;
  display_rank?: number;
}

interface Props {
  stats: {
    total_companies: number;
    avg_global_score: number;
    top_performers: number;
    need_improvement: number;
  };
  topCompanies: TopCompany[];
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
        '#F97316', // Orange for average (50-64)
        '#EAB308', // Yellow for good (65-79)
        '#10B981', // Emerald for excellent (80+)
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
          weight: 'normal' as const // Use allowed values: "bold", "normal", "lighter", "bolder"
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
          weight: 'normal' as const // Use only allowed values: "bold", "normal", "lighter", "bolder"
        } as const,
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

// Function to get color based on score (green > yellow > orange > red)
const getScoreColor = (score: number) => {
  if (score >= 80) {
    return 'from-emerald-500 to-emerald-600'; // Excellent (80-100)
  } else if (score >= 65) {
    return 'from-yellow-400 to-yellow-500'; // Good (65-79)
  } else if (score >= 50) {
    return 'from-orange-400 to-orange-500'; // Average (50-64)
  } else {
    return 'from-red-400 to-red-500'; // Poor (0-49)
  }
};

// Function to get text color based on score
const getScoreTextColor = (score: number) => {
  if (score >= 80) {
    return 'text-emerald-700'; 
  } else if (score >= 65) {
    return 'text-yellow-700';
  } else if (score >= 50) {
    return 'text-orange-700';
  } else {
    return 'text-red-700';
  }
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

const goToCompanyDetail = (companyId: number) => {
  router.get(`/rse/company/${companyId}`);
};
</script>

<template>

  <Head title="CSR Dashboard - EcoScope">
    <meta name="description"
      content="Corporate Sustainability Assessment Dashboard - Discover the sustainability performance of companies with detailed CSR scores and analytics." />
  </Head>

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-8">
      <!-- Enhanced Header -->
      <div
        class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 rounded-2xl shadow-lg border border-gray-200/20 p-8">
        <div class="flex items-center space-x-4 mb-4">
          <div
            class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-xl flex items-center justify-center">
            <TrendingUpIcon class="h-7 w-7 text-white" />
          </div>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
              Corporate Sustainability Assessment
            </h1>
            <p class="text-gray-600 mt-1">
              Discover the sustainability performance of companies based on official data sources
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
        <div
          class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center">
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

        <div
          class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
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

        <div
          class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
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

        <div
          class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-6 hover:shadow-xl transition-all duration-300">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
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
            <div
              class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
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
            <div
              class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
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
              <div
                class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
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
              <select v-model="sortBy" @change="refreshDashboardData"
                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:border-emerald-500 focus:outline-none">
                <option value="global_score">Score</option>
                <option value="name">Name</option>
                <option value="sector">Sector</option>
                <option value="rating_letter">Rating</option>
              </select>
              <button @click="handleSort(sortBy)" class="p-1 hover:bg-gray-100 rounded transition-colors"
                :class="{ 'bg-emerald-50 text-emerald-600': sortBy === sortBy }">
                <component :is="getSortIcon(sortBy) || ChevronDownIcon" class="h-4 w-4 text-gray-600" />
              </button>
              <button
                class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-cyan-600 px-4 py-2 text-sm font-semibold text-white shadow hover:from-emerald-700 hover:to-cyan-700 transition-all ml-4"
                @click="() => router.get('/rse/companies')">
                See All Companies
              </button>
            </div>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200/50">
            <thead class="bg-gray-50/50">
              <tr>
                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  #
                </th>
                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Company
                </th>
                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Sector
                </th>
                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Score
                </th>
                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Rating
                </th>
              </tr>
            </thead>
            <tbody class="bg-white/50 divide-y divide-gray-200/30">
              <tr v-for="company in props.topCompanies" :key="company.id"
                class="hover:bg-gray-50/50 transition-colors duration-200 cursor-pointer"
                @click="goToCompanyDetail(company.id)">
                <td class="px-8 py-4 whitespace-nowrap font-bold text-gray-700">{{ company.display_rank ?? '-' }}</td>
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
                  <div class="text-sm font-medium mb-1" :class="getScoreTextColor(company.global_score)">
                    {{ Math.round(company.global_score) }}/100
                  </div>
                  <div class="w-20 bg-gray-200 rounded-full h-2">
                    <div
                      class="bg-gradient-to-r h-2 rounded-full transition-all duration-500"
                      :class="getScoreColor(company.global_score)"
                      :style="`width: ${company.global_score}%`"></div>
                  </div>
                </td>
                <td class="px-8 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border"
                    :class="getRatingColor(company.rating_letter)">
                    {{ company.rating_letter }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
