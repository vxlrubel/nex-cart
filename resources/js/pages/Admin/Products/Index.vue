<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plus, Search, Pencil, ListFilter, Trash2, Eye } from 'lucide-vue-next';
import productRoutes from '@/routes/admin/products';
import type { Product } from '@/types';

defineProps<{
    products: Product[];
}>();
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center gap-4">
            <h1 class="text-2xl font-semibold">Products</h1>
            <Link
                :href="productRoutes?.create?.() || '#'"
                class="inline-flex items-center gap-2 border border-indigo-500 text-indigo-500 px-3 py-2 text-sm font-medium hover:border-indigo-700 hover:text-indigo-700"
            >
                <Plus class="h-4 w-4" />
                Add Product
            </Link>
        </div>

        <div class="rounded-lg border bg-card shadow-sm">
            <div class="flex items-center gap-4 border-b p-4 justify-between overflow-x-auto">

                <div class="flex-1 flex items-center gap-2">
                    <select class="h-9 border bg-background px-3 text-sm cursor-pointer">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="trash">Move to trash</option>
                    </select>

                    <button type="button" class="inline-flex items-center justify-center gap-2 border bg-indigo-500 border-indigo-500 text-white px-3 h-9 text-sm font-medium hover:border-indigo-700 hover:bg-indigo-700 cursor-pointer w-[100px]">
                        Apply
                    </button>

                    <div class="relative max-w-[200px] ml-4">
                        <ListFilter
                            class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                        />
                        <select class="h-9 w-full border bg-background pr-4 pl-8 text-sm cursor-pointer">
                            <option value="">All Categories</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                        </select>
                    </div>
                </div>
                <div class="relative max-w-[250px] flex-1">
                    <Search
                        class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                    />
                    <input
                        type="text"
                        placeholder="Search products..."
                        class="h-9 w-full border bg-background pr-4 pl-8 text-sm"
                    />
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="py-3 px-2 text-sm font-medium w-[50px] max-w-[50px] text-center select-none">
                            <label class="inline-flex justify-center items-center gap-1 cursor-pointer" for="select-all">
                                <input type="checkbox" id="select-all" /><span >All</span>
                            </label>
                            </th>
                            <th class="px-1 py-3 text-left text-sm font-medium w-[55px] max-w-[55px]">
                                Image
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium">
                                Name
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium">
                                SKU
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium">
                                Price
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium">
                                Stock
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium">
                                Status
                            </th>
                            <th class="px-4 py-3 text-center w-[125px] text-sm font-medium">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in products || []"
                            :key="product.id"
                            class="border-t"
                        >
                            <td class="py-1 px-2">
                                <input type="checkbox" />
                            </td>
                            <td class="px-1 py-3">
                                <img
                                    v-if="product.image"
                                    :src="product.image"
                                    :alt="product.name"
                                    class="h-10 w-10 rounded object-cover"
                                />
                                <div v-else class="h-10 w-10 rounded bg-muted" />
                            </td>
                            <td class="px-4 py-3 font-medium">
                                {{ product.name }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground">
                                {{ product.sku }}
                            </td>
                            <td class="px-4 py-3">${{ product.price }}</td>
                            <td class="px-4 py-3">{{ product.stock_quantity }}</td>
                            <td class="px-4 py-3">
                                <span
                                    :class="
                                        product.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800'
                                    "
                                    class="rounded p-1 text-xs w-[60px] text-center inline-block"
                                >
                                    {{ product.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link
                                        :href="
                                            product?.id
                                                ? `/products/${product.slug}`
                                                : '#'
                                        "
                                        class="rounded-full p-1 hover:bg-muted inline-flex items-center justify-center border border-neutral-500 text-neutral-500"
                                    >
                                        <Eye class="h-3 w-3" />
                                    </Link>
                                    <Link
                                        :href="
                                            product?.id
                                                ? `/admin/products/${product.id}/edit`
                                                : '#'
                                        "
                                        class="rounded-full p-1 hover:bg-muted inline-flex items-center justify-center border border-indigo-500 text-indigo-500"
                                    >
                                        <Pencil class="h-3 w-3" />
                                    </Link>
                                    <button
                                        class="rounded-full p-1 hover:bg-muted inline-flex items-center justify-center border border-red-500 text-red-500"
                                    >
                                        <Trash2 class="h-3 w-3" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
