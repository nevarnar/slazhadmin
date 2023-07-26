<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                Create Townships for Delivery
            </p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-7 gap-x-8 mx-2">
                
                   <!-- start row -->
                   <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Duration day</label
                    >
                </div>
                <div class="col-span-7">
                    <!-- free space for grid -->
                </div>


                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                        v-model="form_data.duration"
                            type="number"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="duration day"
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.duration"
                        >
                            {{validationMsg.duration}}
                        </p>
                    </div>
                </div>
                <div class="col-span-5">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->
                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Delivery Price</label
                    >
                </div>
                <div class="col-span-7">
                    <!-- free space for grid -->
                </div>


                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                        v-model="form_data.delivery_fee"
                            type="number"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Delivery Price"
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.delivery_fee"
                        >
                            {{validationMsg.delivery_fee}}
                        </p>
                    </div>
                </div>
                <div class="col-span-5">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->


                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Township</label
                    >
                </div>
                <div class="col-span-7">
                    <!-- free space for grid -->
                </div>


                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <multiselect
                             class="mt-3"
                            v-model="form_data.itemValue"
                            :options="form_data.itemOptions"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customItemLabel"
                            :searchable="true"
                            :internal-search="false"
                            :clear-on-select="false"
                            :options-limit="50"
                            :limit="3"
                            :max-height="200"
                            @search-change="asyncFindItem"
                            placeholder="Search Township"
                        ></multiselect>
                         <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.itemValue"
                        >
                            {{ validationMsg.itemValue }}
                        </p>
                    </div>
                </div>
                <div class="col-span-5">
                    <button class="primary-button btn-clear mt-2"
                    @click="addHandler()">
                        Add
                    </button>
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->
                <div class="col-span-7">
                    <hr class="my-2 h-0.5" />
                </div>
            </div>


            <div class="w-full pt-2 mb-6">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th"></th>
                            <th class="sec-thead-th">Township</th>
                            <th class="sec-thead-th">Division</th>
                            <th class="sec-thead-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                             v-for="(data, index) in getTableRows"
                            :key="index"
                        >
                            <td class="sec-table-td">{{index+1}}</td>
                            <td class="sec-table-td">
                                {{data.item.name_translations[0].name}}
                            </td>
                            <td class="sec-table-td">
                                {{data.item.division.name_translations[0].name}}
                            </td>
                            <td class="sec-table-td">
                                 <button
                                      @click="deleteTableRow(data)"
                                    type="button"
                                    title="Delete"
                                    id="delete_button"
                                >
                                    <a class="a-clear" href="#">
                                        <i class="fal fa-trash"></i>
                                    </a>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end pb-4">
                <button
                   @click="onSubmit()"
                    type="button"
                    class="primary-button bg-black"
                >
                    Save
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import VueTimepicker from 'vue2-timepicker'
import Multiselect from "vue-multiselect";
import apiLoading from "./../Components/apiLoadingComponent";


