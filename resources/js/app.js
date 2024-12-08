import { createApp } from 'vue';
import store from './store';
import App from './App.vue';
import router from './router';

import Aura from '@primevue/themes/aura';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

import '@/assets/styles.scss';
import '@/assets/tailwind.css';

import { definePreset } from '@primevue/themes';
import axios from 'axios';

const app = createApp(App);





app.use(router);

const MyPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{sky.50}',
            100: '{sky.100}',
            200: '{sky.200}',
            300: '{sky.300}',
            400: '{sky.400}',
            500: '{sky.500}',
            600: '{sky.600}',
            700: '{sky.700}',
            800: '{sky.800}',
            900: '{sky.900}',
            950: '{sky.950}'
        }
    }
});
app.use(PrimeVue, {
    theme: {
        preset: MyPreset,
        options: {
            darkModeSelector: '.app-dark',

        }
    },
    locale: {
        dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        dayNamesShort: ["Пон", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        dayNamesMin: ["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],
        monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
        monthNamesShort: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
        today: 'Today',
        weekHeader: 'Wk',
        firstDayOfWeek: 1,
        dateFormat: 'dd.mm.yy',
  }
});



import { updatePrimaryPalette } from '@primevue/themes';



app.use(ToastService);
app.use(ConfirmationService);


app.use(store);
app.mount('#app');

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if(error.response.status === 401) {
        router.push({name: 'login'})
    }

    if(error.response.status === 403){
        router.push(({name: 'access'}))
    }
    return Promise.reject(error);
});
