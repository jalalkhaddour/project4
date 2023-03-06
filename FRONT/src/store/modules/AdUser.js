const AdUser = {
    namespaced: true,
    state: {
        username: '',
        password: '',
        Authenticated: false,
        Cookies: '',
        Role: ''
    },
    getters: {
        username(state, getters, rootState) {

            return state.username;
        },
        password(state) {
            return state.password;
        },
        Authenticated(state) {
            return state.Authenticated;
        },
        Cookies(state) {
            return state.Cookies;
        },
        Role(state) {
            return state.Role;
        }
    },
    mutations: {
        SetUsername(state, un) {
            state.username = un
        },
        SetPassword(state, p) {
            state.password = p
        },
        SetAuthenticated(state, a) {
            state.Authenticated = a
        },
        SetCookies(state, c) {
            state.Cookies = c
        },
        SetRole(state, r) {
            state.Role = r
        }


    },

    actions: {}
}
export default AdUser;