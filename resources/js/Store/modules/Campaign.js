export default{
    state:{
        discountSubProductRows:[],
        campaignPaginatedData:[],
    },
    getters:{
        getDiscountSubProducts(state){
            return state.discountSubProductRows;
        },
        getCampaignPaginatedData(state){
            return state.campaignPaginatedData;
        }
    },
    mutations:{
        removeDiscountSubProductRow(state, stock_id) {
            const deleteItem = state.discountSubProductRows.findIndex(
                (p) => p.local_id === stock_id
            );
            state.discountSubProductRows.splice(deleteItem, 1);
        },
        setDiscountSubProductRow(state, stock) {
            state.discountSubProductRows.push(stock);
        },
        setCampaignPaginatedData(state, campaign) {
            state.campaignPaginatedData = campaign;
        },
    },
    actions:{

    }
}