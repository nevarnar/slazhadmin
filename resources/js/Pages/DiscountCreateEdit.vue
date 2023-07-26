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
        <div class="col-span-2" v-if="form_data.is_flash_sale">
          <label for="" class="form-label label-form">Starting Hour</label>
        </div>
        <div class="col-span-1" v-if="form_data.is_flash_sale">
          <!-- free space for grid -->
        </div>
        <div class="col-span-3" v-if="!form_data.is_flash_sale"></div>

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

          <!-- <label class="checkbox-container"
            >Flash Sale
            <input type="checkbox" v-model="form_data.is_flash_sale" />
            <span class="flashsale-check"></span>
          </label> -->
        </div>
        <div class="col-span-2 mb-3" v-if="form_data.is_flash_sale">
          <div class="form-group mb-6 mt-2">
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
        <div class="col-span-1" v-if="form_data.is_flash_sale">
          <!-- free space for grid -->
        </div>
        <div class="col-span-3" v-if="!form_data.is_flash_sale"></div>
        <!-- end row -->

        <!-- start row -->
        <div class="col-span-2">
          <label for="" class="form-label label-form">Discount Type</label>
        </div>

        <div
          v-show="form_data?.discount_type_id?.name != 'Delivery Free'"
          class="col-span-2"
        >
          <label for="" class="form-label label-form">Promotion Amount</label>
        </div>

        <div
          class="col-span-2"
          v-show="form_data?.discount_type_id?.name == 'Delivery Free'"
        ></div>
        <div class="col-span-3"></div>

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
              @search-change="getDiscountType"
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
        <div
          v-show="form_data?.discount_type_id?.name != 'Delivery Free'"
          class="col-span-2 mb-3"
        >
          <div class="form-group mb-6">
            <input
              v-model="form_data.amount"
              type="number"
              class="form-control input-form mt-2"
              id=""
              placeholder="Promotion Amount"
            />
            <p class="text-red-600 text-xs" v-show="validationMsg.amount">
              {{ validationMsg.amount }}
            </p>
          </div>
        </div>

        <div
          class="col-span-2"
          v-show="form_data?.discount_type_id?.name == 'Delivery Free'"
        ></div>

        <div class="col-span-3"></div>
        <!-- end row -->

        <!-- start row -->

        <div class="col-span-2">
          <label for="" class="form-label label-form"
            >Minimum Buying Amount</label
          >
        </div>
        <div class="col-span-2">
          <label for="" class="form-label label-form">Quantity</label>
        </div>
        <div class="col-span-3">
          <!-- free space for grid -->
        </div>

        <!-- mini -->
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
        <div class="col-span-3">
          <!-- free space for grid  -->
        </div>
        <!-- end row -->

        <!-- Add sku -->
        <div v-if="this.isediting == 'create'" class="contents">
          <div class="col-span-7 mt-3 mb-2">
            <p class="page-tittle">Add SKU</p>
          </div>
          <!-- start row -->
          <div class="col-span-7">
            <label for="" class="form-label label-form">Product Type</label>
          </div>
          <!-- <div class="col-span-5"></div> -->

          <div class="col-span-2">
            <div class="form-group mb-6 mt-2">
              <multiselect
                v-model="form_data.typeValue"
                :options="form_data.typeOptions"
                :searchable="false"
                :close-on-select="true"
                :show-labels="false"
                :allow-empty="false"
                track-by="name"
                label="name"
                placeholder="Choose Type"
                @input="changePromotionType"
              ></multiselect>
              <p class="text-red-600 text-xs" v-show="validationMsg.type">
                {{ validationMsg.type }}
              </p>
            </div>
          </div>

          <!-- <div class="col-span-5"></div> -->
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

      <discount-item-table :isediting="isediting" />

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

    <!-- modal -->
    <div
      ref="modal"
      class="modal fade primary-modal"
      id="delete_modal"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-box">
        <div class="modal-content content-modal" style="width: auto">
          <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-black primary-font text-lg font-semibold">
              Warning!
            </p>
          </div>
          <form>
            <div class="modal-body px-2 mx-2">
              <div class="block p-6 pt-3 rounded-lg bg-white">
                <div class="mb-4">
                  <p class="text-sm primary-font">
                    These products are different from other products in
                    promotion details. Are you sure to continue
                  </p>
                </div>
                <div class="mb-3 pb-2 border-b">
                  <div class="form-check inline-block ml-3 mr-2">
                    <input
                      :checked="form_data.warning_all_checked"
                      v-model="form_data.warning_all_checked"
                      @change="warning_all_checked_change($event)"
                      class="form-check-input input-check mt-1 float-center"
                      type="checkbox"
                      value=""
                    />
                  </div>
                  <div class="inline-block">
                    <button
                      class="btn-clear text-sm primary-font"
                      type="button"
                      @click="warningDelete"
                    >
                      Delete
                    </button>
                  </div>
                </div>
                <div>
                  <table class="primary-table">
                    <tbody>
                      <tr
                        v-for="(sub, idx) in form_data.update_discounts"
                        :key="idx"
                        style="border: none"
                      >
                        <td style="padding-left: 0">
                          <div
                            v-if="form_data.warning_all_checked"
                            class="form-check inline-block ml-3 mr-2"
                          >
                            <input
                              :checked="sub.checked"
                              v-model="sub.checked"
                              class="
                                form-check-input
                                input-check
                                my-0
                                float-center
                              "
                              type="checkbox"
                              value=""
                            />
                          </div>
                          <span v-if="!form_data.warning_all_checked">{{
                            ++idx
                          }}</span>
                        </td>
                        <td>
                          {{ sub.product.name_translations[0].name }}
                        </td>
                        <td>
                          {{ sub.sku }}
                        </td>
                        <td>hm</td>
                        <td>
                          {{
                            sub.product.thing.sub_categories[0]
                              .name_translations[0].name
                          }}
                        </td>
                        <td>Sub Products</td>
                        <td>
                          <button
                            type="button"
                            title="Delete"
                            class=""
                            @click="deleteUpdateDiscounts([sub.id])"
                          >
                            <i class="fal fa-trash-alt"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="modal-footer modal-btn-container">
              <button
                type="button"
                class="primary-button bg-black"
                data-bs-dismiss="modal"
                @click="confirmUpdateDiscount"
              >
                Confirm
              </button>
            </div>
          </form>
        </div>
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
export default {
  name: "DiscountCreateEdit",
  components: {
    Multiselect,
    VueTimepicker,
    apiLoading,
    DatePicker,
    DiscountItemTable,
  },
  props: {
    isediting: String,
  },
  data() {
    return {
      form_data: {
        id: "",
        quantity: "",
        start_date: "",
        end_date: "",
        start_time: "",
        amount: "",
        is_flash_sale: false,
        is_based_on_amount: false, //true
        min_buying_amount: "", //must type
        is_unlimited: false,
        discount_type_id: null,
        discountTypeOptions: [],
        itemValue: "",
        itemOptions: [],
        promotionCategoryValue: "",
        promotionCategoryOptions: [],
        typeValue: null,
        typeOptions: [
          { name: "Product", value: "product" },
          { name: "Style", value: "style" },
          { name: "Series", value: "series" },
          { name: "Brand", value: "brand" },
          { name: "SubCategory", value: "sub_category" },
        ],
        warning_all_checked: false,
        update_discounts: [],
        update_discount_items: [],
        tem_payload: null,
        // promotionTypeValue: null,
        // promotionTypeOptions: [
        //   { name: "Series", value: "series" },
        //   { name: "Brand", value: "brands" },
        // ],
      },
      successValidationRules: false,
      validationMsg: {
        start_time: "",
        start_date: "",
        end_date: "",
        discount_type: "",
        min_buying_amount: "",
        name: "",
        quantity: "",
        amount: "",
        type: "",
        promotion_type: "",
        promotion_category: "",
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
    },
  },
  methods: {
    ...mapActions(["getApiData", "postWebForm", "actionPromotionCategory"]),
    ...mapMutations(["setApiLoading", "setPromotionItems"]),
    customItemLabel(option) {
      if (this.form_data.typeValue.value == "product") {
        return `${option.product.name_translations[0].name} - ${option.sku} `;
      } else if (this.form_data.typeValue.value == "style") {
        return `${option.name_translations[0].name} - ${option.item_code} `;
      } else if (this.form_data.typeValue.value == "brand") {
        return `${option.name_translations[0].name} - ${option.sku_name} `;
      } else {
        return `${option.name_translations[0].name} `;
      }
      // return this.form_data.typeValue.value=='product'? `${option.product.name_translations[0].name} - ${option.sku} ` : `${option.name_translations[0].name} - ${option.item_code} `
    },
    customLabel(option) {
      return `${option.name_translations[0].name}`;
    },
    async getDiscountType() {
      this.getApiData({
        url: `get_discount_type`,
      }).then((res) => {
        this.form_data.discountTypeOptions = res.data.data;
      });
    },
    async asyncFindItem(query) {
      let payload = {
        url: `get_item_with_type_in_stock?search_input=${query}&type=${this.form_data.typeValue.value}`,
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
    getPromotionCategory() {
      if (
        this.form_data.typeValue == null ||
        this.form_data.promotionTypeValue == null
      ) {
        return;
      }
      let payload = {
        url: `get_promotion_category?type=${this.form_data.typeValue.value}&promotion_type=${this.form_data.promotionTypeValue.value}`,
      };
      this.getApiData(payload).then((res) => {
        this.form_data.promotionCategoryOptions = res.data.data;
      });
    },
    getPromotionItem() {
      if (
        this.form_data.typeValue == null ||
        this.form_data.promotionCategoryValue == null ||
        this.form_data.promotionTypeValue == null
      ) {
        return;
      }
      let payload = {
        url: `get_sub_product_by_series_and_brand?type=${this.form_data.typeValue.value}&promotion_category=${this.form_data.promotionCategoryValue.id}&promotion_type=${this.form_data.promotionTypeValue.value}`,
      };
      this.getApiData(payload).then((res) => {
        this.form_data.itemOptions = res.data.data;
      });
    },
    setEmptyField() {
      this.form_data.discount_type_id = "";
      this.form_data.quantity = "";
      this.form_data.amount = "";
      this.form_data.typeValue = "";
      this.form_data.promotionTypeValue = "";
      this.form_data.promotionCategoryValue = "";
      this.form_data.itemValue = "";
    },
    addItemValidation() {
      // if (this.form_data.amount == "") {
      //     this.validationMsg.amount = "Amount is required.";
      //     this.successValidationRules = false;
      //   }
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
      if (this.form_data.typeValue == "" || this.form_data.typeValue == null) {
        this.validationMsg.type = "Type is required.";
        this.successValidationRules = false;
      }
    },
    async addHandler() {
      this.addItemValidation();
      // this.form_data.typeValue &&  this.form_data.amount && this.form_data.quantity &&
      if (this.form_data.discount_type_id) {
        if (
          this.form_data.itemValue == "" ||
          this.form_data.itemValue == null
        ) {
          this.form_data.itemOptions.forEach((item) => {
            if (
              this.addPromotionItemRows.some(
                (data) => data.item.id === item.id
              ) &&
              this.addPromotionItemRows.some(
                (data) => data.type_value === this.form_data.typeValue.value
              )
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
          if (
            this.addPromotionItemRows.some(
              (data) => data.item.id === this.form_data.itemValue.id
            ) &&
            this.addPromotionItemRows.some(
              (data) => data.type_value === this.form_data.typeValue.value
            )
          ) {
            this.$swal("Error!", "Item already exits.", "error");
            return;
          }
          console.log("before add", this.form_data.itemValue);
          this.addRow(this.form_data.itemValue);
        }
      }

      // let payload = {
      //     local_id: Math.random().toString(36).slice(2), //for local edit
      //     item: this.form_data.itemValue,
      //     discount_type:this.form_data.discount_type_id,
      //     amount: this.form_data.amount,
      //     quantity: this.form_data.quantity,
      //     type:this.form_data.typeValue.value,
      //     promotion_type:this.form_data.promotionTypeValue.value,
      //     promotion_category:this.form_data.promotionCategoryValue.id,
      // };
      // this.setPromotionItems(payload);

      // let form_data=new FormData();
      // form_data.append("sub_product_id", this.itemValue.id);
      // let data = {
      //     url: "discounts/validate_sub_product",
      //     form_data: form_data,
      // };
      // await this.postWebForm(data)
      //     .then((res) => {
      //         if(this.successValidationRules==true){
      //             let payload = {
      //                 local_id: Math.random().toString(36).slice(2), //for local edit
      //                 item: this.itemValue,
      //                 discount_type:this.discount_type_id,
      //                 amount: this.amount,
      //                 quantity: this.quantity,
      //             };
      //             this.setSubProductRow(payload);
      //         }
      //     })
      //     .catch((error) => {
      //         this.setApiLoading(false);
      //         this.validateResError(error);
      //     });
      //   }
      //    else {
      //     this.$swal({
      //       icon: "warning",
      //       title: "Warining",
      //       text: "Fill all required fields.",
      //       showConfirmButton: false,
      //       timer: 1000,
      //     });
      //   }
    },
    addRow(data) {
      // this.validateDiscountAmountAndQuantity(data);
      //   console.log('de',data.total_style_price);

      //   if(this.form_data.typeValue.value=='product'){
      //     var original_price= data?.product_prices.price
      //   }
      //   if(this.form_data.typeValue.value=='style'){
      //     var original_price= data?.total_style_price;
      //   }
      //   let discounted_price=this.calPrice(original_price);

      let payload = {
        local_id: Math.random().toString(36).slice(2), //for local edit
        item: data,
        start_date:this.form_data.start_date,
        end_date:this.form_data.end_date,
        discount_type: this.form_data.discount_type_id.id,
        // amount: this.form_data.amount,
        quantity: parseInt(this.form_data.quantity),
        // type:this.form_data.typeValue.value,
        type:
          this.form_data.typeValue.value == "product"
            ? "sub_product"
            : this.form_data.typeValue.value,
        type_value: this.form_data.typeValue.value,
        update_discounts: null,
        // promotion_type: this.form_data.promotionTypeValue.value,
        // promotion_category: this.form_data.promotionCategoryValue.id,
        // discounted_price:discounted_price,
        // original_price : original_price,
      };

      let data_form = {
        url: "discounts/validate_sub_product",
        form_data: payload,
      };
      this.postWebForm(data_form)
        .then((res) => {
          console.log("model", res.data.data);
          if (res.data.data.length > 0) {
            const newArr = res.data.data.map((v) => ({
              ...v,
              checked: 1,
            }));
            this.form_data.update_discounts = newArr;
            if (payload.type != "sub_product") {
              newArr.forEach((subb) => {
                let deleteIndex = payload.item.sub_products.findIndex(
                  (i) => i.id === subb.id
                );
                payload.item.sub_products.splice(deleteIndex, 1);
              });
            }
            this.form_data.tem_payload = payload;
            $("#delete_modal").modal("show");
          } else {
            this.setPromotionItems(payload);
            this.form_data.itemValue = null;
            this.form_data.itemOptions = [];
          }
        })
        .catch((error) => {
          this.$swal("Error!", error.response.data.message, "error");
        });
    },
    validateDiscountAmountAndQuantity(itemValue) {
      this.successValidationRules = true;
      if (parseInt(itemValue.quantity) < this.form_data.quantity) {
        this.$swal(
          "Error!",
          "Quantity must be less than " + itemValue.quantity + " in stock"
        );
        this.successValidationRules = false;
        // this.quantity=this.addMySubProductRows[0].quantity;
        return;
      }
      if (this.form_data?.discount_type_id?.name == "Percentage") {
        if (this.form_data?.amount > 100) {
          this.$swal("Error!", "Amount must be less than 100");
          this.form_data.amount = "";
          this.successValidationRules = false;
          //   if (this.isediting == "edit") {
          //     this.amount = this.addMySubProductRows[0].amount;
          //   }
          return;
        }
        // }
      } else if (this.form_data.discount_type_id.name == "Fixed") {
        if (itemValue.product_prices.price < this.form_data.amount) {
          this.successValidationRules = false;
          this.$swal(
            "Error!",
            "Amount must be less than " + itemValue.product_prices.price
          );
          //   if (this.isediting == "edit") {
          //     this.amount = this.addMySubProductRows[0].amount;
          //   }
          return;
        }
      }
    },
    calPrice(original_price) {
      if (original_price == undefined) {
        return 0;
      }
      console.log(
        "dis",
        original_price - (original_price.price * this.form_data.amount) / 100
      );
      if (this.form_data.typeValue.value == "product") {
        return this.form_data.discount_type_id.name === "Percentage"
          ? original_price - (original_price * this.form_data.amount) / 100
          : original_price - this.form_data.amount;
      } else {
        return this.form_data.discount_type_id.name === "Percentage"
          ? original_price -
              (original_price.price * this.form_data.amount) / 100
          : original_price - this.form_data.amount;
      }
    },
    validateResError(error) {
      if (error.response.data.message != null) {
        this.successValidationRules = false;
        this.$swal("Error!", error.response.data.message, "error");
        return;
      }
    },
    resetvalidateRulesMsg() {
      this.validationMsg.discount_type = "";
      this.validationMsg.start_date = "";
      this.validationMsg.end_date = "";
      this.validationMsg.name = "";
      this.validationMsg.amount = "";
      this.validationMsg.quantity = "";
      this.validationMsg.start_time = "";
      this.validationMsg.min_buying_amount = "";
    },
    validateRules() {
      this.successValidationRules = true;
      this.resetvalidateRulesMsg();
      if (this.form_data.discount_type_id == null) {
        this.validationMsg.discount_type = "Discount Type is required.";
        this.successValidationRules = false;
      }
      if (this.form_data.start_date == "") {
        this.validationMsg.start_date = "Start Date is required.";
        this.successValidationRules = false;
      }
      if (this.form_data.end_date == "") {
        this.validationMsg.end_date = "End Date is required.";
        this.successValidationRules = false;
      }
      if (this.form_data.is_flash_sale == true) {
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
      }
      if (
        this.form_data?.discount_type_id?.name != "Delivery Free" &&
        this.form_data.amount == ""
      ) {
        this.validationMsg.amount = "Amount is required.";
        this.successValidationRules = false;
      } else if (
        this.form_data?.discount_type_id?.name == "Percentage" &&
        this.form_data?.amount >= 100
      ) {
        this.validationMsg.amount = "Percentage amount must be less than 100%";
        this.successValidationRules = false;
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
      if (
        this.form_data.quantity == "" &&
        this.form_data.is_unlimited == false
      ) {
        this.validationMsg.quantity = "Quantity is required.";
        this.successValidationRules = false;
      }
      if (
        this.form_data.is_unlimited == false &&
        this.addPromotionItemRows.length == 0
      ) {
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
        } else {
          var sub_products = [];
          var styles = [];
          var update_discount_items = [];
          this.addPromotionItemRows.forEach((row) => {
            if (row.update_discounts) {
              update_discount_items = [
                ...update_discount_items,
                ...row.update_discounts,
              ];
            }
            if (row.type == "sub_product") {
              sub_products.push(row.item);
            }
            if (row.type == "style") {
              styles.push(row.item);
            }
            if (
              row.type == "series" ||
              row.type == "brand" ||
              row.type == "sub_category"
            ) {
              row.item.sub_products.forEach((sub) => {
                sub_products.push(sub);
              });
            }
          });
          formData.append("sub_products", JSON.stringify(sub_products));
          formData.append("styles", JSON.stringify(styles));
          formData.append(
            "update_discount_items",
            JSON.stringify(update_discount_items)
          );
        }

        formData.append("start_date", this.form_data.start_date);
        formData.append("end_date", this.form_data.end_date);
        formData.append("start_time", this.form_data.start_time);
        formData.append("discount_type_id", this.form_data.discount_type_id.id);
        formData.append(
          "is_flash_sale",
          this.form_data.is_flash_sale == true ? 1 : 0
        );
        if (this.form_data?.discount_type_id?.name == "Delivery Free") {
          formData.append("amount", null);
        } else {
          formData.append("amount", this.form_data.amount);
        }
        formData.append(
          "is_based_on_amount",
          this.form_data.is_based_on_amount
        );

        formData.append("quantity", this.form_data.quantity);
        formData.append("is_unlimited", this.form_data.is_unlimited);

        formData.append("min_buying_amount", this.form_data.min_buying_amount);
        this.setApiLoading(true);
        let payload = {
          url: "discounts/createOrUpdate",
          form_data: formData,
        };
        this.postWebForm(payload)
          .then((res) => {
            this.setApiLoading(false);
            this.$swal({
              icon: "success",
              title: "Created!",
              text: `Discount has been ${this.isediting}d`,
              showConfirmButton: false,
              timer: 1000,
            });
            window.location.href = "/discount_index";
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
      let res = await axios.get(`/discounts/${uri[uriLast]}`);

      res = res.data.data;
      console.log("res", res);
      this.form_data.id = res.id;
      if (!res.quantity){
        this.form_data.quantity = "";
        this.form_data.is_unlimited = true;
      }
      this.form_data.discount_type_id = res.discount_type;
      this.form_data.start_date = this.momentFormat.stringify(res.start_date);
      this.form_data.end_date = this.momentFormat.stringify(res.end_date);
      this.form_data.start_time = res.start_time;
      this.form_data.min_buying_amount = res.min_buying_amount;
      this.form_data.is_flash_sale = res.is_flash_sale;
      this.form_data.amount = res.discount_value;
      this.form_data.quantity = res.quantity;

      let payload = {
        local_id: Math.random().toString(36).slice(2), //for local edit
        item: res.discountable,
        discount_type: this.form_data.discount_type_id.id,
        type: res.discountable_type,
      };
      this.setPromotionItems(payload);
      this.form_data.itemValue = null;
      this.form_data.itemOptions = [];
    },
    warning_all_checked_change() {
      console.log(
        "change wwarning_all_checked",
        this.form_data.warning_all_checked
      );
      this.form_data.update_discounts.forEach((sub) => {
        sub.checked = this.form_data.warning_all_checked;
      });
    },
    warningDelete() {
      if (!this.form_data.warning_all_checked) {
        return;
      }
      var deleteSubArr = [];
      this.form_data.update_discounts.forEach((sub) => {
        if (sub.checked) {
          deleteSubArr.push(sub.id);
        }
      });
      if (deleteSubArr.length == 0) {
        return;
      }
      this.deleteUpdateDiscounts(deleteSubArr);
    },
    deleteUpdateDiscounts(subIds) {
      if (subIds.length == 0) {
        return;
      }
      var filterSubs = this.form_data.update_discounts.filter((el) => {
        return !subIds.includes(el.id);
      });
      this.form_data.update_discounts = filterSubs;
    },
    confirmUpdateDiscount() {
      if (this.form_data.warning_all_checked) {
        var filter_sub = this.form_data.update_discounts.filter((el) => {
          return el.checked == true;
        });
      } else {
        var filter_sub = this.form_data.update_discounts;
      }
      if (filter_sub.length == 0) {
        return 0;
      }
      filter_sub.forEach((s) => {
        this.form_data.update_discount_items.push(s);
      });
      if (this.form_data.tem_payload == null) {
        return;
      }
      this.form_data.tem_payload.update_discounts = filter_sub;
      this.setPromotionItems(this.form_data.tem_payload);
      this.form_data.itemValue = null;
      this.form_data.itemOptions = [];
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("D MMM-YYYY");
      }
    },
    changeIsBasedOnAmount() {
      this.form_data.min_buying_amount = "";
    },
    changeIsUnlimited() {
      this.form_data.quantity = "";
    },
  },

  mounted() {
    if (this.isediting == "edit") {
      this.getDetail();
    }
    this.getDiscountType();
  },
};
</script>

<style></style>
