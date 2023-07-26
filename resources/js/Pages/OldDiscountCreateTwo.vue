<template>
    <div class="w-full">
        <table class="secondary-table">
            <thead class="secondary-table-thead">
                <tr>
                    <th class="sec-thead-th">Product Name</th>
                     <th class="sec-thead-th">Item Code</th>
                    <th class="sec-thead-th">Sub Category</th>
                    <th class="sec-thead-th">Price</th>
                    <th class="sec-thead-th">Discount Price</th>
                    <th class="sec-thead-th"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(stock, index) in addMySubProductRows"
                    :key="index"
                >
                   
                    <td class="sec-table-td">
                        {{ stock.item.product.name_translations[0].name }}
                    </td>
                     <td class="sec-table-td">{{ stock.item.sku }}</td>
                   
                    <td class="sec-table-td">
                        {{
                            stock.item.product.thing.sub_categories[0]
                                .name_translations[0].name
                        }}
                    </td>
                    <td class="sec-table-td">{{
                        stock.item.product_prices.price}}</td>
                      <td class="sec-table-td">{{
                        calPrice(stock)}}</td>
                    <td class="sec-table-td">
                        <button
                            @click="deleteSubProductRow(stock)"
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
    export default {
        name: "DiscountCreateTwo",
        computed: {
            ...mapGetters(["addMySubProductRows"]),
        },
        methods: {
            ...mapMutations(["removeSubProductRow"]),
                calPrice(stock){
                    return  stock.discount_type.name==='Percentage'?(stock.item.product_prices.price-(stock.item.product_prices.price*stock.amount)/100):stock.item.product_prices.price-stock.amount;
                },
                deleteSubProductRow(stock) {
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
                        this.removeSubProductRow(stock.local_id);
                    } else {
                        // this.$swal("Cancelled", "Your file is still intact", "info");
                    }
                });
            },
        },
    };

</script>

<style>

</style>