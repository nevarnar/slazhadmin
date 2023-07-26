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
                    {{ order.address?.address }}
                </td>
                <td>
                    {{ order.total_quantity }}
                </td>
                <td>{{ order.total }}</td>
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
                        <div v-if="deliverymen" class="text-left">
                            <multiselect
                                class="mt-2"
                                v-model="delivery_value"
                                :options="deliverymen"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                :custom-label="customLabel"
                                :disabled="after_select"
                                placeholder="Choose Delivery"
                            ></multiselect>
                        </div>
                    </div>
                    <button
                        @click="selectDelivery"
                        type="button"
                        class="pr-2"
                        title=""
                        id=""
                    >
                        <i class="fal fa-check"></i>
                    </button>
                </div>

                <div
                    v-for="(subproduct, s_id) in order.order_item"
                    :key="s_id"
                    class="contents"
                >
                    <order-list-subproduct-by-inventory
                        :subproduct="subproduct"
                        :order-save-delivery="orderSaveDelivery"
                    />
                </div>
            </td>
        </tr>
    </div>
</template>
<script>
import OrderListSubproductByInventory from "./OrderListSubproductByInventory.vue";
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
    name: "OrderListItemByInventory",
    components: {
        OrderListSubproductByInventory,
        Multiselect,
    },
    props: {
        order: {},
        deliverymen: {},
        filterValue:{}
    },
    computed: {
        ...mapGetters(["reRenderKey"]),
    },
    data() {
        return {
            statusValue: this.filterValue,
            statusOptions: [
                {
                    name: "Confirmed",
                    value: "confirmed",
                    step:1,
                },
                {
                    name: "Delivering",
                    value: "delivering",
                    step:2,
                },
                {
                    name: "Delivered",
                    value: "delivered",
                    step:3,
                },
            ],
            showSubProuductTable: false,
            delivery_value: this.order?.delivery_man,
            after_select: this.order?.delivery_man ? true : false,
            images: [],
        };
    },
    methods: {
        ...mapMutations(["setReRenderKey"]),
        ...mapActions(["postWebForm"]),
        customLabel(option) {
            return `${option?.name_translations[0]?.name}`;
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
        getStatus(status) {
            if (status == "confirmed") {
                return {
                    name: "Confirmed",
                    value: "confirmed",
                };
            }
            if (status==="delivering") {
                console.log('Status is ', status);
                return {
                    name: "Delivering",
                    value: "delivering",
                };
            }
        },
        getStep(status) {
            if (status == "confirmed") {
                return 1;  //first step
            }
            if (status==="delivering") {
                return 2;
            }
            if (status==="delivered") {
                return 3;
            }
        },
        changeStatus() {
            // if(!this.after_select){
            if(!this.delivery_value?.delivery_id){
                let ren = this.reRenderKey;
                this.setReRenderKey(ren++);
                this.$swal(
                    "Error!",
                    "Select delivery man first",
                    "error"
                );
                return;
            }
            let currentStep = this.getStep(this.order.status);
            if( this.statusValue.step - currentStep !=1){
                this.$swal(
                    "Error!",
                    "Please confirm step by step !",
                    "error"
                );
                let ren = this.reRenderKey;
                this.setReRenderKey(ren++);
                return;
               
            }
            let form_data = {
                order_id: this.order.id,
                status: this.statusValue.value,
                delivery_man_id: this.delivery_value.delivery_id,
            };
            let payload = {
                url: "inventory_order_action_status",
                form_data: form_data,
            };
            this.postWebForm(payload)
                .then((res) => {
                    let ren = this.reRenderKey;
                    this.$swal(
                        "Success!",
                        "Successfully change status",
                        "success"
                    );
                    // Toast.fire(``, "", "success");
                    this.setReRenderKey(ren++);
                })
                .catch((error) => {
                    this.$swal(
                        "Error!",
                        error.response.data.message[0].message,
                        "error"
                    );
                    let ren = this.reRenderKey;
                    this.setReRenderKey(ren++);
                });
        },
        selectDelivery() {
            if (!this.delivery_value) {
                return;
            }
            this.after_select = true;
        },
        orderSaveDelivery(subproduct, type) {
            if (!this.delivery_value) {
                this.$swal({
                    icon: "error",
                    title: "Error",
                    text: "Choose delivery man first!",
                    showConfirmButton: false,
                    timer: 1000,
                });
                return;
            }
            this.$swal({
                title: "Are you sure?",
                text: "You can't revert your action",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                confirmButtonColor: "#f27474",
                cancelButtonText: "No",
                showCloseButton: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.value) {
                    let sub_id =
                        type == "sub_product"
                            ? subproduct.orderable_id
                            : subproduct.sub_product_id;
                    let form_data = {
                        delivery_man_id: this.delivery_value.id,
                        order_id: this.order.id,
                        floor_id: subproduct.floor_id,
                        sub_product_id: sub_id,
                        qty: subproduct.buying_quantity,
                        type: type,
                        order_item_id: subproduct.id,
                        // status: 1,
                    };
                    let payload = {
                        url: "orders/save_delivery_man",
                        form_data: form_data,
                    };
                    this.postWebForm(payload)
                        .then((res) => {
                            let ren = this.reRenderKey;
                            this.setReRenderKey(ren++);
                        })
                        .catch((error) => {
                            this.$swal(
                                "Error!",
                                error.response.data.message[0].message,
                                "error"
                            );
                        });
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
    mounted() {
    },
    watch: {
        filterValue(){
            this.statusValue = this.filterValue;
        },
        'order.delivery_man': {
            handler(newVal, oldVal) {
                this.delivery_value = this.order.delivery_man;
            },
            },
        // deliverymen() {
        //     this.delivery_options = this.deliverymen;
        // },
    },
};
</script>
<style lang=""></style>
