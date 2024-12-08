<script>

import axios from 'axios';
import { RouterLink } from 'vue-router';
import { useToast } from 'primevue/usetoast';
import subject from "../../store/modules/subject.js";
import templates from "./Templates.vue";

export default {

    data(){
        return {
            days: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            day: null,
            schedule: [],
            name: null,
            toast: useToast(),
            confirmVisible: null,
            linkRedirect: null,
            check: true,
            subgroups: null,
            loadList: null,
            maxSubgroups: null,
            loadSubgroup: null,
            from: null,


        }
    },
    mounted(){


        this.$store.dispatch('getBells')
        this.$store.dispatch('getTemplates')


        this.getSubjects()


        this.$store.dispatch('getGroup', this.$route.params.id);
        this.schedule = this.generateSchedule();


    },
    computed: {
        subject() {
            return subject
        },
        bells(){
            return this.$store.getters.bells
        },

        group(){
            return this.$store.getters.group
        },



        selectedTemplate(){
            return this.templates[0]
        },

        templates(){
            return this.$store.getters.templates.map(template => ({
                ...template,
                templateName: `${template.name} (от ${template.start})`
            }))
        }

    },

    methods: {



        generateSchedule() {

            const schedule = [];
            for (let day = 0; day < 6; day++) {
                const daySchedule = [];
                for (let lesson = 1; lesson <= 7; lesson++) {
                    // Создаем новую копию объекта с помощью spread syntax
                    daySchedule.push({ ...{
                            number: lesson,
                            cabinet: null,
                            lessons: [{load: null}]
                        } });
                }
                schedule.push(daySchedule);
            }
            return schedule;
        },


        confirmAndNavigate() {
            this.confirmVisible = false;
            this.check = false;
            this.$router.push({name: this.linkRedirect});

        },

        getSubjects(){

            axios.get('/api/subject')
                .then(res => {
                    this.subjects = res.data
                    this.getLoads()
                })
        },
        getLoads(){

            axios.get(`/api/load/${this.$route.params.id}`)
                .then(res => {

                        this.loadSubgroup = true;
                        this.subgroups = res.data.subgroups
                        this.loadList = res.data.loads.map(load => ({
                            ...load,
                            subject_name: this.getSubjectName(load.subject_id).name + (load.subgroup_id ? ' (' + this.subgroups.find(p => p.id === load.subgroup_id).name + ')' : '')
                        }))


                        this.findMaxSubgroups()

                        this.getLessons()
                })

        },

        getSubjectName(id){
            return this.subjects.find(p => p.id === id)
        },

        addLesson(dayIndex, lessonNumber) {
            const lesson = this.schedule[dayIndex][lessonNumber];
            if (this.hasInvalidSubgroups(lesson.lessons)) {
                this.toast.add({
                    severity: 'error',
                    summary: 'Ошибка',
                    detail: 'Раздвоить урок можно только для подгрупп',
                    life: 3000
                });
                return 0;
            }

            lesson.lessons.push({ load: null });

        },

        hasInvalidSubgroups(subgroups) {
            // Проверяем, есть ли недействительные подгруппы

            for (let i = 0; i <= this.maxSubgroups; i++) {

                if (subgroups[i] && subgroups[i].load.subgroup_id === null) {
                    return true;
                }
            }

            return false;
        },

        findMaxSubgroups() {
            const subjectCounts = {};


            this.subgroups.reduce((counts, group) => {
                counts[group.subject_id] = (counts[group.subject_id] || 0) + 1;
                return counts;
            }, subjectCounts);



            const maxCount = Math.max(...Object.values(subjectCounts));
            if (maxCount<0){
                this.maxSubgroups = 1
            } else{
                this.maxSubgroups = maxCount
            }
        },


        handleSelectChange(dayIndex, lessonNumber, subgroupIndex) {
            const lesson = this.schedule[dayIndex][lessonNumber].lessons;
            const hasNullLoad = lesson.some(subgroup => subgroup.load.subgroup_id === null);

            const thisLoad = lesson[subgroupIndex].load;


            const repeatCount = lesson.filter(item => item !== lesson[subgroupIndex])
                .reduce((count, item) => {
                    if(!item.load){
                        return 0
                    }
                    if (item.load.subgroup_id === thisLoad.subgroup_id) {
                        return count + 1;
                    }
                    return count;
                }, 0);

            const hasNonNullLoad = lesson.some(subgroup => subgroup.load.subgroup_id
                !== null);

            // Если оба условия истинны, то сбрасываем выбор
            if (hasNullLoad && hasNonNullLoad) {
                lesson[subgroupIndex].load = null;

                this.toast.add({
                    severity: 'error',
                    summary: 'Ошибка',
                    detail: 'Одновременно весь класс и отдельная подгруппа не может присутствовать в одно и то же время',
                    life: 3000
                });
            }

            if (repeatCount>0) {
                lesson[subgroupIndex].load = null;

                this.toast.add({
                    severity: 'error',
                    summary: 'Ошибка',
                    detail: 'На занятии не может присутствовать одновременно одна и та же подгруппа',
                    life: 3000
                });
            }

            this.setLesson(thisLoad, dayIndex, lessonNumber)
        },

        setLesson(load, day, number){
            console.log(load.id, load.teacher.id, day+1, number+1);

            axios.post('/api/timetable_lesson', {load_id: load.id, day: day+1, number: number+1, timetable_id: this.selectedTemplate.id, group_id: this.group.id })
                .then(res => {
                    console.log(res.data);
                });
            this.toast.add({
                severity: 'info',
                summary: 'Успешно',
                detail: 'Урок сохранен и распределен по дням',
                life: 3000
            });
        },

        getLessons() {

            axios.get(`/api/timetable_lesson/${this.selectedTemplate.id}`)
                .then(res => {


                    res.data.data.forEach(lesson => {

                        let schedule = this.schedule[lesson.day-1][lesson.number-1].lessons
                        if(schedule[0].load === null){
                            schedule.splice(0)
                        }
                        schedule.push({ load: this.getLoadById(lesson.load_id) });
                        console.log(res.data);
                    })
                })

        },

        getLoadById(loadId){

            return this.loadList.find(load => load.id === loadId);

        },



},



}

