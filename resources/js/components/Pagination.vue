<template>
    <div v-if="links.length > 3" class="flex items-center gap-1">
        <template v-for="(link, index) in links" :key="index">
            <Link
                v-if="link.url"
                :href="link.url"
                :class="[
                    'rounded px-3 py-1',
                    link.active
                        ? 'bg-indigo-600 text-white'
                        : 'text-gray-700 hover:bg-gray-100',
                ]"
                v-html="link.label"
            />
            <span v-else class="px-3 py-1 text-gray-400" v-html="link.label" />
        </template>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>
