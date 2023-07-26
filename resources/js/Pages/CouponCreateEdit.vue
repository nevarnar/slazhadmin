<template lang="">
    <div>
        <div class="inner-main-container">
            <div>
                <p class="page-tittle">
                    create Coupon
                </p>
            </div>

            <div class="pt-6 mb-6">
                <div class="grid grid-cols-8 gap-x-8 mx-2">
                    <!-- start row -->
                    <div class="col-span-4">
                        <label for="" class="form-label label-form"
                            >Coupon Name</label
                        >
                    </div>
                    <div class="col-span-2">
                        <label for="" class="form-label label-form"
                            >Coupon Code</label
                        >
                    </div>
                    <div class="col-span-2"></div>


                    <div class="col-span-2">
                        <div class="form-group mb-6">
                            <input v-model="form_data.name"
                                type="text"
                                class="form-control input-form mt-2"
                                id=""
                                placeholder="In English"
                            />
                              <p class="text-red-600 text-xs" v-if="validationMsg.name">
                                {{ validationMsg.name }}
                                </p>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="form-group mb-6">
                            <input v-model="form_data.mm_name"
                                type="text"
                                class="form-control input-form mt-2"
                                id=""
                                placeholder="In Myanmar"
                            />
                            <p class="text-red-600 text-xs" v-if="validationMsg.mm_name">
                                {{ validationMsg.mm_name }}
                                </p>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="form-group mb-2">
                            <input v-model="form_data.code"
                                type="text"
                                class="form-control input-form mt-2"
                                id=""
                                placeholder="Code"
                            />
                              <p class="text-red-600 text-xs" v-if="validationMsg.code">
                                {{ validationMsg.code }}
                                </p>
                        </div>
                    </div>
                    <div class="col-span-2"></div>
                    <!-- end row -->

                    <!-- start row -->
                    <div class="col-span-2">
                        <label for="" class="form-label label-form"
                            >Start Date</label
                        >
                    </div>
                    <div class="col-span-2">
                        <label for="" class="form-label label-form"
                            >End Date</label
                        >
                    </div><div class="col-span-4"></div>

                    <div class="col-span-2">
                        <div class="form-group mb-6">
                            <date-picker
                            v-model="form_data.start_date"
                            valueType="format"
                            format="DD-MM-YY"
                            class="w-full"
                            :formatter="momentFormat"
                            :disabled-date="disabledRange"
                            style="width: 100%"
                            placeholder="dd-mm-yy"
                          ></date-picker>
                            <p class="text-red-600 text-xs" v-if="validationMsg.start_date">
                                {{ validationMsg.start_date }}
                                </p>
                            <!-- start-end date picker -->
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="form-group mb-6">
                            <date-picker
                            v-model="form_data.end_date"
                            valueType="format"
                            format="DD-MM-YY"
                            class="w-full"
                            style="width: 100%"
                            :formatter="momentFormat"
                            :disabled-date="disabledBeforeStartDate"
                            placeholder="dd-mm-yy"
                          ></date-picker>
                            <p class="text-red-600 text-xs" v-if="validationMsg.end_date">
                                {{ validationMsg.end_date }}
                                </p>
                            <!-- start-end date picker -->
                        </div>
                    </div><div class="col-span-4"></div>
                    <!-- end row -->

                    <!-- start row -->
                    <div class="col-span-8">
                        <label for="" class="form-label label-form"
                            >Description</label
                        >
                    </div>
                    <div class="col-span-6 mb-3">
                        <textarea name="" v-model="form_data.description"
                            class="mt-2 w-full min-h-[160px] focus:outline-none rounded animated-textarea active:shadow-none active:outline-none block"
                            cols="30"
                            rows="10"
                            style="border: 1px solid #e5e7eb"
                            ></textarea>
                              <p class="text-red-600 text-xs" v-if="validationMsg.description">
                                {{ validationMsg.description }}
                                </p>
                    </div><div class="col-span-2"></div>
                    <div class="col-span-6 mb-4">
                        <textarea name="" v-model="form_data.mm_description"
                            class="mt-2 w-full min-h-[160px] focus:outline-none rounded animated-textarea active:shadow-none active:outline-none block"
                            cols="30"
                            rows="10"
                            style="border: 1px solid #e5e7eb"
                            ></textarea>
                              <p class="text-red-600 text-xs" v-if="validationMsg.mm_description">
                                {{ validationMsg.mm_description }}
                                </p>
                    </div><div class="col-span-2"></div>
                    <!-- end row -->

                    <!-- start row -->
                    <div class="col-span-8">
                        <label for="" class="form-label label-form"
                            >Upload Image</label
                        >
                    </div>
                    <div class=" col-span-4 mb-6">
                        <input type="file" ref="iconFile"  @change="onChange" class="form-control input-form mt-3"
                            placeholder=""/>
                            <img-preview :img-preview="icon_preview" :delete-image="deleteImage" /> 
                              <p class="text-red-600 text-xs" v-if="validationMsg.photo">
                                {{ validationMsg.photo }}
                                </p>
                    </div><div class=" col-span-4"></div>
                    <!-- end row -->


                    <!-- start row -->
                    <div class="col-span-2">
                        <label for="" class="form-label label-form"
                            >Coupon Discount Type</label
                        >
                    </div>
                    <div class="col-span-2">
                        <label v-if="form_data.coupon_discount_type_value?.name != 'free_delivery'" for="" class="form-label label-form"
                            >Amount</label
                        >
                    </div>
                    <div class="col-span-4"></div>


                    <div class="col-span-2">
                        <div class="form-group mb-6">
                                <multiselect v-if="form_data.coupon_discount_type_options"
                                v-model="form_data.coupon_discount_type_value"
                                :options="form_data.coupon_discount_type_options"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="id"
                                placeholder="Choose "
                                ></multiselect>
                                  <p class="text-red-600 text-xs" v-if="validationMsg.coupon_discount_type_id">
                                {{ validationMsg.coupon_discount_type_id }}
                                </p>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div v-if="form_data.coupon_discount_type_value?.name != 'free_delivery'" class="form-group mb-6">
                            <input
                             v-model="form_data.discount_value"
                                type="number"
                                class="form-control input-form mt-2"
                                id=""
                                placeholder="Amount"
                            />
                              <p class="text-red-600 text-xs" v-if="validationMsg.discount_value">
                                {{ validationMsg.discount_value }}
                                </p>
                        </div>
                    </div>

                    <div class="col-span-4">
                        <!-- free space for grid  -->
                    </div>
                    <div class=" col-span-8">
                        <hr class="my-2 h-0.5" />
                    </div>
                    <!-- end row -->

                    <!-- start row -->
                        <div class=" col-span-8 px-1.5 mb-4">
                            <p class="text-xs primary-font text-gray-500">
                                Coupon Type is the limitation of products coupon can be used for. If you choose every item,the discount will be affected on every items & if you choose limited,coupons can be used only for that chosen categories / brands.If you choose campaign,the coupon can only be used in chosen campaign.
                            </p>
                        </div>

                    <div class=" col-span-2">
                        <label for="" class="form-label label-form"
                            >Coupon Type</label
                        >
                    </div>
                    <div v-if="form_data.coupon_type_value?.name=='Private' || form_data.coupon_type_value?.name== 'private'" class=" col-span-2">
                        <label for="" class="form-label label-form"
                            >User Name</label
                        >
                    </div>
                     <div v-else-if="form_data.coupon_type_value?.name=='Count' || form_data.coupon_type_value?.name== 'count'" class=" col-span-2">
                          <label for="" class="form-label label-form"
                            >Count</label
                        >
                    </div>

                    <div v-else class=" col-span-2"></div>
                    <div class=" col-span-4"></div>

                    <div class=" col-span-2 mb-4">
                          <multiselect v-if="form_data.coupon_type_options"
                                v-model="form_data.coupon_type_value"
                                :options="form_data.coupon_type_options"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="id"
                                placeholder="Choose "
                                class="mt-2"
                                ></multiselect>
                                  <p class="text-red-600 text-xs" v-if="validationMsg.coupon_type_id">
                                {{ validationMsg.coupon_type_id }}
                                </p>
                    </div>
                    <div class="contents" v-if="form_data.coupon_type_value?.name=='Private' || form_data.coupon_type_value?.name=='private'">
                        <div class="col-span-2">
                        <div class="form-group mb-2">
                               <multiselect v-if="user_options"
                                v-model="user_value"
                                :options="user_options"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="id"
                                placeholder="Choose "
                                class="mt-2"
                                ></multiselect>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <button @click="addUser" class="primary-button btn-clear mt-2">
                            Add
                        </button>
                    </div>
                    </div>
                    <div v-else-if="form_data.coupon_type_value?.name=='Count' || form_data.coupon_type_value?.name=='count'" class=" col-span-2">
                               <input
                            v-model="form_data.count"
                                type="number"
                                class="form-control input-form mt-2"
                                id=""
                                placeholder="Count"
                            />
                    </div>
                    <div v-else class=" col-span-2"></div>
                    <div class=" col-span-2"></div>

                    <div v-if="form_data.coupon_type_value?.name=='Private' || form_data.coupon_type_value?.name=='private'"  class=" col-span-8 w-full pt-2 mb-6">
                        <table class="secondary-table">
                            <thead class="secondary-table-thead">
                                <tr>
                                    <th class="sec-thead-th"> {{ users.length !=0 ? "User Name" : "No users found" }}</th>
                                    <th class="sec-thead-th"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, u_id) in users" :key="u_id">
                                    <td class="sec-table-td">
                                        {{ user.name }}
                                    </td>
                                    <td class="sec-table-td">
                                        <button @click="deleteUser(user.id)" class="primary-font text-sm text-gray-400"
                                            type="button"
                                            title="Delete"
                                            id=""
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-span-8">
                        <hr class="my-2 h-0.5" />
                    </div>
                    <!-- end row -->

                    <!-- start row -->
                    <div class=" col-span-8">
                        <label for="" class="form-label label-form"
                            >Coupon Limitation</label
                        >
                    </div>
                    <div class=" col-span-2 mb-6">
                        <multiselect
                        v-model="coupon_limitation_first"
                        :options="coupon_limitation_first_options"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        label="name"
                        track-by="name"
                        placeholder="Choose "
                        ></multiselect>
                           <p class="text-red-600 text-xs" v-if="validationMsg.coupon_limitation_feature">
                                {{ validationMsg.coupon_limitation_feature }}
                                </p>





                    </div>
                    <div class=" col-span-6"></div>

                    <div class="contents" v-if="coupon_limitation_first?.name=='Specific'">
                        <div class=" col-span-2">
                            <label for="" class="form-label label-form"
                                >Coupon Limitation</label
                            >
                        </div>
                        <div class=" col-span-2">
                            <label for="" class="form-label label-form"
                                >Name</label
                            >
                        </div>
                        <div class="col-span-4"></div>
                        <div class=" col-span-2">

                            <multiselect
                                v-model="typeFirstValue"
                                :options="typeFirstOptions"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                :allow-empty="false"
                                track-by="name"
                                label="name"
                                placeholder="Choose Type"
                                @input="changeType"
                                class="mt-2"
                            ></multiselect>
                        </div>
                        <div class="col-span-3">
                            <div class="form-group mb-2">
                                <multiselect
                                    class="mt-2"
                                    v-model="itemFirstValue"
                                    :options="itemFirstOptions"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customItemLabelFirst"
                                    :searchable="true"
                                    :max-height="200"
                                    :internal-search="false"
                                    @search-change="asyncFindItemFirst"
                                    placeholder="Search Item"
                                ></multiselect>
                                <!-- <input
                                    type="text"
                                    class="form-control input-form mt-2"
                                    id=""
                                    placeholder="Name"
                                /> -->
                            </div>
                        </div>
                        <div class="col-span-2">
                            <button @click="addHandler(itemFirstValue,'first')" class="primary-button btn-clear mt-2">
                                Add
                            </button>
                        </div>
                        <div class=" col-span-1"></div>
                        <div class=" col-span-8 w-full pt-2 mb-6">
                            <table class="secondary-table">
                                <thead class="secondary-table-thead">
                                    <tr>
                                        <th class="sec-thead-th">Name</th>
                                        <th class="sec-thead-th">Type</th>
                                        <th class="sec-thead-th"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i_id) in coupon_limitation_feature" :key="i_id">
                                        <td class="sec-table-td">
                                            {{ item.type=='collection' ?  item?.item?.item_code : item?.item?.name_translations[0]?.name }}
                                        </td>
                                        <td class="sec-table-td">
                                            {{ item.type }}
                                        </td>
                                        <td class="sec-table-td">
                                            <button @click="deleteItem(item.local_id,'first')" class="primary-font text-sm text-gray-400"
                                                type="button"
                                                title="Delete"
                                                id=""
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class=" col-span-8">
                        <hr class="my-2 h-0.5" />
                    </div>
                    <!-- end row -->


                    <!-- start row -->
                    <div class=" col-span-4"></div>
                    <div v-if="mini_purchase_yes_or_no_value.name == 'Yes'" class=" col-span-2">
                        <label for="" class="form-label label-form"
                            >Amount</label
                        >
                    </div>
                            <div v-else class=" col-span-2">
                        <label for="" class="form-label label-form"
                            ></label
                        >
                    </div>
                     <div class=" col-span-2"></div>
                    <div class="col-span-2">
                        <div class="form-group mb-6">
                            <label for="" class="form-label label-form"
                            >Total Minimum Purchase Amount</label
                        >
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="form-group mb-6">

                                <multiselect
                                v-model="mini_purchase_yes_or_no_value"
                                :options="mini_purchase_yes_or_no_options"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="name"
                                placeholder="Choose "
                                class="mt-2"
                                ></multiselect>
                        </div>
                    </div>

                    <div v-if="mini_purchase_yes_or_no_value.name == 'Yes'" class="col-span-2">
                        <div class="form-group mb-6">
                            <input
                            v-model="form_data.min_buying_amount"
                                type="number"
                                class="form-control input-form mt-2"
                                id=""
                                placeholder="Amount"
                            />
                                 <p class="text-red-600 text-xs" v-if="validationMsg.min_buying_amount">
                                {{ validationMsg.min_buying_amount }}
                                </p>
                        </div>
                    </div><div class=" col-span-2"></div>
                    <!-- end row -->

                    <div v-if="mini_purchase_yes_or_no_value?.name == 'Yes'" class="contents">
                    <div class=" col-span-8">
                        <label for="" class="form-label label-form"
                            >Limitation</label
                        >
                    </div>
                    <div class=" col-span-2 mb-4">
                            <multiselect
                                v-model="coupon_limitation_second"
                                :options="coupon_limitation_second_options"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="name"
                                class="mt-2"
                                placeholder="Choose "
                                ></multiselect>
                                   <p class="text-red-600 text-xs" v-if="validationMsg.coupon_limitation_feature_one">
                                {{ validationMsg.coupon_limitation_feature_one }}
                                </p>
                    </div>   <div class=" col-span-6"></div>

                    <div v-if="this.coupon_limitation_second.name=='Specific'" class="contents">
                        <div class=" col-span-2">
                            <label for="" class="form-label label-form"
                                >Coupon Limitation</label
                            >
                        </div>
                        <div class=" col-span-2">
                            <label for="" class="form-label label-form"
                                >Name</label
                            >
                        </div>  <div class="col-span-4"></div>
                        <div class=" col-span-2">
                                <multiselect
                                v-model="typeSecondValue"
                                :options="typeSecondOptions"
                                :searchable="false"
                                :close-on-select="true"
                                :show-labels="false"
                                :allow-empty="false"
                                track-by="name"
                                label="name"
                                placeholder="Choose Type"
                                @input="changeType"
                                class="mt-2"
                            ></multiselect>
                        </div>
                        <div class="col-span-3">
                            <div class="form-group mb-2">
                                <multiselect
                                    class="mt-2"
                                    v-model="itemSecondValue"
                                    :options="itemSecondOptions"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customItemLabelSecond"
                                    :searchable="true"
                                    :max-height="200"
                                    :internal-search="false"
                                    @search-change="asyncFindItemSecond"
                                    placeholder="Search Item"
                                ></multiselect>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <button @click="addHandler(itemSecondValue,'second')" class="primary-button btn-clear mt-2">
                                Add
                            </button>
                        </div>
                        <div class="col-span-1"></div>
                        <div class=" col-span-8 w-full pt-2 mb-6">
                            <table class="secondary-table">
                                <thead class="secondary-table-thead">
                                    <tr>
                                        <th class="sec-thead-th">Name</th>
                                        <th class="sec-thead-th">Type</th>
                                        <th class="sec-thead-th"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, ii_id) in coupon_limitation_feature_one" :key="ii_id">
                                        <td class="sec-table-td">
                                            {{ item.type=='collection' ?  item.item.item_code : item.item.name_translations[0].name }}
                                        </td>
                                        <td class="sec-table-td">
                                            {{ item.type }}
                                        </td>
                                        <td class="sec-table-td">
                                            <button @click="deleteItem(item.local_id,'second')" class="primary-font text-sm text-gray-400"
                                                type="button"
                                                title="Delete"
                                                id=""
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>




                </div>

                <div class="flex justify-end pb-4">
                    <button  :disabled="currentApiLoading"
                        type="button"
                        class="primary-button bg-black" @click="onSubmit"
                        v-show="checkShow"
                    >
                       <api-loading />
                        {{ isediting=='create' ? 'Create' : 'Save' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import VueTimepicker from "vue2-timepicker";
import Multiselect from "vue-multiselect";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import moment from "moment";
import apiLoading from "../Components/apiLoadingComponent.vue";
import ImgPreview from "../Components/imgPreview.vue";
export default {
  name: "CouponcreateEdit",
  components: {
    Multiselect,
    VueTimepicker,
    apiLoading,
    DatePicker,
    ImgPreview
  },
  props: {
    isediting: {
      type: String,
    },
  },
  data() {
    return {
      form_data: {
        id: "",
        name: "",
        mm_name: "",
        code: "",
        start_date: "",
        end_date: "",
        description: "",
        mm_description: "",
        photo: {},
        coupon_discount_type_value: "",
        coupon_discount_type_options: [],
        discount_value: "",
        coupon_type_value: "",
        coupon_type_options: [],
        min_buying_amount: "",
        count: "",
      },
      icon_preview:"",
      coupon_limitation_first: { name: "Specific" },
      coupon_limitation_first_options: [{ name: "Specific" }, { name: "None" }],
      coupon_limitation_second: { name: "Specific" },
      coupon_limitation_second_options: [
        { name: "Specific" },
        { name: "None" },
      ],
      typeFirstValue: null,
      typeFirstOptions: [
        { name: "Product", value: "product" },
        { name: "Stylist", value: "style_name" },
        { name: "Collection", value: "collection" },
        { name: "Series", value: "series" },
        { name: "Brand", value: "brand" },
        { name: "SubCategory", value: "sub_category" },
      ],

      itemFirstValue: null,
      itemFirstOptions: [],

      typeSecondValue: null,
      typeSecondOptions: [
        { name: "Product", value: "product" },
        { name: "Stylist", value: "style_name" },
        { name: "Collection", value: "collection" },
        { name: "Series", value: "series" },
        { name: "Brand", value: "brand" },
        { name: "SubCategory", value: "sub_category" },
      ],

      itemSecondValue: null,
      itemSecondOptions: [],
      coupon_limitation_feature: [],
      coupon_limitation_feature_one: [],
      user_value: null,
      user_options: null,
      users: [],
      mini_purchase_yes_or_no_value: { name: "Yes" },
      mini_purchase_yes_or_no_options: [{ name: "Yes" }, { name: "No" }],
      momentFormat: {
        stringify: (date) => {
          return date ? moment(date).format("LL") : "";
        },
        parse: (value) => {
          return value ? moment(value, "LL").toDate() : null;
        },
      },
      validationMsg: {
        name: null,
        mm_name: null,
        code: null,
        start_date: null,
        end_date: null,
        description: null,
        mm_description: null,
        photo: null,
        coupon_discount_type_id: null,
        discount_value: null,
        coupon_type_id: null,
        coupon_limitation_feature: null,
        min_buying_amount: null,
        coupon_limitation_feature_one: null,
      },
      successValidation: false,
    };
  },
  computed: {
    ...mapGetters(["currentApiLoading"]),
    checkShow(){
      if(this.form_data.id!=""){
        if (moment(new Date()).isBefore(this.form_data.start_date)) {
          return true;
        }
        if (moment(new Date()).isBefore(moment())) {
          return true;
        }
        return false;
      }
      return true;
    },
  },
  methods: {
    ...mapActions(["getApiData", "postWebForm"]),
    ...mapMutations(["setApiLoading"]),

    disabledRange: function (date) {
      this.end_date = "";
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return date < today;
    },
    disabledBeforeStartDate: function (date) {
      const start = new Date(this.form_data.start_date);
      start.setHours(0, 0, 0, 0);
      return date < start;
    },
    onChange(event) {
      if (event.target.files[0].size > 4000000) {
        //4M
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "Size cannot exceed 4M.",
        });
        return;
      }
      this.form_data.photo = {
        name: event.target.files[0].name,
        data: event.target.files[0],
      };
      this.icon_preview = URL.createObjectURL(event.target.files[0]);
    },
    customItemLabelFirst(option) {
      if (this.typeFirstValue.value == "product") {
        return `${option.name_translations[0].name} - ${option.sku} `;
      } else if (this.typeFirstValue.value == "collection") {
        return `${option.name_translations[0].name}`;
      } else if (this.typeFirstValue.value == "brand") {
        return `${option.name_translations[0].name} - ${option.sku_name} `;
      } else {
        return `${option.name_translations[0].name} `;
      }
    },
    customItemLabelSecond(option) {
      if (this.typeSecondValue.value == "product") {
        return `${option.name_translations[0].name} - ${option.sku} `;
      } else if (this.typeSecondValue.value == "collection") {
        return `${option.name_translations[0].name}`;
      } else if (this.typeSecondValue.value == "brand") {
        return `${option.name_translations[0].name} - ${option.sku_name} `;
      } else {
        return `${option.name_translations[0].name} `;
      }
    },
    async getCouponDiscountType() {
      this.getApiData({
        url: `get_coupon_discount_type`,
      }).then((res) => {
        this.form_data.coupon_discount_type_options = res.data.data;
      });
    },
    async getCouponType() {
      this.getApiData({
        url: `get_coupon_type`,
      }).then((res) => {
        this.form_data.coupon_type_options = res.data.data;
      });
    },
    async getUsers() {
      this.getApiData({
        url: `get_user`,
      }).then((res) => {
        this.user_options = res.data.data;
      });
    },
    addUser() {
      if (!this.user_value || this.checkUserExit()) {
        return;
      }
      this.users.push(this.user_value);
      this.user_value = null;
    },
    deleteUser(id) {
      this.users = this.users.filter((user) => user.id != id);
    },
    changeType() {
      this.itemFirstOptions = [];
      this.itemFirstValue = null;
      this.itemSecondOptions = [];
      this.itemSecondValue = null;
    },
    async asyncFindItemFirst(query) {
      let payload = {
        url: `get_coupon_feature?search_input=${query}&type=${this.typeFirstValue.value}`,
      };
      this.getApiData(payload).then((res) => {
        console.log("res", res.data.data);
        this.itemFirstOptions = res.data.data;
      });
    },
    async asyncFindItemSecond(query) {
      let payload = {
        url: `get_coupon_feature?search_input=${query}&type=${this.typeSecondValue.value}`,
      };
      this.getApiData(payload).then((res) => {
        console.log("res", res.data.data);
        this.itemSecondOptions = res.data.data;
      });
    },
    addHandler(data, firstOrSecond) {
      if (!data) {
        return;
      }
      if (firstOrSecond == "first") {
        this.addRow(data, firstOrSecond);
      } else {
        this.addRow(data, firstOrSecond);
      }
    },
    addRow(data, firstOrSecond) {
      console.log(data, firstOrSecond);
      if (this.checkCouponLimitationExit(data, firstOrSecond)) {
        return;
      }
      let payload = {
        local_id: Math.random().toString(36).slice(2), //for local edit
        item: data,
        type:
          firstOrSecond == "first"
            ? this.typeFirstValue.value
            : this.typeSecondValue.value,
      };
      if (firstOrSecond == "first") {
        this.coupon_limitation_feature.push(payload);
      } else {
        this.coupon_limitation_feature_one.push(payload);
      }
    },

    deleteItem(local_id, firstOrSecond) {
      if (firstOrSecond == "first") {
        this.coupon_limitation_feature = this.coupon_limitation_feature.filter(
          (cou) => cou.local_id != local_id
        );
      } else {
        this.coupon_limitation_feature_one =
          this.coupon_limitation_feature_one.filter(
            (cou) => cou.local_id != local_id
          );
      }
    },
    onSubmit() {
      this.resetValidation();
      this.checkValidation();
      if (!this.successValidation) {
        return;
      }
      let formData = new FormData();
      if (this.isediting == "edit") {
        formData.append("id", this.form_data.id);
      }
      let name_translations = [
        { name: this.form_data.name, language_code: "en" },
        { name: this.form_data.mm_name, language_code: "mm" },
      ];
      formData.append("data", JSON.stringify(name_translations));

      formData.append("code", this.form_data.code);
      formData.append("start_date", this.form_data.start_date);
      formData.append("end_date", this.form_data.end_date);
      let descriptions = [
        { name: this.form_data.description, language_code: "en" },
        { name: this.form_data.mm_description, language_code: "mm" },
      ];
      formData.append("descriptions", JSON.stringify(descriptions));

      if (Object.keys(this.form_data.photo).length > 0) {
        formData.append(
          "photo",
          this.form_data.photo.data,
          this.form_data.photo.name
        );
      }
      formData.append(
        "coupon_discount_type_id",
        this.form_data.coupon_discount_type_value.id
      );
      if (this.form_data.coupon_discount_type_value.name == "free_delivery") {
        formData.append("discount_value", null);
      } else {
        formData.append("discount_value", this.form_data.discount_value);
      }
      formData.append("coupon_type_id", this.form_data.coupon_type_value.id);
      if (
        this.form_data.coupon_type_value.name == "Private" ||
        this.form_data.coupon_type_value.name == "private"
      ) {
        let users = this.users.map((user) => user.id);
        formData.append("users", JSON.stringify(users));
      }
      if (
        this.form_data.coupon_type_value.name == "Count" ||
        this.form_data.coupon_type_value.name == "count"
      ) {
        formData.append("count", this.form_data.count);
      }

      if (this.coupon_limitation_first.name == "Specific") {
        let coupon_limitation_feature = [];
        this.coupon_limitation_feature.forEach((coupon) => {
          let cou = { type: coupon.type, id: coupon.item.id };
          coupon_limitation_feature.push(cou);
        });
        formData.append(
          "coupon_limitation_feature",
          JSON.stringify(coupon_limitation_feature)
        );
      } else {
        formData.append("coupon_limitation_feature", null);
      }
      if (this.coupon_limitation_second.name == "Specific") {
        let coupon_limitation_feature_one = [];
        this.coupon_limitation_feature_one.forEach((coupon) => {
          let cou = { type: coupon.type, id: coupon.item.id };
          coupon_limitation_feature_one.push(cou);
        });
        formData.append(
          "coupon_limitation_feature_one",
          JSON.stringify(coupon_limitation_feature_one)
        );
      } else {
        formData.append("coupon_limitation_feature_one", null);
      }

      if (this.mini_purchase_yes_or_no_value.name == "Yes") {
        formData.append("min_buying_amount", this.form_data.min_buying_amount);
      } else {
        formData.append("min_buying_amount", null);
      }
      this.setApiLoading(true);

      let payload = {
        url: "coupon/createOrUpdate",
        form_data: formData,
      };
      this.postWebForm(payload)
        .then((res) => {
          this.setApiLoading(false);
          this.$swal({
            icon: "success",
            title: `${this.isediting == "edit" ? "Edit" : "Create"}`,
            text: `Discount has been ${this.isediting}d`,
            showConfirmButton: false,
            timer: 1000,
          });

          window.location.href = "/coupon";
        })
        .catch((error) => {
          this.setApiLoading(false);
          //   this.validateResError(error);
          this.$swal("Error!", error.response.data.message, "error");
        });
      // name, mm_name , code , start_date , end_date, description , mm_description , photo , coupon_discount_type_id , discount_value , coupon_type_id , coupon_limitation_feature [{type: , id : }] , coupon_limitation_feature_one [{type: , id : }] , min_buying_amount ->null : 1000, users: [1,2],  //when private
      // count      // when limited
    },
    checkValidation() {
      this.successValidation = true;
      if (this.form_data.name == "") {
        this.validationMsg.name = "Name is required";
        this.successValidation = false;
      }
      if (this.form_data.mm_name == "") {
        this.validationMsg.mm_name = "Name(mm) is required";
        this.successValidation = false;
      }
      if (this.form_data.code == "") {
        this.validationMsg.code = "Code is required";
        this.successValidation = false;
      }
      if (this.form_data.start_date == "") {
        this.validationMsg.start_date = "Start date is required";
        this.successValidation = false;
      }
      if (this.form_data.end_date == "") {
        this.validationMsg.end_date = "End date is required";
        this.successValidation = false;
      }
      if (this.form_data.description == "") {
        this.validationMsg.description = "Description is required";
        this.successValidation = false;
      }
      if (this.form_data.mm_description == "") {
        this.validationMsg.mm_description = "Description (mm) is required";
        this.successValidation = false;
      }
      if (
        Object.keys(this.form_data.photo).length <= 0 &&
        this.isediting == "create"
      ) {
        this.validationMsg.photo = "Photo is required";
        this.successValidation = false;
      }
      if (this.form_data.coupon_discount_type_value == "") {
        this.validationMsg.coupon_discount_type_id =
          "Coupon discount type is required";
        this.successValidation = false;
      }
      if (this.form_data.coupon_discount_type_value.name != "free_delivery") {
        if (this.form_data.discount_value == "") {
          this.validationMsg.coupon_discount_type_id = "Discount is required";
          this.successValidation = false;
        }
      }

      if (this.form_data.discount_value?.name == "percentage") {
        console.log("ok");
        if (this.form_data.discount_value > 100) {
          this.validationMsg.discount_value =
            "Discount percent must less than 100%";
          this.successValidation = false;
        }
      }

      //   if (this.form_data.discount_value == "") {
      //     this.validationMsg.coupon_discount_type_id = "Discount is required";
      //     this.successValidation = false;
      //   }
      if (this.form_data.coupon_type_value == "") {
        this.validationMsg.coupon_type_id = "Coupon type is required";
        this.successValidation = false;
      }
      if (
        this.form_data.coupon_type_value?.name == "Private" ||
        this.form_data.coupon_type_value?.name == "private"
      ) {
        if (this.users.length == 0) {
          this.validationMsg.coupon_type_id = "Users are required";
          this.successValidation = false;
        }
      }
      if (
        this.form_data.coupon_type_value?.name == "Count" ||
        this.form_data.coupon_type_value?.name == "count"
      ) {
        if (!this.form_data.count) {
          this.validationMsg.coupon_type_id = " Count is  required";
          this.successValidation = false;
        }
      }

      if (this.coupon_limitation_first.name == "Specific") {
        if (this.coupon_limitation_feature.length == 0) {
          this.validationMsg.coupon_limitation_feature =
            "Below items are required";
          this.successValidation = false;
        }
      }

      if (
        this.mini_purchase_yes_or_no_value.name == "Yes" &&
        this.form_data.min_buying_amount <= 0
      ) {
        this.validationMsg.min_buying_amount =
          " Min buying amount is  required";
        this.successValidation = false;
        if (this.coupon_limitation_second.name == "Specific") {
          if (this.coupon_limitation_feature_one.length == 0) {
            this.validationMsg.coupon_limitation_feature_one =
              "Below items are required";
            this.successValidation = false;
          }
        }
      }
    },
    async getCouponDetail() {
      let uri = window.location.href.split("/");
      let uriLast = uri.length - 1;
      let res = await axios.get(`/coupons/${uri[uriLast]}`);
      res = res.data.data;
      console.log("res", res);
      this.form_data.id = res.id;
      this.icon_preview = res.photo;
      this.form_data.name = res.name_translations[0].name;
      this.form_data.mm_name = res.name_translations[1].name;
      this.form_data.description = res.description_translations[0].name;
      this.form_data.mm_description = res.description_translations[1].name;
      this.form_data.code = res.code;
      this.form_data.start_date = moment(res.start_date).format(
        "MMMM DD, YYYY"
      );
      this.form_data.end_date = moment(res.end_date).format("MMMM DD, YYYY");
      this.form_data.coupon_discount_type_value = res.coupon_discount_type;
      this.form_data.discount_value = res.discount_value;
      this.form_data.coupon_type_value = res.coupon_type;
      this.form_data.min_buying_amount = res.min_buying_amount;
      if (this.form_data.min_buying_amount) {
        this.mini_purchase_yes_or_no_value = { name: "Yes" };
      } else {
        this.mini_purchase_yes_or_no_value = { name: "No" };
      }
      this.form_data.count = res.count;
      this.users = res.users;

      if (res?.coupon_limitation.length != 0) {
        this.coupon_limitation_first = { name: "Specific" };
      } else {
        this.coupon_limitation_first = { name: "None" };
      }
      res?.coupon_limitation.forEach((cou) => {
        let payload = {
          local_id: Math.random().toString(36).slice(2), //for local edit
          item: cou.limitable,
          type: cou.limitable_type,
        };
        this.coupon_limitation_feature.push(payload);
      });
      if (res?.min_buying_condition.length != 0) {
        this.coupon_limitation_second = { name: "Specific" };
      } else {
        this.coupon_limitation_second = { name: "None" };
      }
      res?.min_buying_condition.forEach((cou) => {
        let payload = {
          local_id: Math.random().toString(36).slice(2), //for local edit
          item: cou.buyable,
          type: cou.buyable_type,
        };
        this.coupon_limitation_feature_one.push(payload);
      });
    },
    checkUserExit() {
      let checkuser = this.users.filter(
        (user) => user.id == this.user_value.id
      );
      if (checkuser.length != 0) {
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "User already exit",
          showConfirmButton: false,
          timer: 1000,
        });
        return true;
      } else {
        return false;
      }
    },
    checkCouponLimitationExit(data, firstOrSecond) {
      console.log("checkCouponLimitationExit", data, firstOrSecond);
      if (
        firstOrSecond == "first" &&
        this.coupon_limitation_feature.length != 0
      ) {
        this.$swal("Error!", "Cannot add more", "error");
        return true;
      } else if (
        firstOrSecond == "second" &&
        this.coupon_limitation_feature_one.length != 0
      ) {
        this.$swal("error", "Cannot add more", "error");
        return true;
      }
      return false;
    },
    resetValidation() {
      this.validationMsg.name = null;
      this.validationMsg.mm_name = null;
      this.validationMsg.code = null;
      this.validationMsg.start_date = null;
      this.validationMsg.end_date = null;
      this.validationMsg.description = null;
      this.validationMsg.mm_description = null;
      this.validationMsg.photo = null;
      this.validationMsg.coupon_discount_type_id = null;
      this.validationMsg.discount_value = null;
      this.validationMsg.coupon_type_id = null;
      this.validationMsg.coupon_limitation_feature = null;
      this.validationMsg.min_buying_amount = null;
      this.validationMsg.coupon_limitation_feature_one = null;
    },
    deleteImage() {
        this.form_data.photo = {};
        this.icon_preview = null;
        this.$refs.iconFile.value = null;
    },
  },

  mounted() {
    this.getCouponDiscountType();
    this.getCouponType();
    this.getUsers();
    if (this.isediting == "edit") {
      this.getCouponDetail();
    }
  },
};
</script>
<style lang="">
</style>
