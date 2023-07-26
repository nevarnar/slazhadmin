export default {
    state: { defects: [], invoices: [] },
    getters: {
        myDefects(state) {
            return state.defects;
        },
        myInvoices(state) {
            return state.invoices;
        },
    },

    mutations: {
        setDefects(state, defects) {
            state.defects = defects;
        },
        setInvoices(state, invoices) {
            state.invoices = invoices;
        },
    },
    actions: {},
};
