import api from '../../api';

const state = {
    groups: null,
    group: null,

    teachers: null,
    periods: null
}

const getters = {
    groups: state => state.groups,
    group: state => state.group,
    teachers: state => state.teachers,
    periods: state => state.periods,
}

const actions = {
    
    getGroupsByOrganization({commit}){

        api.get('group')
        .then(res => {

            commit('setGroups', res.data.groups)
            commit('setTeachers', 
                res.data.teachers.map(teacher => ({
                    ...teacher,
                    fullName: `${teacher.surname} ${teacher.name} ${teacher.patronymic}` // Добавляем поле fullName
                  }))
            )
            commit('setPeriods', res.data.periods)
        })
    },

    getGroup({commit}, id){
        api.get(`group/${id}`)
        .then(res => {
            

            commit('setGroup', res.data.data)
        })
    }
}

const mutations = {
    setGroups(state,groups){
        state.groups = groups
    },
    setGroup(state,group){
        let teacher = group.manager
        group.manager.fullName = `${teacher.surname} ${teacher.surname} ${teacher.patronymic}` 
        state.group = group
    },
    setTeachers(state,teachers){
        state.teachers = teachers
    },


    setPeriods(state,periods){
        state.periods = periods
    },
}

export default {
    state, mutations, getters, actions
}


