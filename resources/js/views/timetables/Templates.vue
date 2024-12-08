<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';
import { useToast } from 'primevue/usetoast';



export default {
    data() {
        return {
            groupId: this.$route.params.id

        }
    },

    computed: {
        group() {
            return this.$store.getters.group
        },
        templates(){
            return {0: {name: 'Основной шаблон'}}
        }
    },
    mounted() {
        this.$store.dispatch('getGroup', this.$route.params.id)
    },

    methods: {



    },




}

</script>
<template>


    <div v-if="!group" class="card flex flex-col gap-4">
        <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

    </div>
    <div v-if="group" class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Шаблоны расписания {{ group.number }}{{ group.letter }} класса</div>


        <div >
            <div class="grid">
                <DataTable   :value="templates" sortMode="multiple" tableStyle="min-width: 50rem"  show>

                    <Column field="id" header="id" sortable style="width: 5%"  :hidden="true"></Column>


                    <Column field="name" style="width: 83%" header="Наименование" sortable ></Column>

                    <Column   header=""  style="">
                        <template #body="slotProps" >
                            <Button icon="pi pi-pencil"
                                    outlined rounded  as="router-link"
                                    :to="{name: 'class.edit', params: {id: slotProps.data.id} }"
                                    v-tooltip.bottom="{ value: 'Редактировать', autoHide: false }"
                            />
                            <Button icon="pi pi-table"
                                    outlined rounded
                                    v-tooltip.bottom="{ value: 'Распределить по дням', autoHide: false }"
                            />
                            <Button icon="pi pi-copy"
                                    outlined rounded
                                    v-tooltip.bottom="{ value: 'Копировать', autoHide: false }"
                            />
                            <Button icon="pi pi-trash"
                                    outlined rounded severity="danger"
                                    v-tooltip.bottom="{ value: 'Удалить', autoHide: false }"
                            />

                        </template>
                    </Column>

                </DataTable>
            </div>
        </div>


        <div class="grid grid-cols-10 ">
            <Button label="Добавить" icon="pi pi-plus" as="router-link"  :to="{name: 'timetable.create', params: {id: groupId}}" />
        </div>
    </div>



</template>

