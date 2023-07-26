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
                <td>{{ format_date(order.created_at) }}</td>
                <td>
                    {{ order.user.name }}
                </td>
                <td>
                    {{ order.address.township_name }}, {{order.address.division_name}}
                </td>
                <td>
                    {{ order.qty }}
                </td>
                <td>
                    {{ order.reason.name }}
                </td>
                <td>{{ order.amount }}</td>
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
                        <div class="block text-left" v-if="permissionUser=='order-management' && order.status=='received'">
                            <p
                                class="text-[13px] text-gray-800 inline-block primary-font"
                            >
                                Change return type :
                            </p>
                            <multiselect
                                class="mt-2"
                                v-model="returnType"
                                :options="order.reasons"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="id"
                                placeholder="Choose Return Type"
                            ></multiselect>
                        </div>
                        <div v-if="permissionUser=='inventory-management'" class="block text-left">
                            <p
                                class="text-[13px] text-gray-800 inline-block primary-font"
                            >
                                Delivery Man :
                            </p>
                            <multiselect v-if="deliverymen"
                                class="mt-2"
                                v-model="delivery_man_id"
                                :options="deliverymen"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                :custom-label="customLabel"
                                track-by="id"
                                placeholder="Choose Delivery"
                            ></multiselect>
                        </div>
                    </div>
                    <div class="px-3">
                        <div class="block text-left" v-if="permissionUser=='order-management' && order.status=='received'">
                            <p
                                class="text-[13px] text-gray-800 inline-block primary-font"
                            >
                                Choose Inventory :
                            </p>
                            <multiselect
                                class="mt-2"
                                v-model="inventory_value"
                                :options="order.inventories"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                :custom-label="customLabel"
                                track-by="id"
                                placeholder="Choose inventory"
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <sale-return-subproduct
                    :new-return-item="new_return_item"
                    :permission-user='permissionUser'
                    :sale-return="order"
                    :statusvalue="statusValue"
                    :select-available-floor="selectAvailableFloor"
                    :set-new-return-item="setNewReturnItem"
                    :return-type="returnType"
                    :inventory-value="inventory_value"
                ></sale-return-subproduct>
            </td>
        </tr>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import SaleReturnSubproduct from "./SaleReturnSubproduct.vue";
import moment from "moment";

export default {
    name: "SaleReturnItem",
    components: {
        SaleReturnSubproduct,
        Multiselect,
    },
    props: {
        order: {}, //
        permissionUser:{},
        deliverymen: {}
    },
    data() {
        return {
            statusValue: this.getStatus(this.order.status),
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
            showSubProuductTable: false,
            images: [],
            old_floor:  this.order?.floor?.id,
            new_return_item: null,
            delivery_man_id:null,
            returnType:this.order?.reason,
            inventory_value:null
        };
    },
    computed: {
        ...mapGetters(["reRenderKey"]),
        statusOptions(){ //with permission
            if(this.permissionUser=='order-management'){
                return [
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
                }
                ]
            }else if(this.permissionUser=='inventory-management'){
                return [
                {
                    name: "Delivering",
                    value: "delivering",
                },
                {
                    name: "Delivered",
                    value: "delivered",
                }
                ]
            }
            else {
                return [
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
            ]
            }
        }
    },
    methods: {
        ...mapActions(["postApiForm"]),
        ...mapMutations(["setReRenderKey"]),
        customLabel(option) {
            return `${option?.name_translations[0]?.name}`;
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format("D MMM-YYYY");
            }
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
        changeStatus() {
            let ren = this.reRenderKey;
            if(!this.returnType){
                this.setReRenderKey(++ren);
                this.statusValue = this.getStatus(this.order.status);
                return;
            }
            console.log('oldfloor',this.old_floor);
            if (
                this.old_floor == null &&
                this.statusValue.value == "confirmed" && this.permissionUser=='order-management'
            ) {
                Toast.fire(
                    `Select floors ${this.statusValue.value}`,
                    "",
                    "error"
                );
                this.statusValue = this.getStatus(this.order.status);
                this.showSubProuductTable = 1;
                this.setReRenderKey(++ren);
                return;
            }
            if (
                this.delivery_man_id == null && this.permissionUser=='inventory-management'
            ) {
                Toast.fire(
                    `Select delivery man ${this.statusValue.value}`,
                    "",
                    "error"
                );
                this.statusValue = this.getStatus(this.order.status);
                this.setReRenderKey(++ren);

                return;
            }
            if(this.returnType.name =='Wrong Size' && !this.new_return_item && this.permissionUser == 'order-management'){
                Toast.fire(
                    `Choose new Item`,
                    "",
                    "error"
                );
                this.statusValue = this.getStatus(this.order.status);
                this.setReRenderKey(++ren);
                return;
            }
            let old_item = {
                type: "sub_product",
                floor_id: this.old_floor,
                id: this.order.sub_product.id,
                quantity: this.order.qty,
            };
            let payload= null;
            if(this.permissionUser=='order-management'){
                 payload = {
                    form_data: {
                        sale_return_id: this.order.id,
                        item: old_item,
                        return_item: this.new_return_item,
                        status: this.statusValue.value,
                        reason_id: this.returnType.id
                    },
                    url: "update_sale_return_action",
                };
            }else if(this.permissionUser=='inventory-management'){
                payload = {
                    form_data: {
                        sale_return_id: this.order.id,
                        status: this.statusValue.value,
                        delivery_man_id: this.delivery_man_id.delivery_id
                    },
                    url: "update_sale_return_action",
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
            console.log("load images");
            Promise.all(imageLoadings)
                .then(() => {
                    console.log("Images loaded!");
                    this.isLoading = false;
                })
                .catch((error) => {
                    console.error("Some image(s) failed loading!");
                });
        },
        selectAvailableFloor({ floor_id }) {
            this.old_floor = floor_id;
        },
        setNewReturnItem(payload) {
            this.new_return_item = payload;
        },
    },
    mounted() {
        this.getImages();
        if(this.order.delivery_man){
            this.delivery_man_id = this.order.delivery_man
        }
    },
};
</script>
<style lang=""></style>
