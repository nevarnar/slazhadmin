export default {
    state: {
        subCategories: [],
    },
    getters: {
        mySubCategories(state) {
            return state.subCategories;
        },
    },
    mutations: {
        setSubCategories(state, subCategory) {
            state.subCategories = subCategory;
        },
    },
    actions: {},
};
