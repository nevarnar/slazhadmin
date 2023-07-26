export default {
    state: { reviews: [] },
    getters: {
        myReviews(state) {
            return state.reviews;
        },
    },
    mutations: {
        setReviews(state, payload) {
            state.reviews = payload;
        },
        removeReview(state, review_id) {
            const deleteItem = state.reviews.findIndex(
                (r) => r.id === review_id
            );
            state.reviews.splice(deleteItem, 1);
        },
    },
    actions: {
        async reviewApproved({ commit }, review) {
            let formData = { id: review.id, status: "approved" };
            await axios.post(`/reviews/toggleStatus`, formData);
            commit("removeReview", review.id);
        },
    },
};
