import { useState } from "react";
import { NavLink } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import { icons } from "../utils/Icons";

export default function Sidebar() {
  const { menus } = useAuth();
  const [open, setOpen] = useState(null);

  return (
    <aside className="w-64 bg-white border-r border-slate-200 min-h-screen flex flex-col font-sans antialiased">
      {/* LOGO SECTION */}
      <div className="h-16 flex items-center px-6 border-b border-slate-100/80">
        <div className="flex items-center gap-2">
          {(() => {
            const name = localStorage.getItem("project_name") || "Application";

            return (
              <span className="text-lg font-extrabold tracking-tighter text-slate-900">
                {name}
              </span>
            );
          })()}
        </div>
      </div>

      {/* NAVIGATION */}
      <nav className="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        {menus.map((menu) => {
          const Icon = icons[menu.icon];
          const Chevron = icons.chevron;
          const hasChild = menu.children && menu.children.length > 0;
          const isOpen = open === menu.id;

          return (
            <div key={menu.id}>
              {!hasChild ? (
                /* SINGLE MENU - Smaller Text (xs), Clearer Color (slate-900) */
                <NavLink
                  to={menu.route}
                  className={({ isActive }) =>
                    `flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition-all duration-200 group
                    ${
                      isActive
                        ? "bg-primary text-white shadow-sm shadow-primary/30 font-bold"
                        : "text-slate-900 hover:bg-slate-50 hover:text-primary font-semibold"
                    }`
                  }
                >
                  {Icon && (
                    <Icon size={18} strokeWidth={2.5} className="shrink-0" />
                  )}
                  <span className="tracking-normal">{menu.name}</span>
                </NavLink>
              ) : (
                /* GROUP MENU */
                <div className="space-y-1">
                  <button
                    onClick={() => setOpen(isOpen ? null : menu.id)}
                    className={`w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs transition-all duration-200
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
                          className={isOpen ? "text-primary" : "text-slate-900"}
                        />
                      )}
                      <span className="tracking-normal">{menu.name}</span>
                    </div>
                    {Chevron && (
                      <Chevron
                        size={12}
                        className={`transition-transform duration-300 ${
                          isOpen ? "rotate-180 text-primary" : "text-slate-400"
                        }`}
                      />
                    )}
                  </button>

                  {/* CHILD MENU - Even smaller but distinct */}
                  <div
                    className={`overflow-hidden transition-all duration-300 ${
                      isOpen ? "max-h-96 opacity-100" : "max-h-0 opacity-0"
                    }`}
                  >
                    <div className="ml-5 mt-0.5 pl-4 border-l-2 border-slate-100 space-y-0.5">
                      {menu.children.map((sub) => (
                        <NavLink
                          key={sub.id}
                          to={sub.route}
                          className={({ isActive }) =>
                            `flex items-center px-3 py-1.5 rounded-lg text-[12px] transition-all
                            ${
                              isActive
                                ? "text-primary font-bold"
                                : "text-slate-500 hover:text-slate-900 font-medium"
                            }`
                          }
                        >
                          <span className="tracking-tight">{sub.name}</span>
                        </NavLink>
                      ))}
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
