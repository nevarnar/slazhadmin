<template>
    <!-- Modal -->
    <div
        class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
        id="edit_stock_items"
        tabindex="-1"
        aria-labelledby="edit_stock_items"
        aria-hidden="true"
        ref="modal"
    >
        <div class="modal-dialog modal-box">
            <form>
                <div class="modal-content content-modal-normal">
                    <div class="modal-body px-2">
                        <div class="block px-6 pt-6 rounded-lg bg-white">
                            <div class="form-group mb-4">
                                <label
                                    for="name"
                                    class="form-label label-form mb-3 block"
                                    >Inventory</label
                                >

                                <multiselect
                                    v-model="inventoryValue"
                                    :options="inventoryOptions"
                                    :searchable="false"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customLabel"
                                    placeholder="Choose a floor"
                                    disabled
                                ></multiselect>
                            </div>
                            <div class="form-group mb-4">
                                <label
                                    for="sku_name"
                                    class="form-label label-form mb-3 block"
                                    >Shelf</label
                                >
                                <multiselect
                                    v-model="floorValue"
                                    :options="floorOptions"
                                    :searchable="false"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    label="name"
                                    placeholder="Choose a floor"
                                    disabled
                                ></multiselect>
                            </div>
                            <div class="form-group mb-4">
                                <label
                                    for="country_id"
                                    class="form-label label-form"
                                    >Amount</label
                                >
                                <input
                                    v-model="quantity"
                                    type="number"
                                    class="form-control input-form mt-2"
                                    autocomplete="off"
                                    id="sku_name"
                                    placeholder=""
                                />
                                <p
                                    class="text-red-600 text-xs"
                                    v-show="validationMsg.quantity"
                                >
                                    {{ validationMsg.quantity }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="modal-footer modal-footer-box justify-start px-8 pt-0 pb-8"
                    >
                        <button
                            @click="addHandler"
                            type="button"
                            class="px-6 py-2.5 mr-5 primary-button"
                        >
                            Save
                        </button>
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                            id="cancel"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
    name: "EditStockModal",
    props: ["invoice", "floors"],
    data() {
        return {
            inventoryValue: null,
            inventoryOptions: [],
            floorValue: null,
            floorOptions: [],
            quantity: 0,
            remark: "",
            validationMsg: {
                quantity: "",
                remark: "",
            },
            saveStockFormData: [],
        };
    },

    methods: {
        ...mapActions(["postWebForm", "getApiData"]),
        validationRules() {
            if (this.quantity <= 0) {
                this.validationMsg.quantity = "Quantity is required";
            }
        },
        addHandler() {
            this.validationMsg.quantity = "";
            this.validationRules();
            if (!this.quantity && this.floorValue?.id) {
                return;
            }
            let form_data = new FormData(); //wrong naming invoice -> stock
            form_data.append("stock_id", this.invoice.id);
            form_data.append("quantity", this.quantity);
            form_data.append("sub_product_id", this.invoice?.sub_product_id);
            form_data.append("floor_id", this.floorValue.id);
            let payload = {
                form_data: form_data,
                url: "save_stock",
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.closeModal();
                    this.$swal({
                        icon: "success",
                        title: "Created",
                        text: "Stock has been edited.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    this.$emit("getProvinces");

                    // window.location.href = "/defect_confirm";
                })
                .catch((error) => {
                    // this.validateResError(error);
                });
        },
        closeModal() {
            this.quantity = "";
            this.remark = "";
            let id = "cancel";
            console.log("close", id);

            document.getElementById(id).click();
        },
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        // async getInventories() {
        //     this.getApiData({
        //         url: `get_inventories`,
        //     }).then((res) => {
        //         this.inventoryOptions = res.data.data;
        //     });
        // },
        // async getFloor() {
        //     // this.authUser.inventory_id
        //     let payload = {
        //         url: `get_floor_by_inventory?inventory_id=${
        //             this.inventoryValue.id
        //         }&is_admin=${1}`,
        //     };

        //     this.getApiData(payload).then((res) => {
        //         this.floorOptions = res.data.data;
        //     });
        //     // let ress = await this.postApiForm(payload);
        // },
    },
    watch: {
        invoice(newValue, oldValue) {
            console.log("watch");
            this.quantity = this.invoice?.quantity;
            // this.floorOptions = this.floors;
            this.floorValue = this.invoice?.floor;
            this.inventoryValue = this.invoice?.inventory;
        },
    },
    created() {
        // this.getInventories();
        if (this.invoice?.quantity) {
            this.quantity = this.invoice?.quantity;
            // this.floorOptions = this.floors;
            this.floorValue = this.invoice.floor;
        }
        console.log("mounted", this.quantity);
    },
};
</script>
