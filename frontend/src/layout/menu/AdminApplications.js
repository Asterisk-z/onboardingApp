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
        icon: "dashboard-fill",
        text: "Applications",
        link: "/admin-applications",
      },
    ],
  },
];

export default adminApplication;