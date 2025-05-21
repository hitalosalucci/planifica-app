export function setupErrorHandling(router) {

  // rota dinamica para os erros
  router.addRoute({
    path: '/error/:code',
    name: 'error',
    component: () => import('@/pages/Errors/PageErrorDefault.vue'),
    props: route => ({ 
      code: route.params.code,
      error: route.meta.error 
    })
  });

  // redirect default
  router.addRoute({
    path: '/:pathMatch(.*)*',
    redirect: to => ({
      name: 'error',
      params: { code: 404 },
      meta: { error: { message: 'Página não encontrada' } }
    })
  });

  // quando houver erro
  router.onError((error) => {
    const code = error.response?.status || 500;
    router.push({
      name: 'error',
      params: { code },
      meta: { error: error.response?.data || error }
    });
  });
}