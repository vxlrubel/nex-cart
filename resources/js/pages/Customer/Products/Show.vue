<template>
    <div class="min-h-screen bg-gray-50">
        <CustomerHeader />

        <main class="container mx-auto px-4 py-8">
            <div class="rounded-lg bg-white p-6 shadow">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div>
                        <img
                            :src="product.image || '/placeholder.jpg'"
                            :alt="product.name"
                            class="w-full rounded-lg"
                        />
                    </div>
                    <div>
                        <h1 class="mb-2 text-3xl font-bold">
                            {{ product.name }}
                        </h1>
                        <p class="mb-4 text-gray-500">
                            {{ product.category?.name }}
                        </p>

                        <div class="mb-4 flex items-center gap-4">
                            <span class="text-3xl font-bold text-indigo-600"
                                >${{ product.price }}</span
                            >
                            <span
                                v-if="product.compare_price"
                                class="text-xl text-gray-400 line-through"
                            >
                                ${{ product.compare_price }}
                            </span>
                        </div>

                        <p class="mb-6 text-gray-600">
                            {{
                                product.short_description || product.description
                            }}
                        </p>

                        <div class="mb-4">
                            <span
                                :class="
                                    product.stock_quantity > 0
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                                class="font-semibold"
                            >
                                {{
                                    product.stock_quantity > 0
                                        ? `In Stock (${product.stock_quantity})`
                                        : 'Out of Stock'
                                }}
                            </span>
                        </div>

                        <form @submit.prevent="addToCart" class="mb-6">
                            <div class="flex gap-4">
                                <input
                                    v-model="quantity"
                                    type="number"
                                    min="1"
                                    :max="product.stock_quantity"
                                    class="w-24 rounded border px-4 py-2"
                                    required
                                />
                                <button
                                    type="submit"
                                    :disabled="product.stock_quantity < 1"
                                    class="flex-1 rounded bg-indigo-600 py-2 text-white hover:bg-indigo-700 disabled:bg-gray-400"
                                >
                                    Add to Cart
                                </button>
                            </div>
                        </form>

                        <button
                            @click="toggleWishlist"
                            class="w-full rounded border border-gray-300 py-2 hover:bg-gray-50"
                        >
                            {{
                                inWishlist
                                    ? 'Remove from Wishlist'
                                    : 'Add to Wishlist'
                            }}
                        </button>
                    </div>
                </div>

                <div class="mt-12">
                    <h2 class="mb-4 text-2xl font-bold">Product Description</h2>
                    <p class="text-gray-600">{{ product.description }}</p>
                </div>

                <div class="mt-12">
                    <h2 class="mb-4 text-2xl font-bold">Reviews</h2>
                    <div v-if="product.reviews?.length > 0" class="space-y-4">
                        <div
                            v-for="review in product.reviews"
                            :key="review.id"
                            class="border-b pb-4"
                        >
                            <div class="mb-2 flex items-center gap-2">
                                <span class="font-semibold">{{
                                    review.user?.name
                                }}</span>
                                <span class="text-yellow-500">{{
                                    '★'.repeat(review.rating)
                                }}</span>
                            </div>
                            <p v-if="review.title" class="font-medium">
                                {{ review.title }}
                            </p>
                            <p class="text-gray-600">{{ review.comment }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500">No reviews yet.</p>
                </div>

                <div v-if="$page.props.auth?.user" class="mt-8">
                    <h3 class="mb-4 text-xl font-bold">Write a Review</h3>
                    <form @submit.prevent="submitReview">
                        <div class="mb-4">
                            <label class="mb-2 block">Rating</label>
                            <select
                                v-model="reviewForm.rating"
                                class="w-full rounded border px-3 py-2"
                                required
                            >
                                <option value="">Select rating</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="mb-2 block">Title</label>
                            <input
                                v-model="reviewForm.title"
                                type="text"
                                class="w-full rounded border px-3 py-2"
                            />
                        </div>
                        <div class="mb-4">
                            <label class="mb-2 block">Comment</label>
                            <textarea
                                v-model="reviewForm.comment"
                                rows="4"
                                class="w-full rounded border px-3 py-2"
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="rounded bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700"
                        >
                            Submit Review
                        </button>
                    </form>
                </div>

                <div v-if="relatedProducts.length > 0" class="mt-12">
                    <h2 class="mb-4 text-2xl font-bold">Related Products</h2>
                    <div
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                    >
                        <div
                            v-for="related in relatedProducts"
                            :key="related.id"
                            class="overflow-hidden rounded-lg bg-white shadow"
                        >
                            <Link :href="`/products/${related.slug}`">
                                <img
                                    :src="related.image || '/placeholder.jpg'"
                                    :alt="related.name"
                                    class="h-48 w-full object-cover"
                                />
                            </Link>
                            <div class="p-4">
                                <h3 class="font-semibold">
                                    {{ related.name }}
                                </h3>
                                <p class="font-bold text-indigo-600">
                                    ${{ related.price }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import CustomerHeader from '@/components/CustomerHeader.vue';

const props = defineProps({
    product: Object,
    relatedProducts: Array,
});

const quantity = ref(1);
const inWishlist = ref(false);
const reviewForm = reactive({
    rating: '',
    title: '',
    comment: '',
});

const addToCart = async () => {
    try {
        await router.post('/cart/add', {
            product_id: props.product.id,
            quantity: quantity.value,
        });
        alert('Product added to cart!');
    } catch (error) {
        alert('Failed to add to cart');
    }
};

const toggleWishlist = async () => {
    try {
        await router.post('/wishlist/toggle', {
            product_id: props.product.id,
        });
        inWishlist.value = !inWishlist.value;
    } catch (error) {
        alert('Please login to add to wishlist');
    }
};

const submitReview = async () => {
    try {
        await router.post('/reviews', {
            product_id: props.product.id,
            ...reviewForm,
        });
        alert('Review submitted!');
        router.reload();
    } catch (error) {
        alert('Failed to submit review');
    }
};
</script>
