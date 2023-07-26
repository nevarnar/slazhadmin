<template lang="">
    <div style="display: contents">
        <tr>
            <div
                class="contents"
                @click="showSubProuductTable = 1 - showSubProuductTable"
            >
                <td>{{ order.index }}</td>
                <td>
                    {{ order.order_id }}
                </td>
                <td>{{ order.date }}</td>
                <td>
                    {{ order.user.name }}
                </td>
                <td>
                    <!-- {{ order }} -->
                </td>
                <td>
                    {{ order.total_quantity }}
                </td>
                <td>{{ order.total_value }}</td>
            </div>
            <td>
                <multiselect
                    class="mt-2"
                    v-model="statusValue"
                    :options="statusOptions"
                    :searchable="false"
                    :close-on-select="true"
                    :show-labels="false"
                    label="name"
                    track-by="name"
                    placeholder="Choose "
                    @input="changeStatus"
                ></multiselect>
            </td>
        </tr>

        <tr class="border-b-0" v-show="showSubProuductTable">
            <td colspan="9" class="border-b-0 border-l-[6px] border-gray-600">
                <div
                    class="relative flex justify-end w-full py-3 pr-40 border-b"
                >
                    <div
                        class="w-[44%] whitespace-normal break-words text-left pr-3"
                    >
                        <p class="text-[13px] text-gray-800 primary-font">
                            {{ order.address ? order.address.address : null }}
                        </p>
                    </div>
                    <div class="px-3">
                        <div class="block text-left">
                            <p
                                class="text-[13px] text-gray-800 inline-block primary-font"
                            >
                                Discount :
                            </p>
                            <p class="text-[13px] text-gray-800 inline-block">
                                {{ order.total_discount_value }} MMK
                            </p>
                        </div>
                        <div class="block text-left">
                            <p
                                class="text-[13px] text-gray-800 inline-block primary-font"
                            >
                                Delivery Fees :
                            </p>
                            <p class="text-[13px] text-gray-800 inline-block">
                                {{
                                    order.is_delivery_free == 0
                                        ? "NotFree"
                                        : "Free"
                                }}
                            </p>
                        </div>
                        <div
                            v-if="permissionUser == 'inventory-management'"
                            class="flex"
                        >
                            <div class="block text-left">
                                <p
                                    class="text-[13px] text-gray-800 inline-block primary-font"
                                >
                                    Delivery Man :
                                </p>
                                <multiselect
                                    v-if="deliverymen"
                                    class="mt-2"
                                    v-model="delivery_value"
                                    :options="deliverymen"
                                    :searchable="false"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customLabel"
                                    track-by="id"
                                    :disabled="after_select"
                                    placeholder="Choose Delivery"
                                ></multiselect>
                            </div>
                            <button
                                @click="selectDelivery"
                                type="button"
                                class="pr-2 ml-3 mt-3"
                                title=""
                                id=""
                            >
                                <i class="fal fa-check"></i>
                            </button>
                        </div>
                    </div>

                    <div
                        v-if="permissionUser == 'order-management'"
                        class="block text-left flex ml-4"
                    >
                        <p
                            class="text-[13px] text-gray-800 inline-block primary-font mt-4"
                        >
                            Inventory :
                        </p>
                        <multiselect
                            v-if="order.inventories"
                            class="mt-2"
                            v-model="inventory_value"
                            :options="order.inventories"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customLabel"
                            track-by="id"
                            placeholder="Choose Inventory"
                        ></multiselect>
                    </div>
                </div>

                <div
                    v-for="(subproduct, s_id) in order.order_items"
                    :key="s_id"
                    class="contents"
                >
                    <order-list-subproduct
                        :subproduct="subproduct"
                        :statusvalue="statusValue"
                        :change-product-style-qty="changeProductStyleQty"
                        :select-available-floor="selectAvailableFloor"
                        :permission-user="permissionUser"
                        :inventory-value="inventory_value"
                    ></order-list-subproduct>
                </div>
            </td>
        </tr>
    </div>
