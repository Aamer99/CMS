import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            user: [],
            token: null,
            menu: [],
            departments: [],
            managers: [],
        };
    },
    mutations: {
        setUser(state, newUser) {
            console.log(newUser);
            state.user = newUser;
            localStorage.setItem("currentUser", JSON.stringify(newUser));
        },
        setToken(state, newToken) {
            state.token = newToken;
            localStorage.setItem("token",newToken);
        },
        setMenu(state, newMenu) {
            state.menu = newMenu;
        },
        setManagers(state, newManagers) {
            state.managers = newManagers;
        },
        setDepartments(state, newDepartments) {
            state.departments = newDepartments;
        },
    },
});

export default store;
