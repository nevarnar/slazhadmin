<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Delivery Management</p>
        </div>
        <div class="relative flex justify-between">
            <div>
                <div class="inline-block">
                    <!-- :method="search" -->

                    <SearchBox
                        :paginationUrl="paginationUrl"
                        :mutationName="mutationName"
                        :searchCollection="
                            this.filterValue.id == 0
                                ? ''
                                : { delivery_id: this.filterValue.id }
                        "
                    />
                </div>
                <div class="inline-block mx-1">
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
                <div class="inline-block ml-1 mr-1.5">
                    <div class="form-group mb-4">
                        <multiselect
                            v-model="filterValue"
                            :options="filterOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :allow-empty="false"
                            track-by="name"
                            label="name"
                            placeholder="Choose Type"
                            @input="changeFilter"
                        ></multiselect>
                    </div>
                </div>
            </div>

            <createbtn v-on:open_create_modal="onCreate" />
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Delivery Man Name</th>
                        <th>Delivery Name</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="delivery in myDeliveries" :key="delivery.id">
                        <td>{{ delivery.index }}</td>
                        <td>{{ delivery.name_translations[0].name }}</td>
                        <td>{{ delivery.delivery.name }}</td>
                        <td>{{ delivery.phone_number }}</td>
                        <td>
                            <button
                                @click="onEdit(delivery.id)"
                                type="button"
                                title="Edit"
                                id="edit-button"
                            >
                                <i class="fal fa-file-edit"></i>
                            </button>
                            <button
                                @click="onDelete(delivery.id)"
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
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :typeOfSearch="typeOfSearch"
                :mutationName="mutationName"
                :pagination-url="paginationUrl"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";

export default {
    name: "deliveryLists",
    components: {
        Createbtn,
        SearchBox,
        Multiselect,
    },
    data() {
        return {
            typeOfSearch: "delivery_men",
            mutationName: "setDeliveries",
            filterValue: { id: 0, name: "All" },
            filterOptions: [{ id: 0, name: "All" }],
        };
    },
    computed: {
        ...mapGetters(["myDeliveries"]),
        paginationUrl() {
            return this.filterValue.id == 0
                ? "delivery_men?"
                : `delivery_men?delivery_id=${this.filterValue.id}`;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            // "search",
            "deleteDelivery",
            "getApiData",
        ]),
        ...mapMutations(["setCurrentPage"]),
        onEdit(product_id) {
            window.location.href = `/delivery_men_lists/edit/${product_id}`;
        },
        onCreate(product_id) {
            window.location.href = `/delivery_men_lists/create`;
        },
        onDelete(delivery_id) {
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
                    this.deleteDelivery(delivery_id).then(
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: "You successfully deleted this file",
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    );
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
        async getDeliveries() {
            let res = await this.getApiData({ url: "deliveries" });
            this.filterOptions = [...this.filterOptions, ...res.data.data];
        },
        changeFilter() {
            // let payload = {
            //     type: this.typeOfSearch,
            //     mutationName: this.mutationName,
            //     search_collection:
            //         this.filterValue.id == 0
            //             ? ""
            //             : { delivery_id: this.filterValue.id },
            //     search_input: "",
            //     page: 1,
            // };
            let payload = {
                page: 1,
                url: `${this.paginationUrl}`,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
            // this.search(payload);
            this.setCurrentPage(1);
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "delivery_men?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
        this.getDeliveries();
    },
};
</script>
