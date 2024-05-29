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
  {
    icon: "dashboard-fill",
    text: "Applications",
    link: "/admin-applications",
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
    subMenu: [{
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
    text: "Report",
    active: false,
    subMenu: [{
      text: "Membership Application",
      link: "/admin-application-report",
    },
    {
      text: "Authorised Representatives Reports",
      link: "/admin-representatives-report",
    },
    ],
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
  {
    icon: "tile-thumb-fill",
    text: "Notification Of Change",
    link: "/admin-notification-of-change",
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
        text: "Stakeholders",
        link: "/admin-stakeholders",
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
      {
        text: "DOH ",
        link: "/admin-doh",
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
    icon: "tile-thumb-fill",
    text: "Membership",
    active: false,
    subMenu: [
      {
        text: "Application",
        link: "/membership-applications",
      },
      {
        text: "Addition",
        link: "/membership-addictions",
      },
      {
        text: "Conversion",
        link: "/membership-conversions",
      },

    ],
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
    text: "Authorised Representatives",
    active: false,
    subMenu: [

      {
        text: "Update Authorised Representatives",
        link: "/auth-representatives",
      },
      {
        text: "Pending Authorised Representatives",
        link: "/auth-representatives-pending",
      },
      {
        text: "View Authorised Representatives",
        link: "/auth-representatives-view",
      },

    ],
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
    subMenu: [{
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
    subMenu: [{
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
  {
    icon: "tile-thumb-fill",
    text: "AR Creation Request",
    link: "/ar-creation-request",
  },
  {
    icon: "tile-thumb-fill",
    text: "Notification Of Change",
    link: "/notification-of-change",
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