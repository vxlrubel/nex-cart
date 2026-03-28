<template>
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-sm">
            <nav
                class="container mx-auto flex items-center justify-between px-4 py-4"
            >
                <Link href="/" class="text-2xl font-bold text-indigo-600"
                    >NexCart</Link
                >
                <div class="flex items-center gap-6">
                    <Link
                        href="/products"
                        class="text-gray-700 hover:text-indigo-600"
                        >Products</Link
                    >
                    <Link
                        href="/cart"
                        class="text-gray-700 hover:text-indigo-600"
                        >Cart</Link
                    >
                </div>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <h1 class="mb-6 text-2xl font-bold">Shopping Cart</h1>

            <div
                v-if="cart?.items?.length > 0"
                class="grid grid-cols-1 gap-8 lg:grid-cols-3"
            >
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left">Product</th>
                                    <th class="px-4 py-3 text-left">Price</th>
                                    <th class="px-4 py-3 text-left">
                                        Quantity
                                    </th>
                                    <th class="px-4 py-3 text-left">Total</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="item in cart.items"
                                    :key="item.id"
                                    class="border-t"
                                >
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-4">
                                            <img
                                                :src="
                                                    item.product?.image ||
                                                    '/placeholder.jpg'
                                                "
                                                :alt="item.product?.name"
                                                class="h-16 w-16 rounded object-cover"
                                            />
                                            <div>
                                                <Link
                                                    :href="`/products/${item.product?.slug}`"
                                                    class="font-semibold hover:text-indigo-600"
                                                >
                                                    {{ item.product?.name }}
                                                </Link>
                                                <p
                                                    v-if="item.variant"
                                                    class="text-sm text-gray-500"
                                                >
                                                    {{ item.variant?.name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">${{ item.price }}</td>
                                    <td class="px-4 py-4">
                                        <form
                                            @submit.prevent="
                                                updateQuantity(
                                                    item.id,
                                                    item.quantity,
                                                )
                                            "
                                            class="flex items-center gap-2"
                                        >
                                            <input
                                                v-model="item.quantity"
                                                type="number"
                                                min="1"
                                                class="w-16 rounded border px-2 py-1"
                                            />
                                            <button
                                                type="submit"
                                                class="text-indigo-600 hover:text-indigo-800"
                                            >
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 font-semibold">
                                        ${{ item.total }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <button
                                            @click="removeItem(item.id)"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="rounded-lg bg-white p-6 shadow">
                        <h2 class="mb-4 text-xl font-bold">Order Summary</h2>
                        <div class="mb-4 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>${{ cart.subtotal }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>${{ cart.tax }}</span>
                            </div>
                            <div
                                class="flex justify-between border-t pt-2 text-lg font-bold"
                            >
                                <span>Total</span>
                                <span>${{ cart.total }}</span>
                            </div>
                        </div>
                        <Link
                            href="/checkout"
                            class="block w-full rounded bg-indigo-600 py-3 text-center text-white hover:bg-indigo-700"
                        >
                            Proceed to Checkout
                        </Link>
                        <button
                            @click="clearCart"
                            class="mt-4 block w-full text-center text-gray-500 hover:text-gray-700"
                        >
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>

            <div v-else class="py-12 text-center">
                <p class="mb-6 text-lg text-gray-500">Your cart is empty</p>
                <Link
                    href="/products"
                    class="rounded bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700"
                >
                    Continue Shopping
                </Link>
            </div>
        </main>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
    cart: Object,
});

const updateQuantity = async (itemId, quantity) => {
    try {
        await router.put(`/cart/${itemId}`, { quantity });
    } catch (error) {
        alert('Failed to update quantity');
    }
};

const removeItem = async (itemId) => {
    if (confirm('Remove this item?')) {
        try {
            await router.delete(`/cart/${itemId}`);
        } catch (error) {
            alert('Failed to remove item');
        }
    }
};

const clearCart = async () => {
    if (confirm('Clear all items from cart?')) {
        try {
            await router.delete('/cart/clear');
        } catch (error) {
            alert('Failed to clear cart');
        }
    }
};
</script>
