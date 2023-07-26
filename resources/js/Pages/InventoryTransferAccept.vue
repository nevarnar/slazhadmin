<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle pl-4 mb-0">Accept Transfer</p>
        </div>
        <div class="pt-2 mb-6">
            <div class="ml-4 pl-1">
                <div class="flex justify-start pt-4">
                    <p
                        class="text-sm text-gray-800 inline-block w-20 min-w-max text-left"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        Id
                    </p>
                    <p class="text-sm text-gray-500 inline-block">
                        {{ transferAcceptLists.transfer_id }}
                    </p>
                </div>
                <div class="flex justify-start py-2">
                    <p
                        class="text-sm text-gray-800 inline-block w-20 min-w-max text-left"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        From
                    </p>
                    <p class="text-sm text-gray-500 inline-block">
                        {{
                            transferAcceptLists?.from_inventory
                                ?.name_translations[0].name
                        }}
                    </p>
                </div>
            </div>
            <div>
                <hr class="my-2 h-0" />
            </div>

            <!-- start row -->
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
                            <th class="sec-thead-th"></th>
                            <th class="sec-thead-th" style="text-align: right">
                                Total
                            </th>
                            <th class="sec-thead-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <div
                            class="contents"
                            v-for="(
                                subproduct, index
                            ) in transferAcceptLists?.sub_products"
                            :key="index"
                        >
                            <inventory-transfer-accept-row
                                :subproduct="subproduct"
                                :index="++index"
                                :auth-user="authUser"
                            />
                        </div>
                    </tbody>
                </table>
            </div>

            <!-- end row -->

            <div class="flex justify-end pb-4 mt-12">
                <button
                    type="button"
                    class="primary-button bg-black"
                    :disabled="currentApiLoading"
                    @click.prevent="createHandler"
                >
                    <api-loading />

                    Accept
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import InventoryTransferAcceptRow from "./InventoryTransferAcceptRow.vue";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
    name: "InventoryTransferAccept",
    components: {
        InventoryTransferAcceptRow,
        apiLoading,
    },
    props: ["authUser"],
    computed: {
        ...mapGetters(["transferAcceptLists", "currentApiLoading"]),
        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
    },
    methods: {
        ...mapMutations(["setTransferAcceptLists", "setApiLoading"]),
        ...mapActions(["postWebForm"]),
        async getInventoryTransferDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/accept_transfer/${uri[uriLast]}`);
            let response = res.data.data;
            response.sub_products.forEach((sub) => {
                sub.recommended_floor.forEach((floor) => {
                    floor.transfer_amount = 0;
                    floor.max_amount_validation = false;
                });
                // floor.transfer_amount = 0;
                // floor.max_amount_validation = false;
            });

            this.setTransferAcceptLists(response);
        },
        createHandler() {
            var transfer_items = [];
            this.transferAcceptLists.sub_products.forEach((item) => {
                console.log("item", item);

                item.recommended_floor.forEach((floor) => {
                    if (floor.transfer_amount > 0) {
                        let transfer_item = {
                            sub_product_id: null,
                            floor_id: null,
                            quantity: null,
                        };

                        transfer_item.sub_product_id = item.id;
                        transfer_item.floor_id = floor.id;
                        transfer_item.quantity = parseInt(
                            floor.transfer_amount
                        );
                        transfer_items.push(transfer_item);
                    }
                });
            });

            let form_data = new FormData();
            form_data.append("stocks", JSON.stringify(transfer_items));
            form_data.append("transfer_id", this.transferAcceptLists.id);

            this.setApiLoading(true);
            let payload = {
                url: "accept_transfer",
                form_data: form_data,
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.setApiLoading(false);
                    console.log("res", res);

                    this.$swal({
                        icon: "success",
                        title: "Created",
                        text: `Transfer stock has been confirm.`,
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    window.location.href = "/inventory_transfer_lists";
                })
                .catch((error) => {
                    if (error?.response?.data?.message) {
                        this.$swal(
                            "Error",
                            error?.response?.data?.message,
                            "error"
                        );
                    }
                    this.setApiLoading(false);
                });
        },
    },
    mounted() {
        this.getInventoryTransferDetail();
    },
};
</script>
<style lang=""></style>
