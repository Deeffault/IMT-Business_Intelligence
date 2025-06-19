<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, LayoutGrid, Newspaper, TrendingUpIcon } from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
    {
        title: 'CSR Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'CSR Blog',
        href: '/blog',
        icon: Newspaper,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'EcoScope Repository',
        href: 'https://github.com/Deeffault/IMT-Business_Intelligence',
        icon: BookOpen,
    },
    {
        title: 'CSR Documentation',
        href: 'https://csrd.efrag.org/',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-lg flex items-center justify-center">
                                <TrendingUpIcon class="h-5 w-5 text-white" />
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">
                                EcoScope
                            </span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
