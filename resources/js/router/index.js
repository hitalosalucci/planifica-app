import { 
  createRouter,
  createWebHistory
} from "vue-router";
import routes from "./routes";

import { setupErrorHandling } from './errorHandler';

// import MainLayout from '../layouts/MainLayout.vue'
// import Dashboard from '../pages/Dashboard.vue'

// const { showLoading, hideLoading } = useLoading();

const router = createRouter({
  scrollBehavior: () => ({ left: 0, top: 0 }),
  history: createWebHistory(),
  routes,
});

setupErrorHandling(router);

export default router