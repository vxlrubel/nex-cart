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

            <h1 class="mb-6 text-2xl font-bold">Edit Product</h1>

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
                            placeholder="e.g., my-product-name"
                            class="w-full rounded border px-3 py-2"
                            :class="{ 'border-red-500': slugError }"
                        />
                        <p v-if="slugError" class="mt-1 text-sm text-red-500">
                            {{ slugError }}
                        </p>
                        <p v-else class="mt-1 text-sm text-gray-500">
                            Only lowercase letters (a-z), numbers, and hyphens
                        </p>
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

                <div class="rounded-lg border border-gray-200 p-4">
                    <h3 class="mb-4 text-lg font-semibold">SEO Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block font-medium"
                                >Meta Title</label
                            >
                            <input
                                v-model="form.meta_title"
                                type="text"
                                class="w-full rounded border px-3 py-2"
                            />
                            <p class="mt-1 text-sm text-gray-500">
                                Recommended: 50-60 characters
                            </p>
                        </div>
                        <div>
                            <label class="mb-2 block font-medium"
                                >Meta Description</label
                            >
                            <textarea
                                v-model="form.meta_description"
                                rows="2"
                                class="w-full rounded border px-3 py-2"
                            ></textarea>
                            <p class="mt-1 text-sm text-gray-500">
                                Recommended: 150-160 characters
                            </p>
                        </div>
                        <div>
                            <label class="mb-2 block font-medium"
                                >Meta Keywords</label
                            >
                            <input
                                v-model="form.meta_keywords"
                                type="text"
                                class="w-full rounded border px-3 py-2"
                                placeholder="keyword1, keyword2, keyword3"
                            />
                        </div>
                        <div>
                            <label class="mb-2 block font-medium"
                                >Custom Schema (JSON-LD)</label
                            >
                            <textarea
                                v-model="form.custom_schema"
                                rows="4"
                                class="w-full rounded border px-3 py-2 font-mono text-sm"
                                placeholder='{"@context": "https://schema.org", ...}'
                            ></textarea>
                        </div>
                    </div>
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
                        Update Product
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
import { reactive, watch, computed } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps({
    product: Object,
    categories: Array,
});

const formatSlug = (value) => {
    return value
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^a-z0-9-]/g, '')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
};

const form = reactive({
    name: props.product.name,
    slug: props.product.slug,
    description: props.product.description,
    short_description: props.product.short_description,
    price: props.product.price,
    compare_price: props.product.compare_price,
    category_id: props.product.category_id,
    sku: props.product.sku,
    stock_quantity: props.product.stock_quantity,
    low_stock_threshold: props.product.low_stock_threshold,
    is_active: props.product.is_active,
    is_featured: props.product.is_featured,
    image: props.product.image,
    meta_title: props.product.meta_title || '',
    meta_description: props.product.meta_description || '',
    meta_keywords: props.product.meta_keywords || '',
    custom_schema: props.product.custom_schema || '',
});

watch(
    () => form.name,
    (newName) => {
        if (
            !form.slug ||
            form.slug === formatSlug(form.name.slice(0, form.slug.length))
        ) {
            form.slug = formatSlug(newName);
        }
    },
);

const slugError = computed(() => {
    if (!form.slug) return '';
    if (!/^[a-z0-9-]+$/.test(form.slug)) {
        return 'Only lowercase letters (a-z), numbers, and hyphens are allowed';
    }
    return '';
});

watch(
    () => form.slug,
    (newSlug) => {
        const formatted = newSlug
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9-]/g, '');
        if (newSlug !== formatted) {
            form.slug = formatted;
        }
    },
);

const submit = async () => {
    try {
        await router.put(`/admin/products/${props.product.id}`, form);
    } catch (error) {
        alert('Failed to update product');
    }
};
</script>
