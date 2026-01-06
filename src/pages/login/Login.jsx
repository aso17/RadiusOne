import { useContext, useState } from "react";
import { useNavigate } from "react-router-dom";
import { ProjectContext } from "../../context/ProjectContext";
import LoadingDots from "../../components/common/LoadingDots";
import { login } from "../../services/AuthService";
import LoginForm from "./LoginForm";

export default function Login() {
  const { project, loading } = useContext(ProjectContext);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const navigate = useNavigate();
  const handleLogin = async (values) => {
    setIsSubmitting(true);

    try {
      console.log("Login values:", values);

      const response = await login(values);
      console.log("Response data:", response.data);

      // Pastikan data token dan user ada
      const { token, user } = response.data;

      if (!token || !user) {
        throw new Error("Token atau user tidak ditemukan di response");
      }

      // Simpan ke localStorage
      localStorage.setItem("access_token", token);
      localStorage.setItem("user", JSON.stringify(user));

      // Redirect ke halaman utama
      navigate("/");
    } catch (error) {
      console.error("Login failed", error);

      // Ambil pesan error dari Laravel jika ada
      const message =
        error.response?.data?.errors?.email?.[0] || // pesan validasi email/password salah
        error.response?.data?.message || // fallback Laravel
        error.message || // fallback JS error
        "Login gagal"; // fallback umum

      alert(message);
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
