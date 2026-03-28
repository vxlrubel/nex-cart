<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import userRoutes from '@/routes/admin/users';
import type { User } from '@/types';

defineProps<{
    users: User[];
}>();
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Users</h1>
            <Link
                :href="userRoutes?.create?.() || '#'"
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />
                Add User
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
                            Email
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Role
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Verified
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Joined
                        </th>
                        <th class="px-4 py-3 text-right text-sm font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users || []"
                        :key="user.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3 font-medium">{{ user.name }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ user.email }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded bg-blue-100 px-2 py-1 text-xs text-blue-800"
                            >
                                {{ user.roles?.[0]?.name || 'Customer' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                :class="
                                    user.email_verified_at
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800'
                                "
                                class="rounded px-2 py-1 text-xs"
                            >
                                {{
                                    user.email_verified_at
                                        ? 'Verified'
                                        : 'Pending'
                                }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{
                                new Date(user.created_at).toLocaleDateString(
                                    'en-US',
                                )
                            }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    :href="
                                        user?.id
                                            ? `/admin/users/${user.id}/edit`
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
