import { useState } from "react";
import { NavLink, useLocation } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import { icons } from "../utils/Icons";

export default function Sidebar() {
  const { menus } = useAuth();
  const [open, setOpen] = useState(null);
  const location = useLocation();

  return (
    <aside className="w-64 bg-white border-r border-slate-200 min-h-screen flex flex-col font-sans antialiased">
      {/* LOGO */}
      <div className="h-16 flex items-center px-6 border-b border-slate-100/80">
        <span className="text-lg font-extrabold tracking-tighter text-slate-900">
          {localStorage.getItem("project_name") || "Application"}
        </span>
      </div>

      {/* NAVIGATION */}
      <nav className="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        {menus.map((menu) => {
          const Icon = icons[menu.icon];
          const Chevron = icons.chevron;
          const DotIcon = icons.dot;
          const hasChild = menu.children?.length > 0;
          const isOpen = open === menu.id;

          return (
            <div key={menu.id}>
              {/* SINGLE MENU */}
              {!hasChild ? (
                <NavLink
                  to={menu.route}
                  className={({ isActive }) =>
                    `flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition-all
                    ${
                      isActive
                        ? "bg-primary text-white shadow-sm font-bold"
                        : "text-slate-900 hover:bg-slate-50 hover:text-primary font-semibold"
                    }`
                  }
                >
                  {Icon && <Icon size={18} strokeWidth={2.5} />}
                  <span>{menu.name}</span>
                </NavLink>
              ) : (
                /* GROUP MENU */
                <div className="space-y-1">
                  <button
                    onClick={() => setOpen(isOpen ? null : menu.id)}
                    className={`w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs transition-all
                    ${
                      isOpen
                        ? "bg-slate-50 text-primary font-bold"
                        : "text-slate-900 hover:bg-slate-50 hover:text-primary font-semibold"
                    }`}
                  >
                    <div className="flex items-center gap-3">
                      {Icon && (
                        <Icon
                          size={18}
                          strokeWidth={2.5}
                          className={isOpen ? "text-primary" : ""}
                        />
                      )}
                      <span>{menu.name}</span>
                    </div>
                    {Chevron && (
                      <Chevron
                        size={12}
                        className={`transition-transform ${
                          isOpen ? "rotate-180 text-primary" : "text-slate-400"
                        }`}
                      />
                    )}
                  </button>

                  {/* CHILD MENU */}
                  <div
                    className={`overflow-hidden transition-all duration-300 ${
                      isOpen ? "max-h-96 opacity-100" : "max-h-0 opacity-0"
                    }`}
                  >
                    <div className="ml-5 mt-1 pl-4 border-l-2 border-slate-100 space-y-1">
                      {menu.children.map((sub) => {
                        const isActive = location.pathname === sub.route;

                        return (
                          <NavLink
                            key={sub.id}
                            to={sub.route}
                            className={`flex items-center gap-3 px-3 py-1.5 rounded-lg text-[12px] transition-all
                              ${
                                isActive
                                  ? "text-primary font-bold"
                                  : "text-slate-500 hover:text-slate-900 font-medium"
                              }`}
                          >
                            {DotIcon && (
                              <DotIcon
                                size={10} // 🔴 DOT BESAR
                                strokeWidth={3}
                                className={
                                  isActive ? "text-primary" : "text-slate-400"
                                }
                              />
                            )}
                            <span>{sub.name}</span>
                          </NavLink>
                        );
                      })}
                    </div>
                  </div>
                </div>
              )}
            </div>
          );
        })}
      </nav>
    </aside>
  );
}
