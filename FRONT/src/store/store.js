import { createStore } from "vuex";
import Student from "./modules/Student.js";
import AdUser from "./modules/AdUser.js";
import Exam from "./modules/Exam.js";
const store = createStore({
    state() {
        return {
            dept: "",
            spec: "",
            homeAnimation: false,
            homeAnimation2: false,
        };
    },
    getters: {
        dept(state) {
            return state.dept;
        },
        spec(state) {
            return state.spec;
        },
        homeAnimation(state) {
            return state.homeAnimation;
        },
        homeAnimation2(state) {
            return state.homeAnimation2;
        },
    },
    mutations: {
        setDept(state, de) {
            state.dept = de;
            console.log(state.dept);
        },
        setSpec(state, sp) {
            state.spec = sp;
            console.log(state.spec);
        },
        setHomeAnimation(state, ha) {
            state.homeAnimation = ha
        },
        setHomeAnimation2(state, ha) {
            state.homeAnimation2 = ha
        }
    },
    actions: {},
    modules: {
        Student: Student,
        AdUser: AdUser,
        Exam: Exam,
    },
});

export default store;