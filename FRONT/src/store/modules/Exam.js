const Exam = {
    namespaced: true,
    state: {
        c_code: 0,
        study_year: "",
        semster: "",
    },
    getters: {
        c_code(state) {
            return state.c_code;
        },
        study_year(state) {
            return state.study_year;
        },
        semster(state) {
            return state.semster
        }
    },
    mutations: {
        SetCode(state, c) {
            state.c_code = c;
        },
        SetStudyYear(state, s) {
            state.study_year = s;
        },
        SetSemster(state, s) {
            state.semster = s;
        }
    },

    actions: {},
};
export default Exam;