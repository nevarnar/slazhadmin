<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle pl-4 mb-0">Warehouse Transfer</p>
        </div>
        <div class="pt-2 mb-6">
            <div class="ml-4 pl-0">
                <div class="grid grid-cols-5 gap-y-1 gap-x-8">
                    <div class="flex justify-start pt-4 mb-2 col-span-2">
                        <p
                            class="text-sm text-gray-800 inline-block min-w-max pr-4"
                            style="font-family: 'Roboto', sans-serif"
                        >
                            To
                        </p>
                        <p class="text-sm text-gray-500 inline-block">
                            Transfer ID
                        </p>
                        <span>:</span>
                        <p class="text-sm text-gray-500 inline-block">
                            {{ authUser.transaction_id }}
                        </p>
                    </div>
                    <div class="col-span-3"></div>
                    <div class="mb-4 col-span-2">
                        <multiselect
                            v-model="inventoryValue"
                            :options="inventoryOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :allow-empty="false"
                            track-by="name"
                            :custom-label="customLabel"
                            placeholder="Inventory"
                        ></multiselect>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.inventory_id"
                        >
                            {{ validationMsg.inventory_id }}
                        </p>
                    </div>
                    <div class="col-span-3"></div>
                </div>
                

                <div class="grid grid-cols-5 gap-y-1 gap-x-8">
                    <div class="col-span-2">
                        <label for="" class="form-label label-form"
                            >Item Code</label
                        >
                    </div>
                    <div class="col-span-2">
                        <label for="" class="form-label label-form"
                            >Amount (Max-
                            {{ itemValue?.total_quantity }})</label
                        >
                    </div>
                    <div class="col-span-1">
                        <!-- free space for grid -->
                    </div>

                    <!-- start row -->
                    <div class="col-span-2">
                        <div class="form-group mb-4">
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
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="form-group mb-4">
                            <input
                                v-model="amount"
                                type="number"
                                class="form-control input-form mt-1"
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
                    <!-- end row -->
                </div>
            </div>
            <div>
                <hr class="my-2 h-0" />
            </div>

            <!-- start row -->
            <div class="w-full pt-0">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th">Id</th>
                            <th class="sec-thead-th">Product Name</th>
                            <th class="sec-thead-th">Category</th>
                            <th class="sec-thead-th">Brand</th>
                            <th class="sec-thead-th">Color</th>
                            <th class="sec-thead-th">Size</th>
                            <th class="sec-thead-th">Floor / Amount</th>
                            <th class="sec-thead-th">Action</th>
                            <th class="sec-thead-th" style="text-align: right">
                                Total
                            </th>
                            <th class="sec-thead-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <div
                            class="contents"
                            v-for="(item, i) in myTransferItems"
                            :key="i"
                        >
                            <inventory-transfer-create-row
                                :item-stock="item"
                                :index="++i"
                            />
                        </div>
                    </tbody>
                </table>
            </div>

            <!-- end row -->

            <div class="flex justify-end pb-4 mt-12">
                <button
                    :disabled="currentApiLoading"
                    @click.prevent="createHandler"
                    type="button"
                    class="primary-button bg-black"
                >
                    <api-loading />
                    Create
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import InventoryTransferCreateRow from "../Components/InventoryTransferCreateRow.vue";
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
    name: "InventoryTransferCreate",
    components: {
        Multiselect,
        InventoryTransferCreateRow,
        apiLoading,
    },
    props: ["authUser"],
    data() {
        return {
            inventoryValue: null,
            inventoryOptions: [],
            itemValue: null,
            itemOptions: [],
            amount: 0,
            validationMsg: {
                inventory_id: "",
            },
        };
    },
    computed: {
        ...mapGetters(["myTransferItems", "currentApiLoading"]),
        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
    },
    methods: {
        ...mapActions(["getApiData", "getWebData", "postWebForm"]),
        ...mapMutations(["setTransferItem", "setApiLoading"]),
        customItemLabel(option) {
            return `${option.sub_product.sku} `;
        },
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        async asyncFindItem(query) {
            let payload = {
                url: `sub_products_by_inventory?search_input=${query}&inventory_id=${this.authUser.inventory_id}`,
            };
            this.getWebData(payload).then((res) => {
                console.log("res", res.data.data);
                this.itemOptions = res.data.data;
            });
        },
        addHandler() {
            if (this.itemValue == null || this.amount == 0) {
                this.$swal("Warning!", "Fill all required fields.", "warning");
                return;
            }
            console.log(this.amount, this.itemValue.total_quantity);
            if (this.amount > this.itemValue.total_quantity) {
                this.$swal(
                    "Warning!",
                    "Cannot exceed totoal quantity.",
                    "warning"
                );
                return;
            }

            if (
                this.myTransferItems.some(
                    (data) => data.item.id === this.itemValue.id
                )
            ) {
                console.log("1");
                this.$swal("Error!", "Item already exits.", "error");
                return;
            }
            console.log("2");

            this.itemValue.floors.forEach((floor) => {
                floor.transfer_amount = 0;
                floor.max_amount_validation = false;
            });
            let payload = {
                item: this.itemValue,
                amountValidation: true,
                amount: this.amount,
            };
            console.log(
                this.itemValue.sub_product.color.name_translations[0].name
            );
            this.setTransferItem(payload);
        },
        async getInventories() {
            this.getApiData({
                url: `get_inventories`,
            }).then((res) => {
                let response = res.data.data;
                console.log(response);
                const deleteItem = response.findIndex(
                    (p) => p.id ==this.authUser.inventory_id
                );
                response.splice(deleteItem, 1);
                this.inventoryOptions = response;
            });
        },
        createHandler() {
            console.log(this.myTransferItems);
            this.validationMsg.inventory_id = "";
            if (this.myTransferItems.length == 0) {
                return;
            }

            if (this.inventoryValue == null) {
                this.validationMsg.inventory_id = "Inventory is required";
                return;
            }
            var valiationErrorCount = 0;
            var transfer_items = [];
            this.myTransferItems.forEach((item) => {
                console.log("item", item);

                if (item.amountValidation) {
                    valiationErrorCount++;
                }
                item.item.floors.forEach((floor) => {
                    console.log("floor", floor);
                    let transfer_item = {
                        sub_product_id: null,
                        floor_id: null,
                        quantity: null,
                    };
                    transfer_item.sub_product_id = item.item.sub_product_id;
                    transfer_item.floor_id = floor.id;
                    transfer_item.floor_id = floor.id;
                    transfer_item.quantity = parseInt(floor.transfer_amount);
                    transfer_items.push(transfer_item);
                    if (floor.max_amount_validation) {
                        valiationErrorCount++;
                    }
                });
            });
            if (valiationErrorCount > 0) {
                this.$swal("Warning!", "Fill all required fields.", "warning");
                return;
            }
            console.log(transfer_items);
            let form_data = new FormData();
            form_data.append("transfer_id", this.authUser.transaction_id);
            form_data.append("to_inventory_id", this.inventoryValue.id);
            form_data.append("stocks", JSON.stringify(transfer_items));

            this.setApiLoading(true);
            let payload = {
                url: "transfers",
                form_data: form_data,
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.setApiLoading(false);
                    console.log("res", res);

                    this.$swal({
                        icon: "success",
                        title: "Created",
                        text: `Transfer stock has been created.`,
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    window.location.href = "/inventory_transfer_lists";
                })
                .catch((error) => {
                    this.setApiLoading(false);
                });
        },
    },
    mounted() {
        this.getInventories();
    },
};
</script>
<style lang=""></style>
