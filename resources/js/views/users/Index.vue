<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';



export default {
    data() {
        return {
            
            visible: null,
            icondisplay: null,
            name: null,
            surname: null,
            patronymic: null,
            username: null,
            selectedUser: null,
            loginInValid: null,
            roles:null,
            selectedRoles: null,
            deleteUsersDialog: null
        }
    },

    computed: {
            users() {
                return this.$store.getters.users;
            }
    },
    mounted() {
     
        this.$store.dispatch('getUsers')
        this.getRoles()
    },
 
    methods: {
        
        addUser(){
            let roles = [];
            this.selectedRoles.forEach(element => {
                roles.push(String(element.id))
            });

            api.post('users', {name: this.name, surname: this.surname, patronymic: this.patronymic, username: this.username, roles:roles})
            .then(res => {
                // Обрабатываем успешный ответ
               
                this.visible = false
                this.$store.dispatch('getUsers')
                this.username = null
                this.name = null
                this.surname = null
                this.patronymic = null
                this.selectedRoles = null
                
            })
            .catch(error => {
                this.loginInValid = this.username
                console.log(error)
            })

        },

        getRoles(){

            api.get('roles')
            .then(res=>{
                this.roles = res.data
            }

            )
        },

        confirmDeleteSelected() {
            this.deleteUsersDialog = true
        },
        deleteSelected(){
            let users = [];
            this.selectedUser.forEach(element => {
                users.push(element.id)
            });
            api.delete('users',  {data: {ids: users}})
            .then(res => {
                this.$store.dispatch('getUsers')
                this.deleteUsersDialog = false
                this.selectedUser = null
            })
            .catch(error => {
                console.log(error)
            })
        }
       
    

    },
    
    

}

</script>
<template>

    <div v-if="!users" class="card flex flex-col gap-4">
        <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

    </div>
    <div v-if="users">
    <Toolbar class="mb-6">
        <template #start>
            <Button label="Добавить" icon="pi pi-plus" severity="secondary" class="mr-2" @click="visible = true" />
            <Button  label="Удалить" icon="pi pi-trash" severity="secondary" @click="confirmDeleteSelected" :disabled="!selectedUser || !selectedUser.length" />
        </template>

        <template #end>
            <Button label="Импорт" icon="pi pi-upload" severity="secondary" @click="exportCSV($event)" />
        </template>
    </Toolbar>
    <DataTable v-model:selection="selectedUser"  :value="users" sortMode="multiple" tableStyle="min-width: 50rem" >
        <Column selectionMode="multiple" style="" :exportable="false" >
        </Column>
        <Column field="id" header="id" sortable style="width: 5%"  :hidden="true"></Column>
        <Column field="surname" header="Фамилия" sortable style="width: 25%"></Column>
        <Column field="name" header="Имя" sortable style="width: 25%" ></Column>
        <Column field="patronymic" header="Отчество" sortable style="width: 25%" ></Column>
        <Column field="username" header="Логин" sortable ></Column>
        <Column   header=""  style="">
            <template #body="slotProps">
                <Button icon="pi pi-pencil" outlined rounded class="mr-2" as="router-link" :to="{name: 'user.edit', params: {id: slotProps.data.id} }" />
                <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteProduct(slotProps.data)" />
            </template>
        </Column>

    </DataTable>
    
    </div>

    <Dialog v-model:visible="visible" modal header="Добавление сотрудника"  :style="{ width: '750px' }">
        
        <div class="mt-1 mb-3" v-if="loginInValid">
            <Message severity="error">Логин {{ this.login }} уже используется. Попробуйте ввести другой</Message>

        </div>
        <div class="flex items-center gap-4 mb-8">
            <label for="surname" class="font-semibold w-24">Фамилия</label>
            <InputText v-model="surname" id="surname" class="flex-auto" autocomplete="off" autofocus/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <label for="name" class="font-semibold w-24">Имя</label>
            <InputText v-model="name" id="name" class="flex-auto" autocomplete="off"  />
        </div>
        

        <div class="flex items-center gap-4 mb-8">
            <label for="patronymic" class="font-semibold w-24">Отчество</label>
            <InputText v-model="patronymic" id="patronymic" class="flex-auto" autocomplete="off" />
        </div>
        <div class="flex items-center gap-4 mb-8">
            <label for="email" class="font-semibold w-24">Дата рождения</label>
            <DatePicker v-model="icondisplay" showIcon fluid iconDisplay="input" />


        </div>

        <div class="flex items-center gap-4 mb-8">
            <label for="username" class="font-semibold w-24">Логин</label>
            <InputText v-model="username" id="username" class="flex-auto" autocomplete="off" :invalid="loginInValid !== null" />
           

        </div>

        <div class="flex items-center gap-4 mb-8">
            <label for="username" class="font-semibold w-24">Роли</label>
            <MultiSelect v-model="selectedRoles" :options="roles" optionLabel="name" filter placeholder="Выберите роли"
                :maxSelectedLabels="3" class="w-full md:w-80" />
        
           

        </div>
        
        
        <div class="flex justify-end gap-2">
            <Button type="button" label="Отмена" severity="secondary" @click="visible = false"></Button>
            <Button type="button" label="Добавить" @click="addUser"></Button>
        </div>
    </Dialog>

    <Dialog v-model:visible="deleteUsersDialog" :style="{ width: '450px' }" header="Подтверждение" :modal="true">
        <div class="flex items-center gap-4">
            <i class="pi pi-exclamation-triangle !text-3xl" />
            <span >Вы действительно хотите удалить выбранных пользователей?</span>
        </div>
        <template #footer>
            <Button   label="Нет" icon="pi pi-times" text  />
            <Button label="Да" icon="pi pi-check" text @click="deleteSelected" />
            
        </template>
    </Dialog>


</template>

