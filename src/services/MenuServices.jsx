export const menus = [
    {
        id: 1,
        name: 'App Settings',
        icon: 'settings',
        children: [
            {
                name: 'Router',
                route: '/settings/router'
            }
        ]
    },
    {
        id: 2,
        name: 'POP Data',
        icon: 'layers',
        route: '/odp-pop'
    },
    {
        id: 3,
        name: 'Service Plan',
        icon: 'send',
        route: '/service-plan'
    },
    {
        id: 4,
        name: 'Customers',
        icon: 'user-plus',
        children: [
            { name: 'Hotspot Users', route: '/customers/hotspot' },
            { name: 'PPP Users', route: '/customers/ppp' },
            { name: 'Mapping Users', route: '/customers/mapping' }
        ]
    },
    {
        id: 5,
        name: 'Voucher Card',
        icon: 'credit-card',
        route: '/voucher'
    },
    {
        id: 6,
        name: 'Unpaid Invoice',
        icon: 'file-text',
        route: '/invoice/unpaid'
    },
    {
        id: 7,
        name: 'Finance Report',
        icon: 'dollar-sign',
        route: '/finance-report'
    },
    {
        id: 8,
        name: 'Online Payment',
        icon: 'globe',
        route: '/online-payment'
    },
    {
        id: 9,
        name: 'Support Tickets',
        icon: 'tag',
        route: '/support-tickets'
    }
]
