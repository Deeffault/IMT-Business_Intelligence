<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import {
    BookOpenIcon,
    LeafIcon,
    HeartIcon,
    ShieldIcon,
    ScaleIcon,
    BarChart3Icon,
    DatabaseIcon,
    SearchIcon,
    CheckCircleIcon,
    AlertTriangleIcon,
    InfoIcon,
    TrendingUpIcon,
    FileTextIcon,
    GlobeIcon,
    BuildingIcon,
    UsersIcon,
    AwardIcon,
    TargetIcon,
    PieChartIcon,
    LayersIcon,
    ZapIcon,
    RecycleIcon,
    Users2Icon,
    BriefcaseIcon,
    EyeIcon
} from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Home', href: '/' },
    { title: 'CSR Documentation', href: '#' },
];

const scoringCategories = [
    {
        name: 'Environmental',
        icon: LeafIcon,
        color: 'emerald',
        weight: 30,
        description: 'Environmental impact and sustainability practices',
        subcategories: [
            { name: 'Carbon Emissions', weight: 35, description: 'CO2 footprint and reduction initiatives' },
            { name: 'Energy Efficiency', weight: 25, description: 'Renewable energy usage and efficiency measures' },
            { name: 'Waste Management', weight: 20, description: 'Waste reduction, recycling, and circular economy' },
            { name: 'Water Conservation', weight: 15, description: 'Water usage optimization and conservation' },
            { name: 'Biodiversity Impact', weight: 5, description: 'Impact on ecosystems and biodiversity protection' }
        ]
    },
    {
        name: 'Social',
        icon: HeartIcon,
        color: 'cyan',
        weight: 25,
        description: 'Social responsibility and human rights practices',
        subcategories: [
            { name: 'Employee Wellbeing', weight: 30, description: 'Working conditions, health & safety, work-life balance' },
            { name: 'Diversity & Inclusion', weight: 25, description: 'Gender equality, ethnic diversity, inclusive practices' },
            { name: 'Community Engagement', weight: 20, description: 'Local community support and development programs' },
            { name: 'Human Rights', weight: 15, description: 'Human rights compliance and protection measures' },
            { name: 'Training & Development', weight: 10, description: 'Employee skill development and career advancement' }
        ]
    },
    {
        name: 'Governance',
        icon: ShieldIcon,
        color: 'blue',
        weight: 25,
        description: 'Corporate governance and management practices',
        subcategories: [
            { name: 'Board Independence', weight: 25, description: 'Independent directors and board composition' },
            { name: 'Executive Compensation', weight: 20, description: 'Fair and transparent compensation policies' },
            { name: 'Risk Management', weight: 20, description: 'Risk assessment and mitigation strategies' },
            { name: 'Stakeholder Engagement', weight: 20, description: 'Communication with investors and stakeholders' },
            { name: 'Data Privacy', weight: 15, description: 'Data protection and privacy compliance' }
        ]
    },
    {
        name: 'Ethics',
        icon: ScaleIcon,
        color: 'purple',
        weight: 20,
        description: 'Business ethics and compliance standards',
        subcategories: [
            { name: 'Anti-Corruption', weight: 30, description: 'Anti-bribery and corruption prevention measures' },
            { name: 'Supply Chain Ethics', weight: 25, description: 'Ethical sourcing and supplier standards' },
            { name: 'Transparency', weight: 20, description: 'Financial transparency and disclosure practices' },
            { name: 'Fair Competition', weight: 15, description: 'Compliance with competition and antitrust laws' },
            { name: 'Tax Responsibility', weight: 10, description: 'Responsible tax practices and compliance' }
        ]
    }
];

const dataSources = [
    {
        name: 'Corporate Reports',
        icon: FileTextIcon,
        description: 'Annual reports, sustainability reports, and ESG disclosures',
        frequency: 'Annual',
        reliability: 95
    },
    {
        name: 'Public Databases',
        icon: DatabaseIcon,
        description: 'Government databases, regulatory filings, and official records',
        frequency: 'Quarterly',
        reliability: 90
    },
    {
        name: 'Third-party Assessments',
        icon: AwardIcon,
        description: 'Independent audits, certifications, and rating agencies',
        frequency: 'Variable',
        reliability: 85
    },
    {
        name: 'News & Media',
        icon: GlobeIcon,
        description: 'News articles, press releases, and media coverage',
        frequency: 'Daily',
        reliability: 70
    },
    {
        name: 'Stakeholder Feedback',
        icon: Users2Icon,
        description: 'Employee reviews, customer feedback, and community reports',
        frequency: 'Continuous',
        reliability: 65
    }
];

const ratingScale = [
    { letter: 'A+', range: '90-100', color: 'emerald', description: 'Outstanding CSR performance with industry-leading practices' },
    { letter: 'A', range: '80-89', color: 'emerald', description: 'Excellent CSR performance with strong sustainability initiatives' },
    { letter: 'B', range: '70-79', color: 'cyan', description: 'Good CSR performance with solid environmental and social practices' },
    { letter: 'C', range: '60-69', color: 'yellow', description: 'Average CSR performance with room for improvement' },
    { letter: 'D', range: '50-59', color: 'orange', description: 'Below average CSR performance requiring significant improvements' },
    { letter: 'E', range: '0-49', color: 'red', description: 'Poor CSR performance with major sustainability concerns' }
];

