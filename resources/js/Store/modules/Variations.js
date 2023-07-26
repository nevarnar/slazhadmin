export default {
    state: {
        variations: [],
    },
    getters: {
        myVariations(state) {
            return state.variations;
        },
    },
    mutations: {
        setVariations(state, variations) {
            state.variations = variations;
        },
    },
    actions: {
        async updateOrCreateVariation({ commit, dispatch }, payload) {
            if (payload.type == "create") {
                var res = await axios.post(
                    `/variations/create`,
                    payload.form_data
                );
            } else {
                //edit
                var res = await axios.post(
                    `/variations/update/${payload.edit_id}`,
                    payload.form_data
                );
            }

            let variation = res.data.data;
            return variation;
        },
    },
};
