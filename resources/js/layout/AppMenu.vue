<script setup>
import { ref } from 'vue';

import { useRouter } from 'vue-router';
import AppMenuItem from './AppMenuItem.vue';

const router = useRouter();

const model = ref([
    {
        label: 'Главная',
        items: [{ label: 'Рабочий стол', icon: 'pi pi-fw pi-home', to: '/' }]
    },
    {
        label: 'Пользователи',
        items: [
            { label: 'Сотрудники', icon: 'pi pi-fw pi-id-card', to:  router.resolve({name: 'users.index'}) },
            { label: 'Ученики', icon: 'pi pi-fw pi-check-square', to: router.resolve({name: 'student.index'}) },

        
        ]
    },


    {
        label: 'Организация',
        items: [
            { label: 'Предметы', icon: 'pi pi-fw pi-list', to: router.resolve({name: 'subject.index'}) },
            { label: 'Звонки', icon: 'pi pi-fw pi-bell', to: router.resolve({name: 'bells.index'}) },
            { label: 'Периоды', icon: 'pi pi-fw pi-calendar', to: router.resolve({name: 'periods.index'}) },
            { label: 'Классы', icon: 'pi pi-fw pi-folder', to: router.resolve({name: 'class.index'}) },
            { label: 'Нагрузка', icon: 'pi pi-fw pi-th-large', to: router.resolve({name: 'load.index'}) },
            { label: 'Расписание', icon: 'pi pi-fw pi-calendar-times', to: '/uikit/input' },
  
        
        ]
    },
    {
        label: 'Pages',
        icon: 'pi pi-fw pi-briefcase',
        to: '/pages',
        items: [
            {
                label: 'Landing',
                icon: 'pi pi-fw pi-globe',
                to: '/landing'
            },
            {
                label: 'Auth',
                icon: 'pi pi-fw pi-user',
                items: [
                    {
                        label: 'Login',
                        icon: 'pi pi-fw pi-sign-in',
                        to: '/auth/login'
                    },
                    {
                        label: 'Error',
                        icon: 'pi pi-fw pi-times-circle',
                        to: '/auth/error'
                    },
                    {
                        label: 'Access Denied',
                        icon: 'pi pi-fw pi-lock',
                        to: '/auth/access'
                    }
                ]
            },
            {
                label: 'Crud',
                icon: 'pi pi-fw pi-pencil',
                to: '/pages/crud'
            },
            {
                label: 'Not Found',
                icon: 'pi pi-fw pi-exclamation-circle',
                to: '/pages/notfound'
            },
            {
                label: 'Empty',
                icon: 'pi pi-fw pi-circle-off',
                to: '/pages/empty'
            }
        ]
    },

]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
