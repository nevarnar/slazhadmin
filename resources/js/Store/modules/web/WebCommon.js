export default {
    state: {
        language_code: localStorage.getItem("appLanguage") || 'en',
        filter_by: {
            brand_ids: [],
            size_ids: [],
            color_ids: [],
            price_range_ids: [],
            sub_variation_ids: [],
            season_ids: [],
            sub_category_id: null,
        },
        shopping_cart: JSON.parse(localStorage.getItem("slazhmm_shop")),
        re_render_key:0,

    },
    getters: {
        languageCode(state) {
            return state.language_code;
        },
        filterBy(state) {
            return state.filter_by;
        },
        shoppingCart(state) {
            return state.shopping_cart
        },
        reRenderKey(state) {
            return state.re_render_key
        }
    },
    mutations: {
        setLanguageCode(state, payload) {
            state.language_code = payload;
            localStorage.setItem("appLanguage", payload);
        },
        setReRenderKey(state, payload) {
            state.re_render_key ++ ;
        },
        setFilterBy(state, payload) {
            if (payload.filter_name == 'brand_ids') {
                if (payload.selected) {
                    state.filter_by.brand_ids = [...state.filter_by.brand_ids, payload.id];
                    console.log('selected');
                } else {
                    let filter = state.filter_by.brand_ids.filter(b => b != payload.id);
                    state.filter_by.brand_ids = filter;
                    console.log('not selected');

                }
            }
            if (payload.filter_name == 'size_ids') {
                if (payload.selected) {
                    state.filter_by.size_ids = [...state.filter_by.size_ids, payload.id];
                } else {
                    let filter = state.filter_by.size_ids.filter(b => b != payload.id);
                    state.filter_by.size_ids = filter;
                }
            }

            if (payload.filter_name == 'color_ids') {
                if (payload.selected) {
                    state.filter_by.color_ids = [...state.filter_by.color_ids, payload.id];
                } else {
                    let filter = state.filter_by.color_ids.filter(b => b != payload.id);
                    state.filter_by.color_ids = filter;
                }
            }
            if (payload.filter_name == 'price_range_ids') {
                if (payload.selected) {
                    state.filter_by.price_range_ids = [payload.id];
                } else {
                    state.filter_by.price_range_ids = [payload.id];

                    // let filter = state.filter_by.price_range_ids.filter(b => b != payload.id);
                    // state.filter_by.price_range_ids = filter;
                }
            }
            if (payload.filter_name == 'sub_variation_ids') {
                if (payload.selected) {
                    state.filter_by.sub_variation_ids = [...state.filter_by.sub_variation_ids, payload.id];
                } else {
                    let filter = state.filter_by.sub_variation_ids.filter(b => b != payload.id);
                    state.filter_by.sub_variation_ids = filter;
                }
            }
            if (payload.filter_name == 'sub_category_id') {
                console.log('1', payload.id);
                state.filter_by.sub_category_id = payload.id
            }
        },
        resetFilterBy(state, payload) {
            state.filter_by = {
                brand_ids: [],
                size_ids: [],
                color_ids: [],
                price_range_ids: [],
                sub_variation_ids: [],
                season_ids: [],
                sub_category_id: null
            }
        },
        setShoppingCart(state, payload) {
            console.log('shoppingcartepayload',payload);
            state.shopping_cart = payload;
        },
    },
    actions: {},
};
