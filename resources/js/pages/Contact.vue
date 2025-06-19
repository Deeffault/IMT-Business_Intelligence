<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import {
    BuildingIcon,
    UserIcon,
    MailIcon,
    PhoneIcon,
    TrendingUpIcon,
    CircleDollarSignIcon,
    ClockIcon,
    MessageSquareIcon,
    CheckCircleIcon,
    XCircleIcon,
    ArrowRightIcon,
    StarIcon
} from 'lucide-vue-next';

interface Message {
    type: 'success' | 'error';
    title: string;
    content: string;
}

const props = defineProps<{
    message?: Message;
    error?: Message;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Home', href: '/' },
    { title: 'Contact', href: '#' },
];

const form = useForm({
    company_name: '',
    contact_name: '',
    email: '',
    phone: '',
    company_size: '',
    sector: '',
    current_score: '',
    improvement_goals: '',
    budget_range: '',
    timeline: '',
    message: '',
});

const companySizes = [
    { value: 'micro', label: 'Micro-entreprise (< 10 employés)' },
    { value: 'small', label: 'Petite entreprise (10-49 employés)' },
    { value: 'medium', label: 'Moyenne entreprise (50-249 employés)' },
    { value: 'large', label: 'Grande entreprise (250+ employés)' },
];

const budgetRanges = [
    { value: '5000-15000', label: '5 000€ - 15 000€' },
    { value: '15000-50000', label: '15 000€ - 50 000€' },
    { value: '50000-100000', label: '50 000€ - 100 000€' },
    { value: '100000+', label: '100 000€+' },
];

const timelines = [
    { value: 'immediate', label: 'Immédiat (< 1 mois)' },
    { value: '1-3months', label: '1-3 mois' },
    { value: '3-6months', label: '3-6 mois' },
    { value: '6-12months', label: '6-12 mois' },
];

const showAlert = ref(false);

const alertMessage = computed(() => props.message || props.error);

if (alertMessage.value) {
    showAlert.value = true;
    setTimeout(() => {
        showAlert.value = false;
    }, 5000);
}

const submit = () => {
    form.post(route('contact.store'), {
        onSuccess: () => {
            // Le message de succès sera géré par la redirection
        },
        onError: () => {
            // Les erreurs seront affichées automatiquement
        }
    });
};
</script>

