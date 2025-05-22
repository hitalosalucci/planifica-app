import { 
  createRouter,
  createWebHistory
} from "vue-router";
import routes from "./routes";
import { useAuthStore } from "../stores/auth";

// import { setupErrorHandling } from './errorHandler';

// const { showLoading, hideLoading } = useLoading();


const router = createRouter({
  scrollBehavior: () => ({ left: 0, top: 0 }),
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to) => {
  // showLoading();

  const authStore = useAuthStore();

  // Redireciona usuários não autenticados
  if (to.meta.requiresAuth && !authStore?.authUser) {
    // Salva a página de intenção para voltar assim que logar
    authStore.returnUrl = to.fullPath;
    // Redireciona para pagna de login
    return "/login";
  }

  // Redireciona usuários autenticados
  if (!to.meta.requiresAuth && authStore?.authUser) {
    return "/events"; //Pagina inicial ao logar no sistema -> caso ele não tenha tido uma pagina especifica quando não autenticado
  }

  // if (await authStore?.user) {

  //   if (to.name !== "error-forbidden") {
  //     const resp = await authStore.getUserAuthRoles();

  //     // If there is an error in the response, redirect to the "error-forbidden" route to display an error message and prevent further actions
  //     if (!(await checkRouteAccess(to.name))) {
  //       return "/error-forbidden";
  //     }
  //   }
  // }

});

router.afterEach(() => {
  // hideLoading();
});

// setupErrorHandling(router);

export default router