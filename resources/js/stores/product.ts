import { defineStore } from 'pinia';
import { ref } from 'vue';

interface Product {
    id: number;
    name: string;
    slug: string;
    price: number;
    compare_price: number | null;
    image: string | null;
    images: string[] | null;
    stock_quantity: number;
    is_active: boolean;
    is_featured: boolean;
    category?: {
        id: number;
        name: string;
    };
}

export const useProductStore = defineStore('product', () => {
    const products = ref<Product[]>([]);
    const currentProduct = ref<Product | null>(null);
    const isLoading = ref(false);

    const setProducts = (data: Product[]) => {
        products.value = data;
    };

    const setCurrentProduct = (data: Product | null) => {
        currentProduct.value = data;
    };

    const isInStock = (product: Product): boolean => {
        return product.stock_quantity > 0;
    };

    const isOnSale = (product: Product): boolean => {
        return (
            product.compare_price !== null &&
            product.compare_price > product.price
        );
    };

    return {
        products,
        currentProduct,
        isLoading,
        setProducts,
        setCurrentProduct,
        isInStock,
        isOnSale,
    };
});
