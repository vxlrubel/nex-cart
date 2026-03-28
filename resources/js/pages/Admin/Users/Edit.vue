<script setup lang="ts">
import { reactive } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
    };
}>();

const form = reactive({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
});

const submit = async () => {
    try {
        await router.put(`/admin/users/${props.user.id}`, form);
    } catch (error) {
        alert('Failed to update user');
    }
};
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <Link
                href="/admin/users"
                class="flex items-center gap-1 text-muted-foreground hover:text-foreground"
            >
                ← Back to Users
            </Link>
        </div>

        <h1 class="mb-6 text-2xl font-semibold">Edit User</h1>

        <form
            @submit.prevent="submit"
            class="max-w-2xl space-y-6 rounded-lg border bg-card p-6 shadow-sm"
        >
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
                <label class="mb-2 block text-sm font-medium">Email *</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="w-full rounded border bg-background px-3 py-2"
                    required
                />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium"
                    >New Password</label
                >
                <input
                    v-model="form.password"
                    type="password"
                    class="w-full rounded border bg-background px-3 py-2"
                    placeholder="Leave blank to keep current password"
                />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium"
                    >Confirm Password</label
                >
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    class="w-full rounded border bg-background px-3 py-2"
                />
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="rounded bg-primary px-6 py-2 text-primary-foreground hover:bg-primary/90"
                >
                    Update User
                </button>
                <Link
                    href="/admin/users"
                    class="rounded bg-muted px-6 py-2 hover:bg-muted/80"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </div>
</template>
