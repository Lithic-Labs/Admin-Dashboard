export default [
  {
    path: "/",
    component: () => import("@/layouts/Default.vue"),
    children: [
      {
        path: "/instance/:id",
        name: "allinstance",
        component: () =>
          import("@/pages/Instance/index.vue"),
      },
    ],
 
  },
    // {
    //   path: "/",
    //   component: () => import("@/layouts/Default.vue"),
    //   children: [
    //     {
    //       path: "/createInstance/:id/:name",
    //       name: "instance",
    //       component: () =>
    //         import("@/pages/Instance/index.vue"),
    //     },
    //   ],
   
    // },
    {
      path: "/",
      component: () => import("@/layouts/Default.vue"),
      children: [
        {
          path: "/updateInstance/:id/:name",
          name: "updateinstance",
          component: () =>
            import("@/pages/Instance/edit.vue"),
        },
      ],
   
    },
    {
      path: "/",
      component: () => import("@/layouts/Default.vue"),
      children: [
        {
          path: "/viewInstance/:id/:name/:uid",
          name: "viewinstance",
          component: () =>
            import("@/pages/Instance/view.vue"),
        },
      ],
 
    },
  
  ];
 