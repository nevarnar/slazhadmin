export default {
    state: {
        promotionCategory: [],
        addPromotionItems: [],
        discount_lists: [],

    },
    getters: {
        discountLists(state) {
            return state.discount_lists;
        },
        addPromotionItemRows(state) {
            return state.addPromotionItems;
        }

    },
    mutations: {
        setDiscountLists(state, data) {
            state.discount_lists = data;
        },
        setPromotionItems(state, data) {
            state.addPromotionItems.push(data);
        },
        removePromotionItemRows(state, id) {
            const deleteItem = state.addPromotionItems.findIndex(
                (p) => p.local_id === id
            );
            state.addPromotionItems.splice(deleteItem, 1);
        },
    },
    actions: {
        // async actionPromotionCategory({commit},payload){
        //     let res=await axios.post('/support_ticket/toggle_support_ticket',payload);
        //     commit.state.promotionCategory=res.data.data;
        // }
    }
}