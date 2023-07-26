<template lang="">
    <div class="inner-main-container">
        <div class="flex justify-between">
            <p class="page-tittle pt-2">Order Lists</p>

            <div></div>
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
                <div
                    class="list-component"
                    v-if="permissionUser == 'inventory-management'"
                >
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
                            @input="getOrderLists(1)"
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
                        <th>Division</th>
                        <th>Item Count</th>
                        <th>Total Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <div
                        style="display: contents"
                        v-for="(order, index) in myOrders"
                        :key="index"
                    >
                        <order-list-item
                            :deliverymen="deliverymen"
                            :order="order"
                            :key="`${reRenderKey+index}${order.status}`"
                            :permission-user="permissionUser"
                        ></order-list-item>
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
import { mapActions, mapGetters, mapMutations } from "vuex";
import OrderListItem from "../Components/OrderListItem.vue";
import searchBox from "../Components/searchBoxComponent.vue";
import Multiselect from "vue-multiselect";
export default {
    name: "OrderLists",
    props: {
        permissionUser: {},
    },
    components: {
        searchBox,
        OrderListItem,
        Multiselect,
    },
    data() {
        return {
            mutationName: "setOrders",
            deliverymen: null,
            filterValue: { name: "Confirmed", value: "confirmed" },
            filterOptions: [
                { name: "Confirmed", value: "confirmed" },
                { name: "Delivering", value: "delivering" },
                { name: "Delivered", value: "delivered" },
            ],
        };
    },
    computed: {
        ...mapGetters(["myOrders", "reRenderKey", "currentPage"]),
    },
    methods: {
        ...mapActions(["getPaginatedData", "getApiData"]),
        ...mapMutations(["setReRenderKey"]),

        getOrderLists(page) {
            let paginatePage = page;
            let url = null;
            if (this.permissionUser == "inventory-management") {
                url = `orders?status=${this.filterValue.value}`;
            } else {
                url = "orders?";
            }
            let payload = {
                page: paginatePage,
                url: url,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
     
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
<style lang=""></style>
