<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle pl-4 mb-0">Add Stock to Inventory</p>
        </div>
        <div class="pt-2 mb-6">
            <div class="ml-4 pl-1">
                <div class="pt-4">
                    <p
                        class="text-sm text-gray-800 inline-block"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        Invoice Name
                    </p>
                    <span class="px-1 text-gray-600 pb-2 text-sm">:</span>
                    <p class="text-sm text-gray-600 inline-block">
                        {{ invoice?.invoice_no }}
                    </p>
                </div>
                <div class="py-1.5">
                    <p
                        class="text-sm text-gray-800 inline-block"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        Supplier Name
                    </p>
                    <span class="px-1 text-gray-600 pb-2 text-sm">:</span>
                    <p class="text-sm text-gray-600 inline-block">
                        {{ invoice?.supplier.contact_name }}
                    </p>
                </div>
            </div>

            <!-- start row -->

            <div>
                <hr class="my-2 h-0" />
            </div>
            <div class="w-full pt-0">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th">Id</th>
                            <th class="sec-thead-th">Item Code</th>
                            <th class="sec-thead-th">Product Name</th>
                            <th class="sec-thead-th">Series</th>
                            <th class="sec-thead-th">Brand</th>
                            <th class="sec-thead-th">Sub Category</th>
                            <th class="sec-thead-th">Color</th>
                            <th class="sec-thead-th">Size</th>
                            <th class="sec-thead-th" style="text-align: center">
                                Location
                            </th>
                            <th class="sec-thead-th">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(stock, index) in invoice?.stocks"
                            :key="stock.id"
                        >
                            <td class="sec-table-td">{{ ++index }}</td>
                            <td class="sec-table-td">
                                {{ stock.sub_product.sku }}
                            </td>
                            <td class="sec-table-td">
                                {{
                                    stock?.sub_product?.product?.name_translations[0]?.name
                                }}
                            </td>
                            <td class="sec-table-td">
                                {{
                                    stock.sub_product?.product?.thing?.series[0]?.length!=0 ? stock.sub_product?.product?.thing?.series[0]?.name_translations[0]?.name : ''

                                }}
                            </td>
                            <td class="sec-table-td">
                                {{
                                    stock.sub_product?.product?.thing?.brands[0]?.name_translations[0]?.name
                                }}
                            </td>
                            <td class="sec-table-td">
                                {{
                                    stock?.sub_product?.product?.thing?.sub_categories[0]?.name_translations[0]?.name
                                }}
                            </td>
                            <td class="sec-table-td">
                                {{
                                    stock.sub_product.color.name_translations[0]
                                        ?.name
                                }}
                            </td>
                            <td class="sec-table-td">
                                {{ stock?.sub_product?.size?.name }}
                            </td>

                            <td class="sec-table-td">{{ stock.floor?.name }}</td>
                            <td class="sec-table-td">{{ stock.quantity }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- end row -->
        </div>
    </div>
</template>
<script>
export default {
    name: "InvoiceDetail",
    data() {
        return {
            invoice: null,
        };
    },
    methods: {
        async getInvoiceDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/invoices/${uri[uriLast]}`);
            res = res.data.data;
            this.invoice = res;
        },
    },
    mounted() {
        this.getInvoiceDetail();
    },
};
</script>
<style lang=""></style>
