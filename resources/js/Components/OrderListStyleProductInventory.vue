<template lang="">
<div class="contents">
    <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
        <img :src="subproduct.sub_product.photo.name" alt=""/>
    </div>

    <div class="w-full flex flex-row">
        <div class="w-max">
            <div class="flex justify-start pl-4 pt-4">
                <p class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                    style="font-family: 'Roboto',sans-serif;">
                    {{ subproduct.sub_product.product.name_translations[0].name }}
                </p>
            </div>
            <div class="flex justify-start pl-4 pt-4">
                <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                    style="font-family: 'Roboto',sans-serif;">
                    Color
                </p>
                <span class="px-3"> : </span>
                <p class="text-sm text-gray-500 inline-block">
                    {{ subproduct.sub_product.color.name_translations[0].name  }}
                </p>
            </div>
            <div class="flex justify-start pl-4 py-2">
                <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                    style="font-family: 'Roboto',sans-serif;">
                    Size
                </p>
                <span class="px-3"> : </span>
                <p class="text-sm text-gray-500 inline-block">
                    {{ subproduct.sub_product.size.name  }}

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
                        <th>
                             <button v-if="subproduct.assign_delivery_status=='pending'"  @click="orderSaveDelivery(subproduct,'style')" type="button" class="pr-2" title=""id="">
                                <i class="fal fa-check" ></i>
                            </button>
                            <p v-else>Done</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="sec-table-td">
                            {{ subproduct.buying_quantity }}
                        </td>
                        <td class="sec-table-td">
                            {{ subproduct.sub_product.sku }}
                        </td>
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

</template>
<script>
import Multiselect from "vue-multiselect";
import { mapGetters, mapMutations } from "vuex";

export default {
  name: "OrderListStyleproductInventory",
  components: {
    Multiselect,
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
    return {};
  },
  methods: {},
};
</script>
<style lang="">
</style>
