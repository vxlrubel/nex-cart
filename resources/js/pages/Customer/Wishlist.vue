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
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <h1 class="mb-6 text-2xl font-bold">My Wishlist</h1>

            <div
                v-if="wishlists.data.length > 0"
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
            >
                <div
                    v-for="item in wishlists.data"
                    :key="item.id"
                    class="overflow-hidden rounded-lg bg-white shadow"
                >
                    <Link :href="`/products/${item.product?.slug}`">
                        <img
                            :src="item.product?.image || '/placeholder.jpg'"
                            :alt="item.product?.name"
                            class="h-48 w-full object-cover"
                        />
                    </Link>
                    <div class="p-4">
                        <Link
                            :href="`/products/${item.product?.slug}`"
                            class="font-semibold hover:text-indigo-600"
                        >
                            {{ item.product?.name }}
                        </Link>
                        <p class="mt-2 font-bold text-indigo-600">
                            ${{ item.product?.price }}
                        </p>
                        <div class="mt-3 flex gap-2">
                            <button
                                @click="addToCart(item.product_id)"
                                class="flex-1 rounded bg-indigo-600 py-2 text-white hover:bg-indigo-700"
                            >
                                Add to Cart
                            </button>
                            <button
                                @click="removeItem(item.id)"
                                class="rounded px-3 py-2 text-red-600 hover:bg-red-50"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="py-12 text-center">
                <p class="mb-6 text-lg text-gray-500">Your wishlist is empty</p>
                <Link
                    href="/products"
                    class="rounded bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700"
                >
                    Browse Products
                </Link>
            </div>
        </main>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
    wishlists: Object,
});

const addToCart = async (productId) => {
    try {
        await router.post('/cart/add', { product_id: productId, quantity: 1 });
        alert('Added to cart!');
    } catch (error) {
        alert('Failed to add to cart');
    }
};

const removeItem = async (id) => {
    try {
        await router.delete(`/wishlist/${id}`);
    } catch (error) {
        alert('Failed to remove');
    }
};
</script>
