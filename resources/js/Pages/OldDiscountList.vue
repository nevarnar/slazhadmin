<template>
     <div class="inner-main-container">
        <div>
            <p class="page-tittle">Dicsount Product List</p>
           
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
                <div class="list-component">
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
                <div class="list-component">
                     <multiselect
                        v-model="discountTypeValue"
                        :options="discountTypeOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        placeholder="Discount Type"
                        label="name"
                        @input="getDiscountPaginatedData"
                    ></multiselect>
                </div>
                <!-- <div class="list-component">
                    <SearchBox
                        :pagination-url="paginationUrl"
                        :mutationName="mutationName"
                    />
                </div> -->
                
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
                        <th>Discount Type</th>
                        <th>Discount Amount</th>
                        <th>Starting Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbl" >
                    <tr v-for="(discount,index) in myDiscountPaginatedData" :key="discount.id">
                        <td>
                            {{++index}}
                        </td>
                        <td>
                            {{discount.discount_type.name}}
                        </td>
                        <td>
                            <span>{{ discount.amount}}
                            </span>
                            {{discount.discount_type.name == 'Percentage' ? '% ' : 'MMK'}}
                        </td>
                        <td>
                             {{format_date(discount.start_date)}}
                        </td>
                        <td>
                             {{format_date(discount.end_date)}}

                        </td>
                        <td>
                            <button
                            @click="onEdit(discount.id)"
                                type="button"
                                title="Edit"
                                id="edit_button"
                                class="clear-btn mr-2"
                            >
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                            <button
                                type="button"
                                title="Delete"
                                id=""
                                class="clear-btn"
                                @click="destroy(discount.id)"
                            >
                                <a href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myDiscountPaginatedData.length==0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td
                            colspan="5"
                            class="px-5 py-2 text-table"
                        >
                            No Data Found!
                        </td>
                    </tr>
                    <table-pagination
                        :pagination-lists="getDiscountPaginatedData"
                        :max-visible-buttons="5"
                        :mutationName="mutationName"
                        :pagination-url="paginationUrl"
                    />
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import Multiselect from "vue-multiselect";
import moment from "moment";

export default {
    name:"DiscountList",
    components:{
        Createbtn,
        SearchBox,
        Multiselect,
    },
    data(){
        return {
            mutationName:"setDiscountPaginatedData",
            discountTypeValue:null,
            discountTypeOptions:[],
        }
    },
    computed:{
        ...mapGetters(['myDiscountPaginatedData']),
        paginationUrl() {
            return `discounts?discount_type_id=${ this.discountTypeValue == null ? "" : this.discountTypeValue.id}`;
        },
    },
    methods:{
        ...mapActions(["getPaginatedWebData", "getApiData","deleteWebData"]),
        onEdit(discount_id) {
            window.location.href = `/discount_index/edit/${discount_id}`;
        },
         onCreate(id) {
            window.location.href = `/discount_index/create`;
        },
        async getDiscountType() {
                this.getApiData({
                    url: `get_discount_type`,
                }).then((res) => {
                    this.discountTypeOptions = res.data.data;
                });
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format("D MMM-YYYY");
            }
        },
        getDiscountPaginatedData() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: this.paginationUrl,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedWebData(payload);
        },
        destroy(id) {
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
                        url: `discounts/${id}`,
                    };
                    this.deleteWebData(payload).then((res) => {
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: "You successfully deleted this file",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        this.getDiscountPaginatedData();
                    });
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
    mounted(){
        // console.log(this.myDiscountPaginatedData.length);
        this.getDiscountType();
        this.getDiscountPaginatedData();
    }
}
</script>

<style>

</style>