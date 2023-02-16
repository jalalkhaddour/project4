const Student = {
    namespaced: true,
    state: {
        university_num: '',
        fullname: '',
        info: {}
    },
    getters: {
        university_num(state, getters, rootState) {

            return state.university_num;
        },
        fullname(state) {
            return state.fullname;
        },
        info(state) {
            return state.info
        }
    },
    mutations: {
        SetID(state, id) {
            state.university_num = id
        },
        SetName(state, n) {
            state.fullname = n
        },
        SetInfo(state, i) {
            state.info = i
        }
    },

    actions: {}
}
export default Student;