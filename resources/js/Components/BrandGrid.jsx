import { Link } from "@inertiajs/react";
import Section from "@/Components/Layout/Section";

export default function BrandGrid({ title, brands }) {
    return (
        <Section title={title}>
            <div className="grid grid-cols-2 md:grid-cols-6 lg:grid-cols-8 2xl:grid-cols-12 gap-4">
                {brands.map((brand) => (
                    <div className="flex flex-col gap-2" key={brand.id}>
                        {brand.name}
                    </div>
                ))}
            </div>
        </Section>
    );
}
