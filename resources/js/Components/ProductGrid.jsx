import { Link } from "@inertiajs/react";
import productPlaceholderImage from "../../images/placeholder.jpg";
import Section from "@/Components/Layout/Section";
import AddToBasketButton from "@/Components/AddToBasketButton";

const BROKEN_IMAGE_URL_SVG =
    "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI2NjY2NjYyIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMjAiIGZpbGw9IiM2NjY2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4=";

export default function ProductGrid({ auth, title, products }) {
    return (
        <Section title={title}>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-x-8 gap-y-16">
                {products.map((product) => {
                    const hasVariants = product.variants?.length;
                    return (
                        <div className="flex flex-col gap-2" key={product.id}>
                            <div>
                                <img
                                    src={
                                        product.main_image ||
                                        productPlaceholderImage
                                    }
                                    alt={product.main_image_alt_text}
                                    onError={(e) => {
                                        // If image fails to load (broken link), use placeholder
                                        e.target.src = BROKEN_IMAGE_URL_SVG;
                                        e.target.onerror = null; // Prevent infinite loop
                                    }}
                                    className="w-full object-cover"
                                />
                            </div>
                            <div className="flex text-lg">
                                <Link
                                    href={`/products/${product.slug}${
                                        product.sku ? "?sku=" + product.sku : ""
                                    }`}
                                    className="flex-grow"
                                >
                                    {product.name}
                                </Link>
                                <span className="flex-grow-0">
                                    {product.formatted_price}
                                </span>
                            </div>
                            <div className="flex-1">{hasVariants ? product.variants[0].name : null}</div>
                            <div className="text-sm">
                                <p>Category: {product.category}</p>
                                <p>Brand: {product.brand}</p>
                            </div>
                            {/* {auth.user && ( */}
                            <div>
                                <AddToBasketButton
                                    productId={product.id}
                                    productVariantId={
                                        hasVariants
                                            ? product.variants[0].id
                                            : null
                                    }
                                />
                            </div>
                            {/* )} */}
                        </div>
                    );
                })}
            </div>
        </Section>
    );
}
