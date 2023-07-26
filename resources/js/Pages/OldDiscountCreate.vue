<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                Create Discount 
            </p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2">
                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Duration</label
                    >
                    
                </div>
                <div class="col-span-2">
                    <!-- free space for grid -->
                </div>
                <div class="col-span-2"  v-if="is_flash_sale" >
                    <label for="" class="form-label label-form"
                        >
                        Starting Hour
                        </label
                    >
                </div>

                <div class="col-span-2" v-if="!is_flash_sale" ></div>
                    <!-- free space for grid -->
                <div class="col-span-1">
                    <!-- free space for grid -->
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-2 slazh-datepicker">
                        <!-- <datepicker v-model="start_date" ></datepicker> -->
                        <date-picker v-model="start_date" valueType="format"
                       format="DD-MM-YY" class="w-full"
                       :formatter="momentFormat"
                       :disabled-date="disabledRange"
                       placeholder="dd-mm-yy"
                        ></date-picker>
                        <!-- <input id="start"
                        v-model="start_date"
                            type="date"
                            class="form-control input-form mt-2"
                            placeholder="Start Date  "
                        />
                          <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.start_date"
                        >
                            {{ validationMsg.start_date }}
                        </p> -->
                    </div>
                    <label class="checkbox-container">Flash Sale
                        <!-- <i class="far fa-check-circle check-icon"></i> -->
                        <input type="checkbox" v-model="is_flash_sale" >
                        <span class="flashsale-check"></span>
                    </label>
                </div>
                <div class="col-span-2">
                    
                    <div class="form-group mb-4 slazh-datepicker">
                        <date-picker v-model="end_date" valueType="format"
                           format="DD-MM-YY"
                           :formatter="momentFormat"
                           :disabled-date="disabledBeforeStartDate"
                           placeholder="dd-mm-yy"
                            ></date-picker>
                        <!-- <input id="end"
                        v-model="end_date"
                            type="date"
                            class="form-control input-form mt-2"
                            placeholder="End Date  "
                            
                        /> -->
                          <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.end_date"
                        >
                            {{ validationMsg.end_date }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2" v-show="is_flash_sale">
                    <div class="form-group mb-4">
                            <vue-timepicker 
                               id="start_time"
                                fixed-dropdown-button
                                v-model="start_time"  class="form-control mt-0 w-full" format="HH:mm"
                                >
                                
                            </vue-timepicker>
                        <p
                            class="text-red-600 text-xs"
                            v-if='validationMsg.start_time'
                        >
                            {{validationMsg.start_time}}
                        </p>
                    </div>
                </div>
                <div class="col-span-2" v-if="!is_flash_sale">
                    
                </div>
                <div class="col-span-1">
                    <!-- free space for grid -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Discount Type</label
                    >
                    <div class="form-group mb-4 mt-2">
                         <multiselect
                            :disabled="
                                isediting == 'edit' ? true : false"
                            v-model="discount_type_id"
                            :options="discountTypeOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            label="name"
                            @search-change="getDiscountType"
                            placeholder="Search Discount Type"
                            @input="changeAmount()"
                        ></multiselect>
                         <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.discount_type"
                        >
                            {{ validationMsg.discount_type }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="promotion" class="form-label label-form"
                        > Amount</label
                    >
                    <div class="form-group mb-4">
                        <input
                            type="number"
                            v-model="amount"
                            class="form-control input-form mt-2"
                            id="promotion"
                            placeholder="Promotion Amount"
                            @change="changeAmount()"
                            
                        />
                         <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.amount"
                        >
                            {{ validationMsg.amount }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="quantity" class="form-label label-form"
                        >Quantity</label
                    >
                    <div class="form-group mb-4">
                        <input
                           v-model="quantity"
                            type="number"
                            class="form-control input-form mt-2"
                            id="quantity"
                            placeholder="Quantity"
                            @change="changeQuantity()"
                        />
                         <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.quantity"
                        >
                            {{ validationMsg.quantity }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1">
                    <!-- free space for grid -->
                </div>
                <!-- end row -->


                <div class="col-span-7">
                    <hr class="my-2 h-0.5" />
                </div>
            </div>

            <!-- start row -->
            <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2 mb-4">
                <div class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Item Code</label
                    >
                    <div class="form-group mb-4">
                        <multiselect
                             class="mt-3"
                            v-model="itemValue"
                            :options="itemOptions"
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
                            placeholder="Search Item"
                        ></multiselect>
                         <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.product"
                        >
                            {{ validationMsg.product }}
                        </p>
                    </div>
                </div>

                <div class="col-span-3">
                    <Button
                        @click="addHandler"
                        type="button"
                        class="primary-button bg-black mt-8"
                        >Add</Button
                    >
                </div>
            </div>
            <!-- end row -->

            <!-- start row -->
            
            <discount-create-two />
            <div class="">
                <hr class="my-2 h-0.5" />
            </div>
            <!-- end row -->

            <div class="flex justify-end pb-4">
                <button
                    type="button"
                    class="primary-button bg-black"
                    :disabled="currentApiLoading"
                    @click.prevent="onSubmit"
                >
                 <api-loading />
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
import DiscountCreateTwo from "./OldDiscountCreateTwo.vue";
import apiLoading from "./../Components/apiLoadingComponent";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from "moment";



export default {
    name:"DiscountCreate",
    components:{
        Multiselect,
        DiscountCreateTwo,
        VueTimepicker,
        apiLoading,
        DatePicker,
    },
     props: {
        isediting: String,
    },
    async mounted() {
        if(this.isediting=='edit'){
            this.getDetail();
        }
        this.getDiscountType();
    },
    data(){
        return {
            id:'',
            start_date:'',
            end_date:'',
            start_time:'',
            is_flash_sale:false,
            discount_type_id:null,
            discountTypeOptions:[],
            itemValue: '',
            itemOptions: [],
            amount:'',
            quantity:'',
            successValidationRules: false,
            validationMsg: {
                start_time:"",
                start_date:"",
                end_date: "",
                discount_type: "",
                product:'',
                quantity:'',
                amount:'',
            },
            momentFormat:{
                stringify: (date) => {
                    return date ? moment(date).format('LL') : ''
                  },
                parse: (value) => {
                    return value ? moment(value, 'LL').toDate() : null
                  },
            },
        }
    },
    computed:{
         ...mapGetters(["addMySubProductRows", "currentApiLoading",]),
    },
    methods:{
        ...mapActions(["getApiData","postWebForm"]),
        ...mapMutations(["setSubProductRow","setApiLoading","changeAmountSubProductRow","changeQuantitySubProductRow"]),
         customItemLabel(option) {
            return `${option.product.name_translations[0].name} - ${option.sku} `;
        },
        // disabledStartDate(date) {
        //     return this.start_date && date.setHours(0, 0, 0, 0) > new Date(this.start_date).setHours(0, 0, 0, 0);
        //   },
        disabledRange: function (date) {   
            this.end_date="";
            const today = new Date();
              today.setHours(0, 0, 0, 0);
              return date < today ;
         },
         disabledBeforeStartDate: function (date) {    
            const start = new Date(this.start_date);
              start.setHours(0, 0, 0, 0);
              return date <start
         },
        resetvalidateRulesMsg() {
            this.validationMsg.discount_type = "";
            this.validationMsg.start_date = "";
            this.validationMsg.end_date = "";
            this.validationMsg.product = "";
            this.validationMsg.amount = "";
            this.validationMsg.quantity = "";
            this.validationMsg.start_time = "";
        },
        validateRules() {
            this.successValidationRules = true;
            this.resetvalidateRulesMsg();
            if (this.discount_type_id == null) {
                this.validationMsg.discount_type = "Discount Type is required.";
                this.successValidationRules = false;
            }
            if (this.start_date == "") {
                this.validationMsg.start_date = "Start Date is required.";
                this.successValidationRules = false;
            }
            if (this.end_date == "") {
                this.validationMsg.end_date = "End Date is required.";
                this.successValidationRules = false;
            }
            if (this.is_flash_sale==true){
                if(this.start_time ==="" || this.start_time===null) {
                    this.successValidationRules = false;
                    this.validationMsg.start_time = "Start Time is required.";
                }else{
                       let time=this.start_time;
                      let start_time=time.split(':');
                      if(start_time[0]==='HH'|| start_time[1]==='mm'){
                         this.successValidationRules = false;
                        this.validationMsg.start_time = "Start Time is required.";
                      }
                }
               
            }
            if (this.amount == "") {
                this.validationMsg.amount = "Amount is required.";
                this.successValidationRules = false;
            }
            if (this.quantity == "") {
                this.validationMsg.quantity = "Quantity is required.";
                this.successValidationRules = false;
            }
            if (this.addMySubProductRows.length == 0) {
                this.validationMsg.product = "Product is required.";
                this.successValidationRules = false;
            }
        },
        validateResError(error) {
            if(error.response.data.message!=null){
                this.successValidationRules=false;
                  this.$swal("Error!", error.response.data.message, "error");
                return;
            }
           
        },
         async getDiscountType() {
                this.getApiData({
                    url: `get_discount_type`,
                }).then((res) => {
                    this.discountTypeOptions = res.data.data;
                });
        },
         async asyncFindItem(query) {
            let payload = {
                url: `sub_product_in_stock?search_input=${query}`,
            };
            this.getApiData(payload).then((res) => {
                this.itemOptions = res.data.data;
            });
        },
         scrollToTop() {
            window.scrollTo(0, 0);
        },
        async addHandler() {
            if (this.discount_type_id && this.itemValue && this.amount && this.quantity && this.discount_type_id.id) {
                this.validateDiscountAmountAndQuantity(this.itemValue);
                // if(this.itemValue.quantity< this.quantity){
                //     {
                //         this.$swal("Error!", "Quantity must be less than " +this.itemValue.quantity+ " in stock");
                //         return;
                //     }
                // }
                // if(this.discount_type_id.name=="Percentage"){
                //      let amt=this.itemValue.product_prices.price-(this.itemValue.product_prices.price*this.amount)/100;
                //     if(amt<this.amount){
                //     this.$swal("Error!", "Amount must be less than " +this.itemValue.product_prices.price );
                //     return;
                //     }
                // }else if(this.discount_type_id.name=="Fixed"){
                //     if(this.itemValue.product_prices.price<this.amount){
                //               this.$swal("Error!", "Amount must be less than " +this.itemValue.product_prices.price );
                //             return;
                //     }
                // }
                 if (
                    this.addMySubProductRows.some(
                        (data) => data.item.id === this.itemValue.id
                    )
                ) {
                    this.$swal("Error!", "Item already exits.", "error");
                    return;
                }
                let form_data=new FormData();
                form_data.append("sub_product_id", this.itemValue.id);
                let data = {
                    url: "discounts/validate_sub_product",
                    form_data: form_data,
                };
                await this.postWebForm(data)
                    .then((res) => {    
                        if(this.successValidationRules==true){
                            let payload = {
                                local_id: Math.random().toString(36).slice(2), //for local edit
                                item: this.itemValue,
                                discount_type:this.discount_type_id,
                                amount: this.amount,
                                quantity: this.quantity,
                            };
                            this.setSubProductRow(payload);
                        }
                    })
                    .catch((error) => {
                        this.setApiLoading(false);
                        this.validateResError(error);
                    });
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
        changeAmount(){
            if(this.discount_type_id.name=="Percentage" && this.amount>100){
                this.$swal("Error!", " Value must be less or equal than 100 ");
                this.amount='';
                return;
            }
            if(this.addMySubProductRows.length >0 && this.amount && this.discount_type_id) {
              
                this.addMySubProductRows.forEach(sub=>{
                    this.validateDiscountAmountAndQuantity(sub.item) 
                });
                if(this.successValidationRules==true){
                       let payload={
                        amount:this.amount,
                        discount_type:this.discount_type_id,
                       }
                        this.changeAmountSubProductRow(payload)
                }
            }
        },
        changeQuantity(){
            if(this.isediting=='edit'){
                 if(this.addMySubProductRows.length >0 && this.quantity) {
                    this.addMySubProductRows.forEach(sub=>{
                        this.validateDiscountAmountAndQuantity(sub.item) 
                    });
                    if(this.successValidationRules==true){
                            this.changeQuantitySubProductRow(this.quantity)
                    }
                }
            }
        },
        validateDiscountAmountAndQuantity(itemValue){
            this.successValidationRules=true;
             if(parseInt(itemValue.quantity)< this.quantity){
                {
                    this.$swal("Error!", "Quantity must be less than " +itemValue.quantity+ " in stock");
                    this.successValidationRules = false;
                    this.quantity=this.addMySubProductRows[0].quantity;
                    return ;
                }
            }
            if(this.discount_type_id.name=="Percentage"){
                    if(this.amount>100){
                    
                    // this.$swal("Error!", "Amount must be less than 100" +itemValue.product_prices.price );
                    this.$swal("Error!", "Amount must be less than 100");
                    this.amount='';
                    this.successValidationRules = false;
                    if(this.isediting=='edit'){
                        this.amount=this.addMySubProductRows[0].amount;
                    }
                    return;
                    }
                // }
                
            }else if(this.discount_type_id.name=="Fixed"){
                if(itemValue.product_prices.price<this.amount){
                        this.successValidationRules = false;
                          this.$swal("Error!", "Amount must be less than " +itemValue.product_prices.price );
                         if(this.isediting=='edit'){
                            this.amount=this.addMySubProductRows[0].amount;
                        }
                        return;
                }
            }
        },
        async getDetail(){
            var baseUrl = (window.location).href; // You can also use document.URL
            var id = baseUrl.substring(baseUrl.lastIndexOf('/') + 1);
             let res = await axios.get(`/discounts/${id}`);
            res = res.data.data;
            this.id=res.id;
            this.discount_type_id=res.discount_type;
            this.start_date=res.start_date;
            this.end_date=res.end_date;
            this.start_time=res.start_time==null ? '' : res.start_time;
            this.is_flash_sale=res.is_flash_sale==1 ? true:false;
            this.quantity=res.quantity;
            this.amount=res.amount;

            res.discount_sub_products.forEach((value)=>{
                let payload = {
                    local_id: Math.random().toString(36).slice(2), //for local edit
                    item: value.sub_product,
                    discount_type:this.discount_type_id,
                    amount: this.amount,
                    quantity: this.quantity,
                };
                this.setSubProductRow(payload);
            });
        },
        onSubmit(e){
            e.preventDefault();
            this.validateRules();
            if (this.successValidationRules == true) {
            let form_data = new FormData();
            if (this.isediting == "edit") {
                form_data.append("id", this.id);
            }
            let sub_products = [];
            this.addMySubProductRows.forEach((row) => {
                let sub_product = {
                    sub_product_id: row.item.id,
                };
                sub_products.push(sub_product);
            });
            form_data.append("sub_products", JSON.stringify(sub_products));
            form_data.append("start_date", this.start_date);
            form_data.append("end_date", this.end_date);
            form_data.append("start_time", this.start_time);
            form_data.append("discount_type_id", this.discount_type_id.id);
            form_data.append("is_flash_sale", this.is_flash_sale==true ? 1 : 0);
            form_data.append("amount", this.amount);
             form_data.append("quantity", this.quantity);
            this.setApiLoading(true);
            let payload = {
                url: "discounts/createOrUpdate",
                form_data: form_data,
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.setApiLoading(false);
                    this.$swal({
                        icon: "success",
                        title: "Created!",
                        text: `Discount has been added.`,
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    window.location.href = "/discount_index";
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });
            }else{
                this.setApiLoading(false);
                this.scrollToTop();
                // this.validateResError(error);

            }
        },
    }

}

</script>

<style>

</style>