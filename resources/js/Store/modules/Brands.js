export default {
    state: {
        brands: [],
        countries: [],
    },
    getters: {
        myBrands(state) {
            return state.brands;
        },
        myCountries(state) {
            return state.countries;
        },
    },
    mutations: {
        setBrands(state, brands) {
            state.brands = brands;
        },
        setCountries(state, countries) {
            state.countries = countries;
        },
        setBrand(state, brand) {
            state.brands.unshift(brand);
        },

        setUpdateBrand(state, updateBrand) {
            state.brands = state.brands.filter((brand) => {
                return brand.id != updateBrand.id;
            });
            state.brands.unshift(updateBrand);
        },
        removeBrand(state, removeId) {
            state.brands = state.brands.filter((brand) => {
                return brand.id != removeId;
            });
        },
    },
    actions: {
        async getCountriesLists({ commit }) {
            let res = await axios.get("/api/countries");
            let countries = res.data.data;
            commit("setCountries", countries);
        },
    },
};
