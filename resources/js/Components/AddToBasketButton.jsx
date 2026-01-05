import { router } from "@inertiajs/react";

export default function AddToBasketButton({
    productId,
    productVariantId = null,
}) {

    const add = () => {
        router.post(
            route("cart.add", {
                product: productId,
                productVariant: productVariantId,
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
            }
        );
    };

    return (
        <button
            onClick={add}
            className="w-full bg-green-700 rounded text-white font-bold py-2 px-6"
        >
            Add to Basket
        </button>
    );
}
