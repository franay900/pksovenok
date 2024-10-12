<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';
import { useToast } from 'primevue/usetoast';
import { reactive } from 'vue'



export default {
    data() {
        return {
            periodList: null,
            periods: null,
            toast: useToast()
           
        }
    },

    computed: {
            
    },
    mounted() {
      this.getPeriodTypes()
      this.getPeriods()
    },
 
    methods: {
        getPeriods() {
        api.get('period')
            .then(res => {
                this.fillPeriodList(res.data);
            });
        },
    
        getPeriodTypes(){
            api.get('period_type')
            .then(res => {
                let periodsList = [];
                res.data.forEach(element => {
                    let periods = [];
                    for(let period=0; period<element.quantity; period++ ){
                        periods.push({number: period+1, begin:null, end:null})
                    }
                    let period_name = element.name;
                    periodsList.push({name: period_name, id:element.id, periods: periods});
                 
                    this.periods = res.data
                    this.periodList = periodsList
                });
            })
            
        },

        fillPeriodList(periodsData) {
        // Обновляем periodList для каждого элемента на основе periodsData
        this.periodList.forEach((type) => {
            
            type.periods.forEach((period, index) => {
                
                
                const periodData = periodsData.find(p => p.number === period.number && p.period_type_id === type.id);
                if (periodData) {
                    period.begin = periodData.begin;
                    period.end = periodData.end;
                }
            });
        });
        },

        
        invalidPeriod(periods, period) {
        // Проверка, пустой ли period.begin
        if (!period.begin) {
            return false; // Если  period.begin  пустой, то ошибка не возникает
        }

        // Проверяем, есть ли хотя бы один элемент в  periods  с непустым  begin
        for (let element of periods) {
            if (period.begin) {
            console.log(111111)
            return true; // Если найден такой элемент, то ошибка
            }
        }

        // Если ни один элемент в  periods  не соответствует условию, то ошибки нет
        return false; 
        },
        
        savePeriods(){
      
            api.post('period', {periods: this.periodList})
            .then(res=>{
                this.toast.add({ severity: 'info', summary: 'Сохранено', detail: 'Информация об учебных периодах успешно обновлена', life: 3000 });
                console.log(res.data)
            });

        },
        

        
    },
    
    
    

}

</script>
<template>

    <div class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Учебные периоды</div>

        <div v-if="!periods" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>
        <div v-if="periods">
            <div class="grid">
                <div v-for="period in periodList"  class="mt-3 " >
                <h3 class="font-bold text-center">
                    <i class="pi pi-calendar" ></i> {{ period.name }}
                    </h3>
                
                <DataTable :value="period.periods"   >
                    <Column field="number" header="Номер периода" ></Column>
                    <Column field="begin" header="Начало" >
                        <template #body="slotProps">
                           
                    
                            <DatePicker v-model="period.periods[slotProps.data.number-1].begin" showIcon fluid :showOnFocus="false" 
                            :invalid="(period.periods[slotProps.data.number-1].end && !period.periods[slotProps.data.number-1].begin) ||(!period.periods[slotProps.data.number-1].begin && period.periods.some(p => p.begin))" />

                           
                        </template>
                    </Column>
                    <Column field="end" header="Конец" >
                        <template #body="slotProps">
                            <DatePicker v-model="period.periods[slotProps.data.number-1].end" showIcon fluid :showOnFocus="false" 
                            :invalid="(period.periods[slotProps.data.number-1].begin && !period.periods[slotProps.data.number-1].end) || !period.periods[slotProps.data.number-1].begin && period.periods.some(p => p.begin) " />

                        </template>
                    </Column>
                </DataTable>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-10 ">
            <Button label="Обновить"  @click="savePeriods"  />
        </div>
    </div>



</template>

