import api from '../../api';

const state = {
    bells: null
}

const getters = {
    
    bells: state => state.bells,
}

const actions = {
    getBells({commit}){
        api.get('/bell')
        .then(res => {
            commit('setBells', res.data.data)
        })
    },

    

}

const mutations = {


    setBells(state, bells){
        state.bells = bells
    }
}

export default {
    state, mutations, getters, actions
}