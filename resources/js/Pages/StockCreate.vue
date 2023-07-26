<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle pl-4 mb-0">Add Stocks to Inventory</p>
        </div>
        <div class="pt-6 mb-6">
            <div class="pl-2 grid grid-cols-9 gap-y-1 gap-x-8 mx-2">
                <div class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Invoice Number</label
                    >
                </div>
                <div class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Supplier Name</label
                    >
                </div>
                <div class="col-span-1">
                    <!-- free space for grid -->
                </div>

                <!-- start row -->
                <div class="col-span-4">
                    <div class="form-group mb-4">
                        <input
                            v-model="invoice_no"
                            type="text"
                            class="form-control input-form mt-1"
                            id=""
                            placeholder=""
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.invoice_no"
                        >
                            {{ validationMsg.invoice_no }}
                        </p>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="form-group mb-4 mt-1">
                        <multiselect
                            v-model="supplierValue"
                            :options="supplierOptions"
                            :searchable="true"
                            :close-on-select="true"
                            label="name"
                            :custom-label="customLabel"
                            @search-change="getSuppliers"
                            placeholder="Search supplier"
                        ></multiselect>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.supplier_id"
                        >
                            {{ validationMsg.supplier_id }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->
            </div>
            <hr class="col-span-9 mt-2 mb-3 h-0 border-gray-200" />

            <!-- start row -->
            <div class="pl-2 grid grid-cols-9 gap-y-1 gap-x-8 mx-2">
                <!-- start -->

                <div v-show="isAdmin" class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Inventory</label
                    >
                </div>
                <div class="col-span-4">
                    <label for="" class="form-label label-form">Floor</label>
                </div>
                <div v-show="isAdmin" class="col-span-1"></div>

                <div v-show="!isAdmin" class="col-span-5"></div>
                <!-- end -->

                <!-- start -->
                <div v-show="isAdmin" class="col-span-4">
                    <div class="form-group mb-4 mt-1">
                        <multiselect
                            v-model="inventoryValue"
                            :options="inventoryOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customLabel"
                            placeholder="Choose a inventory"
                            @input="getFloor"
                        ></multiselect>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="form-group mb-4 mt-1">
                        <multiselect
                            v-model="floorValue"
                            :options="floorOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            label="name"
                            placeholder="Choose a floor"
                        ></multiselect>
                    </div>
                </div>
                <div v-show="isAdmin" class="col-span-1"></div>
                <div v-show="!isAdmin" class="col-span-5"></div>
                <!-- end -->

                <!-- start -->
                <div class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Item Code</label
                    >
                </div>
                <div class="col-span-4">
                    <label for="" class="form-label label-form">Amount</label>
                </div>
                <div class="col-span-1"></div>
                <!-- end -->

                <!-- start -->
                <div class="col-span-4">
                    <div class="form-group mb-4 mt-1">
                        <multiselect
                            v-model="itemValue"
                            :options="itemOptions"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customItemLabel"
                            :searchable="true"
                            :internal-search="false"
                            :clear-on-select="false"
                            :options-limit="50"
                            :limit="3"
                            :max-height="200"
                            @search-change="asyncFindItem"
                            placeholder="Search Item"
                        ></multiselect>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.stock"
                        >
                            {{ validationMsg.stock }}
                        </p>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="form-group mb-4">
                        <input
                            v-model="amount"
                            type="number"
                            class="form-control input-form mt-1"
                            id=""
                            placeholder="Amount"
                        />
                    </div>
                </div>
                <div class="col-span-1">
                    <Button
                        @click="addHandler"
                        type="button"
                        class="primary-button bg-black mt-1"
                        >Add</Button
                    >
                </div>
                <!-- end -->
            </div>

            <div class="">
                <hr class="my-2 h-0" />
            </div>

            <!-- end row -->

            <!-- start row -->
            <stock-create-two />

            <!-- end row -->

            <div class="flex justify-end pb-4 mt-12">
                <button
                    :disabled="currentApiLoading"
                    type="button"
                    class="primary-button bg-black"
                    @click="addStockToInventory"
                >
                    <api-loading />
                    Create
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import StockCreateTwo from "./StockCreateTwo.vue";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
    name: "StockCreate",
    components: {
        StockCreateTwo,
        Multiselect,
        apiLoading,
    },
    props: ["authUser"],
    data() {
        return {
            invoice_no: "",
            amount: "",
            supplierValue: null,
            supplierOptions: [],
            itemValue: null,
            itemOptions: [],
            inventoryValue: null,
            inventoryOptions: [],
            floorValue: null,
            floorOptions: [],
            successValidationRules: false,
            validationMsg: {
                supplier_id: "",
                invoice_no: "",
                stock: "",
            },
        };
    },
    computed: {
        ...mapGetters(["myAddStocksToInventoryRows", "currentApiLoading"]),
        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
    },
    methods: {
        ...mapActions(["getApiData", "postWebForm"]),
        ...mapMutations(["setAddStocksToInventoryRows", "setApiLoading"]),
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        customItemLabel(option) {
            return `${option.product.name_translations[0].name} - ${option.sku} `;
        },
        async getSuppliers(query) {
            if (query.trim()) {
                this.getApiData({
                    url: `get_supplier?search_input=${query}`,
                }).then((res) => {
                    this.supplierOptions = res.data.data;
                });
            }
        },
        async getInventories() {
            this.getApiData({
                url: `get_inventories`,
            }).then((res) => {
                this.inventoryOptions = res.data.data;
            });
        },
        async asyncFindItem(query) {
            let payload = {
                url: `search_sub_products?search_input=${query}`,
            };
            this.getApiData(payload).then((res) => {
                console.log("res", res.data.data);
                this.itemOptions = res.data.data;
            });
        },
        async getSupplerSample(query) {
            let payload = {
                url: `suppliers`,
            };
            this.getApiData(payload).then((res) => {
                this.supplierOptions = res.data.data.data;
            });
        },
        async getFloor() {
            if (this.isAdmin && this.inventoryValue == null) {
                return;
            }
            let inventory_id = this.isAdmin
                ? this.inventoryValue.id
                : this.authUser.inventory_id;
            // this.authUser.inventory_id
            let payload = {
                url: `get_floor_by_inventory?inventory_id=${inventory_id}&is_admin=${
                    this.isAdmin ? 1 : 0
                }`,
            };

            this.getApiData(payload).then((res) => {
                this.floorValue = null;
                this.floorOptions = res.data.data;
            });
            // let ress = await this.postWebForm(payload);
        },
        addHandler() {
            if (this.floorValue && this.amount && this.itemValue) {
                let payload = {
                    local_id: Math.random().toString(36).slice(2), //for local edit
                    item: this.itemValue,
                    amount: this.amount,
                    floor: this.floorValue,
                };
                this.setAddStocksToInventoryRows(payload);
                this.floorValue = "";
                this.amount = "";
                this.itemValue = [];
            } else {
                this.$swal({
                    icon: "warning",
                    title: "Warining",
                    text: "Fill all required fields.",
                    showConfirmButton: false,
                    timer: 1000,
                });
            }
        },
        resetvalidateRulesMsg() {
            this.validationMsg.supplier_id = "";
            this.validationMsg.invoice_no = "";
            this.validationMsg.stock = "";
        },
        validateRules() {
            this.successValidationRules = true;
            this.resetvalidateRulesMsg();
            if (this.supplierValue == null) {
                this.validationMsg.supplier_id = "Supplier is required.";
                this.successValidationRules = false;
            }
            if (this.invoice_no.trim() == "") {
                this.validationMsg.invoice_no = "Inventory number is required.";
                this.successValidationRules = false;
            }
            if (this.myAddStocksToInventoryRows.length == 0) {
                this.validationMsg.stock = "Stock is required.";
                this.successValidationRules = false;
            }
        },
        validateResError(error) {
            console.log("first", error.response.data.message);
            if (error.response.data.message.invoice_no != null) {
                this.validationMsg.invoice_no =
                    error.response.data.message.invoice_no;
            }
        },
        addStockToInventory() {
            this.validateRules();
            if (this.successValidationRules == false) {
                return;
            }
            let form_data = new FormData();
            let stocks = [];
            this.myAddStocksToInventoryRows.forEach((row) => {
                let stock = {
                    sub_product_id: row.item.product_prices.sub_product_id,
                    floor_id: row.floor.id,
                    quantity: row.amount,
                };
                stocks.push(stock);
            });
            form_data.append("stocks", JSON.stringify(stocks));
            form_data.append("supplier_id", this.supplierValue.id);
            form_data.append("invoice_no", this.invoice_no);

            this.setApiLoading(true);
            let payload = {
                url: "stocks/createOrUpdate",
                form_data: form_data,
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.setApiLoading(false);

                    console.log("res", res);

                    this.$swal({
                        icon: "success",
                        title: "Created!",
                        text: `Stock has been added.`,
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    window.location.href = "/stocks_lists";
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });
        },
    },

    async mounted() {
        if (this.isAdmin) {
            this.getInventories();
        } else {
            this.getFloor();
        }
        this.getSupplerSample();
    },
};
</script>
