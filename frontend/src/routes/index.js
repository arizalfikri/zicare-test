import { createRouter, createWebHistory } from "vue-router";

import HomeView from "../views/homeView.vue";
import DetailView from "../views/detailView.vue";
import FormPasien from "../views/formPasienView.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: HomeView,
    },
    {
      path: "/form",
      component: FormPasien,
    },
    {
      path: "/detail/:id",
      component: DetailView,
    },
  ],
});

export default router;
