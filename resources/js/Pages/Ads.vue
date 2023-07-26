<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Ads Management</p>
        </div>
        <div class="relative flex justify-between">
            <div class="flex">
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
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
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
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Filter</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="inline-block">
                    <SearchBox
                        pagination-url="ads?"
                        :mutationName="mutationName"
                    />
                </div>
            </div>
            <div>
                <createbtn v-on:open_create_modal="onCreate" />
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ads Name</th>
                        <th>Ads Type</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbl">
                    <tr v-for="(ads,index) in myAds" :key="index">
                        <td>{{index+1}}</td>
                        <td>{{ ads.name_translations[0].name }}</td>
                        <td>{{ ads.ads_type.name }}</td>
                        <td>{{ ads.adsable_type ? ads.adsable_type : (ads.ads_type.name=='Marketing Message' ? 'none' : 'url')}}</td>
                        <td>
                            <button
                                @click="onEdit(ads.id)"
                                type="button"
                                title="Edit"
                                id="edit_button"
                                class="edit-btn"
                            >
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>

                            <button
                                @click="onDelete(ads.id)"
                                type="button"
                                title="Delete"
                                id=""
                                data-bs-toggle="modal"
                                data-bs-target="#delete_modal"
                            >
                                <i class="fal fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <table-pagination
                        :pagination-lists="getPaginatedData"
                        :max-visible-buttons="5"
                        :mutationName="mutationName"
                        pagination-url="ads?"
                    />
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "adsLists",
    components: {
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "ads",
            mutationName: "setAds",
        };
    },
    computed: {
        ...mapGetters(["myAds"]),
    },
    methods: {
        ...mapActions(["getPaginatedData", "search", "deleteAds"]),
        onEdit(product_id) {
            window.location.href = `/ads_lists/edit/${product_id}`;
        },
        onCreate() {
            window.location.href = `/ads_lists/create`;
        },
        onDelete(ads_id) {
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
                    this.deleteAds(ads_id).then(
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: "You successfully deleted this file",
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    );
                    this.getData(this.currentPage);

                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
        getData(page) {
          let paginatePage = page;
          let payload = {
            page: paginatePage,
            url: "ads?",
            paginateMutation: this.mutationName,
          };
          this.getPaginatedData(payload);
        },
    },
    mounted() {
        this.getData(this.currentPage);
    },
};
</script>
