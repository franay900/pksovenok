<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';



export default {
    data() {
        return {
            
            visible: null,
            subjects: null,
            groups: null,
            teachers: null,
            selectedSubgroup: null,

            sPopoverVisible: false,
            selectedGroup: null ,

            selectedSubject: null

        }
    },

    computed: {
            
    },
    mounted() {
        this.getSubjects()
        this.getOrganizationInfo()
    },
 
    methods: {
        
        getSubjects(){

            api.get('subject')
            .then(res => {
                this.subjects = res.data
            })
        },

        getOrganizationInfo() {
            api.get('group')
                .then(res => {
                
                this.teachers = res.data.teachers.map(teacher => ({
                    ...teacher,
                    short_full_name:  `${teacher.surname} ${teacher.surname[0]}.${teacher.patronymic[0]}.` ,
                    fullName: `${teacher.surname} ${teacher.surname} ${teacher.patronymic}` // Добавляем поле fullName
                }));
            
                this.groups = res.data.groups.map(group => ({
                    ...group,
                    group_name: `${group.number}${group.letter}`
                }))
                
                })
                .catch(error => {
                    console.error(error);
                });
        },

        togglePopover(event, group, subject) {
            this.$refs.op.toggle(event);
            this.selectedGroup = group
            this.selectedSubject = subject

           
        },

    },
    
    

}

</script>
<template>

    
        <div  class="card flex flex-col gap-4">
            <div class="font-semibold text-xl">Учебная нагрузка</div>

            <div v-if="!subjects" class="card flex flex-col gap-4">
                <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>
    
            </div>
            <div class="mb-4" style="width: auto;">
          

                <DataTable :value="teachers" scrollable scrollHeight="400px" class="mt-6" showGridlines responsiveLayout="scroll">
                    <Column field="#" header="№" style="width:3%" frozen>
                        <template #body="slotProps">
                            {{ slotProps.index + 1 }}
                        </template>
                    </Column>
                
                    <Column field="short_full_name" header="Учитель" sortable style="min-width:200px; " frozen></Column>
                
                    <Column header="Предмет" style="min-width:150px;" frozen>
                        <template #body="slotProps">
                            
                            <a href="">Биология</a>
                            <span class="flex-grow-1"></span> <span class="ml-2"> 
                                <Button icon="pi pi-plus" size="small" />
                            </span>
                           
                        </template>
                    </Column>
                
                    <Column v-for="group of groups" :key="group.id" :header="group.group_name" style="min-width:47px; max-width:47px;">
                        <template #body="slotProps">
                            <div @click="togglePopover($event, group, 'Биология')">
                                0
                            </div>
                        </template>
                    </Column>
                </DataTable>
                
                <Popover ref="op" :model="isPopoverVisible"  >
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="font-medium block mb-2">{{ selectedGroup.group_name }} {{ selectedSubject  }}</span>
                         
                            <div class="flex">
                                <Checkbox name="category" value="all" v-model="selectedSubgroup"/>
                                <label for="all" class="ml-1">Весь класс</label>
                            </div>

                            <div class="flex">
                                <Checkbox name="category" value="category.name" v-model="selectedSubgroup"/>
                                <label class="ml-1">Подгруппа 1</label>
                            </div>

                            <div class="flex">
                                <Checkbox name="category" value="category.name" v-model="selectedSubgroup"/>
                                <label class="ml-1">Подгруппа 2</label>
                            </div>
                        </div>
                    </div>
                </Popover>
                
                
      


                
            </div>
          
           

        </div>
   
       

</template>

