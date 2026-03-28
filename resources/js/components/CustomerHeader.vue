<template>
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
                <Link href="/cart" class="text-gray-700 hover:text-indigo-600"
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
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
