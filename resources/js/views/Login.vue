<script >

import axios from 'axios'


export default {
    name: 'Login',
    data() {
        return {
            username: null,
            password: null,
            invalidLogin: false
        }
    },


    methods: {
       login(){
            axios.get('sanctum/csrf-cookie').
                then(res => {
                axios.post('', {username: this.username, password:this.password})
                    .then(res=>{


                        this.$router.push({name: 'dashboard'})
                    })
                    .catch(error =>{
                        this.invalidLogin = true;
                        console.error(error)
                    })
            })

       }
    },
}

</script>

<template>

    <div class="bg-surface-50  flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full bg-surface-0  py-20 px-8 sm:px-20" style="border-radius: 53px">
                    <div class="text-center mb-8">
                        <img src="/img/logo.jpg" alt="Girl in a jacket"
                        style="width: 40px; height:40px;border-radius:50%;margin-left: auto;
                        margin-right: auto;
                        ">
                        <div class="text-surface-900 text-3xl font-medium mb-4">Добро пожаловать!</div>
                        <span class="text-muted-color font-medium">Войдите, чтобы продолжить</span>
                    </div>

                    <div>
                        <Message severity="error" v-if="invalidLogin">Неверный логин или пароль</Message>
                        <label for="username" class="block text-surface-900 text-xl font-medium mb-2">Логин</label>
                        <InputText id="username" type="text" placeholder="Логин" class="w-full md:w-[30rem] mb-8" v-model="username" :invalid="invalidLogin" />

                        <label for="password1" class="block text-surface-900  font-medium text-xl mb-2">Пароль</label>
                        <Password id="password1" v-model="password" placeholder="Пароль" :toggleMask="true" class="mb-4" fluid :feedback="false" :invalid="invalidLogin" @keyup.enter="login"></Password>

                        <div class="flex items-center justify-between mt-2 mb-8 gap-8">

                            <span class="font-medium no-underline ml-2 text-right cursor-pointer text-primary">Забыли пароль?</span>
                        </div>

                        <Button label="Войти"   @click="login"></Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
