export default {
    state: {
        inventoryLists: [],
    },
    getters: {
        myInventoryLists(state) {
            return state.inventoryLists;
        },
    },
    mutations: {
        setInventoryLists(state, inv) {
            state.inventoryLists = inv;
        },
        removeInventory(state, removeId) {
            state.inventoryLists = state.inventoryLists.filter((inv) => {
                return inv.id != removeId;
            });
        },
    },
    actions: {
        async deleteShelfApi({ commit }, payload) {
            console.log("vuex", payload);
            let res = await axios.delete(`/shelves/${payload.id}`);
            return res;
        },
    },
};
