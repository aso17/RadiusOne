import { useState } from 'react'
import { NavLink } from 'react-router-dom'
import { menus } from '../services/MenuServices'
import { icons } from '../utils/Icons'

export default function Sidebar() {
    const [open, setOpen] = useState(null)

    return (
        <aside className="w-64 bg-white border-r min-h-screen">

            {/* LOGO */}
            <div className="h-16 flex items-center px-6 font-bold text-blue-600 text-lg border-b border-gray-200">
                RadiusOne
            </div>

            {/* MENU */}
            <nav className="mt-2 text-sm">
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
                                        `flex items-center px-5 py-3
                                         ${isActive
                                            ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600'
                                            : 'text-gray-700 hover:bg-gray-100'}`
                                    }
                                >
                                    <div className="flex items-center gap-3">
                                        {Icon && <Icon size={18} className="shrink-0" />}
                                        <span className="whitespace-nowrap">
                                            {menu.name}
                                        </span>
                                    </div>
                                </NavLink>
                            ) : (
                                /* MENU DENGAN CHILD */
                                <button
                                    type="button"
                                    onClick={() => setOpen(open === menu.id ? null : menu.id)}
                                    className="w-full flex items-center justify-between px-5 py-3 text-gray-700 hover:bg-gray-100"
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
                                <div className="ml-10 mt-1 space-y-1">
                                    {menu.children.map(sub => (
                                        <NavLink
                                            key={sub.path}
                                            to={sub.path}
                                            className={({ isActive }) =>
                                                `block py-2 px-3 text-sm
                         ${isActive
                                                    ? 'text-blue-600 font-medium'
                                                    : 'text-gray-600 hover:text-blue-600'}`
                                            }
                                        >
                                            <span>{sub.name}</span>
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
