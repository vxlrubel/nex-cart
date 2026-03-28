<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow-sm">
            <nav class="container mx-auto px-4 py-4">
                <Link href="/" class="text-2xl font-bold text-indigo-600"
                    >NexCart Admin</Link
                >
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="mb-6 flex items-center gap-4">
                <Link
                    href="/admin/products"
                    class="text-gray-600 hover:text-gray-800"
                    >← Back to Products</Link
                >
            </div>

            <h1 class="mb-6 text-2xl font-bold">Add Product</h1>

            <form
                @submit.prevent="submit"
                class="space-y-6 rounded-lg bg-white p-6 shadow"
            >
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block font-medium">Name *</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full rounded border px-3 py-2"
                            required
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium">Slug</label>
                        <input
                            v-model="form.slug"
                            type="text"
                            class="w-full rounded border px-3 py-2"
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium">Category</label>
                        <select
                            v-model="form.category_id"
                            class="w-full rounded border px-3 py-2"
                        >
                            <option value="">Select Category</option>
                            <option
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="cat.id"
                            >
                                {{ cat.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block font-medium">SKU</label>
                        <input
                            v-model="form.sku"
                            type="text"
                            class="w-full rounded border px-3 py-2"
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium">Price *</label>
                        <input
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            class="w-full rounded border px-3 py-2"
                            required
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium"
                            >Compare Price</label
                        >
                        <input
                            v-model="form.compare_price"
                            type="number"
                            step="0.01"
                            class="w-full rounded border px-3 py-2"
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium"
                            >Stock Quantity *</label
                        >
                        <input
                            v-model="form.stock_quantity"
                            type="number"
                            class="w-full rounded border px-3 py-2"
                            required
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium"
                            >Low Stock Threshold</label
                        >
                        <input
                            v-model="form.low_stock_threshold"
                            type="number"
                            class="w-full rounded border px-3 py-2"
                        />
                    </div>
                    <div>
                        <label class="mb-2 block font-medium">Image URL</label>
                        <input
                            v-model="form.image"
                            type="text"
                            class="w-full rounded border px-3 py-2"
                        />
                    </div>
                </div>

                <div>
                    <label class="mb-2 block font-medium"
                        >Short Description</label
                    >
                    <textarea
                        v-model="form.short_description"
                        rows="2"
                        class="w-full rounded border px-3 py-2"
                    ></textarea>
                </div>

                <div>
                    <label class="mb-2 block font-medium">Description</label>
                    <textarea
                        v-model="form.description"
                        rows="4"
                        class="w-full rounded border px-3 py-2"
                    ></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-2">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="rounded"
                        />
                        <span>Active</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input
                            v-model="form.is_featured"
                            type="checkbox"
                            class="rounded"
                        />
                        <span>Featured</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="rounded bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700"
                    >
                        Create Product
                    </button>
                    <Link
                        href="/admin/products"
                        class="rounded bg-gray-200 px-6 py-2 text-gray-700 hover:bg-gray-300"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </main>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { router, Link } from '@inertiajs/vue3';

defineProps({
    categories: Array,
});

const form = reactive({
    name: '',
    slug: '',
    description: '',
    short_description: '',
    price: '',
    compare_price: '',
    category_id: '',
    sku: '',
    stock_quantity: 0,
    low_stock_threshold: 10,
    is_active: true,
    is_featured: false,
    image: '',
});

const submit = async () => {
    try {
        await router.post('/admin/products', form);
    } catch (error) {
        alert('Failed to create product');
    }
};
</script>
