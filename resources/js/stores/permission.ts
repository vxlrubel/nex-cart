import { defineStore } from 'pinia';
import { ref } from 'vue';

export const usePermissionStore = defineStore('permission', () => {
    const permissions = ref<string[]>([]);

    const hasPermission = (permission: string): boolean => {
        return permissions.value.includes(permission);
    };

    const can = (permission: string): boolean => {
        return hasPermission(permission);
    };

    const setPermissions = (perms: string[]) => {
        permissions.value = perms;
    };

    const addPermission = (permission: string) => {
        if (!permissions.value.includes(permission)) {
            permissions.value.push(permission);
        }
    };

    const removePermission = (permission: string) => {
        permissions.value = permissions.value.filter((p) => p !== permission);
    };

    return {
        permissions,
        hasPermission,
        can,
        setPermissions,
        addPermission,
        removePermission,
    };
});
