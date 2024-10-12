<script>


export default {
   

    mounted(){
        this.$store.dispatch('getBells')
    },
    computed: {
        bells(){
            return this.$store.getters.bells
        }
    }
}

</script>
<template>
    <div  class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Расписание звонков</div>
        
        <div v-if="!bells" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>
        <DataTable v-if="bells" v-model:selection="selectedUser"  :value="bells" sortMode="multiple" tableStyle="min-width: 50rem" >
            <Column selectionMode="multiple" style="" :exportable="false" >
            </Column>
            <Column field="id" header="id" sortable style="width: 5%"  :hidden="true"></Column>
            <Column field="name" header="Наименование" sortable ></Column>
            <Column field="id" header="Учебная неделя" sortable  ></Column>
            <Column   header=""  style="">
                <template #body="slotProps">
                    <Button icon="pi pi-eye" outlined rounded class="mr-2" as="router-link" :to="{name: 'bells.show', params: {id: slotProps.data.id} }" />
                    <Button icon="pi pi-trash" outlined rounded severity="danger" />
                </template>
            </Column>

        </DataTable>
        <div class="grid grid-cols-10 ">
            <Button label="Добавить" icon="pi pi-plus" as="router-link" :to="{name: 'bells.create'}"  />
        </div>
    </div>

</template>

