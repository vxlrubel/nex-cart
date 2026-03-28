<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow-sm">
            <nav
                class="container mx-auto flex items-center justify-between px-4 py-4"
            >
                <Link href="/" class="text-2xl font-bold text-indigo-600"
                    >NexCart Admin</Link
                >
                <div class="flex items-center gap-6">
                    <Link
                        href="/admin/dashboard"
                        class="text-gray-700 hover:text-indigo-600"
                        >Dashboard</Link
                    >
                    <Link
                        href="/admin/users"
                        class="text-gray-700 hover:text-indigo-600"
                        >Users</Link
                    >
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Users</h1>
                <Link
                    href="/admin/users/create"
                    class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                >
                    Add User
                </Link>
            </div>

            <div class="mb-6 rounded-lg bg-white p-4 shadow">
                <form @submit.prevent="search" class="flex gap-4">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search users..."
                        class="flex-1 rounded border px-3 py-2"
                    />
                    <button
                        type="submit"
                        class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                    >
                        Search
                    </button>
                </form>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Roles</th>
                            <th class="px-4 py-3 text-left">Joined</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="border-t"
                        >
                            <td class="px-4 py-3">{{ user.id }}</td>
                            <td class="px-4 py-3">{{ user.name }}</td>
                            <td class="px-4 py-3">{{ user.email }}</td>
                            <td class="px-4 py-3">
                                <span
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    class="mr-1 inline-block rounded bg-gray-100 px-2 py-1 text-sm"
                                >
                                    {{ role.name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ user.created_at }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <Link
                                        :href="`/admin/users/${user.id}/edit`"
                                        class="text-indigo-600 hover:text-indigo-800"
                                        >Edit</Link
                                    >
                                    <button
                                        @click="deleteUser(user.id)"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-4">
                    <Pagination :links="users.links" />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    filters: Object,
});

const searchQuery = ref(props.filters.search || '');

const search = () => {
    router.get('/admin/users', { search: searchQuery.value });
};

const deleteUser = async (id) => {
    if (confirm('Are you sure you want to delete this user?')) {
        try {
            await router.delete(`/admin/users/${id}`);
        } catch (error) {
            alert('Failed to delete user');
        }
    }
};
</script>
