export default {
    state: {
        url: "http://localhost:8000",
        isEditing: true,
        totalPages: 0,
        search_input: null,
        current_page: 1,
        next_click_count: 1,
        apiLoading: false,
        validate_err: false,
        cometchat_config:{
            APP_ID: "2401763d970a73bb",
            AUTH_KEY: "7879ab246b7cd95970e6ba685e7cff97ef3258ec",
            APP_REGION: "US",
            WIDGET_ID: "71745d77-0046-410c-9324-21f9c79e44c3",
            API_KEY:"18e01917f76e56585cf9064885cc9929d42157be"
        },
    },
    getters: {
        myUrl(state) {
            return state.url;
        },
        getisEditing(state) {
            return state.isEditing;
        },
        getTotalPages(state) {
            return state.totalPages;
        },
        getSearchInput(state) {
            return state.search_input;
        },
        currentPage(state) {
            return state.current_page;
        },
        nextClickCount(state) {
            return state.next_click_count;
        },
        currentApiLoading(state) {
            return state.apiLoading;
        },
        validateErr(state) {
            return state.validate_err;
        },
        cometchatConfig(state){
            return state.cometchat_config;
        }
    },
    mutations: {
        setTotalPages(state, page) {
            state.totalPages = page;
        },
        setCurrentPage(state, page) {
            state.current_page = page;
        },
        setisEditing(state, payload) {
            state.isEditing = payload;
        },
        setSearchInput(state, payload) {
            state.search_input = payload;
        },
        setNextClickCount(state, payload) {
            state.next_click_count = payload;
        },
        setApiLoading(state, payload) {
            state.apiLoading = payload;
        },
        setValidateErr(state, payload) {
            state.validate_err = payload;
        },
    },
    actions: {
        async availableChange({ commit }, payload) {
            payload.data.is_available = 1 - payload.data.is_available;

            let res = await axios.post(
                `/${payload.url}/is_available`,
                // `https://admin.slazh.shop/${payload.url}/is_available`,
                payload.data
            );
            return res;
        },
        async search({ commit }, payload) {
            let res = await axios.post(
                `/search?page=${payload.page}`,
                // `https://admin.slazh.shop/search?page=${payload.page}`,
                payload
            );
            let response = res.data.data;
            let startCount = (payload.page - 1) * response.per_page + 1;
            const newArr = response.data.map((v) => ({
                ...v,
                index: startCount++,
            }));
            commit(payload.mutationName, newArr);
            if (payload.page == 1) {
                commit("setNextClickCount", 1);
            }
            commit("setTotalPages", response.last_page);
        },
        async getPaginatedData({ commit }, payload) {
            let res = await axios.get(
                `/${payload.url}&page=${payload.page}`
                // `https://admin.slazh.shop/${payload.url}&page=${payload.page}`
            );

            let data = res.data.data;
            let startCount = (payload.page - 1) * data.per_page + 1;
            const newArr = data.data.map((v) => ({
                ...v,
                index: startCount++,
            }));
            commit(payload.paginateMutation, newArr);
            commit("setTotalPages", data.last_page);
            if (payload.page == 1) {
                commit("setNextClickCount", 1);
            }
            commit("setCurrentPage", payload.page);
        },
        async getPaginatedWebData({ commit }, payload) {
            let res = await axios.get(`/${payload.url}&page=${payload.page}`);
            // let res = await axios.get(`https://admin.slazh.shop/${payload.url}&page=${payload.page}`);

            let data = res.data.data;
            let startCount = (payload.page - 1) * data.per_page + 1;
            const newArr = data.data.map((v) => ({
                ...v,
                index: startCount++,
            }));
            commit(payload.paginateMutation, newArr);
            commit("setTotalPages", data.last_page);
            if (payload.page == 1) {
                commit("setNextClickCount", 1);
            }
            commit("setCurrentPage", payload.page);
        },
        async updateOrCreateData({ commit, dispatch, rootState }, payload) {
            let res = await axios.post(
                `/${payload.url}/create_or_update`,
                // `https://admin.slazh.shop/${payload.url}/create_or_update`,
                payload.form_data
            );
            let data = res.data.data;
            if (payload.type == "update") {
                var page = rootState.CommonData.current_page;
            } else {
                var page = 1;
            }
            dispatch("getPaginatedData", {
                page: page,
                url: payload.url + "?",
                paginateMutation: payload.paginateMutation,
            });
            return data;
        },
        async updateOrCreateWithPage({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/${payload.url}/create_or_update`,
                // `https://admin.slazh.shop/${payload.url}/create_or_update`,
                payload.form_data
            );
            let data = res.data.data;
            return data;
        },
        async updateOrCreate({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/${payload.url}/createOrUpdate`,
                // `https://admin.slazh.shop/${payload.url}/createOrUpdate`,
                
                payload.form_data
            );
            let data = res.data.data;
            return data;
        },
        async removeRow({ commit }, payload) {
            let res = await axios.delete(`/${payload.url}`);
            commit(payload.mutationName, payload.id);
            return res;
        },
        async deleteProductGallaryApi({ commit }, payload) {
            let res = await axios.post(`/delete_photo`, {
                id: payload.id,
                type: payload.type,
            });
            return res;
        },

        async getApiData({ commit }, payload) {
            let response = await axios.get(`/${payload.url}`);
            // let response = await axios.get(`https://admin.slazh.shop/${payload.url}`);
            return response;
        },

        async postApiForm({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/${payload.url}`,
                // `https://admin.slazh.shop/${payload.url}`,
                payload.form_data
            );
            return res;
        },
        async postWebForm({ commit, dispatch }, payload) {
            let res = await axios.post(`/${payload.url}`, payload.form_data);
            // let res = await axios.post(`https://admin.slazh.shop/${payload.url}`, payload.form_data);
            return res;
        },
        async getWebData({ commit }, payload) {
            let response = await axios.get(`/${payload.url}`);
            // let response = await axios.get(`https://admin.slazh.shop/${payload.url}`);
            return response;
        },
        async deleteWebData({ commit }, payload) {
            let res = await axios.delete(`/${payload.url}`);
            // let res = await axios.delete(`https://admin.slazh.shop/${payload.url}`);
            return res;
        },
    },
};
