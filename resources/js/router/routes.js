const routes = [
  {
    path: '/',
    component: () => import('../layouts/AuthLayout.vue'),
    children: [
      {
        path: '/',
        name: '/',
        component: () => import('../pages/Auth/LoginPage.vue'),
      },
      {
        path: 'login',
        name: 'login',
        component: () => import('../pages/Auth/LoginPage.vue'),
      },
    ],
    meta: {
      requiresAuth: false,
    },
  },
]

export default routes;