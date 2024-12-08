<script>
import api from "@/api.js";

export default {
    name: "Index",

    mounted() {
        this.$store.dispatch('getGroupsByOrganization');
        this.$store.dispatch('getTemplates')

    },

    computed: {
        groups(){


            return this.$store.getters.groups
        },


        groupedClasses() {
            return this.groups.reduce((acc, item) => {
                const number = item.number;
                if (!acc[number]) {
                    acc[number] = [];
                }
                acc[number].push(item);
                return acc;
            }, {});
        },

        templates(){
            return this.$store.getters.templates
        }
    },

    data(){
        return {
            parallels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            uniqueClasses: null,
            visible: null,
            from: null,
            mode: null,
            name: null

        };
    },

    methods: {
        createOrCopyTemplate(mode){
            this.mode = mode
            this.visible = true

        },

        saveTemplate(){
            this.visible = false
            api.post('timetable', {start_date: this.from, name: this.name} )
                .then(res => {
                    this.$store.dispatch('getTemplates')
                });
        }
    },




}
</script>

<template>
    <div class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Расписание</div>

        <div v-if="!groups" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>
        <div v-if="groups && templates">



                <Tabs value="0">
                    <TabList>
                        <Tab value="0">Шаблоны</Tab>
                        <Tab value="1">Классы</Tab>
                        <Tab value="2">Header III</Tab>
                    </TabList>
                    <TabPanels class="tab-templates">
                        <TabPanel value="0">

                            <DataTable :value="templates" sortMode="multiple" show class="template-table">

                                <Column field="id" header="id" sortable style="width: 5%"  :hidden="true"></Column>


                                <Column field="name" style="width: 45%" header="Наименование" sortable ></Column>
                                <Column field="start" style="width: 45%" header="От" sortable ></Column>

                                <Column   header=""  style="">
                                    <template #body="slotProps" >


                                        <Button icon="pi pi-copy"
                                                outlined rounded
                                                v-tooltip.bottom="{ value: 'Копировать', autoHide: false }"
                                                @click="createOrCopyTemplate('Копирование')"
                                        />


                                    </template>
                                </Column>

                            </DataTable>

                            <Button label="Добавить" severity="secondary" class="mt-3" @click="createOrCopyTemplate('Добавление')" />

                        </TabPanel>
                        <TabPanel value="1">
                            <div class="grid">
                                <div v-for="parallel in parallels" :key="parallel">
                                    <div class="col" v-if="groupedClasses[parallel]">

                                        <div class=" text-xl">{{ parallel }} </div>
                                        <div v-for="classItem in groupedClasses[parallel]"  class="flex flex-column gap-1">
                                            <div class="flex flex-row gap-1">
                                                <div class="text-center clsss-item" >

                                                    <router-link  class="link" :to="{name: 'timetable.create', params: {id: classItem.id} }" >{{ parallel }}{{ classItem['letter'] }}</router-link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="2">
                            <p class="m-0">
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa
                                qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                            </p>
                        </TabPanel>
                    </TabPanels>
                </Tabs>





                    <Dialog v-model:visible="visible" modal :header="mode" :style="{ width: '25rem' }">
                        <div class="flex items-center gap-4 mb-4">
                            <label for="username" class="font-semibold w-24 mr-3">Наименование</label>
                            <InputText type="text" v-model="name" />
                        </div>

                        <div class="flex items-center gap-4 mb-4">
                            <label for="username" class="font-semibold w-24 mr-3">Дата с</label>
                            <DatePicker v-model="from" showIcon fluid iconDisplay="input" />
                        </div>
                        <div class="flex justify-end gap-2">
                            <Button type="button" label="Отмена" severity="secondary" @click="visible = false"></Button>
                            <Button type="button" label="Сохранить" @click="saveTemplate"></Button>
                        </div>
                    </Dialog>




        </div>

    </div>
</template>

<style scoped lang="scss">

    .grid{
        display: flex;
    }

    .col {
        margin-right: 70px;

    }

    .link {
        color:var(--primary-color);
    }

    .clsss-item{
        margin-top: 12px;
    }

    .tab-templates{
        padding-left: 0px;
    }
</style>
