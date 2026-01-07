import { router } from "@inertiajs/react";
import { useState } from "react";

export default function AddToBasketButton({ product }) {
    const [isLoading, setIsLoading] = useState(false);

    const add = () => {
        setIsLoading(true);
        (() =>
            setTimeout(() => {
                // timeout for testing loader
                router.post(
                    route("cart.add", {
                        product: product.id,
                        productVariant: product.variants[0]?.id,
                    }),
                    {},
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            // Show success message
                            // Update cart count in state/header
                        },
                        onError: (errors) => {
                            // Handle validation errors
                            console.error(errors);
                        },
                        onFinish: () => {
                            setIsLoading(false);
                        },
                    }
                );
            }, 2000))(); // timeout for testing loader
    };

    return (
        <button
            onClick={add}
            className="w-full bg-green-700 rounded text-white font-bold py-2 px-6"
        >
            {isLoading
                ? "Loading..."
                : product.cart_quantity > 0
                    ? "In Basket!"
                    : "Add to Basket"}
        </button>
    );
}
