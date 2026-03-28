<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Package, CreditCard, Truck } from 'lucide-vue-next';

defineProps<{
    order: {
        id: number;
        order_number: string;
        status: string;
        payment_status: string;
        payment_method: string;
        subtotal: number;
        tax: number;
        shipping_cost: number;
        discount: number;
        total: number;
        user: {
            id: number;
            name: string;
            email: string;
        };
        items: {
            id: number;
            product_id: number;
            variant_id: number | null;
            product_name: string;
            variant_name: string | null;
            price: number;
            quantity: number;
            total: number;
        }[];
        created_at: string;
    };
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
            <Link
                href="/admin/orders"
                class="flex items-center gap-1 text-muted-foreground hover:text-foreground"
            >
                <ArrowLeft class="h-4 w-4" />
                Back to Orders
            </Link>
        </div>

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">
                Order #{{ order.order_number }}
            </h1>
            <div class="flex gap-2">
                <span
                    :class="statusClass(order.status)"
                    class="rounded px-3 py-1 text-sm capitalize"
                >
                    {{ order.status }}
                </span>
                <span
                    :class="paymentStatusClass(order.payment_status)"
                    class="rounded px-3 py-1 text-sm capitalize"
                >
                    {{ order.payment_status }}
                </span>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-lg border bg-card shadow-sm lg:col-span-2">
                <div class="border-b p-4">
                    <h2 class="flex items-center gap-2 font-semibold">
                        <Package class="h-5 w-5" />
                        Order Items
                    </h2>
                </div>
                <div class="p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b text-left text-sm">
                                <th class="pb-2 font-medium">Product</th>
                                <th class="pb-2 font-medium">Price</th>
                                <th class="pb-2 font-medium">Qty</th>
                                <th class="pb-2 text-right font-medium">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in order.items"
                                :key="item.id"
                                class="border-b"
                            >
                                <td class="py-3">
                                    <p class="font-medium">
                                        {{ item.product_name }}
                                    </p>
                                    <p
                                        v-if="item.variant_name"
                                        class="text-sm text-muted-foreground"
                                    >
                                        {{ item.variant_name }}
                                    </p>
                                </td>
                                <td class="py-3">${{ item.price }}</td>
                                <td class="py-3">{{ item.quantity }}</td>
                                <td class="py-3 text-right">
                                    ${{ item.total }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="border-t p-4">
                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground"
                                    >Subtotal</span
                                >
                                <span>${{ order.subtotal }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Tax</span>
                                <span>${{ order.tax }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground"
                                    >Shipping</span
                                >
                                <span>${{ order.shipping_cost }}</span>
                            </div>
                            <div
                                v-if="order.discount > 0"
                                class="flex justify-between text-sm text-green-600"
                            >
                                <span>Discount</span>
                                <span>-${{ order.discount }}</span>
                            </div>
                            <div
                                class="flex justify-between border-t pt-2 font-semibold"
                            >
                                <span>Total</span>
                                <span>${{ order.total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg border bg-card shadow-sm">
                    <div class="border-b p-4">
                        <h2 class="flex items-center gap-2 font-semibold">
                            <CreditCard class="h-5 w-5" />
                            Customer
                        </h2>
                    </div>
                    <div class="p-4">
                        <p class="font-medium">{{ order.user?.name }}</p>
                        <p class="text-sm text-muted-foreground">
                            {{ order.user?.email }}
                        </p>
                    </div>
                </div>

                <div class="rounded-lg border bg-card shadow-sm">
                    <div class="border-b p-4">
                        <h2 class="flex items-center gap-2 font-semibold">
                            <Truck class="h-5 w-5" />
                            Payment
                        </h2>
                    </div>
                    <div class="space-y-3 p-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-muted-foreground">Method</span>
                            <span class="capitalize">{{
                                order.payment_method
                            }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-muted-foreground">Date</span>
                            <span>{{
                                new Date(order.created_at).toLocaleString(
                                    'en-US',
                                )
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
