<script setup lang="ts">
import { Star } from 'lucide-vue-next';

defineProps<{
    reviews: Array<{
        id: number;
        rating: number;
        comment: string;
        is_approved: boolean;
        product: { name: string };
        user: { name: string };
        created_at: string;
    }>;
}>();

const statusClass = (approved: boolean) => {
    return approved
        ? 'bg-green-100 text-green-800'
        : 'bg-yellow-100 text-yellow-800';
};
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">Reviews</h1>
        </div>

        <div class="rounded-lg border bg-card shadow-sm">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Product
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Customer
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Rating
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Comment
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium">
                            Date
                        </th>
                        <th class="px-4 py-3 text-right text-sm font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="review in reviews || []"
                        :key="review.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3 font-medium">
                            {{ review.product.name }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ review.user.name }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1">
                                <Star
                                    class="h-4 w-4 fill-yellow-400 text-yellow-400"
                                    v-for="i in review.rating"
                                    :key="i"
                                />
                                <Star
                                    class="h-4 w-4 text-gray-300"
                                    v-for="i in 5 - review.rating"
                                    :key="'empty-' + i"
                                />
                                <span class="ml-1 text-sm"
                                    >({{ review.rating }}/5)</span
                                >
                            </div>
                        </td>
                        <td
                            class="max-w-xs truncate px-4 py-3 text-muted-foreground"
                        >
                            {{ review.comment }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                :class="statusClass(review.is_approved)"
                                class="rounded px-2 py-1 text-xs"
                            >
                                {{
                                    review.is_approved ? 'Approved' : 'Pending'
                                }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{
                                new Date(review.created_at).toLocaleDateString(
                                    'en-US',
                                )
                            }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button
                                v-if="!review.is_approved"
                                class="rounded bg-green-100 px-2 py-1 text-xs text-green-800 hover:bg-green-200"
                            >
                                Approve
                            </button>
                            <button
                                class="ml-2 rounded bg-red-100 px-2 py-1 text-xs text-red-800 hover:bg-red-200"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
