export default {
    state: { addStocksToInventoryRows: [], stockPaginatedData: [] },
    getters: {
        // myStyleProducts(state) {
        //     return state.styleProducts;
        // },
        myAddStocksToInventoryRows(state) {
            return state.addStocksToInventoryRows;
        },
        myStockPaginatedData(state) {
            return state.stockPaginatedData;
        },
    },

    mutations: {
        // setStyleProducts(state, products) {
        //     state.styleProducts = products;
        // },
        setAddStocksToInventoryRows(state, stock) {
            state.addStocksToInventoryRows.push(stock);
        },
        removeAddStocksToInventoryRows(state, stock_id) {
            const deleteItem = state.addStocksToInventoryRows.findIndex(
                (p) => p.local_id === stock_id
            );
            state.addStocksToInventoryRows.splice(deleteItem, 1);
        },
        setStockPaginatedData(state, stocks) {
            state.stockPaginatedData = stocks;
        },
    },
    actions: {
       
    },
};