import axios from "axios";

export default{
    state:{
        mySupportTicketList:[],
    },
    getters:{
        getMySupportTicketList(state){
            return state.mySupportTicketList;
        }
    },
    mutations:{
        setMySupportTicketList(state, data) {
            state.mySupportTicketList = data;
        },
    },
    actions:{
        async toggleSupportTicket({commit},payload){
            let res=await axios.post('/support_ticket/toggle_support_ticket',payload);
            return res;
        }
    }
}