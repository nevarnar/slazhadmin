<template lang="">
    <div class="w-full pt-2">
        <table class="secondary-table">
            <thead class="secondary-table-thead">
                <tr>
                    <th class="sec-thead-th">Item Code</th>
                    <th class="sec-thead-th">Product Name</th>
                    <th class="sec-thead-th">Series</th>
                    <th class="sec-thead-th">Brand</th>
                    <th class="sec-thead-th">Sub Category</th>
                    <th class="sec-thead-th">Color</th>
                    <th class="sec-thead-th">Size</th>
                    <th class="sec-thead-th">Location</th>
                    <th class="sec-thead-th">Amount</th>
                    <th class="sec-thead-th"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(stock, index) in myAddStocksToInventoryRows"
                    :key="index"
                >
                    <td class="sec-table-td">{{ stock.item.sku }}</td>
                    <td class="sec-table-td">
                        {{ stock.item.product.name_translations[0].name }}
                    </td>
                    <td class="sec-table-td">    {{
                        stock.item.product.thing.series.length !=0 ?  stock.item.product.thing.series[0]
                        .name_translations[0].name : null
                    }}</td>
                    <td class="sec-table-td">   {{
                        stock.item.product.thing.brands[0]
                            .name_translations[0].name
                    }}</td>
                    <td class="sec-table-td">
                        {{
                            stock.item.product.thing.sub_categories[0]
                                .name_translations[0].name
                        }}
                    </td>
                    <td class="sec-table-td">
                        {{ stock.item.color.name_translations[0].name }}
                    </td>
                    <td class="sec-table-td">{{ stock.item.size.name }}</td>
                    <td class="sec-table-td">{{ stock.floor.name }}</td>
                    <td class="sec-table-td">{{ stock.amount }}</td>
                    <td class="sec-table-td">
                        <button
                            @click="deleteAddStocksToInventoryRows(stock)"
                            type="button"
                            title="Delete"
                            id="delete-button"
                        >
                            <a href="#">
                                <i class="fal fa-trash"></i>
                            </a>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
export default {
    name: "StockCreateTwo",
    computed: {
        ...mapGetters(["myAddStocksToInventoryRows"]),
    },
    methods: {
        ...mapMutations(["removeAddStocksToInventoryRows"]),
        deleteAddStocksToInventoryRows(stock) {
            this.$swal({
                title: "Are you sure?",
                text: "You can't revert your action",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes Delete it!",
                confirmButtonColor: "#f27474",
                cancelButtonText: "No, Keep it!",
                showCloseButton: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.value) {
                    this.removeAddStocksToInventoryRows(stock.local_id);
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
};
</script>
<style lang=""></style>
