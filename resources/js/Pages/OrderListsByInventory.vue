<template lang="">

<div class="inner-main-container">
    <div class="flex justify-between">
        <p class="page-tittle pt-2">Order List </p>

        <div>

        </div>
    </div>
    <div class="relative flex justify-between">
        <div class="flex">

            <div class="list-component">
                <!-- <SearchBox
                    :mutationName="mutationName"
                    :pagination-url="paginationUrl"
                    search-web="web"
                /> -->
            </div>
            <div class="list-component">
                <div class="form-group mb-2">
                    <multiselect
                        v-model="filterValue"
                        :options="filterOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="false"
                        track-by="name"
                        label="name"
                        placeholder="Choose Type"
                        @input="changeType"
                    ></multiselect>
                </div>
            </div>
            <!-- <div class="list-component">
                <multiselect
                    :options="seriesOptions"
                    :searchable="false"
                    :close-on-select="true"
                    :show-labels="false"
                    :allow-empty="true"
                    track-by="id"
                    :custom-label="customLabel"
                    placeholder="Series"
                ></multiselect>
            </div> -->


        </div>
    </div>
    <div class="block pb-8">
        <table class="table-auto primary-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Item Count</th>
                    <th>Total Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <div
                    style="display: contents" v-for="(order, index) in myOrders" :key="index"
                    >
                  <order-list-item-by-inventory :key="reRenderKey" :filter-value="filterValue" :order="order" :deliverymen="deliverymen"/>
                </div>
            </tbody>
        </table>
           <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="order_list_by_inventory?"
            />
    </div>
</div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import OrderListItemByInventory from "../Components/OrderListItemByInventory.vue";
import searchBox from "../Components/searchBoxComponent.vue";
import Multiselect from "vue-multiselect";

export default {
  name: "OrderListsByInventory",
  components: {
    searchBox,
    OrderListItemByInventory,
    Multiselect,
  },
  data() {
    return {
      mutationName: "setOrders",
      deliverymen: null,
      filterValue: { name: "Confirmed", value: "confirmed" },
      filterOptions: [
          { name: "Confirmed", value: "confirmed" },
          { name: "Delivering", value: "delivering"},
          { name: "Delivered", value: "delivered"},
      ],
    };
  },
  computed: {
    ...mapGetters(["myOrders", "currentPage", "reRenderKey"]),
  },
  methods: {
    ...mapActions(["getPaginatedData", "getApiData"]),
    async getDeliveryMen() {
      let res = await this.getApiData({ url: "get_delivery_men" });
      this.deliverymen = res.data.data;
    },
    changeType() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: `order_list_by_inventory?status=${this.filterValue.value}`,
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
    getOrderLists(page) {
      let paginatePage = page;
      let payload = {
        page: paginatePage,
        url: `order_list_by_inventory?status=${this.filterValue.value}`,
        paginateMutation: this.mutationName,
      };
      this.getPaginatedData(payload);
    },
  },
  watch: {
    reRenderKey() {
      this.getOrderLists(this.currentPage);
    },
  },
  mounted() {
    this.getOrderLists(1);

    this.getDeliveryMen();
    // this.getImages();
  },
};
</script>
<style lang="">
</style>
