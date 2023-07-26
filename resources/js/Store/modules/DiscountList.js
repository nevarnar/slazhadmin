export default{
    state:{
        discountPaginatedData:[]
    },
    getters:{
        myDiscountPaginatedData(state){
            return state.discountPaginatedData;
        }
    },
    mutations:{
        setDiscountPaginatedData(state, discount) {
            state.discountPaginatedData = discount;
        },
    },
    actions:{

    }
}