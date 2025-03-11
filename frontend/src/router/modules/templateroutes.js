export default [
    {
      path: "/",
      component: () => import("@/layouts/Default.vue"),
      children: [
        {
          path: "/template",
          name: "template",
          component: () =>
            import("@/pages/Template/index.vue"),
        },
      ],
    },
  ];
  