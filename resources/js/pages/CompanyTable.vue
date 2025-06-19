<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';

interface Company {
  id: number;
  name: string;
  sector: string;
  display_rank?: number;
  rseScore?: {
    global_score: number|null;
    rating_letter: string|null;
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
  filters: {
    name?: string;
    has_score?: boolean;
  }
}>();

const search = ref(props.filters.name || '');
const hasScore = ref(props.filters.has_score ?? false);
const page = ref(props.companies.current_page);

watch([search, hasScore], () => {
  page.value = 1;
  fetchCompanies();
});

watch(page, () => {
  fetchCompanies();
});

function fetchCompanies() {
  router.get('/rse/companies', {
    name: search.value,
    has_score: hasScore.value ? 1 : 0,
    page: page.value,
  }, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
}

function goToPage(p: number) {
  page.value = p;
}

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
</script>

<template>
  <Head title="All Companies - CSR Dashboard" />
  <AppLayout>
    <div class="space-y-8">
      <div class="px-8 py-6 border-b border-gray-200/50 bg-gradient-to-r from-emerald-50 to-cyan-50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold">All Companies</h1>
        <div class="flex gap-2">
          <input v-model="search" type="text" placeholder="Search by name..." class="border rounded px-3 py-2" />
          <label class="inline-flex items-center gap-1">
            <input type="checkbox" v-model="hasScore" />
            With score only
          </label>
        </div>
      </div>
      <div class="overflow-x-auto bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20">
        <table class="min-w-full divide-y divide-gray-200/50">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Global Score</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200/50">
            <tr v-for="company in props.companies.data" :key="company.id">
              <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-700">{{ company.display_rank ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ company.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ company.sector }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 mb-1">
                  {{ company.rseScore?.global_score !== null && company.rseScore?.global_score !== undefined ? Math.round(company.rseScore.global_score) + '/100' : '-' }}
                </div>
                <div v-if="company.rseScore?.global_score !== null && company.rseScore?.global_score !== undefined" class="w-20 bg-gray-200 rounded-full h-2">
                  <div 
                    class="bg-gradient-to-r from-emerald-500 to-cyan-500 h-2 rounded-full transition-all duration-500"
                    :style="`width: ${company.rseScore.global_score}%`"
                  ></div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  v-if="company.rseScore?.rating_letter"
                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border"
                  :class="getRatingColor(company.rseScore.rating_letter)"
                >
                  {{ company.rseScore.rating_letter }}
                </span>
                <span v-else>-</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center gap-2 mt-4">
        <button v-for="p in props.companies.last_page" :key="p" @click="goToPage(p)" :class="['px-3 py-1 rounded', p === props.companies.current_page ? 'bg-emerald-600 text-white' : 'bg-gray-100']">
          {{ p }}
        </button>
      </div>
    </div>
  </AppLayout>
</template>
