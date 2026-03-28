<template>
    <div
        class="overflow-hidden rounded-lg bg-white shadow-md transition-shadow hover:shadow-lg"
    >
        <Link :href="`/products/${product.slug}`">
            <img
                :src="product.image || '/placeholder.jpg'"
                :alt="product.name"
                class="h-48 w-full object-cover"
            />
        </Link>
        <div class="p-4">
            <Link
                :href="`/products/${product.slug}`"
                class="line-clamp-1 text-lg font-semibold hover:text-indigo-600"
            >
                {{ product.name }}
            </Link>
            <p class="text-sm text-gray-500">{{ product.category?.name }}</p>

            <div class="mt-2 flex items-center gap-2">
                <span class="text-xl font-bold text-indigo-600"
                    >${{ product.price }}</span
                >
                <span
                    v-if="product.compare_price"
                    class="text-sm text-gray-400 line-through"
                >
                    ${{ product.compare_price }}
                </span>
            </div>

            <div class="mt-3 flex items-center justify-between">
                <button
                    @click.prevent="addToCart"
                    :disabled="!inStock"
                    class="flex-1 rounded bg-indigo-600 py-2 text-white hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-gray-400"
                >
                    {{ inStock ? 'Add to Cart' : 'Out of Stock' }}
                </button>
                <button
                    @click.prevent="toggleWishlist"
                    class="ml-2 rounded border p-2 hover:bg-gray-50"
                    :class="isInWishlist ? 'text-red-500' : 'text-gray-400'"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    isInWishlist: {
        type: Boolean,
        default: false,
    },
});

const inStock = computed(() => props.product.stock_quantity > 0);

const addToCart = async () => {
    try {
        await router.post('/cart/add', {
            product_id: props.product.id,
            quantity: 1,
        });
        alert('Added to cart!');
    } catch (error) {
        alert('Failed to add to cart');
    }
};

const toggleWishlist = async () => {
    try {
        await router.post('/wishlist/toggle', {
            product_id: props.product.id,
        });
    } catch (error) {
        alert('Please login to add to wishlist');
    }
};
</script>
