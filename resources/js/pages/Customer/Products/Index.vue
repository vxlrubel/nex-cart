<template>
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-sm">
            <nav
                class="container mx-auto flex items-center justify-between px-4 py-4"
            >
                <Link href="/" class="text-2xl font-bold text-indigo-600"
                    >NexCart</Link
                >
                <div class="flex items-center gap-6">
                    <Link
                        href="/products"
                        class="text-gray-700 hover:text-indigo-600"
                        >Products</Link
                    >
                    <Link
                        href="/cart"
                        class="text-gray-700 hover:text-indigo-600"
                        >Cart</Link
                    >
                    <template v-if="$page.props.auth?.user">
                        <Link
                            href="/wishlist"
                            class="text-gray-700 hover:text-indigo-600"
                            >Wishlist</Link
                        >
                        <Link
                            href="/orders"
                            class="text-gray-700 hover:text-indigo-600"
                            >Orders</Link
                        >
                    </template>
                    <template v-else>
                        <Link
                            href="/login"
                            class="text-gray-700 hover:text-indigo-600"
                            >Login</Link
                        >
                    </template>
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="flex gap-8">
                <aside class="w-64 flex-shrink-0">
                    <div class="rounded-lg bg-white p-4 shadow">
                        <h3 class="mb-4 font-semibold">Search</h3>
                        <form @submit.prevent="search">
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search products..."
                                class="mb-4 w-full rounded border px-3 py-2"
                            />

                            <h3 class="mb-4 font-semibold">Categories</h3>
                            <div class="space-y-2">
                                <Link
                                    v-for="category in categories"
                                    :key="category.id"
                                    :href="`/products?category=${category.slug}`"
                                    class="block text-gray-700 hover:text-indigo-600"
                                >
                                    {{ category.name }}
                                </Link>
                            </div>

                            <h3 class="mt-6 mb-4 font-semibold">Price Range</h3>
                            <div class="flex gap-2">
                                <input
                                    v-model="minPrice"
                                    type="number"
                                    placeholder="Min"
                                    class="w-full rounded border px-3 py-2"
                                />
                                <input
                                    v-model="maxPrice"
                                    type="number"
                                    placeholder="Max"
                                    class="w-full rounded border px-3 py-2"
                                />
                            </div>
                            <button
                                type="submit"
                                class="mt-4 w-full rounded bg-indigo-600 py-2 text-white hover:bg-indigo-700"
                            >
                                Filter
                            </button>
                        </form>
                    </div>
                </aside>

                <div class="flex-1">
                    <div class="mb-6 flex items-center justify-between">
                        <h1 class="text-2xl font-bold">Products</h1>
                        <select
                            v-model="sortBy"
                            @change="applySort"
                            class="rounded border px-3 py-2"
                        >
                            <option value="latest">Latest</option>
                            <option value="price_asc">
                                Price: Low to High
                            </option>
                            <option value="price_desc">
                                Price: High to Low
                            </option>
                            <option value="name">Name</option>
                        </select>
                    </div>

                    <div
                        v-if="products.data.length === 0"
                        class="py-12 text-center"
                    >
                        <p class="text-gray-500">No products found.</p>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <div
                            v-for="product in products.data"
                            :key="product.id"
                            class="overflow-hidden rounded-lg bg-white shadow-md"
                        >
                            <Link :href="`/products/${product.slug}`">
                                <img
                                    :src="product.image || '/placeholder.jpg'"
                                    :alt="product.name"
                                    class="h-48 w-full object-cover"
                                />
                            </Link>
                            <div class="p-4">
                                <Link
                                    :href="`/products/${product.slug}`"
                                    class="text-lg font-semibold hover:text-indigo-600"
                                >
                                    {{ product.name }}
                                </Link>
                                <p class="text-sm text-gray-500">
                                    {{ product.category?.name }}
                                </p>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="font-bold text-indigo-600"
                                        >${{ product.price }}</span
                                    >
                                    <span
                                        v-if="product.compare_price"
                                        class="text-gray-400 line-through"
                                        >${{ product.compare_price }}</span
                                    >
                                </div>
                                <button
                                    @click="addToCart(product.id)"
                                    class="mt-3 w-full rounded bg-indigo-600 py-2 text-white hover:bg-indigo-700"
                                >
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <Pagination :links="products.links" />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

const searchQuery = ref(props.filters.search || '');
const minPrice = ref(props.filters.min_price || '');
const maxPrice = ref(props.filters.max_price || '');
const sortBy = ref(props.filters.sort || 'latest');

const search = () => {
    router.get('/products', {
        search: searchQuery.value,
        min_price: minPrice.value,
        max_price: maxPrice.value,
        sort: sortBy.value,
    });
};

const applySort = () => {
    search();
};

const addToCart = async (productId) => {
    try {
        await router.post('/cart/add', {
            product_id: productId,
            quantity: 1,
        });
        alert('Product added to cart!');
    } catch (error) {
        alert('Failed to add to cart');
    }
};
</script>
