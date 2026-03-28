<script setup lang="ts">
import { Plus, Trash2, Key } from 'lucide-vue-next';

defineProps<{
    permissions: Record<
        string,
        Array<{
            id: number;
            name: string;
            slug: string;
            description: string;
            roles_count: number;
        }>
    >;
}>();
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Permissions</h1>
            <button
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />
                Add Permission
            </button>
        </div>

        <div v-if="permissions">
            <div
                v-for="(perms, group) in permissions"
                :key="group"
                class="mb-6"
            >
                <h2 class="mb-2 text-lg font-semibold capitalize">
                    {{ group }}
                </h2>
                <div class="rounded-lg border bg-card shadow-sm">
                    <table class="w-full">
                        <thead class="bg-muted/50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Name
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Slug
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Description
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Roles
                                </th>
                                <th
                                    class="px-4 py-3 text-right text-sm font-medium"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="permission in perms"
                                :key="permission.id"
                                class="border-t"
                            >
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <Key
                                            class="h-4 w-4 text-muted-foreground"
                                        />
                                        <span class="font-medium">{{
                                            permission.name
                                        }}</span>
                                    </div>
                                </td>
                                <td
                                    class="px-4 py-3 font-mono text-muted-foreground"
                                >
                                    {{ permission.slug }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ permission.description }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="rounded bg-purple-100 px-2 py-1 text-xs text-purple-800"
                                    >
                                        {{ permission.roles_count }} roles
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <button
                                            v-if="
                                                ![
                                                    'dashboard.view',
                                                    'product.view',
                                                    'category.view',
                                                    'order.view',
                                                    'coupon.view',
                                                    'customer.view',
                                                    'review.view',
                                                    'role.view',
                                                    'permission.manage',
                                                ].includes(permission.slug)
                                            "
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
        </div>
    </div>
</template>
