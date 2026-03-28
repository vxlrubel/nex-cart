<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import categoryRoutes from '@/routes/admin/categories';
import type { Category } from '@/types';

defineProps<{
    categories: Category[];
}>();
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Categories</h1>
            <Link
                :href="categoryRoutes?.create?.() || '#'"
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />
                Add Category
            </Link>
        </div>

        <div class="rounded-lg border bg-card shadow-sm">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Name
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Slug
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Parent
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Order
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Status
                        </th>
                        <th class="px-4 py-3 text-right text-sm font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="category in categories || []"
                        :key="category.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3 font-medium">
                            {{ category.name }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ category.slug }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ category.parent_id ? 'Has Parent' : '-' }}
                        </td>
                        <td class="px-4 py-3">{{ category.order }}</td>
                        <td class="px-4 py-3">
                            <span
                                :class="
                                    category.is_active
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800'
                                "
                                class="rounded px-2 py-1 text-xs"
                            >
                                {{ category.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    :href="
                                        category?.id
                                            ? `/admin/categories/${category.id}/edit`
                                            : '#'
                                    "
                                    class="rounded p-1 hover:bg-muted"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Link>
                                <button
                                    class="rounded p-1 text-red-600 hover:bg-red-50"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
