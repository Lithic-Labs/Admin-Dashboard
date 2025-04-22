export default [
    {
      path: "/",
      component: () => import("@/layouts/Default.vue"),
      children: [
        {
          path: "/rewards/:id/:name/:uid",
          name: "rewards",
          component: () =>
            import("@/pages/Rewards/create.vue"),
        },
      ],
    },
  ];
  