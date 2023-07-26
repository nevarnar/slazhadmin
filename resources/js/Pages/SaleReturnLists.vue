<template lang="">

  <div class="inner-main-container">
      <div class="flex justify-between">
          <p class="page-tittle pt-2">Sale Return Lists</p>
      </div>
      <div class="block pb-8">
          <table class="table-auto primary-table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Order ID</th>
                      <th>Date</th>
                      <th>Customer Name</th>
                      <th>Division</th>
                      <th>Item Count</th>
                      <th>Return Type</th>
                      <th>Total Price</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <div
                      style="display: contents" v-for="(sale_return, index) in sale_return_lists" :key="index"
                      >
                    <sale-return-item :deliverymen='deliverymen' :permission-user="permissionUser" :order="sale_return"></sale-return-item>
                  </div>
              </tbody>
          </table>
                <table-pagination
                  :pagination-lists="getPaginatedData"
                  :max-visible-buttons="5"
                  :mutationName="mutationName"
                  pagination-url="orders?"
              />
      </div>
  </div>
  </template>
  <script>
  import { mapActions, mapGetters } from "vuex";
  // import OrderListItem from "../Components/OrderListItem.vue";
  import searchBox from "../Components/searchBoxComponent.vue";
import SaleReturnItem from "../Components/SaleReturnItem.vue";
  
  export default {
    name: "SaleReturnLists",
    components: {
      searchBox,
      SaleReturnItem,
    },
    props: {
      permissionUser: {
        type: String,
      },
    },
    data() {
      return {
        mutationName: "setOrders",
        sale_return_lists: null,
        deliverymen:null,
      };
    },
    computed: {
      ...mapGetters(["myOrders", "reRenderKey", "currentPage"]),
    },
    methods: {
      ...mapActions(["getPaginatedData","getApiData"]),
      async getOrderLists(page) {
        let paginatePage = page;
        let payload = {
          page: paginatePage,
          url: "sale_return_list?",
          paginateMutation: this.mutationName,
        };
        // this.getPaginatedData(payloads)
        let res=await this.getApiData(payload);
        this.sale_return_lists = res.data.data;
      },
      async getDeliveryMen() {
        let res = await this.getApiData({ url: "get_delivery_men" });
        this.deliverymen = res.data.data;
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
  