import SectionHeading from "@/Components/SectionHeading";

export default function Section({ children, title }) {
    return (
        <div className="flex flex-col gap-6">
            <SectionHeading title={title} />
            {children}
        </div>
    );
}
