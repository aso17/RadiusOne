import { createContext, useContext, useEffect, useState, useRef } from "react";
import {
  login as loginApi,
  logout as logoutApi,
  getMe,
  getMenus,
} from "../services/AuthService";

import { getProjectInfo } from "../services/projectService";

const AuthContext = createContext(null);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [menus, setMenus] = useState([]);
  const [loading, setLoading] = useState(true);
  const isInitialized = useRef(false);
  const loadUser = async () => {
    try {
      const { data } = await getMe();
      setUser(data);
      return data;
    } catch (err) {
      await logout();
      return null;
    }
  };

  const loadMenus = async () => {
    try {
      const { data } = await getMenus();
      const menuData = data.menus || [];
      setMenus(menuData);
      return menuData;
    } catch (err) {
      setMenus([]);
      return [];
    }
  };

  const login = async (credentials) => {
    setLoading(true);
    try {
      const { data } = await loginApi(credentials);

      localStorage.setItem("access_token", data.token);
      localStorage.setItem("user", JSON.stringify(data.user));
      // 🔑 simpan branding tenant
      localStorage.setItem("project_name", data.user.tenant.slug);
      localStorage.setItem("project_logo", data.user.tenant.logo);

      setUser(data.user);

      await loadMenus();
    } finally {
      setLoading(false);
    }
  };

  const logout = async () => {
    try {
      await logoutApi();
    } catch (err) {
      console.error("Logout API failed", err);
    } finally {
      localStorage.removeItem("access_token");
      localStorage.removeItem("user");
      localStorage.removeItem("project_name");
      localStorage.removeItem("project_logo");

      setUser(null);
      setMenus([]);
      // Reset ref agar jika login kembali tanpa reload, siklus init bisa diulang jika perlu
      isInitialized.current = false;
      await getProjectInfo();
    }
  };

  useEffect(() => {
    if (isInitialized.current) return;

    const token = localStorage.getItem("access_token");

    if (!token) {
      setLoading(false);
      isInitialized.current = true;
      return;
    }

    const initAuth = async () => {
      try {
        isInitialized.current = true;
        // Ambil data secara paralel saat reload/buka pertama kali
        await Promise.all([loadUser(), loadMenus()]);
      } catch (err) {
        console.error("Initialization failed", err);
      } finally {
        setLoading(false);
      }
    };

    initAuth();
  }, []);

  return (
    <AuthContext.Provider
      value={{
        user,
        menus,
        loading,
        isAuthenticated: !!user,
        login,
        logout,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
