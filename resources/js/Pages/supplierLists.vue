<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Supplier Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox
                pagination-url="suppliers?"
                :mutationName="mutationName"
            />
            <!-- @include('layouts.search_box')  -->
            <createbtn v-on:open_create_modal="onCreate" />
            <!-- @include('layouts.create_button')  -->
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Supplier</th>
                        <th>Country</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="supplier in mySuppliers" :key="supplier.id">
                        <td>
                            {{ supplier.index }}
                        </td>
                        <td>
                            {{ supplier.name_translations[0]?.name }}
                        </td>
                        <td>
                            {{ supplier.country.name_translations[0]?.name }}
                        </td>
                        <td>
                            {{ supplier.phone_number }}
                        </td>
                        <td>
                            <button
                                @click="onEdit(supplier.id)"
                                type="button"
                                title="Edit"
                                id="edit-button"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                            <button
                                @click="onDelete(supplier.id)"
                                type="button"
                                title="Delete"
                                id="delete_button"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="mySuppliers.length == 0"
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
                pagination-url="suppliers?"
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
    name: "supplierLists",
    components: {
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "supplier",
            mutationName: "setSuppliers",
        };
    },
    computed: {
        ...mapGetters(["mySuppliers"]),
    },
    methods: {
        ...mapActions(["getPaginatedData", "deleteSupplier", "search"]),
        onEdit(supplier_id) {
            window.location.href = `/suppliers_lists/edit/${supplier_id}`;
        },
        onCreate(supplier_id) {
            window.location.href = `/suppliers_lists/create`;
        },
        onDelete(supplier_id) {
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
                    this.deleteSupplier(supplier_id).then(
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
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "suppliers?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
