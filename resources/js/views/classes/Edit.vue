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
            numbers: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            selectedClass: null,
            selectedPeriod: null,
            selectedBell: null,
            selectedTeacher: null,
            selectedNumber: null,
            letter: null,
            selectedSubject: null,
            subgroupName: null,
            subgroups: null,
            toast: useToast()

        }
    },

    computed: {
        bells() {
            return this.$store.getters.bells;
        },

        group(){

            return this.$store.getters.group;
        },

        teachers(){
            return this.$store.getters.teachers
        },

        periods(){
            return this.$store.getters.periods
        },

        subjects(){
            return this.$store.getters.subjects
        },


    },
    mounted() {
        this.$store.dispatch('getBells');
        this.$store.dispatch('getGroup', this.$route.params.id);
        this.$store.dispatch('getGroupsByOrganization')
        this.$store.dispatch('getSubjects')
        this.getSubgroups()
    },

    methods: {

        createSubgroup(){
            api.post('subgroup', {name: this.subgroupName, subject_id: this.selectedSubject.id, group_id: this.group.id})
            .then(res=> {
                this.visible = false

                this.getSubgroups()
                this.toast.add(
                    { severity: 'info', summary: 'Сохранено',
                    detail: `Создана подгруппа "${this.subgroupName} для предмета ${this.selectedSubject.short_name}`,
                    life: 3000 });
            })
        },

        getSubgroups(){

            api.get(`subgroup/${this.$route.params.id}`)
            .then(res => {
                this.subgroups = res.data
            })
        },


    },



}

</script>
<template>
        <div v-if="!group || !teachers || !periods || !bells" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>



        <div  class="card flex flex-col gap-4" v-if="group">
            <div class="font-semibold text-xl">{{ group.number }}{{ group.letter }} класс</div>
            <Tabs value="0" >
                <TabList>
                    <Tab value="0">Информация</Tab>
                    <Tab value="1">Подгруппы</Tab>

                </TabList>
                <TabPanels>
                    <TabPanel value="0">

                        <div class="grid grid-cols-12 gap-2">
                            <label for="surname" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Номер</label>
                            <div class="col-span-12 md:col-span-10">
                                <Select id="inventoryStatus" :options="numbers"  v-model="group.number" placeholder="Выберите номер" fluid></Select>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-2 mt-3">
                            <label for="name3" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Буква</label>
                            <div class="col-span-12 md:col-span-10 ">
                                <InputText id="name"  type="text"   fluid v-model="group.letter"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 mt-3">
                            <label for="surname" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Звонки</label>
                            <div class="col-span-12 md:col-span-10">
                                <Select id="inventoryStatus" :options="bells"    v-model="group.bell" optionLabel="name" fluid></Select>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 mt-3">
                            <label for="patronymic" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Периоды</label>
                            <div class="col-span-12 md:col-span-10">
                                <Select id="inventoryStatus" :options="periods"    v-model="group.period" optionLabel="name" fluid></Select>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 mt-3">
                            <label for="patronymic" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Классный руководитель</label>
                            <div class="col-span-12 md:col-span-10">
                                <Select id="inventoryStatus" :options="teachers"    v-model="group.manager" optionLabel="fullName" fluid></Select>
                            </div>
                        </div>
                    </TabPanel>
                    <TabPanel value="1" v-if="subgroups">


                        <DataTable   :value="subgroups" sortMode="multiple" tableStyle="min-width: 50rem" >

                            <Column  header="№" sortable   style="width: 5%;">
                                <template #body="slotProps">
                                    {{ slotProps.index + 1  }}
                                </template>

                            </Column>
                            <Column field="subgroup_name" header="Наименование" sortable   ></Column>

                            <Column field="subject_name" header="Предмет" sortable   ></Column>

                        </DataTable>

                        <Button type="button" class="mt-3"  label="Добавить подгруппу" @click="visible = true" ></Button>


                        <Dialog v-model:visible="visible" modal header="Добавление подгруппы" :style="{ width: '35rem' }">

                            <div class="flex items-center gap-4 mb-4">
                                <label for="subject" class="font-semibold w-24">Предмет</label>
                                <Select id="subject" :options="subjects"    v-model="selectedSubject" optionLabel="name"  class="w-full md:w-56"></Select>
                            </div>
                            <div class="flex items-center gap-4 mb-8">
                                <label for="email" class="font-semibold w-24">Наименование</label>
                                <InputText id="email" class="flex-auto" autocomplete="off"  v-model="subgroupName" />
                            </div>
                            <div class="flex justify-end gap-2">
                                <Button type="button" label="Отмена" severity="secondary" @click="visible = false"></Button>
                                <Button type="button" label="Добавить" @click="createSubgroup"></Button>
                            </div>
                        </Dialog>
                    </TabPanel>

                </TabPanels>
            </Tabs>


        </div>



</template>

