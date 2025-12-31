export default function Hero({ categories }) {
    return (
        <div className="flex justify-center bg-violet-300 py-32">
            <div className="grid grid-cols-2 md:grid-cols-6 lg:grid-cols-8 2xl:grid-cols-12 gap-4">
                {categories.map((category) => (
                    <div className="flex flex-col gap-2" key={category.id}>
                        {category.name}
                    </div>
                ))}
            </div>
        </div>
    );
}
