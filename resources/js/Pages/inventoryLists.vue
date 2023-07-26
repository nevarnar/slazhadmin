<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Inventory List</p>
        </div>
        <div class="relative flex justify-between">
            <div v-if="isAdmin">
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
                        class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Bulk Action</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="inline-block ml-1 mr-1.5">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Filter</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div v-if="isAdmin" class="inline-block">
                    <SearchBox
                        :mutationName="mutationName"
                        pagination-url="inventories?"
                    />
                </div>
            </div>
            <div v-if="isAdmin">
                <createbtn v-on:open_create_modal="onCreate" />
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Inventory Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <div
                        class="contents"
                        v-for="inventory in myInventoryLists"
                        :key="inventory.id"
                    >
                        <tr
                            v-if="showInventoryAdminIvm(inventory)"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#detail' + inventory.id"
                            aria-expanded="false"
                            aria-controls="detail"
                            :key="'1tr-' + inventory.id"
                        >
                            <td>{{ isAdmin ? inventory.index : 1 }}</td>
                            <td>{{ inventory.name_translations[0].name }}</td>
                            <td>
                                <a
                                    href="#"
                                    class="mr-2 a-clear"
                                    title="Floor List"
                                >
                                    <i class="fal fa-list"></i>
                                </a>
                                <button
                                    @click="onEdit(inventory.id)"
                                    type="button"
                                    title="Edit"
                                    id="edit-button"
                                    class="mr-2"
                                >
                                    <i class="fal fa-file-edit"></i>
                                </button>

                                <div
                                    class="form-check form-switch inline-block align-middle"
                                >
                                    <input
                                        :checked="inventory.is_available"
                                        @click="availableOnChange(inventory)"
                                        class="form-check-input switch"
                                        type="checkbox"
                                        role="switch"
                                        id="flexSwitchCheckDefault56"
                                    />
                                </div>
                            </td>
                        </tr>

                        <tr class="collapse" :id="'detail' + inventory.id">
                            <td colspan="8">
                                <div class="relative flex w-full">
                                    <div class="w-full">
                                        <table class="secondary-table">
                                            <thead
                                                style="
                                                    background: rgba(
                                                        3,
                                                        3,
                                                        3,
                                                        0.03
                                                    );
                                                "
                                                class="secondary-table-thead"
                                            >
                                                <tr>
                                                    <th class="sec-thead-th">
                                                        Id
                                                    </th>
                                                    <th class="sec-thead-th">
                                                        Shelf Name
                                                    </th>
                                                    <th class="sec-thead-th">
                                                        Number of floors
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                style="
                                                    background: rgba(
                                                        3,
                                                        3,
                                                        3,
                                                        0.03
                                                    );
                                                "
                                            >
                                                <tr
                                                    v-for="(
                                                        shelf, index
                                                    ) in inventory.shelves"
                                                    :key="index"
                                                >
                                                    <td class="sec-table-td">
                                                        {{ ++index }}
                                                    </td>
                                                    <td class="sec-table-td">
                                                        {{ shelf.name }}
                                                    </td>

                                                    <td
                                                        class="sec-table-td"
                                                        style="text-align: left"
                                                    >
                                                        {{ shelf.floor_number }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr
                            v-if="myInventoryLists == []"
                            class="whitespace-nowrap table-border-bottom"
                        >
                            <td colspan="6" class="px-5 py-2 text-table">
                                No Data Found!
                            </td>
                        </tr>
                    </div>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="20"
                :mutationName="mutationName"
                pagination-url="inventories?"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "inventoryLists",
    components: {
        Createbtn,
        SearchBox,
    },
    props: ["authUser"],

    data() {
        return {
            typeOfSearch: "inventory_lists",
            mutationName: "setInventoryLists",
        };
    },
    computed: {
        ...mapGetters(["myInventoryLists"]),
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
    },
    methods: {
        ...mapActions(["getPaginatedData", "removeRow", "availableChange"]),
        onEdit(inv_id) {
            window.location.href = `/inventory_lists/edit/${inv_id}`;
        },
        onCreate(inv_id) {
            window.location.href = `/inventory_lists/create`;
        },
        availableOnChange(inventory) {
            let payload = {
                data: inventory,
                url: "inventories",
            };

            this.availableChange(payload)
                .then((res) => {})
                .catch((error) => {
                    console.log("b");
                    this.$swal(
                        "Failed!",
                        error?.response?.data?.message,
                        "error"
                    );
                });
        },
        showInventoryAdminIvm(inventory) {
            if (this.isAdmin) {
                return true;
            } else if (this.isInventory) {
                if (
                    !this.isAdmin &&
                    inventory.id == this.authUser.inventory_id
                ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "inventories?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
