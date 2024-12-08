import axios from 'axios';
import templates from "@/views/timetables/Templates.vue";

const state = {
    templates: null
}

const getters = {
    templates: state => state.templates
}

const actions = {

    getTemplates({state,commit,dispatch}){

        axios.get('/api/timetable')
            .then(res => {
                commit('setTemplates', res.data)
            })

    },

}

const mutations = {
    setTemplates(state,templates){
        state.templates = templates
    },



}

export default {
    state, mutations, getters, actions
}

