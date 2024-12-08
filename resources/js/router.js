import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/views/Dashboard.vue')
                },




            ]
        },

        {
            path: '/users',
            component: AppLayout,
            children: [
                {
                    path: '/users',
                    name: 'users.index',
                    component: () => import('@/views/users/Index.vue')
                },

                {
                    path: '/users/:id/edit',
                    name: 'user.edit',
                    component: () => import('@/views/users/Edit.vue')
                },



            ]
        },

        {
            path: '/bells',
            component: AppLayout,
            children: [
                {
                    path: '/bells',
                    name: 'bells.index',
                    component: () => import('@/views/bells/Index.vue')
                },

                {
                    path: '/bells/create',
                    name: 'bells.create',
                    component: () => import('@/views/bells/Create.vue')
                },


                {
                    path: '/bells/:id',
                    name: 'bells.show',
                    component: () => import('@/views/bells/Show.vue')
                },

            ]
        },

        {
            path: '/bells',
            component: AppLayout,
            children: [
                {
                    path: '/periods',
                    name: 'periods.index',
                    component: () => import('@/views/periods/Index.vue')
                },



            ]
        },

        {
            path: '/class',
            component: AppLayout,
            children: [
                {
                    path: '/class',
                    name: 'class.index',
                    component: () => import('@/views/classes/Index.vue')
                },

                {
                    path: '/class/:id/edit',
                    name: 'class.edit',
                    component: () => import('@/views/classes/Edit.vue')
                },



            ]
        },

        {
            path: '/student',
            component: AppLayout,
            children: [
                {
                    path: '/student',
                    name: 'student.index',
                    component: () => import('@/views/students/Index.vue')
                },


            ]
        },


        {
            path: '/subject',
            component: AppLayout,
            children: [
                {
                    path: '/subject',
                    name: 'subject.index',
                    component: () => import('@/views/subjects/Index.vue')
                },


            ]
        },

        {
            path: '/load',
            component: AppLayout,
            children: [
                {
                    path: '/load',
                    name: 'load.index',
                    component: () => import('@/views/load/Index.vue')
                },


            ]
        },


        {
            path: '/timetable',
            component: AppLayout,
            children: [
                {
                    path: '/timetable',
                    name: 'timetable.index',
                    component: () => import('@/views/timetables/Index.vue')
                },
                {
                    path: '/timetable/templates/:id',
                    name: 'timetable.templates',
                    component: () => import('@/views/timetables/Templates.vue')
                },

                {
                    path: '/timetable/create/:id',
                    name: 'timetable.create',
                    component: () => import('@/views/timetables/Create.vue')
                }

            ]
        },


        {
            path: '/timetable',
            component: AppLayout,
            children: [
                {
                    path: '/journal',
                    name: 'journal.organization',
                    component: () => import('@/views/journal/Organization.vue')
                },


            ]
        },

        {
          path: '/login/',
          name: 'login',
          component: () => import('@/views/Login.vue')
      },

      {
        path: '/access/',
        name: 'access',
        component: () => import('@/views/pages/auth/Access.vue')
    },
      {
        path:'/:catchAll(.*)',
        name:'404',
        component: () => import('@/views/pages/NotFound.vue')
      }
    ]
});


// router.beforeEach((to,from, next) => {
//
//     const token = localStorage.getItem('x_xsrf_token')
//
//     if (to.name !== 'login') {
//         if(!token){
//             return next({name:'login'})
//         }
//     }
//     if (to.name === 'login' && token){
//         return next({name:'dashboard'})
//     }
//
//     next()
// })

export default router;
