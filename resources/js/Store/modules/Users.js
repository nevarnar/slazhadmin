export default {
    state: {
        users: [],
    },
    getters: {
        myUsers(state) {
            return state.users;
        },
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
    },
    actions: {
        async availableChangeUser({ commit }, payload) {
            payload.data.is_archive = 1 - payload.data.is_archive;

            let res = await axios.post(`/${payload.url}`, payload.data);
        },
    },
};
