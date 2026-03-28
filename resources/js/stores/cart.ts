import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

interface CartItem {
    id: number;
    product_id: number;
    variant_id: number | null;
    quantity: number;
    price: number;
    total: number;
    product?: {
        id: number;
        name: string;
        slug: string;
        image: string | null;
        stock_quantity: number;
    };
    variant?: {
        id: number;
        name: string;
    };
}

interface Cart {
    id: number;
    items: CartItem[];
    subtotal: number;
    tax: number;
    total: number;
}

export const useCartStore = defineStore('cart', () => {
    const cart = ref<Cart | null>(null);
    const isLoading = ref(false);

    const itemCount = computed(() => {
        return (
            cart.value?.items?.reduce((sum, item) => sum + item.quantity, 0) ??
            0
        );
    });

    const setCart = (cartData: Cart | null) => {
        cart.value = cartData;
    };

    const addItem = async (
        productId: number,
        quantity: number = 1,
        variantId: number | null = null,
    ) => {
        isLoading.value = true;
        try {
            const response = await router.post('/cart/add', {
                product_id: productId,
                quantity,
                variant_id: variantId,
            });
            if (response.props.cart) {
                cart.value = response.props.cart;
            }
            return true;
        } catch (error) {
            console.error('Failed to add item:', error);
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const updateQuantity = async (itemId: number, quantity: number) => {
        isLoading.value = true;
        try {
            const response = await router.put(`/cart/${itemId}`, { quantity });
            if (response.props.cart) {
                cart.value = response.props.cart;
            }
            return true;
        } catch (error) {
            console.error('Failed to update quantity:', error);
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const removeItem = async (itemId: number) => {
        isLoading.value = true;
        try {
            const response = await router.delete(`/cart/${itemId}`);
            if (response.props.cart) {
                cart.value = response.props.cart;
            }
            return true;
        } catch (error) {
            console.error('Failed to remove item:', error);
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const clearCart = async () => {
        isLoading.value = true;
        try {
            const response = await router.delete('/cart/clear');
            if (response.props.cart) {
                cart.value = response.props.cart;
            }
            return true;
        } catch (error) {
            console.error('Failed to clear cart:', error);
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        cart,
        isLoading,
        itemCount,
        setCart,
        addItem,
        updateQuantity,
        removeItem,
        clearCart,
    };
});
