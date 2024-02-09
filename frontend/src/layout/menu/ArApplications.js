const arApplication = [
  {
    heading: "Navigation",
  },
  {
    icon: "bag",
    text: "Authorise Representative",
    link: "#",
    panel: true,
    isAdmin: false,
    newTab: true,
    subPanel: [
      {
        icon: "dashboard-fill",
        text: "Dashboard",
        link: "/dashboard",
      },
      // {
      //   icon: "dashboard-fill",
      //   text: "Application",
      //   link: "/application",
      // },
      {
        icon: "dashboard-fill",
        text: "Activity Log",
        link: "/audit-log",
      },
      {
        icon: "tile-thumb-fill",
        text: "Update Authorised Representatives",
        link: "/auth-representatives",
      }
    ]
  }
];

export default arApplication;