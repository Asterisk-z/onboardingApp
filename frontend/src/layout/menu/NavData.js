const navData = [
  {
    heading: "Navigation",
  },
  {
    icon: "bag",
    text: "Admin",
    link: "#",
    panel: true,
    isAdmin: true,
    newTab: true,
    subPanel: [
      {
        icon: "dashboard-fill",
        text: "Dashboard",
        link: "/admin-dashboard",
      },
      {
        icon: "dashboard-fill",
        text: "Complaints",
        link: "/admin-complaint",
      },
      {
      icon: "tile-thumb-fill",
      text: "Activity Log",
      active: false,
      subMenu: [
          {
            text: "All Logs",
            link: "/admin-audit-log",
          },
          {
            text: "User Log",
            link: "/user-audit-log",
          },
        ],
      },
    ],
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
      {
        icon: "dashboard-fill",
        text: "Complaints",
        link: "/complaint",
      },
      {
        icon: "dashboard-fill",
        text: "Activity Log",
        link: "/audit-log",
      },
      // {
      // icon: "tile-thumb-fill",
      // text: "Projects",
      // active: false,
      // subMenu: [
      //     {
      //       text: "Project Item",
      //       link: "/dashboard",
      //     },
      //   ],
      // },
    ],
  },
];
export default navData;
