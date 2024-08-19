
const adminMSGApplication = [{
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
        icon: "dashboard-fill",
        text: "Pending Applications",
        link: "/admin-applications",
    },
    {
        icon: "dashboard-fill",
        text: "AR Creation Request",
        link: "/admin-creation-request",
    },
    ],
},
];

export default adminMSGApplication;