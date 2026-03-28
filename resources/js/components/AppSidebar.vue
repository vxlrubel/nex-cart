<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Box,
    FolderGit2,
    LayoutGrid,
    Package,
    Settings,
    ShoppingCart,
    Star,
    Tag,
    Users,
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import adminRoutes from '@/routes/admin';
const {
    dashboard,
    products,
    categories,
    orders,
    users,
    coupons,
    reviews,
    roles,
    permissions,
} = adminRoutes;
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard.url(),
        icon: LayoutGrid,
    },
    {
        title: 'Products',
        href: products.index.url(),
        icon: Package,
    },
    {
        title: 'Categories',
        href: categories.index.url(),
        icon: Tag,
    },
    {
        title: 'Orders',
        href: orders.index.url(),
        icon: ShoppingCart,
    },
    {
        title: 'Customers',
        href: users.index.url(),
        icon: Users,
    },
    {
        title: 'Coupons',
        href: coupons.index.url(),
        icon: Box,
    },
    {
        title: 'Reviews',
        href: reviews.index.url(),
        icon: Star,
    },
    {
        title: 'Settings',
        items: [
            {
                title: 'Roles',
                href: roles.index.url(),
                icon: Settings,
            },
            {
                title: 'Permissions',
                href: permissions.index.url(),
                icon: Settings,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
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
                        <Link :href="dashboard.url()">
                            <AppLogo />
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
