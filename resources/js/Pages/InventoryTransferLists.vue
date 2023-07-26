<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Warehouse Transfer List</p>
        </div>
        <div class="relative flex justify-between">
            <div class="flex mb-3">
                <div class="form-check inline-block ml-3 mr-2">
                    <input
                        class="form-check-input input-check float-center"
                        type="checkbox"
                        value=""
                    />
                </div>
                <div class="inline-block mx-1">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder=""
                    >
                        <option value="" disabled selected>Newly In</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="list-component">
                    <div class="form-group mb-3">
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
                            @input="paginatedData"
                        ></multiselect>
                    </div>
                </div>
            </div>
            <div>
                <div class="inline-block">
                    <createbtn v-on:open_create_modal="onCreate" />
                </div>
            </div>
        </div>
        <div class="block pb-8">
            <table class="table-auto primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tranfer ID</th>
                        <th>From / To</th>
                        <th>Type</th>
                        <th>Stage</th>
                        <th>Sending Date</th>
                        <th>Arrival Date</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="transfer in myInventoryTransferLists"
                        :key="transfer.id"
                    >
                        <td>{{ transfer.index }}</td>
                        <td>{{ transfer.transfer_id }}</td>
                        <td>{{ fromToInventory(transfer) }}</td>
                        <td>{{ inOutInventory(transfer) }}</td>
                        <td>{{ stageInventory(transfer) }}</td>
                        <td>{{ format_date(transfer.send_date) }}</td>
                        <td>{{ format_date(transfer.arrive_date) }}</td>

                        <td>
                            <button
                                v-if="showAcceptBtn(transfer)"
                                @click="acceptHandler(transfer.id)"
                                type="button"
                                title="Accept"
                                id=""
                                style="color: green"
                                class="btn-clear"
                            >
                                Accept
                            </button>
                            <button
                                v-if="showDeleteBtn(transfer)"
                                type="button"
                                title="Delete"
                                id=""
                                style="color: red"
                                class="btn-clear"
                                @click="deleteHandler(transfer.id)"
                            >
                                Delete
                            </button>

                            <button
                                v-if="showDetailBtn(transfer)"
                                @click.prevent="detailHandler(transfer.id)"
                                type="button"
                                title="Detail"
                                style="color: blue"
                                id=""
                                class="btn-clear"
                            >
                                Detail
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myInventoryTransferLists.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedWebData"
                :max-visible-buttons="20"
                :mutationName="mutationName"
                :pagination-url="paginationUrl"
            />
        </div>
    </div>
</template>
<script>
import Createbtn from "../Components/createButtonComponent.vue";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import moment from "moment";
import tablePagination from "../Components/tablePaginationComponent.vue";

export default {
    name: "InventoryTransferLists",
    props: ["authUser"],

    components: {
        Createbtn,
        Multiselect,
        tablePagination,
    },
    data() {
        return {
            mutationName: "setInventoryTransferLists",
            filterValue: { name: "Pending", value: "pending" },
            filterOptions: [
                { name: "Pending", value: "pending" },
                { name: "Confirm", value: "confirm" },
            ],
        };
    },
    computed: {
        ...mapGetters(["myInventoryTransferLists"]),
        paginationUrl() {
            return `transfers?status=${this.filterValue.value}&inventory_id=${this.authUser.inventory_id}`;
        },
    },
    methods: {
        ...mapActions(["getPaginatedWebData", "deleteWebData"]),
        onCreate(sub_category_id) {
            window.location.href = `/inventory_transfer`;
        },
        paginatedData() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: `transfers?status=${this.filterValue.value}&inventory_id=${this.authUser.inventory_id}`,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedWebData(payload);
        },
        fromToInventory(transfer) {
            if (this.authUser.inventory_id == transfer.from_inventory.id) {
                return transfer.to_inventory.name_translations[0].name;
            } else if (this.authUser.inventory_id == transfer.to_inventory.id) {
                return transfer.from_inventory.name_translations[0].name;
            }
        },
        inOutInventory(transfer) {
            if (this.authUser.inventory_id == transfer.from_inventory.id) {
                return "Out";
            } else if (this.authUser.inventory_id == transfer.to_inventory.id) {
                return "In";
            }
        },
        stageInventory(transfer) {
            if (transfer.status == "pending") {
                return "Delivering";
            } else if (transfer.status == "confirm") {
                return "Done";
            } else if (transfer.status == "delete") {
                return "Cancle";
            }
        },
        format_date(value) {
            if (value) {
                if (value == "0000-00-00 00:00:00") {
                    return "";
                }
                return moment(String(value)).format("D MMM-YYYY");
            }
        },
        showAcceptBtn(transfer) {
            let inout = this.inOutInventory(transfer);
            if (transfer.status == "pending" && inout == "In") {
                return true;
            } else {
                return false;
            }
        },
        showDeleteBtn(transfer) {
            if (transfer.status == "pending") {
                return true;
            } else {
                return false;
            }
        },
        showDetailBtn(transfer) {
            if (transfer.status == "confirm") {
                return true;
            } else {
                return false;
            }
        },
        detailHandler(id) {
            window.location.href = `/inventory_transfer_lists/${id}`;
        },
        acceptHandler(id) {
            window.location.href = `/inventory_accept_transfer/${id}`;
        },
        deleteHandler(id) {
            let payload = {
                url: `/transfers/${id}`,
            };
            this.deleteWebData(payload);
        },
        deleteHandler(id) {
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
                    let payload = {
                        url: `transfers/${id}`,
                    };
                    this.deleteWebData(payload).then((res) => {
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: "You successfully deleted this file",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        this.paginatedData();
                    });
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
    mounted() {
        this.paginatedData();
    },
};
</script>
<style lang=""></style>
