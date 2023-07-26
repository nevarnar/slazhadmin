export default {
    state: {
        subProducts: [],
        products: [],
    },
    getters: {
        mySubProducts(state) {
            return state.subProducts;
        },
        myProducts(state) {
            return state.products;
        },
    },
    mutations: {
        setSubProducts(state, sub_products) {
            state.subProducts = sub_products;
        },
        setProducts(state, products) {
            state.products = products;
        },
        setSubProductEdit(state, sub_product) {
            const editItem = state.subProducts.find(
                (item) => item.local_id === sub_product.local_id
            );
            editItem.isEditingNow = true;
        },
        setSubProductUpdate(state, sub_product) {
            let updateItem = state.subProducts.find(
                (item) => item.local_id == sub_product.local_id
            );
            console.log(state.subProducts[0].local_id);
            updateItem.isEditingNow = false;
            updateItem.price = sub_product.price;
        },
        setAvailableChange(state, sub_product) {
            let updateItem = state.subProducts.find(
                (item) => item.local_id === sub_product.local_id
            );
            updateItem.available = !sub_product.available;
        },
        setImageUpload(state, payload) {
            let updateImage = state.subProducts.find(
                (item) => item.local_id === payload.sub_product.local_id
            );
            if (payload.view == 'front_view') {
                updateImage.images.front_view_file = payload.image;
                updateImage.images.front_view = payload.image.name;
                updateImage.images.front_view_preview = URL.createObjectURL(payload.image.data);
                if (payload.isediting == "edit") {
                    updateImage.images.is_front_view_update = true;
                }
            } else if (payload.view == 'back_view') {
                updateImage.images.back_view_file = payload.image;
                updateImage.images.back_view = payload.image.name;
                updateImage.images.back_view_preview = URL.createObjectURL(payload.image.data);
                if (payload.isediting == "edit") {
                    updateImage.images.is_back_view_update = true;
                }
            } else if (payload.view == 'side_view') {
                updateImage.images.side_view_file = payload.image;
                updateImage.images.side_view = payload.image.name;
                updateImage.images.side_view_preview = URL.createObjectURL(payload.image.data);
                if (payload.isediting == "edit") {
                    updateImage.images.is_side_view_update = true;
                }
            } else {
                updateImage.images.something_view_file = payload.image;
                updateImage.images.something_view = payload.image.name;
                updateImage.images.something_view_preview = URL.createObjectURL(payload.image.data);
                if (payload.isediting == "edit") {
                    updateImage.images.is_something_view_update = true;
                }
            }


        },
    },
    actions: {
        async updateOrCreateProduct({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/products/create_or_update`,
                payload
            );
            let product = res.data.data;

            return product;
        },
        async createTag({ commit, dispatch }, payload) {
            let res = await axios.post(`/tags/create`, payload);
            let tag = res.data.data;
            console.log(res);
            return tag;
        },
    },
};