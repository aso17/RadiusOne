import { Menu, LogOut, User, Settings } from "lucide-react";
import { useState } from "react";
import { useAuth } from "../context/AuthContext"; // Sesuaikan path-nya
import { useNavigate } from "react-router-dom";

export default function Topbar({ onToggleSidebar }) {
  const [open, setOpen] = useState(false);
  const { logout, user } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    setOpen(false);
    navigate("/login");
  };

  return (
    <header className="h-16 bg-white border-b flex items-center justify-between px-6">
      {/* LEFT */}
      <div className="flex items-center gap-4">
        <button
          onClick={onToggleSidebar}
          className="p-2 rounded hover:bg-gray-100"
        >
          <Menu size={20} />
        </button>
        {/* <span className="font-semibold text-gray-700">Dashboard</span> */}
      </div>

      {/* RIGHT */}
      <div className="relative">
        <div
          onClick={() => setOpen(!open)}
          className="flex items-center gap-2 cursor-pointer"
        >
          <img
            src="https://i.pravatar.cc/40"
            className="w-8 h-8 rounded-full"
            alt="avatar"
          />
          {/* Gunakan nama dari context agar dinamis */}
          <span className="text-sm font-medium">{user?.name || "User"}</span>
        </div>

        {open && (
          <div className="absolute right-0 mt-2 w-44 bg-white border rounded shadow z-50">
            <button className="flex items-center gap-2 w-full px-4 py-2 text-sm hover:bg-gray-100">
              <User size={16} /> Profil
            </button>
            <button className="flex items-center gap-2 w-full px-4 py-2 text-sm hover:bg-gray-100">
              <Settings size={16} /> Pengaturan
            </button>
            <hr />
            <button
              onClick={handleLogout} // Tambahkan ini
              className="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
            >
              <LogOut size={16} /> Logout
            </button>
          </div>
        )}
      </div>
    </header>
  );
}
