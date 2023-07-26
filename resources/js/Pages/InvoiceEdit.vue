<template lang="">
    <div class="inner-main-container">
        <div>
                <p class="page-tittle">Edit ({{invoices[0]?.sub_product?.product?.name_translations[0]?.name}}) Stock Lists</p>
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invoice Number</th>
                        <th>Inventory Number</th>
                        <th>Floor</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(invoice, index) in invoices" :key="index">
                        <td>1</td>
                        <td>
                            <div>
                                <p>{{ invoice.invoice.invoice_no }}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p>{{invoice.inventory.name_translations[0].name}}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p>{{invoice.floor.name}}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p>{{invoice.quantity}}</p>
                            </div>
                        </td>
                        <td>
                            <button
                                type="button"
                                title="Edit"
                                id="edit-button"
                                data-bs-target="#edit_stock_items"
                                data-bs-toggle="modal"
                                @click.prevent="
                                    (editInvoice = invoice), reRender++
                                "
                            >
                                <!-- data-bs-toggle="modal" -->

                                <i class="fal fa-file-edit fw300"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="!invoices.length"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>

            <edit-stock-modal
                :floors="floorOptions"
                @getProvinces="getProvinces"
                :invoice="editInvoice"
            />
        </div>
    </div>
</template>
<script>
import { mapActions } from "vuex";
import EditStockModal from "../Components/EditStockModal.vue";

export default {
    name: "InvoiceEdit",
    components: {
        EditStockModal,
    },
    props: {
        subproductid: {},
        floorid: {}
    },
    data() {
        return {
            invoices: [],
            editInvoice: null,
            floorOptions: [],
            reRender:0
        };
    },
    methods: {
        ...mapActions(["getApiData"]),
        async getProvinces() {
            let res = await axios.get(
                `/edit_stock?sub_product_id=${this.subproductid}&floor_id=${this.floorid}`
            );
            console.log("res", res.data);
            this.invoices = res.data.data;
        },
        async getFloor() {
            let payload = {
                url: `get_floor_by_inventory?inventory_id=${1}&is_admin=${1}`,
            };

            this.getApiData(payload).then((res) => {
                this.floorOptions = res.data.data;
            });
        },
    },
    mounted() {
        this.getProvinces();
        this.getFloor();
    },
};
</script>
<style lang=""></style>
