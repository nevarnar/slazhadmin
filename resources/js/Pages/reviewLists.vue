<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Reviews Management</p>
        </div>
        <div class="relative flex mx-2 my-3">
            <!-- vue select here class="bg-white text-sm border px-4 py-2 mb-4" -->
            <div class="list-component">
                <multiselect
                v-model="typeValue"
                :options="typeOptions"
                :searchable="false"
                :close-on-select="true"
                :show-labels="false"
                track-by="name"
                label="name"
                placeholder="Choose Type"
                @input="reviewPagination"
                ></multiselect>
            </div>
            <div class="list-component">
                <multiselect
                v-model="filterValue"
                :options="filterOptions"
                :searchable="false"
                :close-on-select="true"
                :show-labels="false"
                track-by="name"
                label="name"
                placeholder="Choose Filter"
                @input="reviewPagination"
                ></multiselect>
            </div>

            <div></div>
        </div>
        <div class="block pb-8">
            <table class="primary-table table-auto">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>{{ typeValue.name }}</th>
                        <th>Rating</th>
                        <th>Title</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <review-item
                        v-for="review in myReviews"
                        :review="review"
                        :key="review.id"
                    />
                    <tr
                        v-if="myReviews.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :typeOfSearch="typeOfSearch"
                :mutationName="mutationName"
                :pagination-url="paginationUrl"
                :status="filterValue.value"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Multiselect from "vue-multiselect";
import reviewItem from "./../Components/reviewItem.vue";
import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
    name: "reviewLists",
    components: {
        Multiselect,
        reviewItem,
    },
    data() {
        return {
            typeOfSearch: "",
            mutationName: "setReviews",
            filterValue: { name: "Pending", value: "pending" },
            filterOptions: [
                { name: "Pending", value: "pending" },
                { name: "Approved", value: "approved" },
            ],
            typeValue: { name: "Products", value: "product" },
            typeOptions: [
                { name: "Products", value: "product" },
                { name: "Styles", value: "style" },
            ],
        };
    },
    computed: {
        ...mapGetters(["myReviews"]),
        paginationUrl() {
            return `get_reviews?type=${this.typeValue.value}&status=${this.filterValue.value}`;
        },
    },
    methods: {
        ...mapActions(["getPaginatedData"]),
        reviewPagination() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: `get_reviews?type=${this.typeValue.value}&status=${this.filterValue.value}`,
                status: this.filterValue.value,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
        },
    },
    mounted() {
        this.reviewPagination();
    },
};
</script>
