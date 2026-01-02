import { useContext, useState } from "react";
import { ProjectContext } from "../../context/ProjectContext";
import LoadingDots from "../../components/common/LoadingDots";
import LoginForm from "./LoginForm";

export default function Login() {
    const { project, loading } = useContext(ProjectContext);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleLogin = async (values) => {
        setIsSubmitting(true);
        try {
            // simulasi API
            await new Promise((r) => setTimeout(r, 1500));
            console.log("Login success", values);
        } catch (error) {
            console.error(error);
        } finally {
            setIsSubmitting(false);
        }
    };

    if (loading) return <LoadingDots />;

    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-slate-100 px-4">
            <div className="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
                {/* Logo */}
                <div className="flex justify-center mb-4">
                    <img
                        src={project.logo_url}
                        alt={project.name}
                        className="h-16 md:h-20 object-contain"
                    />
                </div>

                <h1
                    className="text-center text-xl font-bold mb-6"
                    style={{ color: project.primary_color }}
                >
                    {project.name}
                </h1>

                <LoginForm
                    project={project}
                    isSubmitting={isSubmitting}
                    onSubmit={handleLogin}
                />
            </div>

            <footer className="mt-6 text-sm text-gray-500">
                © {new Date().getFullYear()} {project.name}. All rights reserved.
            </footer>
        </div>
    );
}
