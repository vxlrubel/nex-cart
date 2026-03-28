<template>
    <div class="p-6">
        <h1 class="mb-6 text-2xl font-semibold">Dashboard</h1>

        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border bg-card p-6 shadow-sm">
                <p class="text-sm text-muted-foreground">Total Products</p>
                <p class="text-3xl font-bold">{{ stats.total_products }}</p>
            </div>
            <div class="rounded-lg border bg-card p-6 shadow-sm">
                <p class="text-sm text-muted-foreground">Total Orders</p>
                <p class="text-3xl font-bold">{{ stats.total_orders }}</p>
            </div>
            <div class="rounded-lg border bg-card p-6 shadow-sm">
                <p class="text-sm text-muted-foreground">Total Customers</p>
                <p class="text-3xl font-bold">
                    {{ stats.total_customers }}
                </p>
            </div>
            <div class="rounded-lg border bg-card p-6 shadow-sm">
                <p class="text-sm text-muted-foreground">Total Revenue</p>
                <p class="text-3xl font-bold">${{ stats.total_revenue }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="rounded-lg border bg-card p-6 shadow-sm">
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
                            <p class="text-sm text-muted-foreground">
                                {{ order.user?.name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">${{ order.total }}</p>
                            <span
                                :class="statusClass(order.status)"
                                class="rounded px-2 py-1 text-xs"
                            >
                                {{ order.status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border bg-card p-6 shadow-sm">
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
    </div>
</template>

<script setup lang="ts">
defineProps<{
    stats: {
        total_products: number;
        total_orders: number;
        total_customers: number;
        total_revenue: number;
    };
    recentOrders: Array<{
        id: number;
        order_number: string;
        total: number;
        status: string;
        user?: { name: string };
    }>;
    topProducts: Array<{
        id: number;
        name: string;
        total_sold: number;
    }>;
    ordersByStatus: Record<string, number>;
}>();

const statusClass = (status: string) => {
    const classes: Record<string, string> = {
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
