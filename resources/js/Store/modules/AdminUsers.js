export default {
    state: {
        admin_users: [],
    },
    getters: {
        adminUsers(state) {
            return state.admin_users;
        },
    },
    mutations: {
        setAdminUsers(state, admin_users) {
            state.admin_users = admin_users;
        },
        removeAdminUser(state, removeId) {
            state.admin_users = state.admin_users.filter((supplier) => {
                return supplier.id != removeId;
            });
        },
    },
    actions: {
        async deleteAdminUser(context, removeId) {
            await axios.delete(`/admins/${removeId}`);
            context.commit("removeAdminUser", removeId);
        },
    },
};
