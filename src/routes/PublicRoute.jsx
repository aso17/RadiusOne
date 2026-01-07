// GuestRoute.jsx atau PublicRoute.jsx
import { Navigate, Outlet } from "react-router-dom";

export default function PublicRoute() {
  const token = localStorage.getItem("access_token");

  // Jika sudah login, jangan kasih akses ke login form, lempar ke dashboard
  if (token) {
    return <Navigate to="/" replace />;
  }

  return <Outlet />;
}
