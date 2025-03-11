import mainRoute from "@/router/modules/homeroutes";
import authRoute from "@/router/modules/authroutes";
import templateRoute from "@/router/modules/templateroutes";
import userRoute from "@/router/modules/userroutes";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...authRoute ,...mainRoute ,...templateRoute,...userRoute,],
});

export default router;
