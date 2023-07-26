<template lang="">
    <div class="contents">
        <div class="contents" v-if="subproduct.orderable_type == 'sub_product'">
            <div class="relative flex w-full pt-3">
                <div
                    class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative"
                >
                    <img :src="subproduct.orderable.photo.name" alt="" />
                </div>

                <div class="w-full flex flex-row">
                    <div class="w-max">
                        <div class="flex justify-start pl-4 pt-4">
                            <p
                                class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                                style="font-family: 'Roboto', sans-serif"
                            >
                                {{
                                    subproduct.orderable.product
                                        .name_translations[0].name
                                }}
                            </p>
                        </div>
                        <div class="flex justify-start pl-4 pt-4">
                            <p
                                class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                style="font-family: 'Roboto', sans-serif"
                            >
                                Color
                            </p>
                            <span class="px-3"> : </span>
                            <p class="text-sm text-gray-500 inline-block">
                                {{
                                    subproduct.orderable.color
                                        .name_translations[0].name
                                }}
                            </p>
                        </div>
                        <div class="flex justify-start pl-4 py-2">
                            <p
                                class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                style="font-family: 'Roboto', sans-serif"
                            >
                                Size
                            </p>
                            <span class="px-3"> : </span>
                            <p class="text-sm text-gray-500 inline-block">
                                {{ subproduct.orderable.size.name }}
                            </p>
                        </div>
                    </div>

                    <div class="pl-8 pt-3.5 w-full">
                        <table class="secondary-table">
                            <thead class="secondary-table-thead">
                                <tr>
                                    <th
                                        class="sec-thead-th"
                                        style="
                                            padding-top: 0.25rem;
                                            padding-bottom: 0.25rem;
                                        "
                                    >
                                        Count
                                    </th>
                                    <th
                                        class="sec-thead-th"
                                        style="
                                            padding-top: 0.25rem;
                                            padding-bottom: 0.25rem;
                                        "
                                    >
                                        SKU
                                    </th>
                                    <th
                                        class="sec-thead-th"
                                        style="
                                            padding-top: 0.25rem;
                                            padding-bottom: 0.25rem;
                                        "
                                    >
                                        <!-- Avalibility -->
                                    </th>
                                    <div
                                        class="contents"
                                        v-if="!show_avalibility_inventory"
                                    >
                                        <th
                                            @click="
                                                show_avalibility_inventory = true
                                            "
                                            class="sec-thead-th cursor-pointer"
                                            style="
                                                padding-top: 0.25rem;
                                                padding-bottom: 0.25rem;
                                            "
                                        >
                                            Assign
                                        </th>
                                        <th
                                            v-if="
                                                statusvalue?.value == 'received'
                                            "
                                            @click="deleteItem(subproduct.id)"
                                            class="sec-thead-th cursor-pointer"
                                            style="
                                                padding-top: 0.25rem;
                                                padding-bottom: 0.25rem;
                                            "
                                        >
                                            <!-- Delete -->
                                        </th>
                                    </div>

                                    <div class="contents">
                                        <th
                                            class="sec-thead-th px-0 w-36"
                                            style="
                                                padding-top: 0.25rem;
                                                padding-bottom: 0.25rem;
                                            "
                                        >
                                            <!-- <input type="text" class="input-form text-xs" placeholder="Inventory Name"> -->
                                            <div class="flex">
                                                <multiselect
                                                    v-if="
                                                        show_avalibility_inventory
                                                    "
                                                    class="mt-2"
                                                    v-model="
                                                        avalibility_floor_value
                                                    "
                                                    :options="
                                                        avalibility_floor_options
                                                    "
                                                    :searchable="false"
                                                    :close-on-select="true"
                                                    :show-labels="false"
                                                    :custom-label="customLabel"
                                                    track-by="id"
                                                    placeholder="Choose Floor"
                                                    :disabled="after_select"
                                                ></multiselect>
                                            </div>
                                        </th>
                                        <th
                                            class="sec-thead-th"
                                            style="
                                                padding-top: 0.25rem;
                                                padding-bottom: 0.25rem;
                                            "
                                        >
                                            <div class="mt-4">
                                                <div
                                                    class="contents"
                                                    v-if="
                                                        !after_select &&
                                                        show_avalibility_inventory
                                                    "
                                                >
                                                    <button
                                                        @click="
                                                            selectAvailableInventory
                                                        "
                                                        type="button"
                                                        class="pr-2"
                                                        title=""
                                                        id=""
                                                    >
                                                        <i
                                                            class="fal fa-check"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        @click="
                                                            show_avalibility_inventory = false
                                                        "
                                                        type="button"
                                                        title=""
                                                        id=""
                                                    >
                                                        <i
                                                            class="fal fa-times"
                                                        ></i>
                                                    </button>
                                                </div>
                                                <button
                                                    v-if="
                                                        after_select &&
                                                        show_avalibility_inventory && statusvalue.value !='delivering' && statusvalue.value!='delivered'
                                                    "
                                                    @click="
                                                        after_select = false
                                                    "
                                                    type="button"
                                                    title=""
                                                    id=""
                                                >
                                                    <i class="fal fa-edit"></i>
                                                </button>
                                            </div>
                                        </th>

                                        <th
                                            @click="deleteItem(subproduct.id)"
                                            v-if="
                                                after_select &&
                                                show_avalibility_inventory &&
                                                statusvalue.value == 'received'
                                            "
                                            class="sec-thead-th cursor-pointer"
                                            style="
                                                padding-top: 0.25rem;
                                                padding-bottom: 0.25rem;
                                            "
                                        >
                                            <!-- delete -->
                                        </th>
                                    </div>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sec-table-td">
                                        <!-- @click="changeQty(subproduct.order_id,'product',subproduct.orderable_id,subproduct.buying_quantity,'minus')" -->
                                        <button
                                            @click="
                                                changeQty(
                                                    subproduct.id,
                                                    'minus'
                                                )
                                            "
                                            class="inline-block mx-2"
                                        >
                                            -
                                        </button>
                                        {{ qty }}
                                        <button
                                            @click="
                                                changeQty(subproduct.id, 'plus')
                                            "
                                            class="inline-block mx-2"
                                        >
                                            +
                                        </button>
                                    </td>
                                    <td class="sec-table-td">
                                        {{ subproduct.orderable.sku }}
                                    </td>
                                    <td class="sec-table-td"></td>
                                    <td class="sec-table-td">
                                        {{ avalibility_floor_value?.name }}
                                    </td>
                                    <!--   <td colspan="2" class="sec-table-td">

                                </td> -->
                                </tr>

                                <div
                                    class="contents"
                                    v-for="(
                                        inv, i_id
                                    ) in subproduct.available_floors"
                                    :key="i_id"
                                >
                                    <tr>
                                        <td class="sec-table-td"></td>
                                        <td class="sec-table-td"></td>
                                        <td class="sec-table-td">
                                            {{ inv.name }} : {{ inv.qty }}
                                        </td>
                                        <td
                                            colspan="2"
                                            class="sec-table-td"
                                        ></td>
                                    </tr>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="h-0 my-2" />
        </div>
        <div class="contents" v-if="subproduct.orderable_type == 'style'">
            <div class="relative flex w-full pt-3">
                <div
                    class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative"
                >
                    <img
                        :src="subproduct.orderable.feature_photos.name"
                        alt=""
                    />
                </div>

                <div class="w-full flex flex-row">
                    <div class="w-max">
                        <div class="flex justify-start pl-4 pt-4">
                            <p
                                class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                                style="font-family: 'Roboto', sans-serif"
                            >
                                {{
                                    subproduct.orderable.name_translations[0]
                                        .name
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="pl-8 pt-3.5 w-full">
                        <table class="secondary-table">
                            <thead class="secondary-table-thead">
                                <tr>
                                    <th
                                        class="sec-thead-th"
                                        style="
                                            padding-top: 0.25rem;
                                            padding-bottom: 0.25rem;
                                        "
                                    >
                                        Count
                                    </th>
                                    <th
                                        class="sec-thead-th"
                                        style="
                                            padding-top: 0.25rem;
                                            padding-bottom: 0.25rem;
                                        "
                                    >
                                        SKU
                                    </th>
                                    <th
                                        v-if="statusvalue.value == 'received'"
                                        @click="deleteItem(subproduct.id)"
                                        class="sec-thead-th cursor-pointer"
                                        style="
                                            padding-top: 0.25rem;
                                            padding-bottom: 0.25rem;
                                        "
                                    >
                                        <!-- Delete -->
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sec-table-td">
                                        <button
                                            @click="
                                                changeQty(
                                                    subproduct.id,
                                                    'minus'
                                                )
                                            "
                                            class="inline-block mx-2"
                                        >
                                            -
                                        </button>
                                        {{ qty }}
                                        <button
                                            @click="
                                                changeQty(subproduct.id, 'plus')
                                            "
                                            class="inline-block mx-2"
                                        >
                                            +
                                        </button>
                                    </td>
                                    <td class="sec-table-td">
                                        {{ subproduct.orderable.item_code }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div
                v-for="(sub, i_su) in subproduct.order_style_products"
                :key="i_su"
                class="relative flex w-full pt-3"
            >
                <order-list-style-product
                    :subproduct="sub"
                    :statusvalue="statusvalue"
                    :styleid="subproduct.id"
                    :select-available-floor="selectAvailableFloor"
                    :inventory-value="inventoryValue"
                ></order-list-style-product>
            </div>
            <hr class="h-0 my-2" />
        </div>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import OrderListStyleProduct from "./OrderListStyleProduct.vue";

export default {
    name: "OrderListSubproduct",
    components: {
        Multiselect,
        OrderListStyleProduct,
    },
    props: {
        subproduct: {},
        statusvalue: {},
        changeProductStyleQty: {
            type: Function,
        },
        selectAvailableFloor: {
            type: Function,
        },
        permissionUser: {},
        inventoryValue: {},
    },
    computed: {
        ...mapGetters(["reRenderKey"]),
        avalibility_floor_options() {
            if (!this.inventoryValue) {
                return [];
            }
            let floors =
                this.inventoryValue.available_floors_by_sub_product.find(
                    (e) => e.item_id == this.subproduct.id
                );
            if (floors) {
                return floors.floors;
            }
        },
    },
    data() {
        return {
            qty: this.subproduct?.buying_quantity,
            show_avalibility_inventory: false,
            after_select: this.subproduct?.floor ? true : false,
            avalibility_floor_value: this.subproduct?.floor,
            // avalibility_floor_options: this.subproduct?.available_floors,
        };
    },
    methods: {
        ...mapMutations(["setReRenderKey", "setSendOrders"]),
        ...mapActions(["deleteWebData"]),
        customLabel(option) {
            return `${option.name} - ${option.qty}`;
        },
        selectAvailableInventory() {
            if (!this.avalibility_floor_value) {
                return;
            }
            this.selectAvailableFloor({
                type:
                    this.subproduct.orderable_type == "sub_product"
                        ? "sub_product"
                        : "style",
                id: this.subproduct.id,
                floor_id: this.avalibility_floor_value.id,
                style_id: null,
            });
            this.after_select = true;
        },
        changeQty(id, type) {
            if (type == "plus") {
                this.qty++;
            } else {
                if (this.qty == 1) {
                    return;
                }
                this.qty--;
            }

            this.changeProductStyleQty({ id: id, qty: this.qty });
        },
        async deleteItem(id) {
            let payload = {
                url: `orders/delete_order_item/${id}`,
            };
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
                    this.deleteWebData(payload)
                        .then((res) => {
                            this.$swal({
                                icon: "success",
                                title: "Deleted!",
                                text: "Item has been deleted.",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                            this.setReRenderKey(this.reRenderKey++);
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
    watch: {
        statusvalue() {},
        inventoryValue() {
            console.log("hie");
        },
    },
};
</script>
<style lang=""></style>