</template>
<script>
import OrderListSubproduct from "./OrderListSubproduct.vue";
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
    name: "OrderListItem",
    components: {
        OrderListSubproduct,
        Multiselect,
    },
    props: {
        order: {}, //
        permissionUser: {},
        deliverymen: {},
    },
    data() {
        return {
            delivery_value: this.order?.delivery_man,
            after_select: this.order?.delivery_man ? true : false,
            statusValue: this.getStatus(this.order.status),
            showSubProuductTable: false,
            images: [],
            send_orders: [],
            allStatusOptions: [
                {
                    name: "Received",
                    value: "received",
                },
                {
                    name: "Confirmed",
                    value: "confirmed",
                },
                {
                    name: "Cancelled",
                    value: "cancelled",
                },
                {
                    name: "Delivering",
                    value: "delivering",
                },
                {
                    name: "Delivered",
                    value: "delivered",
                },
            ],
            inventory_value: null,
            tem_inventory: this.order.inventory,
        };
    },
    computed: {
        ...mapGetters(["reRenderKey"]),
        statusOptions() {
            //with permission
            if (this.permissionUser == "order-management") {
                return [
                    {
                        name: "Received",
                        value: "received",
                        step: 1,
                    },
                    {
                        name: "Confirmed",
                        value: "confirmed",
                        step: 2,
                    },
                    {
                        name: "Cancelled",
                        value: "cancelled",
                        step: 3,
                    },
                ];
            } else if (this.permissionUser == "inventory-management") {
                return [
                    {
                        name: "Delivering",
                        value: "delivering",
                        step: 3,
                    },
                    {
                        name: "Delivered",
                        value: "delivered",
                        step: 4,
                    },
                ];
            } else {
                return [
                    {
                        name: "Received",
                        value: "received",
                        step: 1,
                    },
                    {
                        name: "Confirmed",
                        value: "confirmed",
                        step: 2,
                    },
                    {
                        name: "Cancelled",
                        value: "cancelled",
                        step: 3,
                    },
                    {
                        name: "Delivering",
                        value: "delivering",
                        step: 3,
                    },
                    {
                        name: "Delivered",
                        value: "delivered",
                        step: 4,
                    },
                ];
            }
        },
    },
    methods: {
        ...mapActions(["postApiForm", "getApiData", "postWebForm"]),
        ...mapMutations(["setReRenderKey"]),
        customLabel(option) {
            return `${option?.name_translations[0]?.name}`;
        },
        getStatus(status) {
            if (status == "received") {
                return {
                    name: "Received",
                    value: "received",
                };
            }
            if (status == "confirmed") {
                return {
                    name: "Confirmed",
                    value: "confirmed",
                };
            }
            if (status == "cancelled") {
                return {
                    name: "Cancelled",
                    value: "cancelled",
                };
            }
            if (status == "delivering") {
                return {
                    name: "Delivering",
                    value: "delivering",
                };
            }
            if (status == "delivered") {
                return {
                    name: "Delivered",
                    value: "delivered",
                };
            }
        },
        getStep(status) {
            if (status == "received") {
                return 1;
            }
            if (status == "confirmed") {
                return 2;
            }
            if (status == "cancelled") {
                return 3;
            }
            if (status === "delivering") {
                return 3;
            }
            if (status === "delivered") {
                return 4;
            }
        },
        changeStatus() {
            if (
                !this.delivery_value?.delivery_id &&
                this.permissionUser == "inventory-management"
            ) {
                let ren = this.reRenderKey;
                this.setReRenderKey(ren++);
                this.$swal("Error!", "Select delivery man first", "error");
                return;
            }
            let currentStep = this.getStep(this.order.status);
            console.log("currentStep", currentStep);
            console.log("status", this.statusValue);
            console.log(
                "minus",
                parseInt(this.statusValue.step) - parseInt(currentStep)
            );
            if (
                parseInt(this.statusValue.step) - parseInt(currentStep) != 1 &&
                this.permissionUser == "inventory-management"
            ) {
                this.$swal("Error!", "Please confirm step by step !", "error");
                let ren = this.reRenderKey;
                this.setReRenderKey(ren++);
                return;
            }
            let null_floor = 0;
            this.send_orders.forEach((item) => {
                if (item.type == "sub_product" && item.floor_id == null) {
                    null_floor += 1;
                }
                if (item.type == "style") {
                    item.order_style_products.forEach((sub) => {
                        if (sub.floor_id == null) {
                            null_floor += 1;
                        }
                    });
                }
            });
            if (null_floor != 0 && this.statusValue.value == "confirmed") {
                Toast.fire(
                    `Select floors ${this.statusValue.value}`,
                    "",
                    "error"
                );
                this.statusValue = this.getStatus(this.order.status);
                this.showSubProuductTable = 1;
                return;
            }
            let payload = null;
            if (this.permissionUser == "inventory-management") {
                payload = {
                    form_data: {
                        order_id: this.order.id,
                        status: this.statusValue.value,
                        items: this.send_orders,
                        delivery_man_id: this.delivery_value.delivery_id,
                    },
                    url: "orders/action_status",
                };
            } else {
                payload = {
                    form_data: {
                        order_id: this.order.id,
                        items: this.send_orders,
                        status: this.statusValue.value,
                        inventory_id: this.inventory_value.id,
                    },
                    url: "orders/action_status",
                };
            }

            this.postApiForm(payload)
                .then((res) => {
                    this.$swal({
                        icon: "success",
                        title: `Success`,
                        text: `Successfully ${this.statusValue.value}`,
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    let ren = this.reRenderKey;
                    this.setReRenderKey(++ren);
                })
                .catch((error) => {});
        },

        getImages() {
            //load image from s3
            let uniqImages = [...new Set(this.images)]; //remove duplicate images
            const imageLoadings = uniqImages.map((imageSrc) => {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.src = imageSrc;
                    img.onload = resolve;
                    img.onerror = reject;
                });
            });
            // console.log("load images");
            Promise.all(imageLoadings)
                .then(() => {
                    // console.log("Images loaded!");
                    this.isLoading = false;
                })
                .catch((error) => {
                    // console.error("Some image(s) failed loading!");
                });
        },
        sendOrderData() {
            this.order?.order_items.forEach((subproduct) => {
                let item = {};
                if (subproduct.orderable_type == "sub_product") {
                    item.type = "sub_product";
                    item.floor_id = subproduct.floor_id;
                } else {
                    let order_style_products = [];
                    subproduct.order_style_products.forEach((sub) => {
                        let order_style_product = {};
                        order_style_product.id = sub.id;
                        order_style_product.quantity = sub.buying_quantity;
                        order_style_product.floor_id = sub.floor_id;
                        order_style_products.push(order_style_product);
                    });
                    item.type = "style";
                    item.order_style_products = order_style_products;
                }
                item.id = subproduct.id;
                item.quantity = subproduct.buying_quantity;
                this.send_orders.push(item);
            });
        },
        changeProductStyleQty({ id, qty }) {
            this.send_orders.forEach((item) => {
                if (item.id == id) {
                    item.quantity = qty;
                }
            });
        },
        selectAvailableFloor({ floor_id, id, type, style_id }) {
            this.send_orders.forEach((item) => {
                if (
                    item.type == type &&
                    type == "sub_product" &&
                    item.id == id
                ) {
                    item.floor_id = floor_id;
                }
                if (
                    item.type == type &&
                    type == "style" &&
                    item.id == style_id
                ) {
                    item.order_style_products.forEach((sub) => {
                        if (sub.id == id) {
                            sub.floor_id = floor_id;
                        }
                    });
                    //   item.floor_id = floor_id;
                }
            });
            //   console.log("selectAvailableFloor", payload);
            //   this.send_orders.forEach((item) => {
            //     if (item.id == id) {
            //       item.quantity = qty;
            //     }
            //   });
        },
        selectDelivery() {
            if (!this.delivery_value) {
                return;
            }
            this.after_select = true;
        },
    },
    mounted() {
        if (this.order.inventory) {
            let inv = this.order.inventories.find(
                (inv) => inv.id == this.order.inventory.id
            );
            this.inventory_value = inv;
        }
        if (
            this.order.delivery_man &&
            this.permissionUser == "inventory-management"
        ) {
            this.delivery_value = this.order.delivery_man;
            this.after_select = true;
        }
        this.getImages();
        this.sendOrderData();
    },
};
</script>
<style lang=""></style>
