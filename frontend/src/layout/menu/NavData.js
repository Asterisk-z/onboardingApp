const navData = [{
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
  // {
  //   icon: "dashboard-fill",
  //   text: "Complaints",
  //   link: "/admin-complaint",
  // },
  {
    icon: "tile-thumb-fill",
    text: "Complaints",
    active: false,
    subMenu: [{
        text: "Manage Complaint",
        link: "/admin-complaint",
      },
      {
        text: "Manage Complaint Type",
        link: "/admin-complaint-type",
      },
    ],
  },
  {
    icon: "tile-thumb-fill",
    text: "Activity Log",
    active: false,
    subMenu: [{
      text: "All Logs",
      link: "/admin-audit-log",
    },
    {
      text: "User Log",
      link: "/user-audit-log",
    },
    ],
  },
  {
    icon: "dashboard-fill",
    text: "Broadcast",
    link: "/admin-broadcast",
    },
    {
    icon: "dashboard-fill",
    text: "Disciplinary and Sanctions History",
    link: "/admin-sanctions",
  },
    {
    icon: "dashboard-fill",
    text: "Competency Framework",
    link: "/admin-competency-framework",
  },
  {
    icon: "dashboard-fill",
    text: "Institutions",
    link: "/admin-institutions",
  },
  {
    icon: "tile-thumb-fill",
    text: "Authorised Representative",
    active: false,
    subMenu: [
      {
        text: "All ARs",
        link: "/admin-list-ar",
      },
      {
        text: "Transfer AR",
        link: "/admin-transfer-ar",
      },
    ],
  },
  {
    icon: "tile-thumb-fill",
    text: "Education and Learning",
    active: false,
    subMenu: [
      {
        text: "Conference & Events",
        link: "/admin-events",
      },
    ],
  },
  {
    icon: "tile-thumb-fill",
    text: "Settings",
    active: false,
    subMenu: [
      // {
      //   text: "Complaint Type",
      //   link: "/admin-complaint-type",
      // },
      {
        text: "Member Category",
        link: "/admin-categories",
      },
      {
        text: "Positions",
        link: "/admin-positions",
      },
      {
        text: "Regulators",
        link: "/admin-regulators",
      },
      {
        text: "Fees and Dues Framework",
        link: "/admin-fees-framework",
      },
      {
        text: "Applicants Guide",
        link: "/admin-applicant-guide",
      },
      {
        text: "Members Guide",
        link: "/admin-members-guide",
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
  subPanel: [{
    icon: "dashboard-fill",
    text: "Dashboard",
    link: "/dashboard",
  },
  {
    icon: "dashboard-fill",
    text: "Application",
    link: "/application",
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
  {
    icon: "tile-thumb-fill",
    text: "Update Authorised Representatives",
    link: "/auth-representatives",
   },
  {
    icon: "tile-thumb-fill",
    text: "Disciplinary and Sanctions History",
    access: ['cco'],
    link: "/sanctions",
  },
  {
    icon: "tile-thumb-fill",
    text: "Regulators",
    link: "/regulators",
  },
  {
    icon: "tile-thumb-fill",
    text: "Fees and Dues Framework",
    link: "/fees-framework",
  },
  {
    icon: "tile-thumb-fill",
    text: "Portals Guide",
    active: false,
    subMenu: [
      {
        text: "Applicant Guide",
        link: "/applicant-guide",
      }, 
      {
        text: "Members Guide",
        link: "/membership-guide",
      },
       
    ],
  },
  {
    icon: "tile-thumb-fill",
    text: "Competency Framework",
    active: false,
    subMenu: [
      {
        text: "Update Competency",
        link: "/update-competency",
      }, 
      {
        text: "Approve Competency",
        link: "/approve-competency",
      },
    ],
  },
  {
    icon: "tile-thumb-fill",
    text: "Education And Learning",
    link: "/education-and-learning",
  },
  // {
  //   icon: "tile-thumb-fill",
  //   text: "FMDQ Fees and Dues",
  //   link: "/fees-framework",
  // },
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