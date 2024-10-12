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


                {
                    path: '/pages/crud',
                    name: 'crud',
                    component: () => import('@/views/pages/Crud.vue')
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
            path: '/class',
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


router.beforeEach((to,from, next) => {

    const access_token = localStorage.getItem('access_token')

    if (to.name !== 'login') {
        if(!access_token){
            return next({name:'login'})
        }
    }
    if (to.name === 'login' && access_token){
        return next({name:'dashboard'})
    }

    next()
})

export default router;
