export default {
    state: {
        ads: [],
    },
    getters: {
        myAds(state) {
            return state.ads;
        },
    },
    mutations: {
        setAds(state, ads) {
            state.ads = ads;
        },
        setAd(state, ad) {
            state.ads.unshift(ad);
        },

        setUpdateAd(state, updateAd) {
            state.ads = state.ads.filter((ad) => {
                return ad.id != updateAd.id;
            });
            state.ads.unshift(updateAd);
        },
        removeAd(state, removeId) {
            state.ads = state.ads.filter((ad) => {
                return ad.id != removeId;
            });
        },
    },
    actions: {
        async createType({ commit, dispatch }, payload) {
            let res = await axios.post(`/ads_type/create`, payload);
            let tag = res;
            return tag;
        },

        async deleteAds(context, removeId) {
            await axios.delete(`/ads/${removeId}`);
            context.commit("removeAd", removeId);
        },
    },
};
