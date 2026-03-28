<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import couponRoutes from '@/routes/admin/coupons';

defineProps<{
    coupons: Array<{
        id: number;
        code: string;
        type: string;
        value: number;
        min_order_amount: number;
        max_uses: number;
        used_count: number;
        starts_at: string;
        expires_at: string;
        is_active: boolean;
    }>;
}>();
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Coupons</h1>
            <Link
                :href="couponRoutes?.create?.() || '#'"
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />
                Add Coupon
            </Link>
        </div>

        <div class="rounded-lg border bg-card shadow-sm">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Code
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Type
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Value
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Min Order
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Usage
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Expires
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Status
                        </th>
                        <th class="px-4 py-3 text-right text-sm font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="coupon in coupons || []"
                        :key="coupon.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3 font-mono font-medium">
                            {{ coupon.code }}
                        </td>
                        <td class="px-4 py-3 capitalize">{{ coupon.type }}</td>
                        <td class="px-4 py-3">
                            {{
                                coupon.type === 'percentage'
                                    ? `${coupon.value}%`
                                    : `$${coupon.value}`
                            }}
                        </td>
                        <td class="px-4 py-3">
                            ${{ coupon.min_order_amount }}
                        </td>
                        <td class="px-4 py-3">
                            {{ coupon.used_count }} / {{ coupon.max_uses }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{
                                new Date(coupon.expires_at).toLocaleDateString()
                            }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                :class="
                                    coupon.is_active
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800'
                                "
                                class="rounded px-2 py-1 text-xs"
                            >
                                {{ coupon.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    :href="
                                        coupon?.id
                                            ? `/admin/coupons/${coupon.id}/edit`
                                            : '#'
                                    "
                                    class="rounded p-1 hover:bg-muted"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Link>
                                <button
                                    class="rounded p-1 text-red-600 hover:bg-red-50"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