const methodologySteps = [
    {
        step: 1,
        title: 'Data Collection',
        icon: SearchIcon,
        description: 'Automated gathering of data from multiple verified sources including corporate reports, regulatory filings, and third-party assessments.',
        details: [
            'Web scraping of official corporate websites',
            'API integration with regulatory databases',
            'Manual verification of critical data points',
            'Real-time monitoring of news and media coverage'
        ]
    },
    {
        step: 2,
        title: 'Data Validation',
        icon: CheckCircleIcon,
        description: 'Multi-layer validation process to ensure data accuracy and reliability before scoring.',
        details: [
            'Cross-referencing multiple data sources',
            'Automated anomaly detection',
            'Expert review of controversial or inconsistent data',
            'Source credibility assessment and weighting'
        ]
    },
    {
        step: 3,
        title: 'Scoring Algorithm',
        icon: BarChart3Icon,
        description: 'Advanced algorithm that weights different CSR categories based on industry standards and best practices.',
        details: [
            'Weighted scoring across four main categories',
            'Industry-specific adjustments and benchmarks',
            'Time-decay for outdated information',
            'Peer comparison and relative scoring'
        ]
    },
    {
        step: 4,
        title: 'Quality Assurance',
        icon: ShieldIcon,
        description: 'Final review and quality control to ensure score accuracy and consistency.',
        details: [
            'Statistical analysis for outlier detection',
            'Historical trend analysis for consistency',
            'Expert panel review for high-profile companies',
            'Continuous monitoring and score updates'
        ]
    }
];
</script>

