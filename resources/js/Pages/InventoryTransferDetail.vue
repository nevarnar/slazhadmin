<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle pl-4 mb-0">Warehouse Transfer</p>
        </div>
        <div class="pt-2 mb-6">
            <div class="ml-4 pl-1">
                <div class="pt-4">
                    <p
                        class="text-sm text-gray-800 inline-block"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        Transfer Id
                    </p>
                    <span class="px-1 text-gray-600 pb-2 text-sm">:</span>
                    <p class="text-sm text-gray-600 inline-block">IT00033</p>
                </div>
                <div class="py-1.5">
                    <p class="text-sm text-gray-500 inline-block">
                        {{ inventoryName }}
                    </p>
                </div>
            </div>

            <!-- start row -->
            <div class="pt-5">
                <p class="page-tittle pl-4 mb-0">Stocks in Transfer Lists</p>
            </div>
            <div>
                <hr class="my-2 h-0" />
            </div>
            <div class="w-full pt-0">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th">Id</th>
                            <th class="sec-thead-th">Product Name</th>
                            <th class="sec-thead-th">Category</th>
                            <th class="sec-thead-th">Brand</th>
                            <th class="sec-thead-th">Color</th>
                            <th class="sec-thead-th">Size</th>
                            <th class="sec-thead-th">Floor</th>
                            <th class="sec-thead-th">Amount</th>
                            <th class="sec-thead-th" style="text-align: center">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <div
                            class="contents"
                            v-for="(
                                subproduct, i
                            ) in inventory_transfer?.sub_products"
                            :key="i"
                        >
                            <inventory-transfer-detail-row
                                :subproduct="subproduct"
                                :in-or-out="inOrOut"
                                :index="++i"
                            />
                        </div>
                    </tbody>
                </table>
            </div>

            <!-- end row -->
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import InventoryTransferDetailRow from "./InventoryTransferDetailRow.vue";
export default {
    name: "InventoryTransferDetail",
    components: {
        InventoryTransferDetailRow,
    },
    props: ["authUser"],
    data() {
        return {
            inventory_transfer: null,
        };
    },
    computed: {
        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
        inventoryName() {
            if (
                this.authUser.inventory_id ==
                this.inventory_transfer?.from_inventory_id
            ) {
                return this.inventory_transfer?.to_inventory
                    .name_translations[0].name;
            } else if (
                this.authUser.inventory_id ==
                this.inventory_transfer?.to_inventory_id
            ) {
                return this.inventory_transfer?.from_inventory
                    .name_translations[0].name;
            }
        },
        inOrOut() {
            if (
                this.authUser.inventory_id ==
                this.inventory_transfer?.from_inventory_id
            ) {
                return "out";
            } else if (
                this.authUser.inventory_id ==
                this.inventory_transfer?.to_inventory_id
            ) {
                return "in";
            }
        },
    },
    methods: {
        async getInventoryTransferDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/transfers/${uri[uriLast]}`);
            res = res.data.data;
            this.inventory_transfer = res;
        },
    },
    mounted() {
        this.getInventoryTransferDetail();
    },
};
</script>
<style lang=""></style>
