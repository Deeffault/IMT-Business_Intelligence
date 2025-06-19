<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Bar, Doughnut } from 'vue-chartjs';
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
  stats?: {
    total_companies: number;
    avg_global_score: number;
    top_performers: number;
    need_improvement: number;
  };
  topCompanies?: Array<{
    id: number;
    name: string;
    sector: string;
    global_score: number;
    rating_letter: string;
  }>;
  scoreDistribution?: Record<string, number>;
  sectorPerformance?: Array<{
    sector: string;
    avg_score: number;
    company_count: number;
  }>;
}

const props = withDefaults(defineProps<Props>(), {
  stats: () => ({
    total_companies: 50000,
    avg_global_score: 65.4,
    top_performers: 1250,
    need_improvement: 8900,
  }),
  topCompanies: () => [
    { id: 1, name: 'Danone', sector: 'Food & Agriculture', global_score: 94.2, rating_letter: 'A+' },
    { id: 2, name: 'L\'Oréal', sector: 'Cosmetics', global_score: 91.8, rating_letter: 'A+' },
    { id: 3, name: 'Renault', sector: 'Automotive', global_score: 89.5, rating_letter: 'A' },
    { id: 4, name: 'Total Energies', sector: 'Energy', global_score: 87.3, rating_letter: 'A' },
    { id: 5, name: 'Carrefour', sector: 'Retail', global_score: 85.9, rating_letter: 'A' },
  ],
  scoreDistribution: () => ({
    'Excellent (80-100)': 1250,
    'Good (60-80)': 28500,
    'Average (40-60)': 15750,
    'Poor (0-40)': 4500,
  }),
  sectorPerformance: () => [
    { sector: 'Energy', avg_score: 72.4, company_count: 156 },
    { sector: 'Finance', avg_score: 68.9, company_count: 324 },
    { sector: 'Food & Agri', avg_score: 71.2, company_count: 189 },
    { sector: 'Automotive', avg_score: 66.8, company_count: 98 },
    { sector: 'Retail', avg_score: 63.4, company_count: 267 },
  ],
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
];

// Configuration des graphiques avec couleurs EcoScope
const scoreDistributionChart = computed(() => ({
  labels: Object.keys(props.scoreDistribution),
  datasets: [
    {
      label: 'Number of companies',
      data: Object.values(props.scoreDistribution),
      backgroundColor: [
        '#10B981', // Emerald pour excellent
        '#06B6D4', // Cyan pour bon
        '#F59E0B', // Amber pour moyen
        '#EF4444', // Red pour faible
      ],
      borderWidth: 0,
    },
  ],
}));

const sectorPerformanceChart = computed(() => ({
  labels: props.sectorPerformance.map(s => s.sector),
  datasets: [
    {
      label: 'Average CSR Score',
      data: props.sectorPerformance.map(s => s.avg_score),
      backgroundColor: 'rgba(16, 185, 129, 0.8)', // Emerald
      borderColor: '#10B981',
      borderWidth: 2,
      borderRadius: 6,
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
        color: '#374151',
        font: {
          family: 'Inter',
          size: 12,
        },
      },
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      max: 100,
      grid: {
        color: '#F3F4F6',
      },
      ticks: {
        color: '#6B7280',
      },
    },
    x: {
      grid: {
        display: false,
      },
      ticks: {
        color: '#6B7280',
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
        color: '#374151',
        font: {
          family: 'Inter',
          size: 12,
        },
        padding: 20,
      },
    },
  },
};

// Fonction pour obtenir la couleur selon la note
const getRatingColor = (letter: string) => {
  const colors = {
    'A+': 'text-emerald-700 bg-emerald-100',
    'A': 'text-emerald-600 bg-emerald-50',
    'B': 'text-cyan-600 bg-cyan-50',
    'C': 'text-amber-600 bg-amber-50',
    'D': 'text-orange-600 bg-orange-50',
    'E': 'text-red-600 bg-red-100',
  };
  return colors[letter as keyof typeof colors] || 'text-gray-500 bg-gray-50';
};
</script>

<template>
  <Head title="Dashboard - EcoScope" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-6 p-4">
      <!-- En-tête avec gradient EcoScope -->
      <div class="bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center space-x-4">
          <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-md">
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
          </div>
          <div>
            <h1 class="text-3xl font-bold mb-2">
              Corporate Sustainability Dashboard
            </h1>
            <p class="text-emerald-100">
              Discover the sustainability performance of French companies with transparent, data-driven insights
            </p>
          </div>
        </div>
      </div>

      <!-- Métriques principales -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Companies Assessed
                </dt>
                <dd class="text-2xl font-bold text-gray-900">
                  {{ props.stats.total_companies.toLocaleString() }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Average Score
                </dt>
                <dd class="text-2xl font-bold text-gray-900">
                  {{ Math.round(props.stats.avg_global_score) }}/100
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Top Performers (80+)
                </dt>
                <dd class="text-2xl font-bold text-gray-900">
                  {{ props.stats.top_performers.toLocaleString() }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Need Improvement (&lt;60)
                </dt>
                <dd class="text-2xl font-bold text-gray-900">
                  {{ props.stats.need_improvement.toLocaleString() }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Graphiques -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Distribution des scores -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
          <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-2 h-2 bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-full mr-3"></div>
            CSR Score Distribution
          </h3>
          <div class="h-64">
            <Doughnut :data="scoreDistributionChart" :options="doughnutOptions" />
          </div>
        </div>

        <!-- Performance par secteur -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
          <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-2 h-2 bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-full mr-3"></div>
            Average Performance by Sector
          </h3>
          <div class="h-64">
            <Bar :data="sectorPerformanceChart" :options="chartOptions" />
          </div>
        </div>
      </div>

      <!-- Top des entreprises -->
      <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <div class="w-2 h-2 bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-full mr-3"></div>
            Top CSR Performers
          </h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Company
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Sector
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Score
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Rating
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="company in props.topCompanies" :key="company.id" class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ company.name }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-500">
                    {{ company.sector }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 font-medium">
                    {{ Math.round(company.global_score) }}/100
                  </div>
                  <div class="w-16 bg-gray-200 rounded-full h-1.5 mt-1">
                    <div 
                      class="bg-gradient-to-r from-emerald-500 to-cyan-600 h-1.5 rounded-full" 
                      :style="{ width: `${company.global_score}%` }"
                    ></div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="getRatingColor(company.rating_letter)">
                    {{ company.rating_letter }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-emerald-600 hover:text-emerald-900 transition-colors duration-150">
                    View Details
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Barre de recherche -->
      <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
          <div class="w-2 h-2 bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-full mr-3"></div>
          Search Companies
        </h3>
        <div class="flex space-x-4">
          <div class="flex-1">
            <input
              type="text"
              placeholder="Company name or SIREN number..."
              class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-150"
            />
          </div>
          <button class="bg-gradient-to-r from-emerald-600 to-cyan-600 text-white px-6 py-2 rounded-lg hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200">
            Search
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
