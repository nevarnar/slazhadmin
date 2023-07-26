<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Collection Management</p>
        </div>
        <div class="relative flex justify-between">
            <div class="flex">
                <div class="form-check inline-block ml-3 mr-2">
                    <input
                        class="form-check-input input-check float-center"
                        type="checkbox"
                        value=""
                    />
                </div>
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Bulk Action</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Filter</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="list-component">
                    <SearchBox
                        pagination-url="collections?"
                        :mutationName="mutationName"
                    />
                </div>
            </div>
            <div>
                <createbtn v-on:open_create_modal="onCreate" />
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Collection Name</th>
                        <th>Collection Code</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbl">
                    <tr
                        v-for="collection in myCollectionPaginatedData"
                        :key="collection.id"
                    >
                        <td>{{ collection.index }}</td>
                        <td>{{ collection.name_translations[0].name }}</td>
                        <td>{{ collection.item_code }}</td>
                        <td>
                            {{
                                collection.thing.categories.length>0?  collection.thing.categories[0]
                                    .name_translations[0].name : ''
                            }}
                        </td>
                        <td>
                            <button
                                @click="onEdit(collection.id)"
                                type="button"
                                title="Edit"
                                id="edit_button"
                                class="edit-btn"
                            >
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                            <button
                                @click="deleteCollection(collection)"
                                type="button"
                                title="Delete"
                                id="delete-button"
                            >
                                <a href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myCollectionPaginatedData.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td
                            colspan="5"
                            class="px-5 py-2 text-table"
                        >
                            No Data Found!
                        </td>
                    </tr>
                    <table-pagination
                        :pagination-lists="getPaginatedData"
                        :max-visible-buttons="5"
                        :mutationName="mutationName"
                        pagination-url="collections?"
                    />
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "collectionLists",
    components: {
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "collection",
            mutationName: "setCollectionPaginatedData",
        };
    },
    computed: {
        ...mapGetters(["myCollectionPaginatedData"]),
    },
    methods: {
        ...mapActions(["getPaginatedData", "search", "removeCollection"]),
        onEdit(collection_id) {
            window.location.href = `/collection_lists/edit/${collection_id}`;
        },
        onCreate(product_id) {
            window.location.href = `/collection_lists/create`;
        },
        deleteCollection(collection) {
            this.$swal({
                title: "Are you sure?",
                text: "You can't revert your action",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes Delete it!",
                confirmButtonColor: "#f27474",
                cancelButtonText: "No, Keep it!",
                showCloseButton: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.value) {
                    this.removeCollection(collection.id);
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "collections?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
