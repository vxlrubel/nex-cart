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
                        <Link
                            href="/admin/dashboard"
                            class="text-gray-700 hover:text-indigo-600"
                            >Dashboard</Link
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

        <main>
            <section class="bg-indigo-600 py-16 text-white">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="mb-4 text-4xl font-bold">Welcome to NexCart</h1>
                    <p class="mb-8 text-xl">
                        Discover amazing products at great prices
                    </p>
                    <Link
                        href="/products"
                        class="rounded-lg bg-white px-6 py-3 font-semibold text-indigo-600 hover:bg-gray-100"
                    >
                        Shop Now
                    </Link>
                </div>
            </section>

            <section class="py-12">
                <div class="container mx-auto px-4">
                    <h2 class="mb-8 text-2xl font-bold">Featured Products</h2>
                    <div
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                    >
                        <div
                            v-for="product in featuredProducts"
                            :key="product.id"
                            class="overflow-hidden rounded-lg bg-white shadow-md"
                        >
                            <img
                                :src="product.image || '/placeholder.jpg'"
                                :alt="product.name"
                                class="h-48 w-full object-cover"
                            />
                            <div class="p-4">
                                <h3 class="mb-2 text-lg font-semibold">
                                    {{ product.name }}
                                </h3>
                                <p class="font-bold text-indigo-600">
                                    ${{ product.price }}
                                </p>
                                <Link
                                    :href="`/products/${product.slug}`"
                                    class="mt-3 block w-full rounded bg-indigo-600 py-2 text-center text-white hover:bg-indigo-700"
                                >
                                    View Details
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-gray-100 py-12">
                <div class="container mx-auto px-4">
                    <h2 class="mb-8 text-2xl font-bold">Categories</h2>
                    <div
                        class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6"
                    >
                        <Link
                            v-for="category in categories"
                            :key="category.id"
                            :href="`/products?category=${category.slug}`"
                            class="rounded-lg bg-white p-4 text-center shadow transition hover:shadow-lg"
                        >
                            <h3 class="font-semibold">{{ category.name }}</h3>
                        </Link>
                    </div>
                </div>
            </section>

            <section class="py-12">
                <div class="container mx-auto px-4">
                    <h2 class="mb-8 text-2xl font-bold">New Arrivals</h2>
                    <div
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                    >
                        <div
                            v-for="product in newArrivals"
                            :key="product.id"
                            class="overflow-hidden rounded-lg bg-white shadow-md"
                        >
                            <img
                                :src="product.image || '/placeholder.jpg'"
                                :alt="product.name"
                                class="h-48 w-full object-cover"
                            />
                            <div class="p-4">
                                <h3 class="mb-2 text-lg font-semibold">
                                    {{ product.name }}
                                </h3>
                                <p class="font-bold text-indigo-600">
                                    ${{ product.price }}
                                </p>
                                <Link
                                    :href="`/products/${product.slug}`"
                                    class="mt-3 block w-full rounded bg-indigo-600 py-2 text-center text-white hover:bg-indigo-700"
                                >
                                    View Details
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="mt-12 bg-gray-800 py-8 text-white">
            <div class="container mx-auto px-4 text-center">
                <p>
                    &copy; {{ new Date().getFullYear() }} NexCart. All rights
                    reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    featuredProducts: Array,
    newArrivals: Array,
    categories: Array,
});
</script>
