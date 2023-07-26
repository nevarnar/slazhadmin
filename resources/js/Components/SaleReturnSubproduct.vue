<template lang="">
  <div class="contents">
  
    <div class="contents">
        <div class="relative flex w-full pt-3">
            <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                <img class="aspect-[3/4]" @click="showPreview" :src="saleReturn.sale_return_photos[0]?.name" alt=""/>
            </div>

            <div class="w-full flex flex-row">
                <div class="w-max">
                    <div class="flex justify-start pl-4 pt-4">
                        <p class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            {{ saleReturn.product_name }}
                        </p>
                    </div>
                    <div class="flex justify-start pl-4 pt-4">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            Color
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                            <!-- {{ saleReturn.sub_product.color.icon  }} -->
                            <img
                              :src="saleReturn.sub_product.color.icon"
                              class="color-active2 rounded-full w-6 h-6"
                          />
                        </p>
                    </div>
                    <div class="flex justify-start pl-4 py-2">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            Size
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                            {{  saleReturn.sub_product.size.name }}

                        </p>
                    </div>
                    <div v-if="saleReturn.sale_return_product" class="contents">
                      <div class="flex justify-start pl-4 py-2">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            New Item
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                          {{saleReturn.sale_return_product.product_name}} ({{saleReturn.sale_return_product.size_name}})({{saleReturn.sale_return_product.color}})
                        </p>
                      </div>
                      <div class="flex justify-start pl-4 py-2">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            Floor
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                            {{saleReturn.sale_return_product.floor_name}}
                        </p>
                      </div>
                    </div>
                    <div v-else class="contents">
                      <div class="contents" v-if="newReturnItem">
                        <div class="flex justify-start pl-4 py-2">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            New Item
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                          {{newReturnItem.return_item_detail.name[0].name}} ({{newReturnItem.return_item_detail.size}})({{newReturnItem.return_item_detail.color}})
                        </p>
                      </div>
                      <div class="flex justify-start pl-4 py-2">
                        <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                            style="font-family: 'Roboto',sans-serif;">
                            Floor
                        </p>
                        <span class="px-3"> : </span>
                        <p class="text-sm text-gray-500 inline-block">
                            {{newReturnItem.return_item_detail.floor}}
                        </p>
                      </div>
                    </div>
                    </div>
                  

                    <button v-if=" returnType.name == 'Wrong Size'" type="button" id="choosesubproduct" @click.prevent="++dataKey"
                        data-bs-toggle="modal" :data-bs-target="'#subproduct_modal'+saleReturn.id">
                        Choose Item
                    </button>
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
                                <div class="contents">
                                  <div class="contents" v-if="!show_avalibility_floor">
                                    <th @click="show_avalibility_floor=true" class="sec-thead-th cursor-pointer"
                                        style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                        Assign Floor
                                    </th>
                                </div>
                                </div>
                            

                                <div class="contents">
                                        <th class="sec-thead-th px-0 w-36"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    <!-- <input type="text" class="input-form text-xs" placeholder="Inventory Name"> -->
                                    <multiselect v-if="show_avalibility_floor" class="mt-2"
                                        v-model="avalibility_floor_value"
                                        :options="avalibility_floor_options"
                                        :searchable="false"
                                        :close-on-select="true"
                                        :show-labels="false"
                                        label="name"
                                        track-by="id"
                                        placeholder="Choose Floor"
                                        :disabled="after_select"
                                    ></multiselect>

                                </th>
                                <th class="sec-thead-th"
                                    style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                    <div v-if="!after_select && show_avalibility_floor" class="contents">
                                      <button @click="selectAvailableInventory" type="button" class="pr-2" title=""id="">
                                        <i class="fal fa-check" ></i>
                                      </button>
                                      <button @click="show_avalibility_floor=false" type="button" title=""id="">
                                        <i class="fal fa-times" ></i>
                                      </button>
                                    </div>
                                    <button
                                      v-if="
                                          after_select &&
                                          show_avalibility_floor && statusvalue.value !='delivering' && statusvalue.value!='delivered'
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
                              
                                </th>
                                </div>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    {{ saleReturn.qty }}
                                </td>
                                <td class="sec-table-td">
                                    {{ saleReturn.sub_product.sku }}
                                </td>
                                <td class="sec-table-td">

                                </td>
                                  <td class="sec-table-td">
                                    {{ avalibility_floor_value?.name }}
                                </td>
                            </tr>

                            <div class="contents" v-for="(inv, i_id) in saleReturn.available_floors" :key="i_id">
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
        <!-- <hr class="h-0 my-2"> -->
        <div
              class="modal fade primary-modal"
              :id="'subproduct_modal'+saleReturn.id"
              tabindex="-1"
              aria-labelledby="createModalLabel"
              aria-hidden="true"
          >
            <subproduct-modal :key="dataKey+saleReturn.sub_product.product_id"
                :product-id="saleReturn.sub_product.product_id"
                :sale-return="saleReturn"
                :set-new-return-item="setNewReturnItem"
            />
        </div>
    </div>
       <!-- Lightbox -->
       <preview-images :key='previewKey' :visibleimage="visible" :indeximage="index" :imgs="previewImagesLightbox" />
</div>

</template>
<script>
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import SubproductModal from "./SubproductModal.vue";
import PreviewImages from "./previewImages.vue";
  
  export default {
    name: "SaleReturnSubproduct",
    components: {
      Multiselect,
      SubproductModal,
      PreviewImages
    },
    props: {
      // subproduct: {},
      saleReturn:{},
      statusvalue: {},
      selectAvailableFloor: {
        type: Function,
      },
      setNewReturnItem:{
        type: Function,
      },
      newReturnItem:{},
      permissionUser: {},
      returnType:{},
      inventoryValue:{}
    },
    computed: {
      ...mapGetters(["reRenderKey"]),
      previewImagesLightbox(){
        if(!this.saleReturn.sale_return_photos.length){
          return null;
        }
        let imgs = this.saleReturn.sale_return_photos.map(pho=> pho.name);
        return imgs;
      },
      avalibility_floor_options() {
        if (!this.inventoryValue && this.permissionUser=='order-management') {
            return [];
        }
        if(this.permissionUser=='inventory-management'){
          return this.saleReturn.available_floors;
        }
        return this.inventoryValue.available_floors;
    },
    },
    data() {
      return {
        show_avalibility_floor: false,
        after_select: this.saleReturn?.floor ? true : false,
        avalibility_floor_value: this.saleReturn?.floor,
        // avalibility_floor_options: this.saleReturn?.available_floors,
        dataKey:1,
        index:1,
        visible:false,
        previewKey:1,
      };
    },
    methods: {
      ...mapMutations(["setReRenderKey", "setSendOrders"]),
      ...mapActions(["deleteWebData"]),
      selectAvailableInventory() {
        if (!this.avalibility_floor_value) {
          return;
        }
        this.selectAvailableFloor({
          floor_id: this.avalibility_floor_value.id,
        });
        this.after_select = true;
      },
      showPreview(){
        console.log('showpreivew')
        // let img_index= this.detailImages.indexOf(this.mainImage);
        // this.index = ;  // index of imgList
        // this.dataKey++;
        this.previewKey++;
        this.visible = true
    }
    },
    watch: {
      statusvalue() {},
    },
  };
  </script>
  <style lang="">
  </style>
  