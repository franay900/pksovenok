<script>

import api from '../../api';
export default {
  data() {
    return {
      visible: null,
      numbers: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
      selectedClass: null,
      periods: [],
      selectedPeriod: null,
      selectedBell: null,
      teachers: null,
      selectedTeacher: null,
      selectedNumber: null,
      letter: null,
      groups: null
    };
  },
  mounted() {
    this.$store.dispatch('getBells');
    this.getOrganizationInfo();
  },
  computed: {
    bells() {
      return this.$store.getters.bells;
    },
  },
  methods: {
    getOrganizationInfo() {
      api.get('group')
        .then(res => {
          this.periods = res.data.periods; // Теперь this.periods определен
          this.teachers = res.data.teachers.map(teacher => ({
            ...teacher, 
            fullName: `${teacher.surname} ${teacher.surname} ${teacher.patronymic}` // Добавляем поле fullName
          }));
       
          this.groups = res.data.groups
         
        })
        .catch(error => {
          console.error(error);
        });
    },

    createClass(){

        api.post('group', 
        {number: this.selectedNumber, letter: this.letter, manager_id: this.selectedTeacher.id, period_type_id: this.selectedPeriod.id, bell_id: this.selectedBell.id})
        .then(res => {
            this.visible = false
            this.getOrganizationInfo()
        })
        
    }
  },
};

</script>
<template>

    <div v-if="!groups" class="card flex flex-col gap-4">
       <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

    </div>
    <div v-if="groups"  class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Классы</div>

     
        <DataTable   :value="groups" sortMode="multiple" tableStyle="min-width: 50rem" >
            <Column selectionMode="multiple" style="" :exportable="false" >
            </Column>
            <Column field="id" header="id" sortable style="width: 5%"  :hidden="true"></Column>
            <Column field="number" header="Номер" sortable ></Column>
            <Column field="letter" header="Буква" sortable  ></Column>
            <Column field="manager_full_name" header="Классный руководитель" sortable  ></Column>
            <Column field="bell.name" header="Звонки" sortable  ></Column>
            <Column field="period_type.name" header="Периоды" sortable  ></Column>
            <Column   header=""  style="">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" outlined rounded class="mr-2" as="router-link" :to="{name: 'class.edit', params: {id: slotProps.data.id} }" />
                    <Button icon="pi pi-trash" outlined rounded severity="danger" />
                </template>
            </Column>

        </DataTable>
        <div class="grid grid-cols-10 ">
            <Button label="Добавить" icon="pi pi-plus" severity="secondary" class="mr-2" @click="visible = true" />
        </div>
    </div>

    <Dialog v-model:visible="visible" modal header="Добавление класса"  :style="{ width: '750px' }">

        <div class="flex flex-col gap-6">
            
            <div>
                <label for="name" class="block  mb-3">Номер</label>
                <Select id="inventoryStatus" :options="numbers"  v-model="selectedNumber" placeholder="Выберите номер" fluid></Select>
                
            </div>
            <div>
                <label for="description" class="block mb-3">Буква</label>
                <InputText v-model="letter" id="description" required="true" rows="3" cols="20" fluid />
            </div>
            <div>
                <label for="inventoryStatus" class="block  mb-3">Классный руководитель</label>
                <Select id="inventoryStatus" :options="teachers" v-model="selectedTeacher" optionLabel="fullName" placeholder="Выберите классного руководителя" fluid></Select>
            </div>

            <div>
                <label for="inventoryStatus" class="block  mb-3">Профиль звонков</label>
                <Select id="inventoryStatus" :options="bells"  v-model="selectedBell" optionLabel="name" placeholder="Выберите профиль звонков" fluid></Select>
            </div>

            <div>
                <label for="inventoryStatus" class="block  mb-3">Периоды</label>
                <Select id="inventoryStatus" :options="periods" v-model="selectedPeriod" optionLabel="name_many" placeholder="Выберите периоды" fluid></Select>
            </div>
        </div>
        
        
        <div class="flex justify-end gap-2 mt-3">
            <Button type="button" label="Отмена" severity="secondary" @click="visible = false"></Button>
            <Button type="button" label="Добавить" @click="createClass"></Button>
        </div>
    </Dialog>

</template>

