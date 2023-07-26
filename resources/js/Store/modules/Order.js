export default {
    state: {
        orders: [],
    },
    getters: {
        myOrders(state) {
            return state.orders;
        },
    },
    mutations: {
        setOrders(state, orders) {
            state.orders = orders;
        },
        setCategory(state, category) {
            state.orders.unshift(category);
        },
        setUpdateCategory(state, updateCategory) {
            state.orders = state.orders.filter((category) => {
                return category.id != updateCategory.id;
            });
            state.orders.unshift(updateCategory);
        },
    },
    actions: {

    },
};
