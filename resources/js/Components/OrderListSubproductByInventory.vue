<template lang="">
<div class="contents">

    <div class="contents" v-if="subproduct.orderable_type=='sub_product'">
        <div class="relative flex w-full pt-3">
            <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                <img :src="subproduct.orderable.photo.name" alt=""/>
            </div>

            <div class="w-full flex flex-row">
                <div class="w-max">
                    <div class="flex justify-start pl-4 pt-4">
                        <p class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            {{ subproduct.orderable.product.name_translations[0].name }}
                        </p>
                    </div>
                    <div class="flex justify-start pl-4 pt-4">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            Color
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                            {{ subproduct.orderable.color.name_translations[0].name  }}
                        </p>
                    </div>
                    <div class="flex justify-start pl-4 py-2">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            Size
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                            {{ subproduct.orderable.size.name  }}

                        </p>
                    </div>
                </div>

                <div class="pl-8 pt-3.5 w-full">
                    <table class="secondary-table">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    Count
                                </th>
                                <th class="sec-thead-th"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    SKU
                                </th>
                                <th
                                    class="sec-thead-th"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    Avalibility
                                </th>

                                <th>
                                    <button v-if="subproduct.assign_delivery_status=='pending'" @click="orderSaveDelivery(subproduct,'sub_product')" type="button" class="pr-2" title=""id="">
                                        <i class="fal fa-check" ></i>
                                    </button>
                                    <p v-else>Done</p>
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    {{ qty }}
                                </td>
                                <td class="sec-table-td">
                                    {{ subproduct.orderable.sku }}
                                </td>
                                <!-- <td class="sec-table-td">

                                </td>
                                <td colspan="2" class="sec-table-td">

                                </td> -->
                            </tr>

                            <div class="contents" v-for="(inv, i_id) in subproduct.available_floors" :key="i_id">
                                <tr>
                                    <td class="sec-table-td">
                                    </td>
                                    <td class="sec-table-td">
                                    </td>
                                    <td class="sec-table-td">
                                        {{ inv.name }} : {{ inv.qty }}
                                    </td>
                                    <td colspan="2" class="sec-table-td">

                                    </td>
                                </tr>

                            </div>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr class="h-0 my-2">
    </div>
    <div class="contents" v-if="subproduct.orderable_type=='style'">
        <div class="relative flex w-full pt-3">
            <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                <img :src="subproduct.orderable.feature_photos.name" alt=""/>
            </div>

            <div class="w-full flex flex-row">
                <div class="w-max">
                    <div class="flex justify-start pl-4 pt-4">
                        <p class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            {{ subproduct.orderable.name_translations[0].name }}
                        </p>
                    </div>
                </div>

                <div class="pl-8 pt-3.5 w-full">
                    <table class="secondary-table">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    Count
                                </th>
                                <th class="sec-thead-th"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    SKU
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                        {{ qty }}
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

        <div v-for="(sub, i_su) in subproduct.order_style_product" :key="i_su" class="relative flex w-full pt-3">
           <order-list-style-product-inventory :subproduct="sub" :statusvalue="statusvalue" :styleid="subproduct.id" :order-save-delivery="orderSaveDelivery"></order-list-style-product-inventory>
        </div>
        <hr class="h-0 my-2">
    </div>
</div>

</template>
<script>
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import OrderListStyleProduct from "./OrderListStyleProduct.vue";
import OrderListStyleProductInventory from "./OrderListStyleProductInventory.vue";

export default {
  name: "OrderListSubproductByInventory",
  components: {
    Multiselect,
    OrderListStyleProduct,
    OrderListStyleProductInventory,
  },
  props: {
    subproduct: {},
    statusvalue: {},
    orderSaveDelivery: {
      type: Function,
    },
  },
  computed: {
    ...mapGetters(["reRenderKey"]),
  },
  data() {
    return {
      qty: this.subproduct?.buying_quantity,
      show_avalibility_inventory: false,
      after_select: this.subproduct?.floor ? true : false,
      avalibility_inventory_value: this.subproduct?.floor,
      avalibility_inventory_options: this.subproduct?.available_floors,
    };
  },
  methods: {
    ...mapMutations(["setReRenderKey", "setSendOrders"]),
    ...mapActions(["deleteWebData"]),
  },
  watch: {
    statusvalue() {},
  },
};
</script>
<style lang="">
</style>
