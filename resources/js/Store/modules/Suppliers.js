export default {
    state: {
        suppliers: [],
        supplierCountries: [],
    },
    getters: {
        mySuppliers(state) {
            return state.suppliers;
        },
    },
    mutations: {
        setSuppliers(state, suppliers) {
            state.suppliers = suppliers;
        },
        removeSupplier(state, removeId) {
            state.suppliers = state.suppliers.filter((supplier) => {
                return supplier.id != removeId;
            });
        },
    },
    actions: {
        async deleteSupplier(context, removeId) {
            await axios.delete(`/suppliers/${removeId}`);
            context.commit("removeSupplier", removeId);
        },
    },
};
