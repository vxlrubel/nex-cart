import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    roles: Array<{ id: number; name: string; slug: string }>;
}

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>(null);
    const permissions = ref<string[]>([]);
    const isAuthenticated = ref(false);

    const hasRole = (roleSlug: string): boolean => {
        return (
            user.value?.roles?.some((role) => role.slug === roleSlug) ?? false
        );
    };

    const hasPermission = (permission: string): boolean => {
        return permissions.value.includes(permission);
    };

    const can = (permission: string): boolean => {
        return hasPermission(permission);
    };

    const setUser = (userData: User | null) => {
        user.value = userData;
        isAuthenticated.value = !!userData;
        if (userData?.roles) {
            permissions.value = userData.roles.flatMap(
                (role: any) => role.permissions?.map((p: any) => p.slug) ?? [],
            );
        }
    };

    const logout = async () => {
        try {
            await router.post('/logout');
            user.value = null;
            permissions.value = [];
            isAuthenticated.value = false;
        } catch (error) {
            console.error('Logout failed:', error);
        }
    };

    return {
        user,
        permissions,
        isAuthenticated,
        hasRole,
        hasPermission,
        can,
        setUser,
        logout,
    };
});
