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
  {
    path: "/",
    component: () => import("../layouts/MainLayout.vue"),
    children: [
      // {
      //   path: "error-forbidden",
      //   name: "error-forbidden",
      //   component: () => import("../pages/ErrorForbidden.vue"),
      // },
      {
        path: "events",
        name: "events",
        component: () => import("../pages/Events/EventsPage.vue"),
        meta: {
          requiresAuth: true,
          label: 'Eventos',
          description: 'Gerencie seus eventos de maneira rápida',
          icon: 'event',
        },
      },
    ],
    meta: {
      requiresAuth: true,
    },
  }
]

export default routes;