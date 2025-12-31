import { Link } from "@inertiajs/react";
import logo from "../../../images/logoipsum-360-white.svg";

export default function Header({ auth }) {
    return (
        <header className="flex justify-center flex-grow-0 bg-violet-900 text-white font-bold">
            <div className="container flex justify-between items-center">
                <div>
                    <img className="w-44 object-cover" src={logo} alt="Company Logo" />
                </div>
                <nav className="flex justify-end items-center gap-4">
                    {auth.user && auth.user.role ? (
                        auth.user.role === "admin" ? (
                            <Link
                                href={route("dashboard")}
                                className="py-2 transition hover:text-violet-300"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                {`Logged in as ${auth.user.email}`}
                                <Link
                                    href={route("logout")}
                                    className="py-2 transition hover:text-violet-300"
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
                                className="py-2 transition hover:text-violet-300"
                            >
                                Log in
                            </Link>
                            <Link
                                href={route("register")}
                                className="py-2 transition hover:text-violet-300"
                            >
                                Register
                            </Link>
                        </>
                    )}
                </nav>
            </div>
        </header>
    );
}
