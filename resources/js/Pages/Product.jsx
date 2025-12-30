import FrontendLayout from "@/Layouts/FrontendLayout";
import { Head } from "@inertiajs/react";

export default function Product({ auth, product }) {
    return (
        <>
            <Head title={product.name} />
            <FrontendLayout auth={auth}>
                <h1 className="text-3xl font-bold">{product.name}</h1>
            </FrontendLayout>
        </>
    );
}
