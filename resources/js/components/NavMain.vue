<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();

const hasSubItems = (item: NavItem) => item.items && item.items.length > 0;
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                <SidebarMenuItem v-if="!hasSubItems(item)">
                    <SidebarMenuButton
                        as-child
                        :is-active="isCurrentUrl(item.href)"
                        :tooltip="item.title"
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>

                <SidebarMenuItem v-else>
                    <SidebarMenuButton as-child :tooltip="item.title">
                        <button class="flex w-full items-center">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }}</span>
                            <ChevronDown class="ml-auto h-4 w-4" />
                        </button>
                    </SidebarMenuButton>
                    <SidebarMenuSub v-if="item.items">
                        <SidebarMenuSubItem
                            v-for="subItem in item.items"
                            :key="subItem.title"
                        >
                            <SidebarMenuSubButton
                                as-child
                                :is-active="isCurrentUrl(subItem.href)"
                            >
                                <Link :href="subItem.href">
                                    <component
                                        :is="subItem.icon"
                                        v-if="subItem.icon"
                                    />
                                    <span>{{ subItem.title }}</span>
                                </Link>
                            </SidebarMenuSubButton>
                        </SidebarMenuSubItem>
                    </SidebarMenuSub>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
