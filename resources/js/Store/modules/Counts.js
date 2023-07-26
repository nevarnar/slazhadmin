export default {
    namespaced: true,
    state: {
        count: 1,
    },
    getters: {
        myCount(state) {
            return state.count;
        },
    },
    mutations: {
        INCREMENT(state) {
            state.count++;
        },
    },
    actions: {
        increCount({ commit }) {
            commit("INCREMENT");
        },
    },
};
