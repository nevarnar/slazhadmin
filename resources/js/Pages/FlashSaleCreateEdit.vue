<template>
  <div class="inner-main-container">
    <div>
      <p class="page-tittle">Create Discount</p>
    </div>
    <div class="pt-6 mb-6">
      <div class="grid grid-cols-7 gap-x-8 mx-2">
        <!-- start row -->
        <div class="col-span-2">
          <label for="" class="form-label label-form">Start Date</label>
        </div>
        <div class="col-span-2">
          <label for="" class="form-label label-form">End Date</label>
        </div>
        <div class="col-span-3">
          <!-- free space for grid -->
        </div>

        <div class="col-span-2 mb-3">
          <div class="form-group mb-2 mt-2">
            <date-picker
              v-model="form_data.start_date"
              valueType="format"
              format="DD-MM-YY"
              class="w-full"
              :formatter="momentFormat"
              :disabled-date="disabledRange"
              style="width: 100%"
              placeholder="dd-mm-yy"
              :disabled="checkShow"
            ></date-picker>
            <p class="text-red-600 text-xs" v-if="validationMsg.start_date">
              {{ validationMsg.start_date }}
            </p>
          </div>
        </div>
        <div class="col-span-2 mb-3">
          <div class="form-group mb-2 mt-2">
            <date-picker
              v-model="form_data.end_date"
              valueType="format"
              format="DD-MM-YY"
              class="w-full"
              style="width: 100%"
              :formatter="momentFormat"
              :disabled-date="disabledBeforeStartDate"
              placeholder="dd-mm-yy"
              :disabled="checkShow"
            ></date-picker>
            <p class="text-red-600 text-xs" v-if="validationMsg.end_date">
              {{ validationMsg.end_date }}
            </p>
          </div>
        </div>

        <div class="col-span-3">
          <!-- free space for grid -->
        </div>
        <!-- end row -->
        <!-- start row -->
        <div class="col-span-2">
          <label for="" class="form-label label-form">Start Time</label>
        </div>
        <div class="col-span-2">
          <label for="" class="form-label label-form">End Time</label>
        </div>
        <div class="col-span-3">
          <!-- free space for grid -->
        </div>

        <div class="col-span-2 mb-3">
          <div class="form-group mb-2 mt-2">
            <vue-timepicker
              id="start_time"
              fixed-dropdown-button
              v-model="form_data.start_time"
              class="form-control mt-0 w-full"
              format="HH:mm"
            >
            </vue-timepicker>
            <p class="text-red-600 text-xs" v-if="validationMsg.start_time">
              {{ validationMsg.start_time }}
            </p>
          </div>
        </div>
        <div class="col-span-2 mb-3">
          <div class="form-group mb-2 mt-2">
            <vue-timepicker
              id="end_time"
              fixed-dropdown-button
              v-model="form_data.end_time"
              class="form-control mt-0 w-full"
              format="HH:mm"
            >
            </vue-timepicker>
            <p class="text-red-600 text-xs" v-if="validationMsg.end_time">
              {{ validationMsg.end_time }}
            </p>
          </div>
        </div>

        <div class="col-span-3">
          <!-- free space for grid -->
        </div>
        <!-- end row -->
        <!-- start row -->
        <div class="col-span-2">
          <label for="" class="form-label label-form">Discount Type</label>
        </div>

        <div class="col-span-2">
          <label for="" class="form-label label-form"
            >Minimum Purchase Amount</label
          >
        </div>

        <div class="col-span-2"></div>

        <div class="col-span-2 mb-3">
          <div class="form-group mb-2 mt-2">
            <multiselect
              :disabled="isediting == 'edit' ? true : false"
              v-model="form_data.discount_type_id"
              :options="form_data.discountTypeOptions"
              :searchable="false"
              :close-on-select="true"
              :show-labels="false"
              label="name"
              placeholder="Search Discount Type"
            ></multiselect>
            <p
              class="text-red-600 text-xs"
              v-show="validationMsg.discount_type"
            >
              {{ validationMsg.discount_type }}
            </p>
          </div>
        </div>

        <!-- promotion -->
        <div class="col-span-2 mb-3">
          <div class="form-group mb-2">
            <input
              :disabled="!form_data.is_based_on_amount"
              v-model="form_data.min_buying_amount"
              type="number"
              class="form-control input-form mt-2"
              id=""
              placeholder="Amount"
              min="0"
              oninput="validity.valid||(value='');"
            />
            <p
              class="text-red-600 text-xs"
              v-if="validationMsg.min_buying_amount"
            >
              {{ validationMsg.min_buying_amount }}
            </p>
          </div>
          <label class="checkbox-container"
            >Based On Amount
            <input
              type="checkbox"
              v-model="form_data.is_based_on_amount"
              @input="changeIsBasedOnAmount"
            />
            <span class="flashsale-check"></span>
          </label>
        </div>

        <div class="col-span-2"></div>

        <!-- Add sku -->
        <div class="contents">
          <div class="col-span-7 mt-3 mb-2">
            <p class="page-tittle">
              Add SKU
              <span class="text-red-600 text-xs" v-show="validationMsg.name">
                {{ validationMsg.name }}
              </span>
            </p>
          </div>

          <!-- start row -->
          <div class="col-span-3">
            <label for="" class="form-label label-form">Product</label>
          </div>
          <div class="col-span-2">
            <label for="" class="form-label label-form">Limited Quantity</label>
          </div>
          <div class="col-span-2"></div>
          <div class="col-span-3">
            <div class="form-group mb-6">
              <multiselect
                class="mt-2"
                v-model="form_data.itemValue"
                :options="form_data.itemOptions"
                :close-on-select="true"
                :show-labels="false"
                :custom-label="customItemLabel"
                :searchable="true"
                :max-height="200"
                :internal-search="false"
                @search-change="asyncFindItem"
                placeholder="Search Item"
              ></multiselect>

              <p class="text-red-600 text-xs" v-show="validationMsg.product">
                {{ validationMsg.product }}
              </p>
            </div>
          </div>
          <div class="col-span-2 mb-3">
            <div class="form-group mb-2">
              <input
                :disabled="form_data.is_unlimited"
                v-model="form_data.quantity"
                type="number"
                class="form-control input-form mt-2"
                id=""
                placeholder="Amount"
                min="0"
                oninput="validity.valid||(value='');"
              />
              <p class="text-red-600 text-xs" v-show="validationMsg.quantity">
                {{ validationMsg.quantity }}
              </p>
            </div>
            <label class="checkbox-container"
              >Unlimited
              <input
                type="checkbox"
                v-model="form_data.is_unlimited"
                @input="changeIsUnlimited"
              />
              <span class="flashsale-check"></span>
            </label>
          </div>

          <div class="col-span-2"></div>

          <!-- end row -->
          <!-- start row -->

          <div class="col-span-2">
            <label for="" class="form-label label-form"
              >Maximum Amount Per User</label
            >
          </div>
          <div class="col-span-2">
            <label for="" class="form-label label-form">Discount Amount</label>
          </div>
          <div class="col-span-3">
            <!-- free space for grid -->
          </div>

          <!-- mini -->
          <div class="col-span-2 mb-3">
            <div class="form-group mb-2">
              <input
                :disabled="!form_data.is_based_on_amount_per_user"
                v-model="form_data.max_buying_count"
                type="number"
                class="form-control input-form mt-2"
                id=""
                placeholder="Amount"
                min="0"
                oninput="validity.valid||(value='');"
              />
              <p
                class="text-red-600 text-xs"
                v-if="validationMsg.max_buying_count"
              >
                {{ validationMsg.max_buying_count }}
              </p>
            </div>
            <label class="checkbox-container"
              >Based On Amount
              <input
                type="checkbox"
                v-model="form_data.is_based_on_amount_per_user"
                @input="changeIsBasedOnAmountPerUser"
              />
              <span class="flashsale-check"></span>
            </label>
          </div>

          <div class="col-span-2 mb-3">
            <div class="form-group mb-2">
              <input
                v-model="form_data.discount_value"
                type="number"
                class="form-control input-form mt-2"
                id=""
                placeholder="Amount"
                min="0"
                oninput="validity.valid||(value='');"
              />
              <p
                class="text-red-600 text-xs"
                v-show="validationMsg.discount_value"
              >
                {{ validationMsg.discount_value }}
              </p>
            </div>
          </div>
          <div class="col-span-2">
            <button class="primary-button btn-clear mt-2" @click="addHandler">
              Add
            </button>
          </div>
          <!-- end row -->
          <div class="col-span-7">
            <hr class="my-2 h-0.5" />
          </div>
        </div>
      </div>

      <flash-sale-create-edit-table :isediting="isediting" />
      <!-- <discount-item-table :isediting="isediting" /> -->

      <div class="flex justify-end pb-4">
        <button
          @click.prevent="onSubmit"
          type="button"
          class="primary-button bg-black"
        >
          {{ isediting == "create" ? "Create" : "Save" }}
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import VueTimepicker from "vue2-timepicker";
import Multiselect from "vue-multiselect";
import apiLoading from "./../Components/apiLoadingComponent";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import moment from "moment";
import DiscountItemTable from "./DiscountCreateEditTable";
import FlashSaleCreateEditTable from "./FlashSaleCreateEditTable.vue";

