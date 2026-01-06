import { createContext, useContext, useEffect, useState } from "react";
import {
  login as loginApi,
  logout as logoutApi,
  getMe,
  getMenus,
} from "../services/AuthService";

const AuthContext = createContext(null);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [menus, setMenus] = useState([]);
  const [loading, setLoading] = useState(true);

  const isAuthenticated = !!user;

  const loadUser = async () => {
    try {
      const { data } = await getMe();
      setUser(data);
    } catch {
      logout();
    }
  };

  const loadMenus = async () => {
    try {
      const { data } = await getMenus();
      setMenus(data.menus);
    } catch (err) {
      console.error("Failed load menus", err);
    }
  };

  const login = async (credentials) => {
    const { data } = await loginApi(credentials);

    localStorage.setItem("access_token", data.token);
    localStorage.setItem("user", JSON.stringify(data.user));

    setUser(data.user);
    await loadMenus();
  };

  const logout = async () => {
    try {
      await logoutApi();
    } catch {}

    localStorage.removeItem("access_token");
    localStorage.removeItem("user");

    setUser(null);
    setMenus([]);
  };

  useEffect(() => {
    const token = localStorage.getItem("access_token");

    if (!token) {
      setLoading(false);
      return;
    }

    Promise.all([loadUser(), loadMenus()]).finally(() => {
      setLoading(false);
    });
  }, []);

  return (
    <AuthContext.Provider
      value={{
        user,
        menus,
        loading,
        isAuthenticated,
        login,
        logout,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
