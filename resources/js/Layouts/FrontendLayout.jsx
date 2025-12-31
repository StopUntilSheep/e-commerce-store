import Header from "@/Components/Layout/Header";
import Footer from "@/Components/Layout/Footer";

export default function FrontendLayout({ auth, hero, children }) {
    return (
        <div className="flex flex-col min-h-screen">
            <Header auth={auth} />
            {hero && hero}
            <main className="flex justify-center flex-grow">
                <div className="container flex flex-col gap-16 py-16">
                    {children}
                </div>
            </main>
            <Footer />
        </div>
    );
}
