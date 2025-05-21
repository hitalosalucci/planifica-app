const routes = [
  {
    path: '/',
    component: () => import('../layouts/MainLayout.vue'),
    children: [
      // {
      //   path: '/dashboard',
      //   component: Dashboard
      // },
    ]
  }
]

export default routes;