<template>
    <Head title="CSR Documentation - Methodology & Scoring" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-6xl mx-auto space-y-12">
            <!-- Header Section -->
            <div class="text-center">
                <div class="h-16 w-16 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <BookOpenIcon class="h-8 w-8 text-white" />
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    CSR Assessment Documentation
                </h1>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Comprehensive guide to our Corporate Social Responsibility assessment methodology, 
                    scoring system, and data collection processes.
                </p>
            </div>

            <!-- Overview Section -->
            <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-2xl p-8 border border-emerald-200">
                <div class="flex items-center space-x-3 mb-6">
                    <InfoIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Assessment Overview</h2>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-600 mb-2">4</div>
                        <p class="text-sm text-gray-600">Main Categories</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-cyan-600 mb-2">19</div>
                        <p class="text-sm text-gray-600">Subcategories</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-600 mb-2">100+</div>
                        <p class="text-sm text-gray-600">Data Points</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-cyan-600 mb-2">24/7</div>
                        <p class="text-sm text-gray-600">Monitoring</p>
                    </div>
                </div>
            </div>

            <!-- Scoring Categories -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center space-x-3 mb-8">
                    <LayersIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Scoring Categories</h2>
                </div>

                <div class="space-y-8">
                    <div v-for="category in scoringCategories" :key="category.name" 
                         class="border border-gray-200 rounded-xl p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div :class="`h-12 w-12 bg-${category.color}-100 rounded-xl flex items-center justify-center border border-${category.color}-200`">
                                    <component :is="category.icon" :class="`h-6 w-6 text-${category.color}-600`" />
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ category.name }}</h3>
                                    <p class="text-gray-600">{{ category.description }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div :class="`text-2xl font-bold text-${category.color}-600`">{{ category.weight }}%</div>
                                <p class="text-sm text-gray-500">Weight</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900 mb-3">Subcategories:</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div v-for="sub in category.subcategories" :key="sub.name" 
                                     class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ sub.name }}</div>
                                        <div class="text-sm text-gray-600">{{ sub.description }}</div>
                                    </div>
                                    <div :class="`text-sm font-medium text-${category.color}-600`">
                                        {{ sub.weight }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating Scale -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <TrendingUpIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Rating Scale</h2>
                </div>

                <div class="grid gap-4">
                    <div v-for="rating in ratingScale" :key="rating.letter" 
                         class="flex items-center justify-between p-4 rounded-xl border-2"
                         :class="{
                             'bg-emerald-50 border-emerald-200': rating.color === 'emerald',
                             'bg-cyan-50 border-cyan-200': rating.color === 'cyan',
                             'bg-yellow-50 border-yellow-200': rating.color === 'yellow',
                             'bg-orange-50 border-orange-200': rating.color === 'orange',
                             'bg-red-50 border-red-200': rating.color === 'red'
                         }">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center justify-center w-12 h-12 rounded-xl font-bold text-lg border-2"
                                 :class="{
                                     'bg-emerald-100 border-emerald-300 text-emerald-700': rating.color === 'emerald',
                                     'bg-cyan-100 border-cyan-300 text-cyan-700': rating.color === 'cyan',
                                     'bg-yellow-100 border-yellow-300 text-yellow-700': rating.color === 'yellow',
                                     'bg-orange-100 border-orange-300 text-orange-700': rating.color === 'orange',
                                     'bg-red-100 border-red-300 text-red-700': rating.color === 'red'
                                 }">
                                {{ rating.letter }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Score Range: {{ rating.range }}</div>
                                <div class="text-gray-600">{{ rating.description }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Sources -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <DatabaseIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Data Sources</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="source in dataSources" :key="source.name" 
                         class="p-6 border border-gray-200 rounded-xl hover:border-emerald-300 transition-colors">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-10 w-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <component :is="source.icon" class="h-5 w-5 text-emerald-600" />
                            </div>
                            <h3 class="font-semibold text-gray-900">{{ source.name }}</h3>
                        </div>
                        <p class="text-gray-600 mb-4">{{ source.description }}</p>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Update Frequency:</span>
                                <span class="font-medium text-gray-900">{{ source.frequency }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Reliability:</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-16 bg-gray-200 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300" 
                                             :style="`width: ${source.reliability}%`"></div>
                                    </div>
                                    <span class="font-medium text-emerald-600">{{ source.reliability }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Methodology -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <TargetIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Assessment Methodology</h2>
                </div>

                <div class="space-y-8">
                    <div v-for="step in methodologySteps" :key="step.step" class="flex space-x-6">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-xl flex items-center justify-center text-white font-bold">
                                {{ step.step }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <component :is="step.icon" class="h-5 w-5 text-emerald-600" />
                                <h3 class="text-xl font-semibold text-gray-900">{{ step.title }}</h3>
                            </div>
                            <p class="text-gray-600 mb-4">{{ step.description }}</p>
                            <ul class="space-y-2">
                                <li v-for="detail in step.details" :key="detail" 
                                    class="flex items-start space-x-2 text-sm text-gray-600">
                                    <CheckCircleIcon class="h-4 w-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                                    <span>{{ detail }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <PieChartIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Key Performance Indicators</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 bg-emerald-50 rounded-xl border border-emerald-200">
                        <div class="flex items-center space-x-3 mb-3">
                            <ZapIcon class="h-6 w-6 text-emerald-600" />
                            <h3 class="font-semibold text-gray-900">Carbon Neutrality</h3>
                        </div>
                        <p class="text-sm text-gray-600">Progress towards net-zero emissions and renewable energy adoption</p>
                    </div>

                    <div class="p-6 bg-cyan-50 rounded-xl border border-cyan-200">
                        <div class="flex items-center space-x-3 mb-3">
                            <Users2Icon class="h-6 w-6 text-cyan-600" />
                            <h3 class="font-semibold text-gray-900">Employee Satisfaction</h3>
                        </div>
                        <p class="text-sm text-gray-600">Workplace conditions, benefits, and employee wellbeing metrics</p>
                    </div>

                    <div class="p-6 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-center space-x-3 mb-3">
                            <BriefcaseIcon class="h-6 w-6 text-blue-600" />
                            <h3 class="font-semibold text-gray-900">Supply Chain Ethics</h3>
                        </div>
                        <p class="text-sm text-gray-600">Ethical sourcing, supplier compliance, and fair trade practices</p>
                    </div>

                    <div class="p-6 bg-purple-50 rounded-xl border border-purple-200">
                        <div class="flex items-center space-x-3 mb-3">
                            <EyeIcon class="h-6 w-6 text-purple-600" />
                            <h3 class="font-semibold text-gray-900">Transparency Index</h3>
                        </div>
                        <p class="text-sm text-gray-600">Public disclosure, reporting quality, and stakeholder communication</p>
                    </div>
                </div>
            </div>

            <!-- Updates & Frequency -->
            <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-2xl p-8 border border-emerald-200">
                <div class="flex items-center space-x-3 mb-6">
                    <AlertTriangleIcon class="h-6 w-6 text-emerald-600" />
                    <h2 class="text-2xl font-bold text-gray-900">Data Updates & Accuracy</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="h-16 w-16 bg-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <SearchIcon class="h-8 w-8 text-white" />
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Real-time Monitoring</h3>
                        <p class="text-sm text-gray-600">Continuous monitoring of news, reports, and regulatory changes affecting CSR scores</p>
                    </div>

                    <div class="text-center">
                        <div class="h-16 w-16 bg-cyan-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <CheckCircleIcon class="h-8 w-8 text-white" />
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Quality Assurance</h3>
                        <p class="text-sm text-gray-600">Multi-layer validation process ensuring data accuracy and reliability</p>
                    </div>

                    <div class="text-center">
                        <div class="h-16 w-16 bg-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <TrendingUpIcon class="h-8 w-8 text-white" />
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Regular Updates</h3>
                        <p class="text-sm text-gray-600">Quarterly comprehensive reviews and monthly incremental updates</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="text-center bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">
                    Questions About Our Methodology?
                </h3>
                <p class="text-gray-600 mb-6">
                    Our team of CSR experts is available to provide detailed explanations and clarifications
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="mailto:methodology@csr-platform.com" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-cyan-600 text-white font-medium rounded-lg hover:from-emerald-700 hover:to-cyan-700 transition-colors">
                        <BookOpenIcon class="h-5 w-5 mr-2" />
                        Contact Methodology Team
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
