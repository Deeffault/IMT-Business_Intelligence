<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Line, Bar, Doughnut } from 'vue-chartjs';
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
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Évaluation RSE',
    href: '/rse',
  },
];

// Configuration des graphiques
const scoreDistributionChart = computed(() => ({
  labels: Object.keys(props.scoreDistribution),
  datasets: [
    {
      label: 'Nombre d\'entreprises',
      data: Object.values(props.scoreDistribution),
      backgroundColor: [
        '#10B981', // Vert pour excellent
        '#F59E0B', // Jaune pour bon
        '#F97316', // Orange pour moyen
        '#EF4444', // Rouge pour faible
      ],
      borderWidth: 0,
    },
  ],
}));

const sectorPerformanceChart = computed(() => ({
  labels: props.sectorPerformance.map(s => s.sector),
  datasets: [
    {
      label: 'Score moyen RSE',
      data: props.sectorPerformance.map(s => s.avg_score),
      backgroundColor: '#3B82F6',
      borderColor: '#1D4ED8',
      borderWidth: 1,
    },
  ],
}));

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top' as const,
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      max: 100,
    },
  },
};

const doughnutOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom' as const,
    },
  },
};

// Fonction pour obtenir la couleur selon la note
const getRatingColor = (letter: string) => {
  const colors = {
    'A+': 'text-green-600 bg-green-100',
    'A': 'text-green-500 bg-green-50',
    'B': 'text-yellow-500 bg-yellow-50',
    'C': 'text-orange-500 bg-orange-50',
    'D': 'text-red-500 bg-red-50',
    'E': 'text-red-600 bg-red-100',
  };
  return colors[letter as keyof typeof colors] || 'text-gray-500 bg-gray-50';
};
</script>

<template>
  <Head title="Tableau de Bord RSE" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-6">
      <!-- En-tête -->
      <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          Évaluation RSE des Entreprises
        </h1>
        <p class="text-gray-600">
          Découvrez les performances de durabilité des entreprises françaises
        </p>
      </div>

      <!-- Métriques principales -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Entreprises évaluées
                </dt>
                <dd class="text-lg font-medium text-gray-900">
                  {{ props.stats.total_companies.toLocaleString() }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Score moyen
                </dt>
                <dd class="text-lg font-medium text-gray-900">
                  {{ Math.round(props.stats.avg_global_score) }}/100
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-emerald-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Performers (80+)
                </dt>
                <dd class="text-lg font-medium text-gray-900">
                  {{ props.stats.top_performers }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  À améliorer (&lt;60)
                </dt>
                <dd class="text-lg font-medium text-gray-900">
                  {{ props.stats.need_improvement }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Graphiques -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Distribution des scores -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            Distribution des scores RSE
          </h3>
          <div class="h-64">
            <Doughnut :data="scoreDistributionChart" :options="doughnutOptions" />
          </div>
        </div>

        <!-- Performance par secteur -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            Performance moyenne par secteur
          </h3>
          <div class="h-64">
            <Bar :data="sectorPerformanceChart" :options="chartOptions" />
          </div>
        </div>
      </div>

      <!-- Top des entreprises -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">
            Meilleures performances RSE
          </h3>
        </div>
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Entreprise
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Secteur
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Score
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Note
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="company in props.topCompanies" :key="company.id">
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
                  <div class="text-sm text-gray-900">
                    {{ Math.round(company.global_score) }}/100
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="getRatingColor(company.rating_letter)">
                    {{ company.rating_letter }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <a :href="`/rse/company/${company.id}`" class="text-indigo-600 hover:text-indigo-900">
                    Voir détails
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Barre de recherche -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
          Rechercher une entreprise
        </h3>
        <div class="flex space-x-4">
          <div class="flex-1">
            <input
              type="text"
              placeholder="Nom de l'entreprise ou SIREN..."
              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <button class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Rechercher
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