export default {
  name: "FlashSaleCreateEdit",
  components: {
    Multiselect,
    VueTimepicker,
    apiLoading,
    DatePicker,
    //   DiscountItemTable,
    FlashSaleCreateEditTable,
  },
  props: {
    isediting: String,
  },
  data() {
    return {
      form_data: {
        id: "",
        quantity: "",
        discount_value: "",
        start_date: "",
        end_date: "",
        start_time: "",
        end_time: "",
        amount: "",
        is_based_on_amount: false, //true
        is_based_on_amount_per_user: false, //true
        min_buying_amount: "", //must type
        max_buying_count: "", //must type
        is_unlimited: false,
        discount_type_id: null,
        discountTypeOptions: [
          {
            id: 1,
            name: "Product",
            value: "product",
          },
          {
            id: 2,
            name: "Style",
            value: "style",
          },
        ],
        itemValue: "",
        itemOptions: [],
      },
      successValidationRules: false,
      validationMsg: {
        start_time: "",
        end_time: "",
        start_date: "",
        end_date: "",
        discount_type: "",
        min_buying_amount: "",
        max_buying_count: "",
        name: "",
        quantity: "",
        amount: "",
        type: "",
        discount_value: "",
      },
      momentFormat: {
        stringify: (date) => {
          return date ? moment(date).format("LL") : "";
        },
        parse: (value) => {
          return value ? moment(value, "LL").toDate() : null;
        },
      },
    };
  },
  computed: {
    ...mapGetters(["currentApiLoading", "addPromotionItemRows"]),
    checkShow(){
      if(this.form_data.id!=""){
        if (moment(new Date()).isAfter(this.form_data.start_date) && moment(new Date()).isAfter(this.form_data.end_date)) {
          console.log("first true");
          return true;
        }
        if (moment(new Date()).isAfter(this.form_data.start_date) && moment(new Date()).isBefore(this.form_data.end_date)) {
          console.log("second");
          return true;
        }
        return false;
      }
      return false;
    },
  },
  methods: {
    ...mapActions(["getApiData", "postWebForm", "actionPromotionCategory"]),
    ...mapMutations(["setApiLoading", "setPromotionItems"]),
    customItemLabel(option) {
      if (this.form_data.discount_type_id.value == "product") {
        return `${option.product.name_translations[0].name} - ${option.sku} `;
      } else if (this.form_data.discount_type_id.value == "style") {
        return `${option.name_translations[0].name} - ${option.item_code} `;
      }
    },
    customLabel(option) {
      return `${option.name_translations[0].name}`;
    },
    
    // checkCanEdit(start_date, end_date) {
    //   //check new Date () isBefore start_date
    //   if (moment(new Date()).isBefore(start_date)) {
    //     console.log("first");
    //     return true;
    //   }
    //   if (moment(new Date()).isAfter(end_date)) {
    //     console.log("second");
    //     return true;
    //   }
    //   return false;
    // },
    async asyncFindItem(query) {
      if (!this.form_data.discount_type_id.value) {
        this.validationMsg.discount_type = "Type is required.";
        return;
      } else {
        this.validationMsg.discount_type = "";
      }

      let payload = {
        url: `get_item_with_type_in_stock?search_input=${query}&type=${this.form_data.discount_type_id.value}`,
      };
      this.getApiData(payload).then((res) => {
        console.log("res", res.data.data);
        this.form_data.itemOptions = res.data.data;
      });
    },
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
    changePromotionType() {
      this.form_data.itemOptions = [];
      this.form_data.itemValue = null;
    },

    setEmptyField() {
      this.form_data.discount_type_id = "";
      this.form_data.amount = "";
      this.form_data.typeValue = "";
      this.form_data.promotionTypeValue = "";
      this.form_data.promotionCategoryValue = "";
      this.form_data.itemValue = "";
    },
    addItemValidation() {
      this.resetvalidateRulesMsg();
      if (this.form_data.discount_type_id == null) {
        this.validationMsg.discount_type = "Discount Type is required.";
        this.successValidationRules = false;
      }
      if (
        this.form_data.is_unlimited == false &&
        this.form_data.quantity == ""
      ) {
        this.validationMsg.quantity = "Quantity is required.";
        this.successValidationRules = false;
      }
      if (this.form_data.is_based_on_amount_per_user == true) {
        if (
          this.form_data.max_buying_count == "" ||
          parseInt(this.form_data.max_buying_count) == 0
        ) {
          this.validationMsg.max_buying_count =
            "Maximun buying amount per user is required.";
          this.successValidationRules = false;
        }
      }

      if (
        this.form_data.discount_value == "" ||
        parseInt(this.form_data.discount_value) == 0
      ) {
        this.validationMsg.discount_value = "Discount Amount is  required.";
        this.successValidationRules = false;
      }
    },
    async addHandler() {
      this.addItemValidation();
      // this.form_data.typeValue &&  this.form_data.amount && this.form_data.quantity &&
      if (this.successValidationRules == false) {
        return;
      }
      if (this.form_data.itemValue == "" || this.form_data.itemValue == null) {
        let typeVal =
          this.form_data.discount_type_id.value == "product"
            ? "sub_product"
            : "style";
        this.form_data.itemOptions.forEach((item) => {
          if (
            this.addPromotionItemRows.some(
              (data) => data.item.id === item.id
            ) &&
            this.addPromotionItemRows.some((data) => data.type === typeVal)
          ) {
            // this.$swal("Error!", "Item already exits.", "error");
            this.$swal({
              icon: "warning",
              title: "Warining",
              text: "Item already exists",
              showConfirmButton: true,
              // timer: 1000,
            });
            return;
          }
          console.log("item", item);
          this.addRow(item);
        });
        // this.setEmptyField();
      } else {
        console.log("same", this.form_data.discount_type_id.value);
        let typeVal =
          this.form_data.discount_type_id.value == "product"
            ? "sub_product"
            : "style";
        if (
          this.addPromotionItemRows.some(
            (data) => data.item.id === this.form_data.itemValue.id
          ) &&
          this.addPromotionItemRows.some((data) => data.type === typeVal)
        ) {
          this.$swal("Error!", "Item already exits.", "error");
          return;
        }
        console.log("before add", this.form_data.itemValue);
        this.addRow(this.form_data.itemValue);
      }
    },

    addRow(data) {
      let payload = {
        local_id: Math.random().toString(36).slice(2), //for local edit
        is_new: true,
        item: data,
        start_date:this.form_data.start_date,
        end_date:this.form_data.end_date,
        quantity:
          this.form_data.quantity != ""
            ? parseInt(this.form_data.quantity)
            : null,
        type:
          this.form_data.discount_type_id.value == "product"
            ? "sub_product"
            : this.form_data.discount_type_id.value,
        max_buying_count:
          this.form_data.max_buying_count != ""
            ? parseInt(this.form_data.max_buying_count)
            : null,
        discount_value:
          this.form_data.discount_value != ""
            ? parseInt(this.form_data.discount_value)
            : null,
      };

      let data_form = {
        url: "flash_sale/validate_sub_product",
        form_data: payload,
      };
      this.postWebForm(data_form)
        .then((res) => {
          console.log("model", res.data.data);

          this.setPromotionItems(payload);
          this.form_data.itemValue = "";
          this.form_data.quantity = "";
          this.form_data.is_unlimited = false;
          this.form_data.max_buying_count = "";
          this.form_data.is_based_on_amount_per_user = false;
          this.form_data.discount_value = "";
        })
        .catch((error) => {
          this.$swal("Error!", error.response.data.message, "error");
        });
    },

    validateResError(error) {
      if (error.response.data.message != null) {
        this.successValidationRules = false;
        this.$swal("Error!", error.response.data.message, "error");
        return;
      }
    },
    resetvalidateRulesMsg() {
      this.successValidationRules = true;
      this.validationMsg.discount_type = "";
      this.validationMsg.start_date = "";
      this.validationMsg.end_date = "";
      this.validationMsg.name = "";
      this.validationMsg.amount = "";
      this.validationMsg.start_time = "";
      this.validationMsg.end_time = "";
      this.validationMsg.min_buying_amount = "";
      this.validationMsg.max_buying_count = "";
      this.validationMsg.discount_value = "";
      this.validationMsg.quantity = "";
    },
    validateRules() {
      this.successValidationRules = true;
      this.resetvalidateRulesMsg();

      if (this.form_data.start_date == "") {
        this.validationMsg.start_date = "Start Date is required.";
        this.successValidationRules = false;
      }
      if (this.form_data.end_date == "") {
        this.validationMsg.end_date = "End Date is required.";
        this.successValidationRules = false;
      }
      if (
        this.form_data.start_time === "" ||
        this.form_data.start_time === null
      ) {
        this.successValidationRules = false;
        this.validationMsg.start_time = "Start Time is required.";
      } else {
        let time = this.form_data.start_time;
        let start_time = time.split(":");
        if (start_time[0] === "HH" || start_time[1] === "mm") {
          this.successValidationRules = false;
          this.validationMsg.start_time = "Start Time is required.";
        }
      }
      if (this.form_data.end_time === "" || this.form_data.end_time === null) {
        this.successValidationRules = false;
        this.validationMsg.end_time = "End Time is required.";
      } else {
        let time = this.form_data.end_time;
        let end_time = time.split(":");
        if (end_time[0] === "HH" || end_time[1] === "mm") {
          this.successValidationRules = false;
          this.validationMsg.end_time = "End Time is required.";
        }
      }

      if (this.form_data.is_based_on_amount == true) {
        if (
          this.form_data.min_buying_amount == "" ||
          parseInt(this.form_data.min_buying_amount) == 0
        ) {
          this.validationMsg.min_buying_amount =
            "Mininum buying amount is required.";
          this.successValidationRules = false;
        }
      }

      if (this.addPromotionItemRows.length == 0) {
        this.validationMsg.name = "Item  is required.";
        this.successValidationRules = false;
      }
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
    onSubmit(e) {
      e.preventDefault();
      this.validateRules();
      if (this.successValidationRules == true) {
        let formData = new FormData();
        if (this.isediting == "edit") {
          formData.append("id", this.form_data.id);
        }
        // addPromotionItemRows
        var filterRow = this.addPromotionItemRows.filter((element) => {
          return element.is_new == true;
        });
        formData.append("flast_sale_items", JSON.stringify(filterRow));
        formData.append("start_date", this.form_data.start_date);
        formData.append("end_date", this.form_data.end_date);
        formData.append("start_time", this.form_data.start_time);
        formData.append("end_time", this.form_data.end_time);
        formData.append(
          "type",
          this.form_data.discount_type_id.value == "product"
            ? "sub_product"
            : "style"
        );

        // formData.append("amount", this.form_data.amount);

        formData.append(
          "min_buying_amount",
          this.form_data.min_buying_amount == ""
            ? null
            : this.form_data.min_buying_amount
        );

        this.setApiLoading(true);
        let payload = {
          url: "flash_sales/createOrUpdate",
          form_data: formData,
        };
        this.postWebForm(payload)
          .then((res) => {
            this.setApiLoading(false);
            this.$swal({
              icon: "success",
              title: "Created!",
              text: `Flash Sale has been ${this.isediting}d`,
              showConfirmButton: false,
              timer: 1000,
            });

            window.location.href = "/flash-sale";
          })
          .catch((error) => {
            this.setApiLoading(false);
            this.validateResError(error);
          });
      } else {
        this.setApiLoading(false);
        return;
        // this.scrollToTop();
        // this.validateResError(error);
      }
    },
    async getDetail() {
      let uri = window.location.href.split("/");
      let uriLast = uri.length - 1;
      let res = await axios.get(`/flash_sales/${uri[uriLast]}`);

      res = res.data.data;
      console.log("res", res);
      this.form_data.id = res.id;

      this.form_data.discount_type_id = res.discount_type;
      if (res.flashsaleable_type == "style") {
        this.form_data.discount_type_id = {
          id: 2,
          name: "Style",
          value: "style",
        };
      } else {
        this.form_data.discount_type_id = {
          id: 1,
          name: "Product",
          value: "product",
        };
      }

      this.form_data.start_date = this.momentFormat.stringify(res.start_date);
      this.form_data.end_date = this.momentFormat.stringify(res.end_date);
      this.form_data.start_time = res.start_time;
      this.form_data.end_time = res.end_time;
      this.form_data.min_buying_amount = res.min_buying_amount;

      if (res.flashsaleable_type == "sub_product") {
        res.flash_sale_sub_products.forEach((sub) => {
          let payload = {
            local_id: Math.random().toString(36).slice(2), //for local edit
            is_new: false,
            item: sub.sub_product,
            quantity: sub.quantity,
            type: res.flashsaleable_type,
            max_buying_count: sub.max_buying_count,
            discount_value: sub.discount_value,
          };
          this.setPromotionItems(payload);
        });
      } else {
        res.flash_sale_styles.forEach((sty) => {
          let payload = {
            local_id: Math.random().toString(36).slice(2), //for local edit
            is_new: false,
            item: sty.style,
            quantity: sty.quantity,
            type: res.flashsaleable_type,
            max_buying_count: sty.max_buying_count,
            discount_value: sty.discount_value,
          };
          this.setPromotionItems(payload);
        });
      }
    },

    format_date(value) {
      if (value) {
        return moment(String(value)).format("D MMM-YYYY");
      }
    },
    changeIsBasedOnAmount() {
      this.form_data.min_buying_amount = "";
    },
    changeIsBasedOnAmountPerUser() {
      this.form_data.max_buying_count = "";
    },
    changeIsUnlimited() {
      this.form_data.quantity = "";
    },
  },

  mounted() {
    if (this.isediting == "edit") {
      this.getDetail();
    }
  },
};
</script>

<style></style>
