<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';
import group from '@/store/modules/group';
import subject from '@/store/modules/subject';
import { useToast } from 'primevue/usetoast';


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
            selectedSubject: null,
            filteredSubgroupsForSubject: {},
            subgroups: null,
            loads: null,
            loadList: null,
            toast: useToast()
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
                    short_full_name:  `${teacher.surname} ${teacher.name[0]}.${teacher.patronymic[0]}.` ,
                    fullName: `${teacher.surname} ${teacher.name} ${teacher.patronymic}` // Добавляем поле fullName
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

        getLoads(event){
         
            api.get(`load/${this.selectedGroup.id}`)
            .then(res => {
                this.subgroups = res.data.subgroups
                this.loadList = res.data.loads
            })
        },

        getSubgroupBySubject(subjectId){

            return this.subgroups.find(subgroup => subgroup.subject_id === subjectId);

        },

        setLoads() {
            const loads = {}; 

            this.subjects.forEach(subject => {

                
                const filteredSubgroups = this.subgroups.filter(subgroup => subgroup.subject_id === subject.id);

                const getTeacher = (subgroup_id) => {
                    const teacher = this.loadList.find(p => p.subject_id === subject.id && p.subgroup_id === subgroup_id)?.teacher;
                    if (teacher) {
                        teacher['fullName'] = `${teacher.surname} ${teacher.name} ${teacher.patronymic}`;
                        teacher['short_full_name'] = `${teacher.surname} ${teacher.name[0]}.${teacher.patronymic[0]}.`;
                    }
                    return teacher || null;
                };

                if (filteredSubgroups.length > 0) {

                
                loads[subject.id] = filteredSubgroups.reduce((acc, subgroup) => {
                    
                    acc[subgroup.id] = { 
                    teacher: getTeacher(subgroup.id)
                    };
                    return acc;
                }, {});
                } else {
      
                    loads[0] = loads[0] || {}; // Инициализируем, если еще нет
                    loads[0][subject.id] = { 
                        subject_id: subject.id,
                        subgroup: null,
                        teacher: getTeacher(null)
                    };
                }
            });

            this.loads = loads;
        },

        updateLoad(event, subject_id, subgroup_id, teacher_id){
            api.post(`load`, {group_id: this.selectedGroup.id, subject_id: subject_id, subgroup_id: subgroup_id, teacher_id: event.value.id})
            .then(res => {
                this.toast.add(
                    { severity: 'info', summary: 'Сохранено', 
                    detail: 'Нагрузка обновлена (установлена)', 
                    life: 3000 });

            })
     },


        

    },
    

    watch: {
    subgroups(newSubgroups) {
      this.filteredSubgroupsForSubject = {};
      for (const subgroup of newSubgroups) {
        
        if (!this.filteredSubgroupsForSubject[subgroup.subject_id]) {
            
          this.filteredSubgroupsForSubject[subgroup.subject_id] = [];
        }
        this.filteredSubgroupsForSubject[subgroup.subject_id].push(subgroup);
      }
      this.setLoads()
      
    },
}
    

}

</script>
<template>


        <div  class="card flex flex-col gap-4">
            <div class="font-semibold text-xl">Учебная нагрузка</div>

            <div v-if="!subjects" class="card flex flex-col gap-4">
                <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>
    
            </div>
            <div   class="mb-4" style="width: auto;">
                
                <Select v-model="selectedGroup" :options="groups" optionLabel="group_name" placeholder="Выберите класс" class="w-full md:w-56"  @change="getLoads($event)" />
                
                <DataTable v-model:selection="selectedUser"  :value="subjects" sortMode="multiple" tableStyle="min-width: 50rem" v-if="selectedGroup && subgroups">

                    <Column  header="№" sortable   style="width: 5%;">
                        <template #body="slotProps">
                            {{ slotProps.index + 1  }}
                        </template>
                        
                    </Column>
                    <Column field="name" header="Предмет" sortable  ></Column>
                    <Column header="Подгруппа" sortable>
                        
                        <template #body="slotProps">
                          <template v-if="filteredSubgroupsForSubject[slotProps.data.id]">
                            <div class="col mt-3" v-for="subgroup in filteredSubgroupsForSubject[slotProps.data.id]" :key="subgroup.id">
                              {{ subgroup.name }} 
                              
                            </div>
                          </template>
                          <template v-else>
                            <div class="col ">Весь класс</div>
                          </template>
                        </template>
                      </Column>
                    
                    <Column  header="Учитель" sortable  >
                        <template #body="slotProps">
                            
                            
                            <div v-if="filteredSubgroupsForSubject[slotProps.data.id]">
                                
                                <div class="col mt-3" v-for="subgroup in filteredSubgroupsForSubject[slotProps.data.id]" :key="subgroup.id">
                                    
                                    <Select  :options="teachers" 
                                    v-model="loads[slotProps.data.id][subgroup.id].teacher" 
                                    optionLabel="fullName" 
                                    placeholder="Выберите учителя" 
                                    class="w-full md:w-56"

                                    @change="updateLoad($event, slotProps.data.id, subgroup.id)"
                                     />
                                   
                                </div>
                            </div>
                              <div v-else>
                                <div class="col ">
                                    <Select 
                                    v-model="loads[0][slotProps.data.id].teacher" 
                                    :options="teachers" 
                                    optionLabel="fullName" 
                                    placeholder="Выберите учителя" 
                                    class="w-full md:w-56" 
                                    @change="updateLoad($event, slotProps.data.id, null)"/>
                                </div>
                            </div>
                            
                          
                        </template>
                    </Column>
            
                </DataTable>
                


                
            </div>
          
           

        </div>
   
       

</template>

