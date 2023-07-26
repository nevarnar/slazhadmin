export default {
    state: {
        categories: [],
    },
    getters: {
        myCategories(state) {
            return state.categories;
        },
    },
    mutations: {
        setCategories(state, categories) {
            state.categories = categories;
        },
        setCategory(state, category) {
            state.categories.unshift(category);
        },
        setUpdateCategory(state, updateCategory) {
            state.categories = state.categories.filter((category) => {
                return category.id != updateCategory.id;
            });
            state.categories.unshift(updateCategory);
        },
    },
    actions: {

    },
};