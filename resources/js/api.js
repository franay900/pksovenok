import axios from 'axios';
import router from './router'

const api = axios.create({baseURL:'/api'});

api.interceptors.response.use(config => {

    return config
},error => {


    if(error.response.status === 401) {
        // redirect to login page
        router.push({name: 'login'})
    }

    if(error.response.status === 403){
        router.push(({name: 'access'}))
    }
    return Promise.reject(error);


})


export default api
