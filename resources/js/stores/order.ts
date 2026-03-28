import { defineStore } from 'pinia';
import { ref } from 'vue';

interface OrderItem {
    id: number;
    product_id: number;
    variant_id: number | null;
    product_name: string;
    variant_name: string | null;
    price: number;
    quantity: number;
    total: number;
}

interface Order {
    id: number;
    order_number: string;
    status: string;
    payment_status: string;
    payment_method: string;
    subtotal: number;
    tax: number;
    shipping_cost: number;
    discount: number;
    total: number;
    items: OrderItem[];
    created_at: string;
}

export const useOrderStore = defineStore('order', () => {
    const orders = ref<Order[]>([]);
    const currentOrder = ref<Order | null>(null);
    const isLoading = ref(false);

    const setOrders = (data: Order[]) => {
        orders.value = data;
    };

    const setCurrentOrder = (data: Order | null) => {
        currentOrder.value = data;
    };

    const canCancel = (order: Order): boolean => {
        return ['pending', 'processing'].includes(order.status);
    };

    const getStatusClass = (status: string): string => {
        const classes: Record<string, string> = {
            pending: 'bg-yellow-100 text-yellow-800',
            processing: 'bg-blue-100 text-blue-800',
            shipped: 'bg-purple-100 text-purple-800',
            delivered: 'bg-green-100 text-green-800',
            cancelled: 'bg-red-100 text-red-800',
            refunded: 'bg-gray-100 text-gray-800',
        };
        return classes[status] || 'bg-gray-100 text-gray-800';
    };

    return {
        orders,
        currentOrder,
        isLoading,
        setOrders,
        setCurrentOrder,
        canCancel,
        getStatusClass,
    };
});
