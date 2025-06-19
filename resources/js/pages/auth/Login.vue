<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { TrendingUpIcon, Menu, X } from 'lucide-vue-next';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const isMobileMenuOpen = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <Head title="Sign In - EcoScope" />

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
                        <Link
                            :href="route('blog')"
                            class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                        >
                            Blog
                        </Link>
                        <Link
                            :href="route('register')"
                            class="inline-flex items-center rounded-lg border border-transparent bg-gradient-to-r from-emerald-600 to-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200"
                        >
                            Sign Up
                        </Link>
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
                        <Link
                            :href="route('blog')"
                            class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
                            @click="isMobileMenuOpen = false"
                        >
                            Blog
                        </Link>
                        <div class="px-3 py-2">
                            <Link
                                :href="route('register')"
                                class="w-full inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-emerald-600 to-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200"
                                @click="isMobileMenuOpen = false"
                            >
                                Sign Up
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <div class="flex min-h-[calc(100vh-4rem)] items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <!-- Background Elements -->
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-1/2 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-gradient-to-r from-emerald-200/20 to-cyan-200/20 blur-3xl"></div>
                <div class="absolute top-1/3 right-1/4 w-[500px] h-[500px] rounded-full bg-gradient-to-l from-blue-200/15 to-purple-200/15 blur-3xl"></div>
            </div>

            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">
                        Sign in to your account
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Or
                        <Link :href="route('register')" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                            create your free account
                        </Link>
                    </p>
                </div>

                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200/20 p-8">
                    <div v-if="status" class="mb-4 text-sm font-medium text-green-600 bg-green-50 rounded-lg p-3">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email address
                            </label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                autocomplete="email"
                                required
                                class="block w-full rounded-lg border border-gray-300 px-3 py-3 text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 transition-colors duration-200"
                                placeholder="your@email.com"
                            />
                            <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="block w-full rounded-lg border border-gray-300 px-3 py-3 text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 transition-colors duration-200"
                                placeholder="••••••••"
                            />
                            <div v-if="form.errors.password" class="mt-2 text-sm text-red-600">
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember"
                                    v-model="form.remember"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                />
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>

                            <div class="text-sm">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-200"
                                >
                                    Forgot your password?
                                </Link>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-emerald-600 to-cyan-600 hover:from-emerald-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                            >
                                <span v-if="form.processing" class="mr-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                {{ form.processing ? 'Signing in...' : 'Sign in' }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <Link :href="route('register')" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                                Create account
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
