<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Variation Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox
                pagination-url="variations?"
                :mutationName="mutationName"
            />
            <!-- @include('layouts.search_box')  -->
            <createbtn v-on:open_create_modal="onCreate" />
            <!-- @include('layouts.create_button')  -->
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Variations
                        </th>
                        <th>
                            Product Sub Category
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="variation in myVariations"
                        :key="variation.id"
                    >
                        <td>
                            {{ variation.index }}
                        </td>
                        <td>
                            <div>
                                {{ variation?.name_translations[0]?.name }}
                            </div>
                        </td>
                        <td>
                            <span
                                v-for="subcate in variation?.sub_categories"
                                :key="subcate.id"
                            >
                                {{ subcate?.name_translations[0]?.name }},
                            </span>
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="variation?.is_available"
                                    @click="
                                        availableChange({
                                            data: variation,
                                            url: 'variations',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <button
                                @click="onEdit(variation.id)"
                                type="button"
                                class="btn-clear"
                                title="Edit"
                                id="edit-button"
                            >
                                <a class="a-clear" href="#">
                                    <i
                                        class="fal fa-file-edit fw300"
                                        style="color: #68728c"
                                    ></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr colspan="4"
                        v-if="myVariations.length == 0"
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
                :mutationName="mutationName"
                pagination-url="variations?"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "variationLists",
    components: {
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "variation",
            mutationName: "setVariations",
        };
    },
    computed: {
        ...mapGetters(["myVariations"]),
    },
    methods: {
        ...mapActions(["getPaginatedData", "search", "availableChange"]),
        onEdit(variation_id) {
            window.location.href = `/variations_lists/edit/${variation_id}`;
        },
        onCreate(variation_id) {
            window.location.href = `/variations_lists/create`;
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "variations?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
