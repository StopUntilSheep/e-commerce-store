import Header from "@/Components/Layout/Header";
import Footer from "@/Components/Layout/Footer";

export default function FrontendLayout({ auth, children }) {
    return (
        <div className="bg-gray-50">
            <div className="flex flex-col min-h-screen">
                <Header auth={auth} />
                <main className="flex justify-center flex-grow bg-red-200">
                    <div className="container bg-white flex flex-col gap-4 p-4">
                        {children}
                    </div>
                </main>
                <Footer />
            </div>
        </div>
    );
}
