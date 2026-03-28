<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Eye } from 'lucide-vue-next';

defineProps<{
    orders: any[];
}>();

const statusClass = (status: string) => {
    const classes: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const paymentStatusClass = (status: string) => {
    const classes: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-800',
        paid: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">Orders</h1>
        </div>

        <div class="rounded-lg border bg-card shadow-sm">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Order #
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Customer
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Total
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Payment
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Date
                        </th>
                        <th class="px-4 py-3 text-right text-sm font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="order in orders || []"
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
                                class="rounded px-2 py-1 text-xs capitalize"
                            >
                                {{ order.status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                :class="
                                    paymentStatusClass(order.payment_status)
                                "
                                class="rounded px-2 py-1 text-xs capitalize"
                            >
                                {{ order.payment_status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{
                                new Date(order.created_at).toLocaleDateString(
                                    'en-US',
                                )
                            }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <Link
                                :href="`/admin/orders/${order.id}`"
                                class="inline-flex items-center gap-1 rounded p-1 hover:bg-muted"
                            >
                                <Eye class="h-4 w-4" />
                                View
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
