import { createStore } from 'vuex'
import Student from './modules/Student.js'
import AdUser from './modules/AdUser.js'
import Exam from './modules/Exam.js';
const store = createStore({
    state() {
        return {
            dept: '',
            spec: '',
        }
    },
    getters: {
        dept(state) {
            return state.dept
        },
        spec(state) {
            return state.spec
        }

    },
    mutations: {
        setDept(state, de) {
            state.dept = de
            console.log(state.dept)
        },
        setSpec(state, sp) {
            state.spec = sp
            console.log(state.spec)
        }
    },
    actions: {},
    modules: {
        Student: Student,
        AdUser: AdUser,
        Exam: Exam

    }
});

export default store