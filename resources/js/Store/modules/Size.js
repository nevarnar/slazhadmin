export default {
    state: {
        sizes: [],
    },
    getters: {
        mySizes(state) {
            return state.sizes;
        },
    },
    mutations: {
        setSizes(state, sizes) {
            state.sizes = sizes;
        },
        // setCategory(state, category) {
        //     state.categories.unshift(category);
        // },
        // setUpdateCategory(state, updateCategory) {
        //     state.categories = state.categories.filter((category) => {
        //         return category.id != updateCategory.id;
        //     });
        //     state.categories.unshift(updateCategory);
        // },
    },
    actions: {

    },
};