<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { ChevronUpIcon, ChevronDownIcon } from 'lucide-vue-next';

interface Company {
  id: number;
  name: string;
  sector: string;
  size?: string;
  country?: string;
  website?: string;
  display_rank?: number;
  rseScore?: {
    global_score: number | null;
    rating_letter: string | null;
    environmental_score?: number | null;
    social_score?: number | null;
    governance_score?: number | null;
    ethics_score?: number | null;
  };
}

const props = defineProps<{
  companies: {
    data: Company[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  },
  sectors: string[],
  filters: {
    name?: string;
    sector?: string;
    min_score?: number;
    max_score?: number;
    sort?: string;
    order?: string;
  }
}>();

const search = ref(props.filters.name || '');
const selectedSector = ref(props.filters.sector || '');
const minScore = ref(props.filters.min_score || '');
const maxScore = ref(props.filters.max_score || '');
const sortBy = ref(props.filters.sort || 'display_rank');
const sortOrder = ref(props.filters.order || 'asc');
const page = ref(props.companies.current_page);

watch([search, selectedSector, minScore, maxScore], () => {
  page.value = 1;
  fetchCompanies();
});

watch(page, () => {
  fetchCompanies();
});

function fetchCompanies() {
  const params: any = {
    page: page.value,
    sort: sortBy.value,
    order: sortOrder.value,
  };

  if (search.value) params.name = search.value;
  if (selectedSector.value) params.sector = selectedSector.value;
  if (minScore.value) params.min_score = minScore.value;
  if (maxScore.value) params.max_score = maxScore.value;

  router.get('/rse/companies', params, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
}

function handleSort(column: string) {
  if (sortBy.value === column) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortBy.value = column;
    sortOrder.value = column === 'display_rank' ? 'asc' : 'desc';
  }
  page.value = 1;
  fetchCompanies();
}

function goToPage(p: number) {
  page.value = p;
}

function resetFilters() {
  search.value = '';
  selectedSector.value = '';
  minScore.value = '';
  maxScore.value = '';
  sortBy.value = 'display_rank';
  sortOrder.value = 'asc';
  page.value = 1;
  fetchCompanies();
}

function goToCompanyDetail(companyId: number) {
  router.get(`/rse/company/${companyId}`);
}

const getSortIcon = (column: string) => {
  if (sortBy.value !== column) return null;
  return sortOrder.value === 'asc' ? ChevronUpIcon : ChevronDownIcon;
};

// Style for rating color (same as dashboard)
const getRatingColor = (letter: string) => {
  const colors: Record<string, string> = {
    'A+': 'text-emerald-700 bg-emerald-100 border-emerald-200',
    'A': 'text-emerald-600 bg-emerald-50 border-emerald-200',
    'B': 'text-cyan-600 bg-cyan-50 border-cyan-200',
    'C': 'text-yellow-600 bg-yellow-50 border-yellow-200',
    'D': 'text-orange-600 bg-orange-50 border-orange-200',
    'E': 'text-red-700 bg-red-100 border-red-200',
  };
  return colors[letter] || 'text-gray-600 bg-gray-50 border-gray-200';
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
</script>

<template>

  <Head title="All Companies - CSR Dashboard" />
  <AppLayout>
    <div class="space-y-8">
      <!-- Enhanced Header with Advanced Filters -->
      <div
        class="px-8 py-6 bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-2xl shadow-lg border border-gray-200/20">
        <h1 class="text-2xl font-bold mb-6">All Companies</h1>

        <!-- Filters Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
          <!-- Search by name -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search by name</label>
            <input v-model="search" type="text" placeholder="Company name..."
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
          </div>

          <!-- Sector filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
            <select v-model="selectedSector"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
              <option value="">All sectors</option>
              <option v-for="sector in props.sectors" :key="sector" :value="sector">
                {{ sector }}
              </option>
            </select>
          </div>

          <!-- Min Score -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Min Score</label>
            <input v-model="minScore" type="number" min="0" max="100" placeholder="0"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
          </div>

          <!-- Max Score -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Max Score</label>
            <input v-model="maxScore" type="number" min="0" max="100" placeholder="100"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
          </div>
        </div>

        <!-- Reset filters button -->
        <div class="flex justify-end">
          <button @click="resetFilters"
            class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            Reset Filters
          </button>
        </div>
      </div>

      <!-- Enhanced Table -->
      <div class="overflow-x-auto bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20">
        <table class="min-w-full divide-y divide-gray-200/50">
          <thead>
            <tr>
              <!-- Rank Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <button @click="handleSort('display_rank')"
                  class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                  Rank
                  <component :is="getSortIcon('display_rank')" v-if="getSortIcon('display_rank')" class="w-4 h-4" />
                </button>
              </th>

              <!-- Name Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <button @click="handleSort('name')"
                  class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                  Name
                  <component :is="getSortIcon('name')" v-if="getSortIcon('name')" class="w-4 h-4" />
                </button>
              </th>

              <!-- Sector Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <button @click="handleSort('sector')"
                  class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                  Sector
                  <component :is="getSortIcon('sector')" v-if="getSortIcon('sector')" class="w-4 h-4" />
                </button>
              </th>

              <!-- Size Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>

              <!-- Global Score Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <button @click="handleSort('global_score')"
                  class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                  Global Score
                  <component :is="getSortIcon('global_score')" v-if="getSortIcon('global_score')" class="w-4 h-4" />
                </button>
              </th>

              <!-- Rating Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <button @click="handleSort('rating_letter')"
                  class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                  Rating
                  <component :is="getSortIcon('rating_letter')" v-if="getSortIcon('rating_letter')" class="w-4 h-4" />
                </button>
              </th>

              <!-- Country Column -->
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200/50">
            <tr v-for="company in props.companies.data" :key="company.id"
              class="hover:bg-gray-50/50 transition-colors cursor-pointer" @click="goToCompanyDetail(company.id)">
              <!-- Rank -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="text-lg font-bold text-gray-900">
                    {{ company.display_rank ?? '-' }}
                  </div>
                </div>
              </td>

              <!-- Name -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ company.name }}</div>
                <div v-if="company.website" class="text-xs text-gray-500">
                  <a :href="company.website" target="_blank" class="hover:text-emerald-600 transition-colors">
                    {{ company.website }}
                  </a>
                </div>
              </td>

              <!-- Sector -->
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  {{ company.sector || 'N/A' }}
                </span>
              </td>

              <!-- Size -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ company.size || 'N/A' }}
              </td>

              <!-- Global Score -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div v-if="company.rseScore?.global_score !== null && company.rseScore?.global_score !== undefined">
                  <div class="text-sm font-medium mb-1" :class="getScoreTextColor(company.rseScore.global_score)">
                    {{ Math.round(company.rseScore.global_score) }}/100
                  </div>
                  <div class="w-20 bg-gray-200 rounded-full h-2">
                    <div
                      class="bg-gradient-to-r h-2 rounded-full transition-all duration-500"
                      :class="getScoreColor(company.rseScore.global_score)"
                      :style="`width: ${company.rseScore.global_score}%`"></div>
                  </div>
                </div>
                <div v-else class="text-sm text-gray-500">-</div>
              </td>

              <!-- Rating -->
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="company.rseScore?.rating_letter"
                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border"
                  :class="getRatingColor(company.rseScore.rating_letter)">
                  {{ company.rseScore.rating_letter }}
                </span>
                <span v-else class="text-sm text-gray-500">-</span>
              </td>

              <!-- Country -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ company.country || 'N/A' }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Enhanced Pagination -->
      <div class="flex items-center justify-between mt-6">
        <div class="flex items-center text-sm text-gray-500">
          Showing {{ (props.companies.current_page - 1) * props.companies.per_page + 1 }} to
          {{ Math.min(props.companies.current_page * props.companies.per_page, props.companies.total) }} of
          {{ props.companies.total }} companies
        </div>

        <div class="flex items-center gap-2">
          <button v-for="p in props.companies.last_page" :key="p" @click="goToPage(p)" :class="[
            'px-3 py-2 rounded-lg text-sm font-medium transition-colors',
            p === props.companies.current_page
              ? 'bg-emerald-600 text-white shadow-md'
              : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
          ]">
            {{ p }}
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
