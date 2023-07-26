export default{
    state:{
        addSubProductRows:[],
    },
    getters:{
        addMySubProductRows(state){
            return state.addSubProductRows;
        },
    },
    mutations:{
        removeSubProductRow(state, stock_id) {
            const deleteItem = state.addSubProductRows.findIndex(
                (p) => p.local_id === stock_id
            );
            state.addSubProductRows.splice(deleteItem, 1);
        },
        setSubProductRow(state, stock) {
            state.addSubProductRows.push(stock);
        },
        changeAmountSubProductRow(state,payload){
            state.addSubProductRows = state.addSubProductRows.filter((data) => {
                 data.amount = payload.amount;
                 data.discount_type=payload.discount_type;
                 return data;
            });
        },
        changeQuantitySubProductRow(state,payload){
            state.addSubProductRows = state.addSubProductRows.filter((data) => {
                return data.quantity = payload;
            });
        }
    },
    actions:{

    }
}