<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Users Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox pagination-url="users?" :mutationName="mutationName" />
            <div>
                <!-- <createbtn v-on:open_create_modal="clearFormData" /> -->
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in myUsers" :key="index">
                        <td>
                            {{ user.index }}
                        </td>
                        <td>{{ user.name ? user.name : "" }}</td>

                        <td>{{ user.phone_number }}</td>

                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="!user.is_archive"
                                    @click="
                                        availableChangeUser({
                                            data: user,
                                            url: 'change_is_archive',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <!-- <button
                                type="button"
                                title="Delete"
                                id=""
                                data-bs-toggle="modal"
                                data-bs-target="#delete_modal"
                            >
                                <i class="fal fa-trash"></i>
                            </button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="20"
                :mutationName="mutationName"
                pagination-url="users?"
            />

            <!-- @include('layouts.delete_modal') -->
            <!-- Modl -->
            <div
                class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                id="create_modal"
                tabindex="-1"
                aria-labelledby="createModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog relative w-auto pointer-events-none">
                    <div
                        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
                    >
                        <div
                            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md"
                        >
                            <h5
                                class="text-xl font-medium leading-normal text-gray-800"
                                id="exampleModalLabel"
                            >
                                Modal title
                            </h5>
                            <button
                                type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body relative p-4">
                            Modal body text goes here.
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md"
                        >
                            <button
                                type="button"
                                class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "./../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import apiLoading from "./../Components/apiLoadingComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "Users",
    components: {
        Createbtn,
        SearchBox,
        apiLoading,
    },
    data() {
        return {
            typeOfSearch: "users",
            mutationName: "setUsers",
        };
    },
    computed: {
        ...mapGetters(["myUsers", "getisEditing", "currentApiLoading"]),
    },
    methods: {
        ...mapActions(["getPaginatedData", "availableChangeUser"]),
        ...mapMutations(["setisEditing", "setApiLoading"]),

        onPageChange(page) {
            this.currentPage = page;
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "users?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
