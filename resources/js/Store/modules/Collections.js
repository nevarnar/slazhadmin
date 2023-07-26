import products from "./products";

export default {
    state: {
        collection_styles: [],
        collection_style_rows: [],
        collection_products: [],
        collection_product_rows: [],
        collectionPaginatedData: [],
    },
    getters: {
        my_collection_styles(state) {
            return state.collection_styles;
        },
        my_collection_style_rows(state) {
            return state.collection_style_rows;
        },
        my_collection_products(state) {
            return state.collection_products;
        },
        my_collection_product_rows(state) {
            return state.collection_product_rows;
        },
        myCollectionPaginatedData(state) {
            return state.collectionPaginatedData;
        },
    },

    mutations: {
        setCollectionStyles(state, styles) {
            state.collection_styles = styles;
        },
        setCollectionStyleRow(state, style) {
            state.collection_style_rows.push(style);
        },
        setCollectionStyleRows(state, styles) {
            state.collection_style_rows = styles;
        },
        removeCollectionStyleRow(state, style) {
            const deleteItem = state.collection_style_rows.findIndex(
                (p) => p.id === style.id
            );
            state.collection_style_rows.splice(deleteItem, 1);
        },
        setCollectionProducts(state, products) {
            state.collection_products = products;
        },
        setCollectionProductRow(state, product) {
            state.collection_product_rows.push(product);
        },
        setCollectionProductRows(state, products) {
            console.log("vuex", products);
            state.collection_product_rows = products;
        },
        removeCollectionProductRow(state, product) {
            const deleteItem = state.collection_product_rows.findIndex(
                (p) => p.id === product.id
            );
            state.collection_product_rows.splice(deleteItem, 1);
        },
        setCollectionPaginatedData(state, collections) {
            state.collectionPaginatedData = collections;
        },
        removeCollection(state, removeId) {
            state.collectionPaginatedData =
                state.collectionPaginatedData.filter((collection) => {
                    return collection.id != removeId;
                });
        },
    },
    actions: {
        async getCollectionStyles({ commit, dispatch, state }) {
            let res = await axios.get(
                `/get_styles?type=style
            `
            );
            let styles = res.data.data;
            let withoutDuplicate = [];
            if (state.collection_style_rows.length != 0) {
                var missings = [];
                var matches = false;

                for (var i = 0; i < styles.length; i++) {
                    matches = false;
                    for (
                        var e = 0;
                        e < state.collection_style_rows.length;
                        e++
                    ) {
                        if (styles[i].id === state.collection_style_rows[e].id)
                            matches = true;
                    }
                    if (!matches) missings.push(styles[i]);
                }
                // return missings;
                commit("setCollectionStyles", missings);
            } else {
                console.log("2", state.collection_style_rows.length);

                commit("setCollectionStyles", styles);
            }
            return withoutDuplicate;
        },

        async updateOrCreateCollection({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/collections/createOrUpdate`,
                payload
            );
            let collection = res.data.data;
            return collection;
        },
        async removeCollection({ commit }, collection_id) {
            console.log("vuex", collection_id);
            await axios.delete(`/collections/${collection_id}`);
            commit("removeCollection", collection_id);
        },
    },
};
