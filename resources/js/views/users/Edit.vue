<script>

import api from '../../api';
export default {

    data(){
        return {
            radioValue: "мужской",

            
        }
    },
    mounted(){
        this.$store.dispatch('getUser', this.$route.params.id)
        this.$store.dispatch('getRoles')
    },

    computed: {
        user(){
            return this.$store.getters.user
        },

        roles(){
            return this.$store.getters.roles
        },

        selectedRoles(){
            return this.$store.getters.selectedRoles
        },

        
    },

    methods: {
        updateUser(){
            api.patch(`users/${this.user.id}`, {name: this.user.name, surname: this.user.surname, patronymic: this.user.patronymic, roles: this.user.roles})
            .then(res => {
                console.log(res.data)
            })
        },

        upload(){

        },

        onUpload(){
            
        }
    },

  
 

   

}

</script>
<template>
        
        <div v-if="!user" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>
        <div v-if="user" class="card flex flex-col gap-4">
            <div class="font-semibold text-xl">Карточка пользователя</div>
            <div class="grid grid-cols-12 gap-2 ">
            <div class="col-span-12 md:col-span-2 ">
            <Avatar label="P" class="mr-2" size="xlarge" />
            </div>
            <div class="col-span-12 md:col-span-10 ">
                <FileUpload ref="fileupload" mode="basic" name="demo[]" url="/api/upload" accept="image/*" :maxFileSize="1000000" @upload="onUpload" />
                <Button class="mt-1" label="Обновить" @click="upload" severity="secondary" fluid />
            </div>
            </div>
            
            <div class="grid grid-cols-12 gap-2">
                <label for="surname" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Фамилия</label>
                <div class="col-span-12 md:col-span-10">
                    <InputText id="surname" type="text" v-model="user.surname"  fluid/>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-2 ">
                <label for="name3" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Имя</label>
                <div class="col-span-12 md:col-span-10 ">
                    <InputText id="name"  type="text"  v-model="user.name"  fluid/>
                </div>
            </div>


            <div class="grid grid-cols-12 gap-2 ">
                <label for="patronymic" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Отчество</label>
                <div class="col-span-12 md:col-span-10 ">
                    <InputText id="patronymic"  type="text" v-model="user.patronymic"  fluid/>
                </div>
            </div>

            
            <div class="grid grid-cols-12 gap-2 ">
                <label for="email"class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Дата рождения</label>
                <div class="col-span-12 md:col-span-3 " >
                    <DatePicker  v-model="user.birthday" showIcon fluid iconDisplay="input"   />
                </div>
    
            </div>
            <div class="grid grid-cols-12 gap-2 ">
                <label for="gender" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Пол</label>
                <div class="col-span-12 md:col-span-3 ">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex items-center">
                            <RadioButton id="option1" name="option" value="мужской" v-model="radioValue" />
                            <label for="option1" class="leading-none ml-2">мужской</label>
                        </div>
                        <div class="flex items-center">
                            <RadioButton id="option2" name="option" value="женский" v-model="radioValue" />
                            <label for="option2" class="leading-none ml-2">женский</label>
                        </div>
                       
                    </div>
                </div>
               
    
            </div>
            <div class="grid grid-cols-12 gap-2 ">
                <label for="username" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Роли</label>
                <div class="col-span-12 md:col-span-3 ">
                <MultiSelect v-model="user.roles" :options="roles" optionLabel="name" filter placeholder="Выберите роли"
                    :maxSelectedLabels="3" class="w-full md:w-80"  />
                </div>
               
    
            </div>

            

            <div class="grid grid-cols-12 gap-2 ">
                <label for="username" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Логин</label>
                <div class="col-span-12 md:col-span-10 ">
                    <InputText disabled="" v-model="user.username" id="username"  type="text"  fluid/>
                </div>
            </div>

            <div class="flexgap-2 mt-3">
               
                <Button type="button" label="Обновить" @click="updateUser"></Button>
            </div>
        </div>
    
    

</template>

