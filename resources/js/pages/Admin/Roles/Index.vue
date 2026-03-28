<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, Shield } from 'lucide-vue-next';
import roleRoutes from '@/routes/admin/roles';

defineProps<{
    roles: Array<{
        id: number;
        name: string;
        slug: string;
        description: string;
        permissions_count: number;
        users_count: number;
    }>;
}>();
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Roles</h1>
            <Link
                :href="roleRoutes?.create?.() || '#'"
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />
                Add Role
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
                            Description
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Permissions
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Users
                        </th>
                        <th class="px-4 py-3 text-right text-sm font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="role in roles || []"
                        :key="role.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <Shield class="h-4 w-4 text-muted-foreground" />
                                <span class="font-medium">{{ role.name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-mono text-muted-foreground">
                            {{ role.slug }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ role.description }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded bg-blue-100 px-2 py-1 text-xs text-blue-800"
                            >
                                {{ role.permissions_count }} permissions
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded bg-purple-100 px-2 py-1 text-xs text-purple-800"
                            >
                                {{ role.users_count }} users
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    :href="
                                        role?.id
                                            ? `/admin/roles/${role.id}/edit`
                                            : '#'
                                    "
                                    class="rounded p-1 hover:bg-muted"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Link>
                                <button
                                    v-if="role.slug !== 'admin'"
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
