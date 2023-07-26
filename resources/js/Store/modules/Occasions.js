export default {
    state: {
        occasions: [],
    },
    getters: {
        myOccasions(state) {
            return state.occasions;
        },
    },
    mutations: {
        setOccasions(state, occasions) {
            state.occasions = occasions;
        },
        setOccasion(state, occasion) {
            state.occasions.unshift(occasion);
        },

        setUpdateOccasion(state, updateOccasion) {
            state.occasions = state.occasions.filter((occasion) => {
                return occasion.id != updateOccasion.id;
            });
            state.occasions.unshift(updateOccasion);
        },
    },
    actions: {},
};
