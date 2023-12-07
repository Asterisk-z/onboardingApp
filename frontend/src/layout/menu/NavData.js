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
      // {
      // icon: "tile-thumb-fill",
      // text: "Projects",
      // active: false,
      // subMenu: [
      //     {
      //       text: "Project Cards",
      //       link: "/project-card",
      //     },
      //     {
      //       text: "Project List",
      //       link: "/project-list",
      //     },
      //   ],
      // },
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
