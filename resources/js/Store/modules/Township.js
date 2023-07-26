export default{
    state:{
        addTableRows:[],
        paginatedData:[],
    },
    getters:{
        getTableRows(state){
            return state.addTableRows;
        },
        getMyTownshipPaginatedData(state){
            return state.paginatedData;
        }
    },
    mutations:{
        removeTableRow(state, id) {
            const deleteItem = state.addTableRows.findIndex(
                (p) => p.local_id === id
            );
            state.addTableRows.splice(deleteItem, 1);
        },
        setTableRow(state, stock) {
            state.addTableRows.push(stock);
        },
        setTownshipPaginatedData(state, data) {
            state.paginatedData = data;
        },
    },
    actions:{

    }
}