export default {
    state: {
        ads_types: [],
    },
    getters: {
        myAdsType(state) {
            return state.ads_types;
        },
    },
    mutations: {
        setAdsTypes(state, ads_types) {
            state.ads_types = ads_types;
        },
        setAdsType(state, ads_type) {
            state.ads_types.unshift(ads_type);
        },
        setUpdateAdsType(state, updateAdsType) {
            state.ads_types = state.ads_types.filter((ads_type) => {
                return ads_type.id != updateAdsType.id;
            });
            state.ads_types.unshift(updateAdsType);
        },
    },
    actions: {

    },
};