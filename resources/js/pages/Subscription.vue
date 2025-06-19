<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Check, X, Users, Heart, TreePine, Leaf, Badge } from 'lucide-vue-next';
</script>


<template>

    <Head title="Subscription Plans" />
    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Choose Your Plan</h1>
                    <p class="mt-2 text-gray-600">Select the perfect plan to support sustainable business practices</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Hero Section -->
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Support Sustainable Business Intelligence
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Join our mission to promote corporate social responsibility and environmental sustainability.
                        Choose from our flexible plans designed for individuals who care about our planet.
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    <!-- Free Plan -->
                    <div
                        class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-8 flex flex-col h-full">
                        <div class="flex-grow">
                            <div class="text-center mb-8">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full mb-4">
                                    <Users class="w-8 h-8 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Free Plan</h3>
                                <div class="text-4xl font-bold text-gray-900 mb-2">
                                    €0<span class="text-lg font-normal text-gray-600">/month</span>
                                </div>
                                <p class="text-gray-600">Perfect for getting started</p>
                            </div>

                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Access to basic CSR dashboard</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">View up to 50 companies</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Basic search and filtering</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Community support</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <X class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-500">Contains advertisements</span>
                                </li>
                                <!-- Spacer items to match other cards -->
                                <li class="invisible flex items-start space-x-3">
                                    <span class="w-5 h-5 mt-0.5 flex-shrink-0"></span>
                                    <span></span>
                                </li>
                                <li class="invisible flex items-start space-x-3">
                                    <span class="w-5 h-5 mt-0.5 flex-shrink-0"></span>
                                    <span></span>
                                </li>
                                <li class="invisible flex items-start space-x-3">
                                    <span class="w-5 h-5 mt-0.5 flex-shrink-0"></span>
                                    <span></span>
                                </li>
                            </ul>
                        </div>

                        <button
                            class="w-full py-3 px-6 bg-gray-200 text-gray-800 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                            Current Plan
                        </button>
                    </div>

                    <!-- Supporter Plan -->
                    <div
                        class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border-2 border-emerald-200 p-8 relative flex flex-col h-full">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span
                                class="bg-gradient-to-r from-emerald-500 to-cyan-600 text-white px-6 py-2 rounded-full text-sm font-semibold">
                                Most Popular
                            </span>
                        </div>

                        <div class="flex-grow">
                            <div class="text-center mb-8">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-full mb-4">
                                    <Heart class="w-8 h-8 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Supporter Plan</h3>
                                <div class="text-4xl font-bold text-gray-900 mb-2">
                                    €1<span class="text-lg font-normal text-gray-600">/month</span>
                                </div>
                                <p class="text-gray-600">Support us & unlock premium features</p>
                            </div>

                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Everything in Free Plan</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700"><strong>Ad-free experience</strong></span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Unlimited company access</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Advanced analytics & comparisons</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Export data to CSV/PDF</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Priority email support</span>
                                </li>
                                <!-- Spacer items -->
                                <li class="invisible flex items-start space-x-3">
                                    <span class="w-5 h-5 mt-0.5 flex-shrink-0"></span>
                                    <span></span>
                                </li>
                                <li class="invisible flex items-start space-x-3">
                                    <span class="w-5 h-5 mt-0.5 flex-shrink-0"></span>
                                    <span></span>
                                </li>
                            </ul>
                        </div>

                        <button
                            class="w-full py-3 px-6 bg-gradient-to-r from-emerald-500 to-cyan-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-cyan-700 transition-all transform hover:scale-105">
                            Choose Supporter Plan
                        </button>
                    </div>

                    <!-- Planet Guardian Plan -->
                    <div
                        class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 p-8 flex flex-col h-full">
                        <div class="flex-grow">
                            <div class="text-center mb-8">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-600 to-emerald-700 rounded-full mb-4">
                                    <TreePine class="w-8 h-8 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Planet Guardian</h3>
                                <div class="text-4xl font-bold text-gray-900 mb-2">
                                    €10<span class="text-lg font-normal text-gray-600">/month</span>
                                </div>
                                <p class="text-gray-600">Make a real environmental impact</p>
                            </div>

                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Everything in Supporter Plan</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <TreePine class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700"><strong>Tree planting in Mali (5+
                                            trees/month)</strong></span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Carbon offset certificate</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Quarterly impact reports</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Exclusive sustainability insights</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Support local communities</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Badge class="w-5 h-5 text-purple-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Planet Guardian badge</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <Check class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                                    <span class="text-gray-700">Direct access to our sustainability team</span>
                                </li>
                            </ul>
                        </div>

                        <button
                            class="w-full py-3 px-6 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-emerald-800 transition-all transform hover:scale-105">
                            Become a Planet Guardian
                        </button>
                    </div>
                </div>

                <!-- Features Comparison Table -->
                <div class="mt-20">
                    <h3 class="text-2xl font-bold text-gray-900 text-center mb-12">Feature Comparison</h3>

                    <div
                        class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200/20 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Features
                                        </th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Free</th>
                                        <th
                                            class="px-6 py-4 text-center text-sm font-semibold text-gray-900 bg-emerald-50">
                                            Supporter</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Planet
                                            Guardian
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">CSR Company Database</td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center bg-emerald-50/30">
                                            <Check class="w-5 h-5 text-emerald-500 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">Company Comparison</td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center bg-emerald-50/30">
                                            <Check class="w-5 h-5 text-emerald-500 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">Ad-free Experience</td>
                                        <td class="px-6 py-4 text-center">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center bg-emerald-50/30">
                                            <Check class="w-5 h-5 text-emerald-500 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">Data Export (CSV/PDF)</td>
                                        <td class="px-6 py-4 text-center">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">Premium Analytics</td>
                                        <td class="px-6 py-4 text-center">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center bg-emerald-50/30">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">API Access</td>
                                        <td class="px-6 py-4 text-center">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center bg-emerald-50/30">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Check class="w-5 h-5 text-green-500 mx-auto" />
                                        </td>
                                    </tr>
                                    <tr class="bg-green-50">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">🌳 Tree Planting in
                                            Mali</td>
                                        <td class="px-6 py-4 text-center">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center bg-emerald-50/30">
                                            <X class="w-5 h-5 text-red-400 mx-auto" />
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <TreePine class="w-5 h-5 text-green-600 mx-auto" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Environmental Impact Section -->
                <div class="mt-20 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-12">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-600 to-emerald-700 rounded-full mb-6">
                            <Leaf class="w-10 h-10 text-white" />
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Make a Real Environmental Impact</h3>
                        <p class="text-lg text-gray-700 max-w-3xl mx-auto mb-8">
                            Our Planet Guardian plan directly supports reforestation efforts in Mali, one of the most
                            environmentally challenged regions in Africa. Every subscription contributes to:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-2">5+ Trees</div>
                                <p class="text-gray-700">Planted monthly per subscription</p>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-2">120kg</div>
                                <p class="text-gray-700">CO₂ offset annually</p>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-2">Local</div>
                                <p class="text-gray-700">Communities supported</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="mt-20">
                    <h3 class="text-2xl font-bold text-gray-900 text-center mb-12">Frequently Asked Questions</h3>

                    <div class="max-w-4xl mx-auto space-y-6">
                        <div class="bg-white/80 backdrop-blur-md rounded-xl p-6 border border-gray-200/20">
                            <h4 class="font-semibold text-gray-900 mb-2">Can I change my plan anytime?</h4>
                            <p class="text-gray-600">Yes, you can upgrade or downgrade your plan at any time. Changes
                                take
                                effect immediately, and you'll be charged or credited accordingly.</p>
                        </div>

                        <div class="bg-white/80 backdrop-blur-md rounded-xl p-6 border border-gray-200/20">
                            <h4 class="font-semibold text-gray-900 mb-2">How does the tree planting work?</h4>
                            <p class="text-gray-600">We partner with verified reforestation organizations in Mali. Each
                                month,
                                your subscription funds the planting and care of trees, and you'll receive reports on
                                the
                                environmental impact.</p>
                        </div>

                        <div class="bg-white/80 backdrop-blur-md rounded-xl p-6 border border-gray-200/20">
                            <h4 class="font-semibold text-gray-900 mb-2">Is there a long-term commitment?</h4>
                            <p class="text-gray-600">No, all plans are month-to-month with no long-term contracts. You
                                can
                                cancel anytime through your account settings.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
