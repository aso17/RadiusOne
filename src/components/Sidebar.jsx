import { useState, useEffect } from "react";
import { NavLink, useLocation } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import { icons } from "../utils/Icons";

export default function Sidebar() {
  const { menus } = useAuth();
  const [open, setOpen] = useState(null);
  const location = useLocation();

  // 🔥 Auto open parent jika child active
  useEffect(() => {
    const parent = menus.find((m) =>
      m.children?.some((c) => c.route === location.pathname),
    );
    if (parent) setOpen(parent.id);
  }, [location.pathname, menus]);

  return (
    <aside className="w-64 bg-white border-r border-slate-200 min-h-screen flex flex-col">
      <div className="flex items-center gap-2 px-6 h-16 border-b">
        <img
          src={localStorage.getItem("project_logo_path")}
          alt="Project Logo"
          className="w-12 h-12 object-contain"
        />
        <span className="text-lg font-extrabold capitalize text-primary tracking-tighter">
          {localStorage.getItem("project_name") || "Application"}
        </span>
      </div>

      <nav className="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        {menus.map((menu) => {
          const Icon = icons[menu.icon];
          const Chevron = icons.chevron;
          const DotIcon = icons.dot;
          const hasChild = menu.children?.length > 0;

          const isChildActive = hasChild
            ? menu.children.some((c) => c.route === location.pathname)
            : false;

          const isActive = menu.route === location.pathname || isChildActive;

          const isOpen = open === menu.id;

          return (
            <div key={menu.id}>
              {!hasChild ? (
                <NavLink
                  to={menu.route}
                  className={() =>
                    `flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition-all
                    ${
                      isActive
                        ? "bg-primary text-white font-bold"
                        : "text-slate-900 hover:bg-slate-50 hover:text-primary font-semibold"
                    }`
                  }
                >
                  {Icon && <Icon size={18} strokeWidth={2.5} />}
                  <span>{menu.name}</span>
                </NavLink>
              ) : (
                <div className="space-y-1">
                  <button
                    onClick={() => setOpen(isOpen ? null : menu.id)}
                    className={`w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs transition-all
                    ${
                      isActive
                        ? "bg-slate-100 text-primary font-bold"
                        : "text-slate-900 hover:bg-slate-50 hover:text-primary font-semibold"
                    }`}
                  >
                    <div className="flex items-center gap-3">
                      {Icon && (
                        <Icon
                          size={18}
                          strokeWidth={2.5}
                          className={isActive ? "text-primary" : ""}
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

                  <div
                    className={`overflow-hidden transition-all duration-300 ${
                      isOpen ? "max-h-96 opacity-100" : "max-h-0 opacity-0"
                    }`}
                  >
                    <div className="ml-5 mt-1 pl-4 border-l-2 border-slate-100 space-y-1">
                      {menu.children.map((sub) => {
                        const isSubActive = location.pathname === sub.route;

                        return (
                          <NavLink
                            key={sub.id}
                            to={sub.route}
                            className={`flex items-center gap-3 px-3 py-1.5 rounded-lg text-[12px] transition-all
                              ${
                                isSubActive
                                  ? "text-primary font-bold"
                                  : "text-slate-500 hover:text-slate-900 font-medium"
                              }`}
                          >
                            {DotIcon && (
                              <DotIcon
                                size={10}
                                strokeWidth={3}
                                className={
                                  isSubActive
                                    ? "text-primary"
                                    : "text-slate-400"
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
