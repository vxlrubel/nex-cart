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
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <h1 class="mb-6 text-2xl font-bold">Orders</h1>

            <div class="mb-6 rounded-lg bg-white p-4 shadow">
                <form @submit.prevent="search" class="flex gap-4">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search by order number..."
                        class="flex-1 rounded border px-3 py-2"
                    />
                    <select
                        v-model="statusFilter"
                        class="rounded border px-3 py-2"
                    >
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
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
                            <th class="px-4 py-3 text-left">Order #</th>
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Payment</th>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="order in orders.data"
                            :key="order.id"
                            class="border-t"
                        >
                            <td class="px-4 py-3 font-medium">
                                {{ order.order_number }}
                            </td>
                            <td class="px-4 py-3">{{ order.user?.name }}</td>
                            <td class="px-4 py-3">${{ order.total }}</td>
                            <td class="px-4 py-3">
                                <span
                                    :class="statusClass(order.status)"
                                    class="rounded px-2 py-1 text-sm"
                                    >{{ order.status }}</span
                                >
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    :class="paymentClass(order.payment_status)"
                                    class="rounded px-2 py-1 text-sm"
                                    >{{ order.payment_status }}</span
                                >
                            </td>
                            <td class="px-4 py-3">{{ order.created_at }}</td>
                            <td class="px-4 py-3">
                                <Link
                                    :href="`/admin/orders/${order.id}`"
                                    class="text-indigo-600 hover:text-indigo-800"
                                    >View</Link
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-4">
                    <Pagination :links="orders.links" />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object,
    filters: Object,
});

const searchQuery = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || '');

const search = () => {
    router.get('/admin/orders', {
        search: searchQuery.value,
        status: statusFilter.value,
    });
};

const statusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800',
    };
    return classes[status] || 'bg-gray-100';
};

const paymentClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        paid: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800',
    };
    return classes[status] || 'bg-gray-100';
};
</script>
