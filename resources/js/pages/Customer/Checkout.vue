<template>
    <div class="min-h-screen bg-gray-50">
        <CustomerHeader />

        <main class="container mx-auto px-4 py-8">
            <h1 class="mb-6 text-2xl font-bold">Checkout</h1>

            <form @submit.prevent="processCheckout">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <div class="space-y-6 lg:col-span-2">
                        <div class="rounded-lg bg-white p-6 shadow">
                            <h2 class="mb-4 text-xl font-bold">
                                Shipping Information
                            </h2>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-2 block"
                                        >First Name *</label
                                    >
                                    <input
                                        v-model="form.shipping_first_name"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div>
                                    <label class="mb-2 block"
                                        >Last Name *</label
                                    >
                                    <input
                                        v-model="form.shipping_last_name"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div class="col-span-2">
                                    <label class="mb-2 block">Email *</label>
                                    <input
                                        v-model="form.shipping_email"
                                        type="email"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div class="col-span-2">
                                    <label class="mb-2 block">Phone *</label>
                                    <input
                                        v-model="form.shipping_phone"
                                        type="tel"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div class="col-span-2">
                                    <label class="mb-2 block">Address *</label>
                                    <input
                                        v-model="form.shipping_address"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div>
                                    <label class="mb-2 block">City *</label>
                                    <input
                                        v-model="form.shipping_city"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div>
                                    <label class="mb-2 block">State</label>
                                    <input
                                        v-model="form.shipping_state"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                    />
                                </div>
                                <div>
                                    <label class="mb-2 block"
                                        >Postal Code *</label
                                    >
                                    <input
                                        v-model="form.shipping_postal_code"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                                <div>
                                    <label class="mb-2 block">Country *</label>
                                    <input
                                        v-model="form.shipping_country"
                                        type="text"
                                        class="w-full rounded border px-3 py-2"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="flex items-center gap-2">
                                    <input
                                        v-model="form.save_address"
                                        type="checkbox"
                                        class="rounded"
                                    />
                                    <span
                                        >Save this address for future
                                        orders</span
                                    >
                                </label>
                            </div>
                        </div>

                        <div class="rounded-lg bg-white p-6 shadow">
                            <h2 class="mb-4 text-xl font-bold">
                                Payment Method
                            </h2>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2">
                                    <input
                                        v-model="form.payment_method"
                                        type="radio"
                                        value="cod"
                                        class="rounded"
                                    />
                                    <span>Cash on Delivery</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input
                                        v-model="form.payment_method"
                                        type="radio"
                                        value="card"
                                        class="rounded"
                                    />
                                    <span>Credit/Debit Card</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input
                                        v-model="form.payment_method"
                                        type="radio"
                                        value="paypal"
                                        class="rounded"
                                    />
                                    <span>PayPal</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div
                            class="sticky top-4 rounded-lg bg-white p-6 shadow"
                        >
                            <h2 class="mb-4 text-xl font-bold">
                                Order Summary
                            </h2>

                            <div
                                v-if="cart?.items?.length > 0"
                                class="mb-4 space-y-3"
                            >
                                <div
                                    v-for="item in cart.items"
                                    :key="item.id"
                                    class="flex justify-between text-sm"
                                >
                                    <span
                                        >{{ item.product?.name }} x
                                        {{ item.quantity }}</span
                                    >
                                    <span>${{ item.total }}</span>
                                </div>
                            </div>

                            <div class="space-y-2 border-t pt-4">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span>${{ cart?.subtotal || 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tax</span>
                                    <span>${{ cart?.tax || 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Shipping</span>
                                    <span>$10.00</span>
                                </div>
                                <div
                                    v-if="couponDiscount > 0"
                                    class="flex justify-between text-green-600"
                                >
                                    <span>Discount</span>
                                    <span>-${{ couponDiscount }}</span>
                                </div>
                                <div
                                    class="flex justify-between border-t pt-2 text-lg font-bold"
                                >
                                    <span>Total</span>
                                    <span>${{ total }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="flex gap-2">
                                    <input
                                        v-model="couponCode"
                                        type="text"
                                        placeholder="Coupon code"
                                        class="flex-1 rounded border px-3 py-2"
                                    />
                                    <button
                                        @click="applyCoupon"
                                        type="button"
                                        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300"
                                    >
                                        Apply
                                    </button>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="mt-6 w-full rounded bg-indigo-600 py-3 text-white hover:bg-indigo-700"
                            >
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import CustomerHeader from '@/components/CustomerHeader.vue';

const props = defineProps({
    cart: Object,
    addresses: Array,
});

const couponCode = ref('');
const couponDiscount = ref(0);

const form = reactive({
    shipping_first_name: '',
    shipping_last_name: '',
    shipping_email: '',
    shipping_phone: '',
    shipping_address: '',
    shipping_city: '',
    shipping_state: '',
    shipping_postal_code: '',
    shipping_country: 'US',
    payment_method: 'cod',
    save_address: false,
    coupon_code: '',
});

const total = computed(() => {
    const subtotal = parseFloat(props.cart?.subtotal || 0);
    const tax = parseFloat(props.cart?.tax || 0);
    const shipping = 10.0;
    return (subtotal + tax + shipping - couponDiscount.value).toFixed(2);
});

const applyCoupon = async () => {
    try {
        await router.post(
            '/checkout/apply-coupon',
            { code: couponCode.value },
            {
                onSuccess: (page) => {
                    if (page.props.coupon_discount) {
                        couponDiscount.value = page.props.coupon_discount;
                        form.coupon_code = page.props.coupon_code;
                        alert('Coupon applied!');
                    }
                },
            },
        );
    } catch (error) {
        alert('Invalid coupon code');
    }
};

const processCheckout = async () => {
    try {
        await router.post('/checkout/process', {
            ...form,
            coupon_code: form.coupon_code,
        });
    } catch (error) {
        alert('Failed to process checkout');
    }
};
</script>
