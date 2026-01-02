import { useState } from 'react'
import { NavLink } from 'react-router-dom'
import { menus } from '../services/MenuServices'
import { icons } from '../utils/Icons'

export default function Sidebar() {
    const [open, setOpen] = useState(null)

    return (
        <aside className="w-64 bg-white border-r border-border min-h-screen">

            {/* LOGO */}
            <div className="h-16 flex items-center px-6 font-bold text-primary text-lg border-b border-border">
                RadiusOne
            </div>

            {/* MENU */}
            <nav className="mt-2 text-text">
                {menus.map(menu => {
                    const Icon = icons[menu.icon]
                    const Chevron = icons.chevron
                    const hasChild = menu.children && menu.children.length > 0

                    return (
                        <div key={menu.id}>

                            {/* MENU TANPA CHILD */}
                            {menu.path ? (
                                <NavLink
                                    to={menu.path}
                                    className={({ isActive }) =>
                                        `flex items-center gap-3 px-5 py-3 text-sm font-medium
                                         ${isActive
                                            ? 'bg-hover text-primary border-l-4 border-primary'
                                            : 'hover:bg-hover text-text'
                                        }`
                                    }
                                >
                                    {Icon && <Icon size={18} className="shrink-0" />}
                                    <span className="whitespace-nowrap">
                                        {menu.name}
                                    </span>
                                </NavLink>
                            ) : (
                                /* MENU DENGAN CHILD */
                                <button
                                    type="button"
                                    onClick={() => setOpen(open === menu.id ? null : menu.id)}
                                    className="w-full flex items-center justify-between px-5 py-3
                                               text-sm font-medium text-text hover:bg-hover"
                                >
                                    <div className="flex items-center gap-3">
                                        {Icon && <Icon size={18} className="shrink-0" />}
                                        <span className="whitespace-nowrap">
                                            {menu.name}
                                        </span>
                                    </div>

                                    {hasChild && Chevron && (
                                        <Chevron
                                            size={16}
                                            className={`transition-transform ${open === menu.id ? 'rotate-90' : ''
                                                }`}
                                        />
                                    )}
                                </button>
                            )}

                            {/* SUB MENU */}
                            {hasChild && open === menu.id && (
                                <div className="ml-10 mt-1 space-y-0.5">
                                    {menu.children.map(sub => (
                                        <NavLink
                                            key={sub.path}
                                            to={sub.path}
                                            className={({ isActive }) =>
                                                `block px-3 py-2 rounded text-[13px] font-normal
                                                 ${isActive
                                                    ? 'text-primary'
                                                    : 'text-slate-600 hover:text-primary'
                                                }`
                                            }
                                        >
                                            {sub.name}
                                        </NavLink>
                                    ))}
                                </div>
                            )}
                        </div>
                    )
                })}
            </nav>
        </aside>
    )
}
