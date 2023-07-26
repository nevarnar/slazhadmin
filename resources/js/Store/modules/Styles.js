import products from "./products";

export default {
    state: { styleProducts: [], styleProductsRows: [], stylePaginatedData: [] },
    getters: {
        myStyleProducts(state) {
            return state.styleProducts;
        },
        myStyleProductsRows(state) {
            return state.styleProductsRows;
        },
        myStylePaginatedData(state) {
            return state.stylePaginatedData;
        },
    },

    mutations: {
        setStyleProducts(state, products) {
            state.styleProducts = products;
        },
        setStyleProductsRow(state, product) {
            state.styleProductsRows.push(product);
        },
        setStyleProductsRows(state, products) {
            state.styleProductsRows = products;
        },
        removeStyleProductRow(state, product) {
            const deleteItem = state.styleProductsRows.findIndex(
                (p) => p.id === product.id
            );
            state.styleProductsRows.splice(deleteItem, 1);
        },
        setStylePaginatedData(state, styles) {
            state.stylePaginatedData = styles;
        },
    },
    actions: {
        async createStyleCategory({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/categories/create_or_update
            `,
                payload
            );
            let style = res.data.data;
            return style;
        },
        async getStyleProducts({ commit, dispatch }) {
            let res = await axios.get(
                `/products_for_style
            `
            );
            let style = res.data.data;
            commit("setStyleProducts", style);
            console.log(style);
            return style;
        },
        async availableColorByProduct({ commit, dispatch }, id) {
            let res = await axios.get(
                `/available_color_by_product/${id}
            `
            );
            let style = res.data.data;
            return style;
        },
        async styleProductsWithSizes({ commit, dispatch }, payload) {
            let res = await axios.get(
                `/products/${payload.product_id}/${payload.color_id}
            `
            );
            let product = res.data.products[0];
            commit("setStyleProductsRow", product);
            return product;
        },
        async updateOrCreateStyle({ commit, dispatch }, payload) {
            let res = await axios.post(`/styles/createOrUpdate`, payload);
            let style = res.data.data;
            return style;
        },
    },
};
