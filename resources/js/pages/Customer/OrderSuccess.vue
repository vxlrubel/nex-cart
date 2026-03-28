<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-50">
        <div class="text-center">
            <div class="mb-4 text-6xl">✓</div>
            <h1 class="mb-4 text-3xl font-bold">Order Placed Successfully!</h1>
            <p class="mb-2 text-gray-600">Thank you for your order.</p>
            <p class="mb-6 text-lg">
                Order Number:
                <span class="font-semibold">{{ order.order_number }}</span>
            </p>
            <div class="space-x-4">
                <Link
                    href="/orders"
                    class="rounded bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700"
                >
                    View Orders
                </Link>
                <Link
                    href="/products"
                    class="rounded bg-gray-200 px-6 py-3 text-gray-700 hover:bg-gray-300"
                >
                    Continue Shopping
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    order: Object,
});
</script>
