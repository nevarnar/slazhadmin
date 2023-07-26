export default{
    state:{
        myReplyList:[],
    },
    getters:{
        getMyReplyList(state){
            return state.myReplyList;
        }
    },
    mutations:{
        setMyReplyList(state, data) {
            state.myReplyList = data;
        },
    },
    actions:{
        
    }
}