<template>
    <Head title="Contact - Improve Your RSE Score" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Alert message -->
        <div v-if="showAlert && alertMessage" 
             :class="[
                 'fixed top-4 right-4 z-50 max-w-md p-4 rounded-lg shadow-lg transition-all duration-300',
                 alertMessage.type === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'
             ]">
            <div class="flex items-start">
                <CheckCircleIcon v-if="alertMessage.type === 'success'" class="h-5 w-5 text-green-400 mt-0.5 mr-3" />
                <XCircleIcon v-else class="h-5 w-5 text-red-400 mt-0.5 mr-3" />
                <div>
                    <h3 :class="[
                        'text-sm font-medium',
                        alertMessage.type === 'success' ? 'text-green-800' : 'text-red-800'
                    ]">
                        {{ alertMessage.title }}
                    </h3>
                    <p :class="[
                        'mt-1 text-sm',
                        alertMessage.type === 'success' ? 'text-green-700' : 'text-red-700'
                    ]">
                        {{ alertMessage.content }}
                    </p>
                </div>
                <button @click="showAlert = false" 
                        class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 hover:bg-gray-100 focus:ring-2 focus:ring-gray-300">
                    <XCircleIcon class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Améliorez Votre Score RSE
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Contactez nos experts pour développer une stratégie RSE personnalisée et améliorer votre score dans notre plateforme d'évaluation.
                </p>
            </div>

            <!-- Benefits Section -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <div class="text-center p-6 bg-white rounded-lg shadow-sm border">
                    <TrendingUpIcon class="h-12 w-12 text-blue-600 mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Score Amélioré</h3>
                    <p class="text-gray-600">Augmentez votre score RSE grâce à nos stratégies éprouvées</p>
                </div>
                <div class="text-center p-6 bg-white rounded-lg shadow-sm border">
                    <StarIcon class="h-12 w-12 text-yellow-500 mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Visibilité Renforcée</h3>
                    <p class="text-gray-600">Améliorez votre positionnement dans nos classements</p>
                </div>
                <div class="text-center p-6 bg-white rounded-lg shadow-sm border">
                    <ArrowRightIcon class="h-12 w-12 text-green-600 mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Accompagnement Expert</h3>
                    <p class="text-gray-600">Bénéficiez de l'expertise de nos consultants RSE</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-lg border p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Demandez un Devis Personnalisé
                </h2>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Company Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <BuildingIcon class="inline h-4 w-4 mr-1" />
                                Nom de l'entreprise *
                            </label>
                            <input
                                id="company_name"
                                v-model="form.company_name"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.company_name }"
                                placeholder="Nom de votre entreprise"
                            />
                            <p v-if="form.errors.company_name" class="mt-1 text-sm text-red-600">
                                {{ form.errors.company_name }}
                            </p>
                        </div>

                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <UserIcon class="inline h-4 w-4 mr-1" />
                                Nom du contact *
                            </label>
                            <input
                                id="contact_name"
                                v-model="form.contact_name"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.contact_name }"
                                placeholder="Votre nom complet"
                            />
                            <p v-if="form.errors.contact_name" class="mt-1 text-sm text-red-600">
                                {{ form.errors.contact_name }}
                            </p>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <MailIcon class="inline h-4 w-4 mr-1" />
                                Email professionnel *
                            </label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.email }"
                                placeholder="contact@votre-entreprise.com"
                            />
                            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <PhoneIcon class="inline h-4 w-4 mr-1" />
                                Téléphone
                            </label>
                            <input
                                id="phone"
                                v-model="form.phone"
                                type="tel"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.phone }"
                                placeholder="+33 1 23 45 67 89"
                            />
                            <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">
                                {{ form.errors.phone }}
                            </p>
                        </div>
                    </div>

                    <!-- Company Details -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_size" class="block text-sm font-medium text-gray-700 mb-2">
                                Taille de l'entreprise *
                            </label>
                            <select
                                id="company_size"
                                v-model="form.company_size"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.company_size }"
                            >
                                <option value="">Sélectionnez une taille</option>
                                <option v-for="size in companySizes" :key="size.value" :value="size.value">
                                    {{ size.label }}
                                </option>
                            </select>
                            <p v-if="form.errors.company_size" class="mt-1 text-sm text-red-600">
                                {{ form.errors.company_size }}
                            </p>
                        </div>

                        <div>
                            <label for="sector" class="block text-sm font-medium text-gray-700 mb-2">
                                Secteur d'activité *
                            </label>
                            <input
                                id="sector"
                                v-model="form.sector"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.sector }"
                                placeholder="Ex: Technology, Finance, Healthcare..."
                            />
                            <p v-if="form.errors.sector" class="mt-1 text-sm text-red-600">
                                {{ form.errors.sector }}
                            </p>
                        </div>
                    </div>

                    <!-- Current Score -->
                    <div>
                        <label for="current_score" class="block text-sm font-medium text-gray-700 mb-2">
                            <TrendingUpIcon class="inline h-4 w-4 mr-1" />
                            Score RSE actuel (si connu)
                        </label>
                        <input
                            id="current_score"
                            v-model="form.current_score"
                            type="number"
                            min="0"
                            max="100"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            :class="{ 'border-red-500': form.errors.current_score }"
                            placeholder="Ex: 65"
                        />
                        <p class="mt-1 text-sm text-gray-500">
                            Si votre entreprise figure déjà dans notre base de données
                        </p>
                        <p v-if="form.errors.current_score" class="mt-1 text-sm text-red-600">
                            {{ form.errors.current_score }}
                        </p>
                    </div>

                    <!-- Improvement Goals -->
                    <div>
                        <label for="improvement_goals" class="block text-sm font-medium text-gray-700 mb-2">
                            Objectifs d'amélioration *
                        </label>
                        <textarea
                            id="improvement_goals"
                            v-model="form.improvement_goals"
                            rows="4"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            :class="{ 'border-red-500': form.errors.improvement_goals }"
                            placeholder="Décrivez vos objectifs RSE et les domaines que vous souhaitez améliorer (environnement, social, gouvernance, éthique)..."
                        ></textarea>
                        <p v-if="form.errors.improvement_goals" class="mt-1 text-sm text-red-600">
                            {{ form.errors.improvement_goals }}
                        </p>
                    </div>

                    <!-- Budget and Timeline -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="budget_range" class="block text-sm font-medium text-gray-700 mb-2">
                                <CircleDollarSignIcon class="inline h-4 w-4 mr-1" />
                                Budget envisagé *
                            </label>
                            <select
                                id="budget_range"
                                v-model="form.budget_range"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.budget_range }"
                            >
                                <option value="">Sélectionnez un budget</option>
                                <option v-for="budget in budgetRanges" :key="budget.value" :value="budget.value">
                                    {{ budget.label }}
                                </option>
                            </select>
                            <p v-if="form.errors.budget_range" class="mt-1 text-sm text-red-600">
                                {{ form.errors.budget_range }}
                            </p>
                        </div>

                        <div>
                            <label for="timeline" class="block text-sm font-medium text-gray-700 mb-2">
                                <ClockIcon class="inline h-4 w-4 mr-1" />
                                Calendrier souhaité *
                            </label>
                            <select
                                id="timeline"
                                v-model="form.timeline"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.timeline }"
                            >
                                <option value="">Sélectionnez un délai</option>
                                <option v-for="timeline in timelines" :key="timeline.value" :value="timeline.value">
                                    {{ timeline.label }}
                                </option>
                            </select>
                            <p v-if="form.errors.timeline" class="mt-1 text-sm text-red-600">
                                {{ form.errors.timeline }}
                            </p>
                        </div>
                    </div>

                    <!-- Additional Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            <MessageSquareIcon class="inline h-4 w-4 mr-1" />
                            Message complémentaire
                        </label>
                        <textarea
                            id="message"
                            v-model="form.message"
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            :class="{ 'border-red-500': form.errors.message }"
                            placeholder="Informations supplémentaires, questions spécifiques, ou contexte particulier..."
                        ></textarea>
                        <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">
                            {{ form.errors.message }}
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-8 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                        >
                            <span v-if="form.processing">Envoi en cours...</span>
                            <span v-else>Envoyer la demande</span>
                            <ArrowRightIcon v-if="!form.processing" class="ml-2 h-4 w-4" />
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="mt-12 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Besoin d'informations supplémentaires ?
                </h3>
                <p class="text-gray-600 mb-4">
                    Notre équipe est disponible pour répondre à toutes vos questions
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-8">
                    <div class="flex items-center">
                        <MailIcon class="h-4 w-4 text-blue-600 mr-2" />
                        <span class="text-gray-700">contact@rse-platform.com</span>
                    </div>
                    <div class="flex items-center">
                        <PhoneIcon class="h-4 w-4 text-blue-600 mr-2" />
                        <span class="text-gray-700">+33 1 23 45 67 89</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
