import axios from 'axios';

const state = {
    bells: null
}

const getters = {

    bells: state => state.bells,
}

const actions = {
    getBells({commit}){
        axios.get('/api/bell')
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
