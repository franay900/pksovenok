import { createStore } from 'vuex'
import userModule from "./modules/user";
import bellModule from "./modules/bell";
import groupModule from "./modules/group";
import subjectModule from './modules/subject';

const store = createStore({
    modules: {
        user: userModule,
        bell: bellModule,
        group: groupModule,
        subject: subjectModule
    }
})

export default store
