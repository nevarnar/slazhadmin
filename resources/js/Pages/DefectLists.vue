<template lang="">
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                {{
                    authUser.defectConfirm
                        ? "Defect Confirmation Lists"
                        : "Defect Lists"
                }}
            </p>
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
                <div class="inline-block mx-1" v-if="isAdmin">
                    <multiselect
                        v-model="inventoryValue"
                        :options="inventoryOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Inventory"
                        @input="getDefectLists"
                    ></multiselect>
                </div>
                <div class="list-component">
                    <!-- <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Date</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select> -->
                    <input
                        @input="getDefectLists"
                        v-model="date"
                        type="date"
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                    />
                </div>
            </div>
            <div></div>
        </div>
        <div class="block pb-8">
            <table class="table-auto primary-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Sub Category</th>
                        <th>Inventory Name</th>
                        <th>Remark</th>

                        <th v-if="authUser.defectConfirm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="defect in myDefects" :key="defect.id">
                        <td class="align-top">{{ defect.index }}</td>
                        <td class="align-top" style="padding: 0.5rem 0.25rem">
                            {{
                                defect.sub_product.product.name_translations[0]
                                    .name
                            }}
                        </td>
                        <td class="align-top" style="padding: 0.5rem 0.25rem">
                            {{ format_date(defect.created_at) }}
                        </td>
                        <td class="align-top" style="padding: 0.5rem 0.25rem">
                            {{ defect.quantity }}
                        </td>
                        <td class="align-top" style="padding: 0.5rem 0.25rem">
                            {{
                                defect.sub_product.product.thing
                                    .sub_categories[0].name_translations[0].name
                            }}
                        </td>
                        <td class="align-top" style="padding: 0.5rem 0.25rem">
                            {{
                                defect.floor.shelf.inventory
                                    .name_translations[0].name
                            }}
                        </td>
                        <show-more-or-less-col :col-data="defect.remark" />

                        <td class="align-top" v-if="authUser.defectConfirm">
                            <button
                                type="button"
                                title="confirm"
                                @click="updateStatus(defect.id, 1)"
                            >
                                <i class="fal fa-check"></i>
                            </button>
                            <button
                                type="button"
                                class="ml-2"
                                title="delete"
                                @click="deleteDefect(defect.id)"
                            >
                                <i class="fal fa-times"></i>
                            </button>
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
import Multiselect from "vue-multiselect";
import tablePagination from "../Components/tablePaginationComponent.vue";

import { mapActions, mapGetters, mapMutations } from "vuex";
import showMoreOrLessCol from "../Components/showMoreOrLessCol.vue";
import moment from "moment";

export default {
    components: {
        Multiselect,
        showMoreOrLessCol,
        tablePagination,
    },
    name: "DefectLists",
    props: ["authUser"],
    data() {
        return {
            inventoryValue: null,
            inventoryOptions: [],
            date: "",
            mutationName: "setDefects",
        };
    },
    computed: {
        ...mapGetters(["myDefects"]),
        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
        isInventory() {
            if (this.authUser.isInventory) {
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
            return this.authUser.defectConfirm
                ? `defects/confirmation_list?inventory_id=${inventory_id}&date=${this.date}`
                : `defects?inventory_id=${inventory_id}&date=${this.date}`;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedWebData",
            "getApiData",
            "getWebData",
            "deleteWebData",
        ]),
        ...mapMutations(["removeDefects"]),
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format("D MMM-YYYY");
            }
        },
        async getInventories() {
            this.getApiData({
                url: `get_inventories`,
            }).then((res) => {
                this.inventoryOptions = res.data.data;
            });
        },
        updateStatus(id) {
            let payload = {
                url: `defects/update_status?id=${id}&status=1`,
            };
            this.getWebData(payload).then((res) => {
                this.$swal({
                    icon: "success",
                    title: "Confirmed!",
                    text: `Defect has been confirmed`,
                    showConfirmButton: false,
                    timer: 1000,
                });

                this.getDefectLists();
            });
        },
        deleteDefect(id) {
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
                        url: `defects/${id}`,
                    };
                    this.deleteWebData(payload).then((res) => {
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: `Defect has been deleted`,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        this.getDefectLists();
                    });
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
        getDefectLists() {
            let paginatePage = 1;
            // let inventory_id = this.isAdmin
            //     ? this.inventoryValue != null
            //         ? this.inventoryValue.id
            //         : ""
            //     : this.authUser.inventory_id;
            // let url = this.authUser.defectConfirm
            //     ? `defects/confirmation_list?inventory_id=${inventory_id}`
            //     : `defects?inventory_id=${inventory_id}`;
            let payload = {
                page: paginatePage,
                url: this.paginationUrl,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedWebData(payload);
        },
    },
    mounted() {
        if (this.isAdmin) {
            this.getInventories();
        }
        this.getDefectLists();
        console.log(typeof this.authUser, this.authUser);
    },
};
</script>
<style lang=""></style>
