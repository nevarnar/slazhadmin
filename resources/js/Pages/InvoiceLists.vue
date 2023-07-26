<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Invoice List</p>
        </div>
        <div class="relative flex justify-between">
            <div class="mb-2">
                <div class="form-check inline-block ml-3 mr-2">
                    <input
                        class="form-check-input input-check float-center"
                        type="checkbox"
                        value=""
                    />
                </div>
                <div class="inline-block mx-1" v-if="isAdmin">
                    <multiselect
                        v-model="inventoryValue"
                        :options="inventoryOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="false"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Inventory"
                        @input="getInvoiceLists"
                    ></multiselect>
                </div>
                <div class="inline-block ml-1 mr-1.5">
                    <input
                        @input="getInvoiceLists"
                        v-model="date"
                        type="date"
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                    />
                </div>
            </div>

            <div></div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invoice Id</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="invoice in myInvoices" :key="invoice.id">
                        <td>{{ invoice.index }}</td>
                        <td>{{ invoice.invoice_no }}</td>
                        <td>{{ format_date(invoice.created_at) }}</td>
                        <!-- <td>3 May 2022</td> -->
                        <td>{{ invoice.supplier.contact_name }}</td>

                        <td>
                            <button
                                @click="invoiceDetail(invoice.id)"
                                type="button"
                                title="Detail"
                                id="detail-button"
                                style="color: blue"
                            >
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedWebData"
                :max-visible-buttons="20"
                mutationName="setInvoices"
                :pagination-url="paginationUrl"
            />
        </div>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters } from "vuex";
import tablePagination from "../Components/tablePaginationComponent.vue";
import moment from "moment";

export default {
    name: "InvoiceLists",
    components: {
        Multiselect,
        tablePagination,
    },
    props: ["authUser"],
    data() {
        return {
            inventoryValue: null,
            inventoryOptions: [],
            date: "",
        };
    },
    computed: {
        ...mapGetters(["myInvoices"]),

        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
        paginationUrl() {
            let inventory_id = this.isAdmin
                ? this.inventoryValue != null
                    ? this.inventoryValue.id
                    : ""
                : this.authUser.inventory_id;
            let url = `invoices?inventory_id=${inventory_id}&date=${this.date}`;
            return url;
        },
    },
    methods: {
        ...mapActions(["getPaginatedWebData", "getApiData", "getWebData"]),
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        async getInventories() {
            this.getApiData({
                url: `get_inventories`,
            }).then((res) => {
                this.inventoryOptions = res.data.data;
            });
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format("D MMM-YYYY");
            }
        },
        getInvoiceLists() {
            let paginatePage = 1;
            // let inventory_id = this.isAdmin
            //     ? this.inventoryValue != null
            //         ? this.inventoryValue.id
            //         : ""
            //     : this.authUser.inventory_id;

            let payload = {
                page: paginatePage,
                url: this.paginationUrl,
                paginateMutation: "setInvoices",
            };
            this.getPaginatedWebData(payload);
        },
        invoiceDetail(id) {
            window.location.href = `/invoice_lists/${id}`;
        },
    },
    mounted() {
        if (this.isAdmin) {
            this.getInventories();
        }
        this.getInvoiceLists();
    },
};
</script>
<style lang=""></style>
