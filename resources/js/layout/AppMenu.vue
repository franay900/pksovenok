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
            { label: 'Расписание', icon: 'pi pi-fw pi-calendar-times', to: router.resolve({name: 'timetable.index'}) },


        ]
    },
    {
        label: 'Журналы',
        icon: 'pi pi-fw pi-briefcase',
        to: '/journal/',
        items: [
            {
                label: 'Журнал организации',
                icon: 'pi pi-fw pi-book',
                to: router.resolve({name: 'journal.organization'})
            },


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
