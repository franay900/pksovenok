import api from '../../api';

const state = {
    subjects: null
}

const getters = {
    subjects: state => state.subjects
}

const actions = {
    
    getSubjects({commit}){

        api.get('subject')
        .then(res => {
           commit('setSubjects', res.data)
        })
    },



}

const mutations = {
    setSubjects(state, subjects){
        state.subjects = subjects
    },
}

export default {
    state, mutations, getters, actions
}