export default {
    name:"TownshipCreateEdit",
    components:{
        Multiselect,
        VueTimepicker,
        apiLoading,
    },
     props: {
        isediting: String,
    },
    async mounted() {
        if(this.isediting=='edit'){
            this.getDetail();
        }
        // this.getTownships();
    },
    data(){
        return {
            form_data:{
                id:'',
                delivery_fee:'',
                itemValue:'',
                itemOptions:[],
                duration:'',
            },
            successValidationRules: false,
            validationMsg: {
                delivery_fee:'',
                itemValue:'',
                duration:'',
            },
            momentFormat: {
                stringify: (date) => {
                  return date ? moment(date).format("LL") : "";
                },
                parse: (value) => {
                  return value ? moment(value, "LL").toDate() : null;
                },
              },
        }
    },
    computed:{
         ...mapGetters(["getTableRows", "currentApiLoading",]),
    },
    methods:{
        ...mapActions(["getApiData","postWebForm"]),
        ...mapMutations(["setTableRow","setApiLoading","removeTableRow"]),
         customItemLabel(option) {
            return `${option.name_translations[0].name} `;
        },
        resetvalidateRulesMsg() {
            this.validationMsg.delivery_fee = "";
            this.validationMsg.itemValue = "";
            this.validationMsg.duration = "";

        },
        validateRules() {
            this.successValidationRules = true;
            this.resetvalidateRulesMsg();
            if (this.form_data.delivery_fee.trim() == "" || this.form_data.delivery_fee == null) {
                this.validationMsg.delivery_fee = "Amount is required.";
                this.successValidationRules = false;
            }
            if (this.getTableRows.length == 0) {
                this.validationMsg.itemValue = "Township is required.";
                this.successValidationRules = false;
            }
            if (this.form_data.duration == "") {
                this.validationMsg.start_date = "Duration is required.";
                this.successValidationRules = false;
              }
        },
        validateResError(error) {
            // if(error.response.data.message!=null){
            //     this.successValidationRules=false;
            //       this.$swal("Error!", error.response.data.message, "error");
            //     return;
            // }

        },
        async asyncFindItem(query) {
            let payload = {
                url: `get_townships?search_input=${query}`,
            };
            this.getApiData(payload).then((res) => {
                this.form_data.itemOptions = res.data.data;
            });
        },
         scrollToTop() {
            window.scrollTo(0, 0);
        },
        async addHandler() {
            if (this.form_data.itemValue) {
                 if (
                    this.getTableRows.some(
                        (data) => data.item.id === this.form_data.itemValue.id
                    )
                ) {
                    this.$swal("Error!", "Item already exits.", "error");
                    return;
                }
                 let payload = {
                    local_id: Math.random().toString(36).slice(2), //for local edit
                    item: this.form_data.itemValue,
                };
                this.setTableRow(payload);
            } else {
                this.$swal({
                    icon: "warning",
                    title: "Warining",
                    text: "Fill all required fields.",
                    showConfirmButton: false,
                    timer: 1000,
                });
            }


        },
        deleteTableRow(data) {
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
                    this.removeTableRow(data.local_id);
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
        // async getDetail(){
        //     var baseUrl = (window.location).href; // You can also use document.URL
        //     var id = baseUrl.substring(baseUrl.lastIndexOf('/') + 1);
        //      let res = await axios.get(`/discounts/${id}`);
        //     res = res.data.data;
        //     this.id=res.id;
        //     this.discount_type_id=res.discount_type;
        //     this.start_date=res.start_date;
        //     this.end_date=res.end_date;
        //     this.start_time=res.start_time==null ? '' : res.start_time;
        //     this.is_flash_sale=res.is_flash_sale==1 ? true:false;
        //     this.quantity=res.quantity;
        //     this.amount=res.amount;

        //     res.discount_townships.forEach((value)=>{
        //         let payload = {
        //             local_id: Math.random().toString(36).slice(2), //for local edit
        //             item: value.township,
        //             discount_type:this.discount_type_id,
        //             amount: this.amount,
        //             quantity: this.quantity,
        //         };
        //         this.setSubProductRow(payload);
        //     });
        // },
        onSubmit(){
            this.validateRules();
            if (this.successValidationRules == true) {
            let form_data = new FormData();
            if (this.isediting == "edit") {
                form_data.append("id", this.id);
            }
            let townships = [];
            this.getTableRows.forEach((row) => {
                let township = {
                    township_id: row.item.id,
                };
                townships.push(township);
            });
            form_data.append("townships", JSON.stringify(townships));
            form_data.append("duration", this.form_data.duration);
            form_data.append("delivery_fee", this.form_data.delivery_fee);
            this.setApiLoading(true);
            let payload = {
                url: "townships/createOrUpdate",
                form_data: form_data,
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.setApiLoading(false);
                    this.$swal({
                        icon: "success",
                        title: "Created!",
                        text: `Delivery Fee has been added successfully.`,
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    window.location.href = "/townships_list";
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });
            }else{
                this.setApiLoading(false);
                this.scrollToTop();

            }
        },
    },

}

</script>

<style>

</style>
