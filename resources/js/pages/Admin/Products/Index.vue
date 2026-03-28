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
                        href="/admin/products"
                        class="text-gray-700 hover:text-indigo-600"
                        >Products</Link
                    >
                    <Link
                        href="/admin/orders"
                        class="text-gray-700 hover:text-indigo-600"
                        >Orders</Link
                    >
                    <Link
                        href="/admin/categories"
                        class="text-gray-700 hover:text-indigo-600"
                        >Categories</Link
                    >
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Products</h1>
                <Link
                    href="/admin/products/create"
                    class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                >
                    Add Product
                </Link>
            </div>

            <div class="mb-6 rounded-lg bg-white p-4 shadow">
                <form @submit.prevent="search" class="flex gap-4">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search products..."
                        class="flex-1 rounded border px-3 py-2"
                    />
                    <select
                        v-model="categoryFilter"
                        class="rounded border px-3 py-2"
                    >
                        <option value="">All Categories</option>
                        <option
                            v-for="cat in categories"
                            :key="cat.id"
                            :value="cat.id"
                        >
                            {{ cat.name }}
                        </option>
                    </select>
                    <select
                        v-model="statusFilter"
                        class="rounded border px-3 py-2"
                    >
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <button
                        type="submit"
                        class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                    >
                        Filter
                    </button>
                </form>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Category</th>
                            <th class="px-4 py-3 text-left">Price</th>
                            <th class="px-4 py-3 text-left">Stock</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in products.data"
                            :key="product.id"
                            class="border-t"
                        >
                            <td class="px-4 py-3">{{ product.id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img
                                        :src="
                                            product.image || '/placeholder.jpg'
                                        "
                                        class="h-12 w-12 rounded object-cover"
                                    />
                                    <div>
                                        <p class="font-medium">
                                            {{ product.name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ product.sku }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                {{ product.category?.name }}
                            </td>
                            <td class="px-4 py-3">${{ product.price }}</td>
                            <td class="px-4 py-3">
                                <span
                                    :class="
                                        product.stock_quantity <=
                                        product.low_stock_threshold
                                            ? 'text-yellow-600'
                                            : ''
                                    "
                                >
                                    {{ product.stock_quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    :class="
                                        product.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800'
                                    "
                                    class="rounded px-2 py-1 text-sm"
                                >
                                    {{
                                        product.is_active
                                            ? 'Active'
                                            : 'Inactive'
                                    }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <Link
                                        :href="`/admin/products/${product.id}/edit`"
                                        class="text-indigo-600 hover:text-indigo-800"
                                        >Edit</Link
                                    >
                                    <button
                                        @click="deleteProduct(product.id)"
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
                    <Pagination :links="products.links" />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

const searchQuery = ref(props.filters.search || '');
const categoryFilter = ref(props.filters.category || '');
const statusFilter = ref(props.filters.status || '');

const search = () => {
    router.get('/admin/products', {
        search: searchQuery.value,
        category: categoryFilter.value,
        status: statusFilter.value,
    });
};

const deleteProduct = async (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        try {
            await router.delete(`/admin/products/${id}`);
        } catch (error) {
            alert('Failed to delete product');
        }
    }
};
</script>
