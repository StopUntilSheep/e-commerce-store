import { Head, Link } from "@inertiajs/react";

export default function Welcome({
    auth,
    featuredProducts,
    newArrivals,
    categories,
}) {
    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50">
                <div className="flex flex-col min-h-screen">
                    <header className="flex justify-center flex-grow-0 bg-yellow-200 border-b border-black">
                        <div className="container flex justify-between items-center bg-white">
                            <div>LOGO</div>
                            <nav className="flex justify-end items-center gap-4">
                                {auth.user && auth.user.role ? (
                                    auth.user.role === "admin" ? (
                                        <Link
                                            href={route("dashboard")}
                                            className="py-2 transition hover:text-black/70"
                                        >
                                            Dashboard
                                        </Link>
                                    ) : (
                                        <>
                                            {`Logged in as ${auth.user.email}`}
                                            <Link
                                                href={route("logout")}
                                                className="py-2 transition hover:text-black/70"
                                                method="post"
                                                as="button"
                                            >
                                                Log Out
                                            </Link>
                                        </>
                                    )
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="py-2 transition hover:text-black/70"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="py-2 transition hover:text-black/70"
                                        >
                                            Register
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </div>
                    </header>

                    <main className="flex justify-center flex-grow bg-red-200">
                        <div className="container bg-white">
                            {featuredProducts.map((product) => (
                                <div>{`${product.name}, ${product.formatted_price}, ${product.category}, ${product.brand}`}</div>
                            ))}
                        </div>
                    </main>

                    <footer className="flex justify-center flex-grow-0 bg-blue-200 border-t border-black">
                        <div className="container bg-white">
                            Footer goes here
                        </div>
                    </footer>
                </div>
            </div>
        </>
    );
}
