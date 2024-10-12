<script>

import api from '../../api';
import { RouterLink } from 'vue-router';
import { useToast } from 'primevue/usetoast';

export default {
   
    data(){
        return {
            days: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            day: null,
            schedule: this.generateSchedule(),
            name: null,
            toast: useToast()
       
        }
    },
    mounted(){
        this.$store.dispatch('getBells')

    },
    computed: {
        bells(){
            return this.$store.getters.bells
        },

        
        
        },

        methods: {
           
            hasInvalidFields() {
      
                for (let dayIndex = 0; dayIndex < this.schedule.length; dayIndex++) {
                    for (let lessonIndex = 0; lessonIndex < this.schedule[dayIndex].length; lessonIndex++) {
                    if (
                        !this.schedule[dayIndex][lessonIndex].end && 
                        this.schedule[dayIndex][lessonIndex].begin
                    ) {
                        return true; // Если хотя бы одно поле невалидно, возвращаем true
                    }
                    }
                }
                return false; // Если все поля валидны, возвращаем false
            },

            generateSchedule() {
                const schedule = [];
                for (let day = 0; day < 6; day++) { // 6 дней недели
                    const daySchedule = [];
                    for (let lesson = 1; lesson <= 7; lesson++) { // 7 уроков
                    daySchedule.push({
                        number: lesson,
                        begin: null, // Заполните "begin" как вам нужно
                        end: null // Заполните "end" как вам нужно
                    });
                    }
                    schedule.push(daySchedule);
                }
                return schedule;
            },

            createBells(){
                if(this.hasInvalidFields()){
                    this.toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Проверьте, указаны ли окончания уроков и наименование звонков', life: 3000 });
                    return 0;
                }
                api.post('/bell', {name: this.name, lessons: this.schedule})
                .then(res => {
                    this.$router.push({name:'bells.index'})
                })
            }
        },
 
}

</script>
<template>
    <Fluid>

      
        <div  class="card ">
            <div class="font-semibold text-xl">Расписание звонков</div>
            
            <div class="grid grid-cols-12  mt-3  ">
                <label for="name"class="flex  col-span-12 mb-2 md:col-span-2 md:mb-0">Наименование</label>
                <div class="col-span-12 md:col-span-3 ">
                    <InputText id="name"  type="text" v-model="name"  />
                </div>

            </div>
            
            <div>
                <div class="grid">
                    <div v-for="(day, dayIndex) in days" :key="dayIndex" class="mt-3 " >
                    <h3 class="font-bold text-center">
                        <i class="pi pi-calendar" ></i> {{ day }}
                        </h3>
                    <DataTable :value="schedule[dayIndex]"   >
                        <Column field="number" header="Номер урока" ></Column>
                        <Column field="begin" header="Начало" >
                            <template #body="slotProps">
                        
                                <DatePicker  
                                v-model.trim="schedule[dayIndex][slotProps.data.number-1].begin" 
                                showIcon fluid iconDisplay="input" timeOnly=""
                                :inputId="'templatedisplay'+dayIndex+slotProps.data.number"
                                >
                                    <template #inputicon="slotProps">
                                        <i class="pi pi-clock" @click="slotProps.clickCallback" />
                                        
                                    </template>
                                </DatePicker>
                            </template>
                        </Column>
                        <Column field="end" header="Конец" >
                            <template #body="slotProps">
                                <DatePicker  
                                v-model="schedule[dayIndex][slotProps.data.number-1].end" 
                                showIcon fluid iconDisplay="input" timeOnly 
                                :inputId="'templatedisplay'+dayIndex+slotProps.data.number" 
                                :invalid="!schedule[dayIndex][slotProps.data.number-1].end && schedule[dayIndex][slotProps.data.number-1].begin !== null">
                                    <template #inputicon="slotProps">
                                        <i class="pi pi-clock" @click="slotProps.clickCallback" />
                                        
                                    </template>
                                </DatePicker>
                            </template>
                        </Column>
                    </DataTable>
                    </div>
                </div>
            </div>
      
            <div class="grid grid-cols-10 mt-3 ">
                <Button label="Сохранить" icon="pi pi-save"  @click="createBells"  />
                <div class=" md:col-span-1 ml-1">
                    <Button label="Копировать" icon="pi pi-copy"  @click="createBells"  />
                </div>
            </div>
        </div>
    </Fluid>
</template>