</script>
<template>


        <div v-if="!group  || !schedule || !loadList" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>
        <div  class=" " v-if="group  && schedule && loadList  && loadSubgroup && templates">
            <div class="card">
                <div class="font-semibold text-xl">Расписание {{ group.number }}{{ group.letter }} класса</div>


                <Select v-model="selectedTemplate" :options="templates" optionLabel="templateName" size="small" placeholder="Шаблон" class="w-full mt-3 " style="width: 27%" />



            </div>


            <div class="grid ">
                <div v-for="(day, dayIndex) in days" :key="dayIndex" class="mb-5 card " >
                    <h3 class="font-bold text-center">
                        <i class="pi pi-calendar" ></i> {{ day }}
                    </h3>
                    <DataTable :value="schedule[dayIndex]"   >
                        <Column field="number" header="№ урока" style="width: 7%" ></Column>
                        <Column  header="Время"  style="width: 10%">
                            <template #body="slotProps">

                                08:00 - 08:40
                            </template>
                        </Column>
                        <Column field="begin" header="Предмет" style="width: 40%"  >
                            <template #body="slotProps">

                                <div v-for="subgroupIndex in maxSubgroups" :key="subgroupIndex">

                                    <div v-if="schedule[dayIndex][slotProps.data.number-1].lessons[subgroupIndex-1]">

                                    <Select
                                            v-model="schedule[dayIndex][slotProps.data.number-1].lessons[subgroupIndex-1].load"
                                            :options="loadList" optionLabel="subject_name"
                                            placeholder="Предмет"
                                            class="w-full md:w-70 mb-2"
                                            @change="handleSelectChange(dayIndex, slotProps.data.number - 1, subgroupIndex - 1)"
                                    >
                                        <template #empty>
                                            Нагрузка не установлена
                                        </template>
                                    </Select>
                                    </div>
                                </div>



                            </template>
                        </Column>
                        <Column field="end" header="Кабинет" style="width: 5%">

                            <template #body="slotProps">
                                <div v-for="subgroupIndex in maxSubgroups" :key="subgroupIndex">
                                    <div v-if="schedule[dayIndex][slotProps.data.number-1].lessons[subgroupIndex-1]">
                                    <Select disabled placeholder="Кабинет" class="w-full md:w-56 mb-2"  />
                                    </div>
                                </div>
                            </template>
                        </Column>

                        <Column field="end"  style="width: 5%">
                            <template #body="slotProps">

                                <Button icon="pi pi-plus" severity="secondary" @click="addLesson(dayIndex  , slotProps.data.number-1)"/>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>



        </div>

        <Dialog v-model:visible="confirmVisible" modal header="Вы уверены?" :style="{ width: '25rem' }">
            <span class="text-surface-500  block mb-8">
                Если вы перейдете на другую страницу, вся введенная информация пропадет.</span>


            <div class="flex justify-end gap-2">
                <Button type="button" label="Отмена" severity="secondary" @click="confirmVisible = false"></Button>
                <Button type="button" label="Перейти" @click="confirmAndNavigate()"></Button>
            </div>
        </Dialog>

</template>

