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
                    <Link
                        href="/admin/users"
                        class="text-gray-700 hover:text-indigo-600"
                        >Users</Link
                    >
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <h1 class="mb-6 text-2xl font-bold">Dashboard</h1>

            <div
                class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4"
            >
                <div class="rounded-lg bg-white p-6 shadow">
                    <p class="text-gray-500">Total Products</p>
                    <p class="text-3xl font-bold">{{ stats.total_products }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow">
                    <p class="text-gray-500">Total Orders</p>
                    <p class="text-3xl font-bold">{{ stats.total_orders }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow">
                    <p class="text-gray-500">Total Customers</p>
                    <p class="text-3xl font-bold">
                        {{ stats.total_customers }}
                    </p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow">
                    <p class="text-gray-500">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ stats.total_revenue }}</p>
                </div>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow">
                    <h2 class="mb-4 text-lg font-semibold">Recent Orders</h2>
                    <div class="space-y-4">
                        <div
                            v-for="order in recentOrders"
                            :key="order.id"
                            class="flex items-center justify-between border-b pb-2"
                        >
                            <div>
                                <p class="font-medium">
                                    {{ order.order_number }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ order.user?.name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">${{ order.total }}</p>
                                <span
                                    :class="statusClass(order.status)"
                                    class="rounded px-2 py-1 text-xs"
                                    >{{ order.status }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <Link
                        href="/admin/orders"
                        class="mt-4 block text-indigo-600 hover:text-indigo-800"
                        >View All Orders →</Link
                    >
                </div>

                <div class="rounded-lg bg-white p-6 shadow">
                    <h2 class="mb-4 text-lg font-semibold">Orders by Status</h2>
                    <div class="space-y-2">
                        <div
                            v-for="(count, status) in ordersByStatus"
                            :key="status"
                            class="flex justify-between"
                        >
                            <span class="capitalize">{{ status }}</span>
                            <span class="font-semibold">{{ count }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow">
                <h2 class="mb-4 text-lg font-semibold">Top Products</h2>
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-left">Total Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in topProducts"
                            :key="product.id"
                            class="border-t"
                        >
                            <td class="px-4 py-2">{{ product.name }}</td>
                            <td class="px-4 py-2">{{ product.total_sold }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</template>

<script setup>
defineProps({
    stats: Object,
    recentOrders: Array,
    topProducts: Array,
    ordersByStatus: Object,
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
</script>
