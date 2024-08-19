
const adminApplication = [{
    heading: "Navigation",
},
{
    icon: "bag",
    text: "Admin",
    link: "#",
    panel: true,
    isAdmin: true,
    newTab: true,
    subPanel: [{
        icon: "dashboard-fill",
        text: "Dashboard",
        link: "/admin-dashboard",
    },
    {
        icon: "tile-thumb-fill",
        text: "Education and Learning",
        active: false,
        subMenu: [{
            text: "Conference & Events",
            link: "/admin-events",
        },],
    },
    ],
},
];

export default adminApplication;