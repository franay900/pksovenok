<script>

import api from '../../api';
import { RouterLink } from 'vue-router';
import { reactive } from 'vue'


export default {
   
    data(){
        return {
            days: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            day: null,
            name: null,
            schedule: null,
            
        }
    },
    mounted(){
      
        this.generateSchedule()
  

    },

        methods: {
           
        generateSchedule() {
            const schedule = reactive([]); 

            // Создаем структуру расписания с пустыми уроками
            for (let day = 0; day < 6; day++) {
                const daySchedule = [];
                for (let lesson = 1; lesson <= 7; lesson++) {
                daySchedule.push({
                    number: lesson,
                    begin: null,
                    end: null
                });
                }
                schedule.push(daySchedule);
            }

    
            api.get('/bell/' + this.$route.params.id)
                .then(res => {
                this.name = res.data.data.name;
                let bellLessons = res.data.data.lessons;

                // Обновляем расписание
                bellLessons.forEach(element => {
                    // Находим индекс урока в расписании
                    const dayIndex = element.day - 1;
                    const lessonIndex = element.number - 1;

                    // Используем Object.assign, чтобы Vue.js отслеживал изменения
                    schedule[dayIndex][lessonIndex] = Object.assign({}, schedule[dayIndex][lessonIndex], {
                    begin: element.begin,
                    end: element.end
                    }); 
                });

                // Устанавливаем schedule в this.schedule
                this.schedule = schedule; 

                });
        },

        createBells(){
            api.post('/bell', {name: this.name, lessons: this.schedule})
            .then(res => {
                this.$router.push({name:'bells.index'})
            })
        },

       
        },

        
}

</script>
<template>
    <Fluid>

      
        <div  class="card ">
            <div class="font-semibold text-xl">Расписание звонков</div>
            
            <div class="grid grid-cols-12 gap-2 ">
                <label for="name"class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Наименование</label>
                <div class="col-span-12 md:col-span-3 ">
                    <InputText id="name"  type="text" v-model="name" disabled="" />
                </div>

            </div>
            
            <div v-if="!schedule" class="card flex flex-col gap-4">
                <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

            </div>
            <div v-if="schedule">
                <div class="grid">
                    <div v-for="(day, dayIndex) in days" :key="dayIndex" class="mt-3 " >
                    <h3 class="font-bold text-center">
                        <i class="pi pi-calendar" ></i> {{ day }}
                        </h3>
                    <DataTable :value="schedule[dayIndex]"   >
                        <Column field="number" header="Номер урока" ></Column>
                        <Column field="begin" header="Начало" >
                            <template #body="slotProps">
                                
                                {{  schedule[dayIndex][slotProps.data.number-1].begin }}
                            </template>
                        </Column>
                        <Column field="end" header="Конец" >
                            <template #body="slotProps">
                                {{  schedule[dayIndex][slotProps.data.number-1].end }}
                            </template>
                        </Column>
                    </DataTable>
                    </div>
                </div>
            </div>
     
            <div class="grid grid-cols-12 mt-3 ">
                <Button label="Назад" icon="pi pi-arrow-circle-left"  as="router-link" :to="{name: 'bells.index'}" />
            </div>
        </div>
    </Fluid>
</template>

