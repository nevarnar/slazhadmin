export default {
    state: {
        colors: [],
    },
    getters: {
        myColors(state) {
            return state.colors;
        },
    },
    mutations: {
        setColors(state, colors) {
            state.colors = colors;
        },
        setColor(state, color) {
            state.colors.unshift(color);
        },

        setUpdateColor(state, updateColor) {
            state.colors = state.colors.filter((color) => {
                return color.id != updateColor.id;
            });
            state.colors.unshift(updateColor);
        },
    },
    actions: {},
};
