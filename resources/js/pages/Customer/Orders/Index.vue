<template>
    <div class="min-h-screen bg-gray-50">
        <CustomerHeader />

        <main class="container mx-auto px-4 py-8">
            <h1 class="mb-6 text-2xl font-bold">My Orders</h1>

            <div v-if="orders.data.length > 0" class="space-y-4">
                <div
                    v-for="order in orders.data"
                    :key="order.id"
                    class="rounded-lg bg-white p-6 shadow"
                >
                    <div class="mb-4 flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">
                                Order #{{ order.order_number }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ order.created_at }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span
                                :class="statusClass(order.status)"
                                class="rounded-full px-3 py-1 text-sm font-medium"
                            >
                                {{ order.status }}
                            </span>
                            <p class="mt-2 text-lg font-bold">
                                ${{ order.total }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <Link
                            :href="`/orders/${order.id}`"
                            class="text-indigo-600 hover:text-indigo-800"
                        >
                            View Details
                        </Link>
                        <button
                            v-if="
                                order.status === 'pending' ||
                                order.status === 'processing'
                            "
                            @click="cancelOrder(order.id)"
                            class="text-red-600 hover:text-red-800"
                        >
                            Cancel Order
                        </button>
                    </div>
                </div>
            </div>

            <div v-else class="py-12 text-center">
                <p class="mb-6 text-lg text-gray-500">
                    You haven't placed any orders yet.
                </p>
                <Link
                    href="/products"
                    class="rounded bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700"
                >
                    Start Shopping
                </Link>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import CustomerHeader from '@/components/CustomerHeader.vue';

defineProps({
    orders: Object,
    filters: Object,
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

const cancelOrder = async (orderId) => {
    if (confirm('Are you sure you want to cancel this order?')) {
        try {
            await router.post(`/orders/${orderId}/cancel`);
            router.reload();
        } catch (error) {
            alert('Failed to cancel order');
        }
    }
};
</script>
