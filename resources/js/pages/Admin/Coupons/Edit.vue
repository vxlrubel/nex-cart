<script setup lang="ts">
import { reactive } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps<{
    coupon: {
        id: number;
        code: string;
        type: string;
        value: number;
        min_order_amount: number | null;
        max_discount: number | null;
        usage_limit: number | null;
        user_id: number | null;
        starts_at: string | null;
        expires_at: string | null;
        is_active: boolean;
    };
}>();

const form = reactive({
    code: props.coupon.code,
    type: props.coupon.type,
    value: props.coupon.value,
    min_order_amount: props.coupon.min_order_amount,
    max_discount: props.coupon.max_discount,
    usage_limit: props.coupon.usage_limit,
    user_id: props.coupon.user_id,
    starts_at: props.coupon.starts_at || '',
    expires_at: props.coupon.expires_at || '',
    is_active: props.coupon.is_active,
});

const submit = async () => {
    try {
        await router.put(`/admin/coupons/${props.coupon.id}`, form);
    } catch (error) {
        alert('Failed to update coupon');
    }
};
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <Link
                href="/admin/coupons"
                class="flex items-center gap-1 text-muted-foreground hover:text-foreground"
            >
                ← Back to Coupons
            </Link>
        </div>

        <h1 class="mb-6 text-2xl font-semibold">Edit Coupon</h1>

        <form
            @submit.prevent="submit"
            class="max-w-2xl space-y-6 rounded-lg border bg-card p-6 shadow-sm"
        >
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium">Code *</label>
                    <input
                        v-model="form.code"
                        type="text"
                        class="w-full rounded border bg-background px-3 py-2 uppercase"
                        required
                    />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Type *</label>
                    <select
                        v-model="form.type"
                        class="w-full rounded border bg-background px-3 py-2"
                        required
                    >
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium"
                        >Value *</label
                    >
                    <input
                        v-model="form.value"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full rounded border bg-background px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium"
                        >Usage Limit</label
                    >
                    <input
                        v-model="form.usage_limit"
                        type="number"
                        min="1"
                        class="w-full rounded border bg-background px-3 py-2"
                        placeholder="Unlimited"
                    />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium"
                        >Min Order Amount</label
                    >
                    <input
                        v-model="form.min_order_amount"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full rounded border bg-background px-3 py-2"
                    />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium"
                        >Max Discount</label
                    >
                    <input
                        v-model="form.max_discount"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full rounded border bg-background px-3 py-2"
                    />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium"
                        >Starts At</label
                    >
                    <input
                        v-model="form.starts_at"
                        type="datetime-local"
                        class="w-full rounded border bg-background px-3 py-2"
                    />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium"
                        >Expires At</label
                    >
                    <input
                        v-model="form.expires_at"
                        type="datetime-local"
                        class="w-full rounded border bg-background px-3 py-2"
                    />
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input
                    v-model="form.is_active"
                    type="checkbox"
                    id="is_active"
                    class="rounded"
                />
                <label for="is_active" class="text-sm font-medium"
                    >Active</label
                >
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="rounded bg-primary px-6 py-2 text-primary-foreground hover:bg-primary/90"
                >
                    Update Coupon
                </button>
                <Link
                    href="/admin/coupons"
                    class="rounded bg-muted px-6 py-2 hover:bg-muted/80"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </div>
</template>
