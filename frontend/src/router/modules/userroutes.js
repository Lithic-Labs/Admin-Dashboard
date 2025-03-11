export default [
    {
      path: "/",
      component: () => import("@/layouts/Default.vue"),
      children: [
        {
          path: "/user",
          name: "user",
          component: () =>
            import("@/pages/User/index.vue"),
        },
      ],
    },
  ];
  