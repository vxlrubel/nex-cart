<template>
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-sm">
            <nav class="container mx-auto px-4 py-4">
                <Link href="/" class="text-2xl font-bold text-indigo-600"
                    >NexCart</Link
                >
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <Link
                href="/orders"
                class="mb-4 inline-block text-indigo-600 hover:text-indigo-800"
                >← Back to Orders</Link
            >

            <div class="rounded-lg bg-white p-6 shadow">
                <div class="mb-6 flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">
                            Order #{{ order.order_number }}
                        </h1>
                        <p class="text-gray-500">{{ order.created_at }}</p>
                    </div>
                    <div class="text-right">
                        <span
                            :class="statusClass(order.status)"
                            class="rounded-full px-3 py-1 text-sm font-medium"
                        >
                            {{ order.status }}
                        </span>
                        <span
                            :class="paymentStatusClass(order.payment_status)"
                            class="ml-2 rounded-full px-3 py-1 text-sm font-medium"
                        >
                            {{ order.payment_status }}
                        </span>
                    </div>
                </div>

                <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <h2 class="mb-2 font-semibold">Shipping Address</h2>
                        <p class="text-gray-600">
                            {{ order.shipping_name }}<br />
                            {{ order.shipping_address }}<br />
                            {{ order.shipping_city }},
                            {{ order.shipping_state }}
                            {{ order.shipping_postal_code }}<br />
                            {{ order.shipping_country }}
                        </p>
                    </div>
                    <div>
                        <h2 class="mb-2 font-semibold">Payment Method</h2>
                        <p class="text-gray-600">{{ order.payment_method }}</p>
                    </div>
                </div>

                <h2 class="mb-4 font-semibold">Order Items</h2>
                <table class="mb-8 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-left">Quantity</th>
                            <th class="px-4 py-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in order.items"
                            :key="item.id"
                            class="border-t"
                        >
                            <td class="px-4 py-4">
                                <p>{{ item.product_name }}</p>
                                <p
                                    v-if="item.variant_name"
                                    class="text-sm text-gray-500"
                                >
                                    {{ item.variant_name }}
                                </p>
                            </td>
                            <td class="px-4 py-4">${{ item.price }}</td>
                            <td class="px-4 py-4">{{ item.quantity }}</td>
                            <td class="px-4 py-4">${{ item.total }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="border-t pt-4">
                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>${{ order.subtotal }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>${{ order.tax }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span>${{ order.shipping_cost }}</span>
                            </div>
                            <div
                                v-if="order.discount > 0"
                                class="flex justify-between text-green-600"
                            >
                                <span>Discount</span>
                                <span>-${{ order.discount }}</span>
                            </div>
                            <div
                                class="flex justify-between border-t pt-2 text-lg font-bold"
                            >
                                <span>Total</span>
                                <span>${{ order.total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
defineProps({
    order: Object,
});

const statusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const paymentStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        paid: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>
