<template>
    <div class="flex items-center gap-1">
        <button
            v-for="star in 5"
            :key="star"
            @click="interactive && $emit('update:modelValue', star)"
            :disabled="!interactive"
            class="focus:outline-none"
            :class="interactive ? 'cursor-pointer' : 'cursor-default'"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                :class="
                    star <= displayValue ? 'text-yellow-400' : 'text-gray-300'
                "
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                />
            </svg>
        </button>
        <span v-if="showCount" class="ml-1 text-sm text-gray-500"
            >({{ count }})</span
        >
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        default: 0,
    },
    count: {
        type: Number,
        default: 0,
    },
    interactive: {
        type: Boolean,
        default: false,
    },
    showCount: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['update:modelValue']);

const displayValue = computed(() => {
    return Math.round(props.modelValue);
});
</script>
