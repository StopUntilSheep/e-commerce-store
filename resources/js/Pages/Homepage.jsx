import FrontendLayout from "@/Layouts/FrontendLayout";
import Hero from "@/Components/Layout/Hero";
import ProductGrid from "@/Components/ProductGrid";
import BrandGrid from "@/Components/BrandGrid";
import { Head } from "@inertiajs/react";

export default function Homepage({
    auth,
    featuredProducts,
    newArrivals,
    categories,
    brands,
}) {
    return (
        <>
            <Head title="Homepage" />
            <FrontendLayout auth={auth} hero={<Hero categories={categories} />}>
                <ProductGrid
                    title="Featured Products"
                    auth={auth}
                    products={featuredProducts}
                />
                <BrandGrid title="Featured Brands" brands={brands} />
            </FrontendLayout>
        </>
    );
}
