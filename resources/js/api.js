import axios from 'axios';
import router from './router'

const api = axios.create({baseURL:'/api'});
api.interceptors.request.use(config=>{
    if (localStorage.getItem('access_token')){
        config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
        
    }
    return config
}, error => {
    return Promise.reject(error);
})

api.interceptors.response.use(config => {
    if (localStorage.getItem('access_token')){
        config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
          
    }
    return config
},error => {

    
    if(error.response.data.message == 'Token has expired'){
        
        return api.post('auth/refresh', {}, {
            headers: {
                'authorization' : `Bearer ${localStorage.getItem('access_token')}`
            }
        }).then(res=>{

            
            localStorage.setItem('access_token', res.data.access_token)
            error.config.headers.authorization = `Bearer ${res.data.access_token}`
      
            return api.request(error.config)
        }).catch(error => {
            console.log(error)
        })
    }
    if(error.response.status === 401){
        localStorage.removeItem('access_token')
        router.push({name: 'login'})
    }

    if(error.response.status === 403){
  
        router.push({name: 'access'})
    }

    return Promise.reject(error);
})


export default api