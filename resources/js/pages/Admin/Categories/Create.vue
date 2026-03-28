<script setup lang="ts">
import { reactive } from 'vue';
import { router, Link } from '@inertiajs/vue3';

defineProps<{
    parentCategories: {
        id: number;
        name: string;
    }[];
}>();

const form = reactive({
    name: '',
    slug: '',
    description: '',
    parent_id: null,
    image: '',
    is_active: true,
    order: 0,
});

const submit = async () => {
    try {
        await router.post('/admin/categories', form);
    } catch (error) {
        alert('Failed to create category');
    }
};
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <Link
                href="/admin/categories"
                class="flex items-center gap-1 text-muted-foreground hover:text-foreground"
            >
                ← Back to Categories
            </Link>
        </div>

        <h1 class="mb-6 text-2xl font-semibold">Add Category</h1>

        <form
            @submit.prevent="submit"
            class="max-w-2xl space-y-6 rounded-lg border bg-card p-6 shadow-sm"
        >
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium">Name *</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full rounded border bg-background px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Slug</label>
                    <input
                        v-model="form.slug"
                        type="text"
                        class="w-full rounded border bg-background px-3 py-2"
                    />
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium"
                    >Parent Category</label
                >
                <select
                    v-model="form.parent_id"
                    class="w-full rounded border bg-background px-3 py-2"
                >
                    <option :value="null">No Parent</option>
                    <option
                        v-for="cat in parentCategories"
                        :key="cat.id"
                        :value="cat.id"
                    >
                        {{ cat.name }}
                    </option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">Image URL</label>
                <input
                    v-model="form.image"
                    type="text"
                    class="w-full rounded border bg-background px-3 py-2"
                />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium"
                    >Description</label
                >
                <textarea
                    v-model="form.description"
                    rows="3"
                    class="w-full rounded border bg-background px-3 py-2"
                ></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium">Order</label>
                    <input
                        v-model="form.order"
                        type="number"
                        min="0"
                        class="w-full rounded border bg-background px-3 py-2"
                    />
                </div>
                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="rounded"
                        />
                        <span class="text-sm font-medium">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="rounded bg-primary px-6 py-2 text-primary-foreground hover:bg-primary/90"
                >
                    Create Category
                </button>
                <Link
                    href="/admin/categories"
                    class="rounded bg-muted px-6 py-2 hover:bg-muted/80"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </div>
</template>
