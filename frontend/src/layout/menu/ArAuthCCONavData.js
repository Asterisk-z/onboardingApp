const arCCONavData = [
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
      text: "Quick links",
      link: "/regulators",
    },
    {
      icon: "tile-thumb-fill",
      text: "Fees and Dues Framework",
      link: "/fees-framework",
    },
    {
      icon: "tile-thumb-fill",
      text: "Portal Guide",
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
      text: "Competency",
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
    ],
  },
];

export default arCCONavData;