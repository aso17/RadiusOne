import axios from "axios";
import { showToast } from "../utils/Toast";
// Import helper storage yang sudah kita buat sebelumnya
import { getWithExpiry } from "../utils/SetWithExpiry";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || "http://localhost:8000/api",
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// --- Request Interceptor ---
api.interceptors.request.use(
  (config) => {
    /**
     * PERBAIKAN:
     * Jangan gunakan localStorage.getItem("access_token") langsung.
     * Gunakan getWithExpiry agar mendapatkan string token murni
     * dan mengecek apakah sudah kadaluarsa sebelum request dikirim.
     */
    const token = getWithExpiry("access_token");

    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error),
);

// --- Response Interceptor ---
api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    const { response } = error;
    const message = response?.data?.message || "Terjadi kesalahan pada sistem";

    if (response) {
      switch (response.status) {
        case 401:
          // Unauthorized: Terjadi jika token salah, expired di server, atau salah format
          showToast("Sesi habis, silakan login kembali", "error");

          // Bersihkan semua data karena sesi sudah tidak valid
          localStorage.clear();

          // Redirect ke login jika tidak sedang di halaman login
          if (window.location.pathname !== "/login") {
            window.location.href = "/login";
          }
          break;

        case 403:
          showToast("Anda tidak memiliki akses (Forbidden)", "error");
          break;

        case 422:
          // Error validasi dari Laravel (misal email sudah terdaftar)
          showToast(message, "error");
          break;

        case 500:
          showToast(
            "Server sedang bermasalah (Internal Server Error)",
            "error",
          );
          break;

        default:
          showToast(message, "error");
          break;
      }
    } else if (error.request) {
      // Masalah koneksi jaringan
      showToast("Koneksi gagal. Periksa jaringan internet Anda.", "error");
    } else {
      showToast("Terjadi kesalahan yang tidak terduga.", "error");
    }

    return Promise.reject(error);
  },
);

export default api;
