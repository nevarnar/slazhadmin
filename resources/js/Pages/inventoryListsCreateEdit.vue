<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                {{
                    isediting == "edit" ? "Edit Inventory" : "Create Inventory"
                }}
            </p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Inventory Name</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Inventory SKU</label
                    >
                </div>
                <div class="col-span-3">
                    <!-- free space for grid -->
                </div>

                <!-- start row -->
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input
                            v-model="formData.name.name"
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Inventory Name"
                            :class="
                                validationMsg.name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.name"
                        >
                            {{ validationMsg.name }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input
                            v-model="formData.sku"
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Inventory SKU"
                            :class="
                                validationMsg.sku
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.sku"
                        >
                            {{ validationMsg.sku }}
                        </p>
                    </div>
                </div>
                <div class="col-span-3">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <div class="col-span-7">
                    <hr class="my-2 h-0.5" />
                </div>
            </div>

            <!-- start row -->
            <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Shelf Name</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Floor Amount</label
                    >
                </div>
                <div class="col-span-3">
                    <!-- free space for grid -->
                </div>

                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input
                            v-model="new_shelf.name"
                            type="text"
                            class="form-control input-form mt-2"
                            id="shelf_name"
                            placeholder="Shelf Name"
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.shelves"
                        >
                            {{ validationMsg.shelves }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input
                            v-model="new_shelf.floor_number"
                            type="number"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Floor Amount"
                        />
                    </div>
                </div>

                <div class="col-span-3">
                    <Button
                        type="button"
                        class="primary-button bg-black mt-2"
                        @click="addShelf"
                        >Add</Button
                    >
                </div>
            </div>
            <!-- end row -->

            <!-- start row -->
            <div class="w-full">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th"></th>
                            <th class="sec-thead-th">Shelf Name</th>
                            <th class="sec-thead-th">Number of floor</th>
                            <th class="sec-thead-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(shelf, index) in shelves" :key="index">
                            <td class="sec-table-td">{{ ++index }}</td>
                            <td class="sec-table-td">{{ shelf.name }}</td>
                            <td class="sec-table-td">
                                {{ shelf.floor_number }}
                            </td>
                            <td class="sec-table-td">
                                <button
                                    @click="removeShelf(shelf)"
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
            </div>

            <div class="">
                <hr class="my-2 h-0.5" />
            </div>
            <!-- end row -->

            <div class="flex justify-end pb-4">
                <button
                    type="button"
                    class="primary-button bg-black"
                    :disabled="currentApiLoading"
                    @click="updateOrCreate"
                >
                    <api-loading />
                    {{ isediting == "create" ? "Create" : "Save" }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";

import Multiselect from "vue-multiselect";
export default {
    name: "inventoryListsCreateEdit",
    components: {
        Multiselect,
        apiLoading,
    },
    props: {
        isediting: String,
    },

    data() {
        return {
            formData: {
                id: "",
                name: {
                    name: "",
                    language_code: "en",
                },
                mm_name: {
                    name: "",
                    language_code: "mm",
                },
                sku: "",
            },
            new_shelf: {
                id: null,
                floor_number: null,
                inventory_id: null,
                name: null,
            },
            edit_shelf: {
                id: null,
                floor_number: null,
                inventory_id: null,
                name: null,
            },
            shelves: [],

            validationMsg: {
                sku: "",
                name: "",
                mm_name: "",
                shelves: "",
            },
        };
    },
    computed: {
        ...mapGetters(["currentApiLoading"]),
    },
    methods: {
        ...mapActions(["postApiForm", "deleteShelfApi"]),
        ...mapMutations(["setApiLoading"]),

        addShelf() {
            let isshelfexit = this.isShelfExit(this.new_shelf);
            if (isshelfexit) {
                this.validationMsg.shelves = "Shelves name already exits";
                return;
            }
            console.log(
                "new",
                this.new_shelf.floor_number < 0,
                Number.isInteger(this.new_shelf.floor_number)
            );
            var checkDecimal = this.new_shelf.floor_number % 1;
            console.log(this.new_shelf.floor_number % 1);
            if (checkDecimal) {
                this.validationMsg.shelves = "Shelf no must be interger";
                return;
            }
            if (this.new_shelf.floor_number <= 0) {
                this.validationMsg.shelves = "Shelf no must be interger";
                return;
            }
            if (this.new_shelf.floor_number && this.new_shelf.name) {
                if (this.shelves.length) {
                    var lastShelfArr = this.shelves.length - 1;
                    var newShelfId = this.shelves[lastShelfArr].id + 1;
                } else {
                    var newShelfId = 1;
                }
                this.new_shelf.id = newShelfId;
                this.shelves.push(this.new_shelf);
                this.new_shelf = {
                    id: null,
                    floor_number: null,
                    inventory_id: null,
                    name: null,
                };
                this.validationMsg.shelves = "";
                $("#shelf_name").focus();
            } else {
                this.validationMsg.shelves = "Please fill the required fields";
            }
        },
        removeShelf(shelf) {
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
                    // this.deleteAds(ads_id).then(
                    //     this.$swal(
                    //         "Deleted",
                    //         "You successfully deleted this file",
                    //         "success"
                    //     )
                    // );
                    const deleteItem = this.shelves.findIndex(
                        (item) => item.id === shelf.id
                    );
                    if (this.shelves[deleteItem].inventory_id != null) {
                        this.deleteShelfApi({
                            id: this.shelves[deleteItem].id,
                        }).then(this.shelves.splice(deleteItem, 1));
                    } else {
                        this.shelves.splice(deleteItem, 1);
                    }
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },

        validateRules() {
            if (this.formData.name.name.trim() === "") {
                this.validationMsg.name = "Name is required.";
            }
            if (this.shelves.length == 0) {
                this.validationMsg.shelves = "Shelves are required.";
            }
            if (this.formData.sku.trim() == "") {
                this.validationMsg.sku = "Sku is required.";
            }
        },
        //for create form & edit form
        formDataToSubmit() {
            let form_data = new FormData();
            if (this.isediting == "edit") {
                form_data.append("id", this.formData.id);
            }
            let submitData = [this.formData.name];
            form_data.append("sku", this.formData.sku);

            form_data.append("data", JSON.stringify(submitData));

            let shelf_arr = [];
            this.shelves.forEach((shelf) => {
                if (shelf.inventory_id == null) {
                    shelf_arr.push(shelf);
                }
            });
            if (this.isediting == "create") {
                form_data.append("shelves", JSON.stringify(this.shelves));
            } else {
                form_data.append("shelves", JSON.stringify(shelf_arr));
            }
            return form_data;
        },
        validateResError(error) {
            if (error.response.data.message[0]) {
                error.response.data.message.forEach((nameError) => {
                    if (nameError.language_code == "en") {
                        this.validationMsg.name = nameError.message;
                    }
                });
            } else {
                if (error.response.data.message.sku) {
                    this.validationMsg.sku = error.response.data.message.sku;
                }
            }
        },

        async updateOrCreate(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.sku = "";
            this.validationMsg.shelves = "";
            this.validateRules();
            if (
                this.formData.name.name &&
                this.shelves.length > 0 &&
                this.formData.sku
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    url: "inventories/createOrUpdate",
                };
                this.setApiLoading(true);

                this.postApiForm(payload)

                    .then((res) => {
                        this.setApiLoading(false);

                        this.$swal({
                            icon: "success",
                            title: `${
                                this.isediting == "create"
                                    ? "Created!"
                                    : "Edited!"
                            }`,
                            text: `Inventory has been ${this.isediting}`,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        window.location.href = "/inventory_lists";
                    })
                    .catch((error) => {
                        this.scrollToTop();
                        this.setApiLoading(false);

                        this.validateResError(error);
                    });
            } else {
                //without data
            }
        },
        isShelfExit(shelf) {
            let isshelfexit = false;
            this.shelves.forEach((element) => {
                if (element.name == shelf.name) {
                    isshelfexit = true;
                }
            });
            return isshelfexit;
        },
        async getInventoryDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/inventories/${uri[uriLast]}`);
            res = res.data.data;
            this.formData.id = res.id;
            this.formData.sku = res.sku;
            res.name_translations.forEach((name_translation) => {
                if (name_translation.language_code == "en") {
                    this.formData.name.name = name_translation.name;
                }
                if (name_translation.language_code == "mm") {
                    this.formData.mm_name.name = name_translation.name;
                }
            });

            this.shelves = res.shelves;
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
    },
    //s
    mounted() {
        if (this.isediting == "edit") {
            this.getInventoryDetail();
        }
    },
};
</script>
