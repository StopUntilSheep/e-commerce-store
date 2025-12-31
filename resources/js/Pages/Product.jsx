import FrontendLayout from "@/Layouts/FrontendLayout";
import { Head, Link } from "@inertiajs/react";

export default function Product({ auth, product }) {
    return (
        <>
            <Head title={product.name} />
            <FrontendLayout auth={auth}>
                <div>
                    <Link
                        href={`/`}
                        className="transition hover:text-violet-700"
                    >
                        Home
                    </Link>
                    <Link
                        href={`/categories/${product.category.slug}`}
                        className="transition hover:text-violet-700 before:content-['>'] before:px-1 before:hover:text-black"
                    >
                        {product.category.name}
                    </Link>
                    <Link
                        href={`/products/${product.slug}`}
                        className="transition hover:text-violet-700 before:content-['>'] before:px-1 before:hover:text-black"
                    >
                        {product.name}
                    </Link>
                </div>

                <div className="flex items-end gap-4">
                    <h1 className="text-3xl font-bold">{product.name}</h1>
                    <span className="font-bold">
                        {product.is_in_stock ? "In Stock" : "Out of Stock"}
                    </span>
                    {product.average_rating ? (
                        <ul className="product-rating">
                            <li>
                                <div
                                    class="stars"
                                    style={{
                                        "--w": `${
                                            product.average_rating * 20
                                        }%`,
                                    }}
                                ></div>
                            </li>
                        </ul>
                    ) : (
                        <span>(No reviews)</span>
                    )}
                </div>
                <div>
                    <p>{product.description}</p>
                    <p>{product.formatted_price}</p>
                    {product.variants?.length > 0 && (
                        <p>
                            <select name="variant" id="variant">
                                {product.variants.map((variant) => {
                                    return (
                                        <option value={variant.sku}>
                                            {variant.name}
                                        </option>
                                    );
                                })}
                            </select>
                        </p>
                    )}
                </div>
                {/* <pre>{JSON.stringify(product, null, 2)}</pre> */}
            </FrontendLayout>
        </>
    );
}
