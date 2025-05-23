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
      {
        path: "people",
        name: "people",
        component: () => import("../pages/People/PeoplePage.vue"),
        meta: {
          requiresAuth: true,
          label: 'Pessoas',
          description: 'Gerencie as pessoas que participarão dos seus eventos',
          icon: 'groups',
        },
      },
      {
        path: "room",
        name: "room",
        component: () => import("../pages/Rooms/RoomsPage.vue"),
        meta: {
          requiresAuth: true,
          label: 'Salas',
          description: 'Gerencie as suas salas de maneira simples',
          icon: 'meeting_room',
        },
      },
      {
        path: "coffee-room",
        name: "coffee-room",
        component: () => import("../pages/CoffeeRooms/CoffeeRoomsPage.vue"),
        meta: {
          requiresAuth: true,
          label: 'Salas de café',
          description: 'Gerencie as suas salas de café, garantindo um Coffee Break organizado',
          icon: 'coffee',
        },
      },
    ],
    meta: {
      requiresAuth: true,
    },
  }
]

export default routes;