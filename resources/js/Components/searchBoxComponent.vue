<template>
    <div class="search-box mb-3 pt-0 mt-px">
        <input
            type="text"
            v-model="search_input"
            @input="searchHandler"
            placeholder="Search.."
            name="search"
        />
        <button type="submit"><i class="fa fa-search"></i></button>
    </div>
</template>

<script>
import { mapActions, mapMutations } from "vuex";
export default {
    name: "Searchbox",
    props: {
        paginationUrl: {
            type: String,
        },
        mutationName: {
            type: String,
        },
        searchWeb: {
            type: String,
        },
        // searchCollection: {
        //     type: [String, Object],
        // },
    },

    data() {
        return {
            search_input: null,
        };
    },
    methods: {
        ...mapActions(["getPaginatedData", "getPaginatedWebData"]),
        ...mapMutations(["setSearchInput", "setCurrentPage"]),

        searchHandler() {
            // let payload = {
            //     type: this.typeOfSearch,
            //     mutationName: this.mutationName,
            //     search_input: this.search_input,
            //     page: 1,
            //     search_collection: this.searchCollection
            //         ? this.searchCollection
            //         : null,
            // };
            // this.search(payload);

            this.setSearchInput(this.search_input);
            this.setCurrentPage(1);

            let payload = {
                page: 1,
                url: `${this.paginationUrl}&search_input=${this.search_input}`,
                paginateMutation: this.mutationName,
            };
            if (this.searchWeb == "web") {
                this.getPaginatedWebData(payload);
            } else {
                //api
                this.getPaginatedData(payload);
            }
        },
    },
    mounted() {},
};
</script>

<style lang="scss" scoped></style>
