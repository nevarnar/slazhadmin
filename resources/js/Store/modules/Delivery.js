export default {
    state: {
        deliveries: [],
    },
    getters: {
        myDeliveries(state) {
            return state.deliveries;
        },
    },
    mutations: {
        setDeliveries(state, deli) {
            state.deliveries = deli;
        },
        setDelivery(state, deli) {
            state.deliveries.unshift(ad);
        },

        setUpdateDelivery(state, updateDeli) {
            state.deliveries = state.deliveries.filter((deli) => {
                return deli.id != updateDeli.id;
            });
            state.deliveries.unshift(updateDeli);
        },
        removeDelivery(state, removeId) {
            state.deliveries = state.deliveries.filter((deli) => {
                return deli.id != removeId;
            });
        },
    },
    actions: {
        async createDelivery({ commit, dispatch }, payload) {
            let res = await axios.post(`/deliveries/create`, payload);
            let tag = res;
            return tag;
        },
        async deleteDelivery(context, removeId) {
            await axios.delete(`/delivery_men/${removeId}`);
            context.commit("removeDelivery", removeId);
        },
    },
};
