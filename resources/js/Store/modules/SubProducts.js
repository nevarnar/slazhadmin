export default {
    state: {
        subProducts: [],
        subProductsListImages: [],
    },
    getters: {
        AllSubProducts(state) {
            return state.subProducts;
        },
        AllSubProductsListImages(state) {
            return state.subProductsListImages;
        },
    },

    mutations: {
        setSubProductsLists(state, sub_products) {
            let image_previews = [];
            sub_products.forEach((sub_product) => {
                // combineProductSkuColorSku
                let combineProductSkuColorSku = "";
                // sub_product.product.sku.trim() +
                // sub_product.color.sku_name.trim();

                sub_product.combineProductSkuColorSku =
                    combineProductSkuColorSku;
                console.log(window.location.origin);
                // let image_preview = `${window.location.origin}/api/download_image/${sub_product.photo.name}`;
                let image_preview = sub_product.photo.name;
                image_previews.push(image_preview);
            });
            // console.log(image_previews);
            state.subProductsListImages = image_previews;

            state.subProducts = sub_products;
        },
        // setAvailableChange(state, sub_product) {
        //     let updateItem = state.subProducts.find(
        //         (item) => item.id === sub_product.id
        //     );
        //     updateItem.available = !sub_product.available;
        // },
    },
    actions: {
        async getSubProductLists({ commit }, page) {
            let res = await axios.get(`/sub_products?page=${page}`);
            let sub_products = res.data.data;
            let startCount = (page - 1) * sub_products.per_page + 1;
            const newArr = sub_products.data.map((v) => ({
                //add index for pagination count
                ...v,
                index: startCount++,
            }));
            commit("setSubProductsLists", newArr);
            commit("setTotalPages", sub_products.last_page);
        },
        async getSubProductOfProduct({ commit }, product_id) {
            let res = await axios.get(
                `/products/sub_product_by_product/${product_id}`
            );
            let sub_products = res.data;
            commit("setSubProductsLists", sub_products.sub_products);
        },
    },
};