<template>
  <div class="inner-main-container">
    <div>
      <p class="page-tittle">Create Campaign</p>
    </div>
    <div class="pt-6 mb-6">
      <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2">
        <!-- start row -->
        <div class="col-span-2">
          <label for="" class="form-label label-form">Campaign Name</label>
        </div>
        <div class="col-span-5">
          <!-- free space for grid -->
        </div>
        <div class="col-span-2">
          <div class="form-group mb-2">
            <input
            v-model="formData.name.name"
              id=""
              type="text"
              class="form-control input-form mt-2"
              placeholder="In English"
            />
             <p
                class="text-red-600 text-xs"
                v-show="validationMsg.name"
            >
                {{ validationMsg.name }}
            </p>
          </div>
        </div>
        <div class="col-span-2">
          <div class="form-group mb-4">
            <input
              v-model="formData.mm_name.name"

              id=""
              type="text"
              class="form-control input-form mt-2"
              placeholder="In Myanmar"
            />
             <p
                class="text-red-600 text-xs"
                v-show="validationMsg.mm_name"
            >
                {{ validationMsg.mm_name }}
            </p>
          </div>
        </div>
        <div class="col-span-3"></div>
        <!-- end row -->

        <!-- start row -->
        <div class="col-span-4">
          <label for="" class="form-label label-form">Duration</label>
        </div>
        <div class="col-span-3">
          <!-- free space for grid -->
        </div>

        <div class="col-span-2">
          <div class="form-group mb-2">
            <input
            v-model="formData.start_date"
              id="start"
              type="date"
              class="form-control input-form mt-2"
              placeholder="Start Date  "
            />
             <p
                class="text-red-600 text-xs"
                v-show="validationMsg.start_date"
            >
                {{ validationMsg.start_date }}
            </p>
          </div>
        </div>
        <div class="col-span-2">
          <div class="form-group mb-4">
            <input
            v-model="formData.end_date"
              id="end"
              type="date"
              class="form-control input-form mt-2"
              placeholder="End Date  "
            />
            <p
                class="text-red-600 text-xs"
                v-show="validationMsg.end_date"
            >
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
          <label for="" class="form-label label-form">Campaign Photo</label>
          <div class="form-group mb-4">
            <input
            @change="choosePhoto"
              type="file"
              class="form-control input-form mt-2"
              id="promotion"
              placeholder="Promotion Amount"
              accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
            />
             <p
                class="text-red-600 text-xs"
                v-show="validationMsg.photo"
            >
                {{ validationMsg.photo }}
            </p>
          </div>
        </div>

        <div class="col-span-5">
          <!-- free space for grid -->
        </div>
        <!-- end row -->

        <!-- start row -->
        <div class="col-span-6">
          <label for="" class="form-label label-form">Campaign Description</label>
          <div class="form-group mb-4">
            <textarea
              v-model="formData.description_name.name"
              name=""
              class="input-form text-table text-left animated-textarea mt-2"
              id=""
              cols="30"
              rows="7"
              style="border: 1px solid #e5e7eb"
              placeholder="In English"
            ></textarea>
             <p
                class="text-red-600 text-xs"
                v-show="validationMsg.description_name"
            >
                {{ validationMsg.description_name }}
            </p>
          </div>
        </div>

        <div class="col-span-1">
          <!-- free space for grid -->
        </div>
        <div class="col-span-6">
          <div class="form-group mb-4">
            <textarea
              v-model="formData.description_mm_name.name"
              name=""
              class="input-form text-table text-left animated-textarea mt-2"
              id=""
              cols="30"
              rows="7"
              style="border: 1px solid #e5e7eb"
              placeholder="In Myanmar"
            ></textarea>
            <p
                class="text-red-600 text-xs"
                v-show="validationMsg.description_mm_name"
            >
                {{ validationMsg.description_mm_name }}
            </p>
          </div>
        </div>

        <div class="col-span-1">
          <!-- free space for grid -->
        </div>
        <!-- end row -->

        <div class="col-span-7 mb-3">
          <hr class="my-2 h-0.5" />
        </div>
      </div>

      <!-- start row -->
      <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2 mb-4">
        <div class="col-span-2">
          <label for="discount_product" class="form-label label-form"
            >Add Discount Product</label
          >
          <div class="form-group mb-4">
             <multiselect

                v-model="formData.itemValue"
                :options="formData.itemOptions"

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
                v-show="validationMsg.discount_sub_product"
            >
                {{ validationMsg.discount_sub_product }}
            </p>
          </div>
        </div>

        <div class="col-span-5">
          <Button
          @click="addHandler()"
          type="button" class="primary-button bg-black mt-8"
            >Add</Button
          >
        </div>
      </div>
      <!-- end row -->

      <!-- start row -->

      <campaign-create-sub-product-list />
      <!-- <div class="w-full">
        <table class="secondary-table">
          <thead class="secondary-table-thead">
            <tr>
              <th class="sec-thead-th"></th>
              <th class="sec-thead-th">Product Name</th>
              <th class="sec-thead-th">Item Code</th>
              <th class="sec-thead-th">Product Category</th>
              <th class="sec-thead-th">Price</th>
              <th class="sec-thead-th">Dicount Price</th>
              <th class="sec-thead-th"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="sec-table-td">1</td>
              <td class="sec-table-td">Product name</td>
              <td class="sec-table-td">AITT - 2043</td>
              <td class="sec-table-td">Product Category</td>
              <td class="sec-table-td">12000 MMKs</td>
              <td class="sec-table-td">8000 MMKs</td>
              <td class="sec-table-td">
                <button type="button" title="Delete" id="delete-button">
                  <a href="#">
                    <i class="fal fa-trash"></i>
                  </a>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div> -->

      <div class="mb-6">
        <hr class="my-2 h-0.5" />
      </div>
      <!-- end row -->

      <div class="flex justify-end pb-4">
        <button
        @click="onSubmit()"
          type="button"
          class="primary-button bg-black"
          :disabled="currentApiLoading"
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
import VueTimepicker from "vue2-timepicker";
import Multiselect from "vue-multiselect";
import CampaignCreateSubProductList from "./CampaignCreateSubProductList.vue";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
  name: "CampaignCreateEdit",
  components: {
    Multiselect,
    CampaignCreateSubProductList,
    VueTimepicker,
    apiLoading,
  },
  props: {
      isediting: String,
  },
  data() {
    return {
      formData: {
        id: "",
        itemValue:'',
        itemOptions:[],
        start_date: null,
        end_date: null,
        name: {
          name: "",
          language_code: "en",
        },
        mm_name: {
          name: "",
          language_code: "mm",
        },
        description_name: {
          name: "",
          language_code: "en",
        },
        description_mm_name: {
          name: "",
          language_code: "mm",
        },
        photo: {},
      },
      validationMsg: {
          start_date: "",
          end_date: "",
          photo:'',
        name:'',
        mm_name:'',
        description_name:'',
        description_mm_name:'',

      },
    };
  },
  props: {
    isediting: String,
  },
  computed: {
    ...mapGetters(["getDiscountSubProducts", "currentApiLoading"]),
  },
  methods: {
    ...mapActions(["getApiData", "postWebForm"]),
    ...mapMutations([
      "setDiscountSubProductRow",
      "setApiLoading",
    ]),
    customItemLabel(option) {
      return `${option.product.name_translations[0].name} - ${option.sku} `;
    },
    resetvalidateRulesMsg() {
      this.validationMsg.photo = "";
      this.validationMsg.start_date = "";
      this.validationMsg.end_date = "";
      this.validationMsg.name = "";
      this.validationMsg.mm_name = "";
      this.validationMsg.description_mm_name = "";
      this.validationMsg.description_name = "";
      this.validationMsg.discount_sub_product = "";
    },
    validateRules() {
      this.successValidationRules = true;
      this.resetvalidateRulesMsg();
      if (
          Object.keys(this.formData.photo).length <= 0 &&
          this.isediting == "create"
      ) {
          this.validationMsg.photo = "Photo is required";
          this.isValidationSuccess = false;
      }
      if (this.formData.start_date == "" || this.formData.start_date == null) {
        this.validationMsg.start_date = "Start Date is required.";
        this.successValidationRules = false;
      }
      if (this.formData.end_date == "" ||this.formData.end_date == null) {
        this.validationMsg.end_date = "End Date is required.";
        this.successValidationRules = false;
      }
      if (this.formData.name.name.trim() == "" ) {
        this.validationMsg.name = "Eng name is required.";
        this.successValidationRules = false;
      }
       if (this.formData.mm_name.name.trim() == "") {
        this.validationMsg.mm_name = "MM name is required.";
        this.successValidationRules = false;
      }
       if (this.formData.description_name.name.trim() == "") {
        this.validationMsg.description_name = "Description is required.";
        this.successValidationRules = false;
      }
       if (this.formData.description_mm_name.name.trim() == "") {
        this.validationMsg.description_mm_name = "Description is required.";
        this.successValidationRules = false;
      }
      if (this.getDiscountSubProducts.length == 0) {
        this.validationMsg.discount_sub_product = " Discount Product is required.";
        this.successValidationRules = false;
      }
    },
     scrollToTop() {
        window.scrollTo(0, 0);
    },
     async asyncFindItem(query) {
        let payload = {
            url: `discount_sub_product_in_stock?search_input=${query}`,
        };
        this.getApiData(payload).then((res) => {
            this.formData.itemOptions = res.data.data;
        });
    },
     validateResError(error) {
        if (error.response.data.message[0]) {
            error.response.data.message.forEach((nameError) => {
                if (nameError.language_code == "en") {
                    this.validationMsg.name = nameError.message;
                }
                if (nameError.language_code == "mm") {
                    this.validationMsg.mm_name = nameError.message;
                }
            });
        } else {
            if (error.response.data.message.photo != null) {
                this.validationMsg.photo = error.response.data.message.photo;
            }
        }
    },
     choosePhoto(event) {
        if (event.target.files[0].size > 4000000) {
          //4M
          this.$swal({
            icon: "error",
            title: "Error!",
            text: "Size cannot exceed 4M.",
          });
          return;
        }
        this.formData.photo = {
            name: event.target.files[0].name,
            data: event.target.files[0],
        };
    },
     addHandler() {
        if(this.formData.itemValue)
        {
             if (
                this.getDiscountSubProducts.some(
                    (data) => data.item.id === this.formData.itemValue.id
                )
            ) {
                this.$swal("Error!", "Item already exits.", "error");
                return;
            }
            let payload = {
                local_id: Math.random().toString(36).slice(2), //for local edit
                item: this.formData.itemValue,
                discount_type:this.formData.itemValue.discount.discount_type,
                amount: this.formData.itemValue.discount.amount,
            };
            this.setDiscountSubProductRow(payload);
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

    onSubmit() {
        this.validateRules();
             if (this.successValidationRules == false) {
                this.scrollToTop();
                return;
            }
        let form_data = new FormData();
        if (this.isediting == "edit") {
            form_data.append("id", this.formData.id);
        }
        let discount_sub_products = [];
        this.getDiscountSubProducts.forEach((row) => {
            let discount_sub_product = {
                discount_sub_product_id: row.item.discount_sub_product_id,
            };
          discount_sub_products.push(discount_sub_product);
        });
        let name_translations = [this.formData.name, this.formData.mm_name];
        form_data.append("data", JSON.stringify(name_translations));
        let description_names = [
            this.formData.description_name,
            this.formData.description_mm_name,
        ];
        form_data.append("description", JSON.stringify(description_names));
        if (Object.keys(this.formData.photo).length > 0) {
            form_data.append(
                "photo",
                this.formData.photo.data,
                this.formData.photo.name
            );
        }
        form_data.append("discount_sub_products", JSON.stringify(discount_sub_products));
        form_data.append("start_date", this.formData.start_date);
        form_data.append("end_date", this.formData.end_date);
        this.setApiLoading(true);
        let payload = {
            url: "campaigns/createOrUpdate",
            form_data: form_data,
        };
        this.postWebForm(payload)
            .then((res) => {
                this.setApiLoading(false);
                this.$swal({
                    icon: "success",
                    title: this.isediting==='create' ? 'Create!': 'Updated!',
                    text: `Campaign has been added.`,
                    showConfirmButton: false,
                    timer: 1000,
                });

                window.location.href = "/campaign_view";
            })
            .catch((error) => {
              this.scrollToTop();
                this.setApiLoading(false);
                this.validateResError(error);
            });
    },
    async getDetail(){
        var baseUrl = (window.location).href; // You can also use document.URL
        var id = baseUrl.substring(baseUrl.lastIndexOf('/') + 1);
         let res = await axios.get(`/campaigns/${id}`);
        res = res.data.data;
        this.formData.id=res.id;
        this.formData.start_date=res.start_date;
        this.formData.end_date=res.end_date;

        res.name_translations[0].language_code==="en" ? this.formData.name.name=res.name_translations[0].name : this.formData.name.name=res.name_translations[1].name ;
        res.name_translations[1].language_code==="mm" ? this.formData.mm_name.name=res.name_translations[1].name : this.formData.mm_name.name=res.name_translations[0].name ;

        res.description_translations[0].language_code==="en" ? this.formData.description_name.name=res.description_translations[0].name : this.formData.description_name.name=res.description_translations[1].name ;

        res.description_translations[1].language_code==="mm" ? this.formData.description_mm_name.name=res.description_translations[1].name : this.formData._description_mm_name.name=res.name_translations[0].name ;

        res.discount_sub_products.forEach((value)=>{
            console.log(value);
             let payload = {
                local_id: Math.random().toString(36).slice(2), //for local edit
                item: value.sub_product,
                discount_type:value.discount.discount_type,
                amount: value.discount.amount,
            };
            this.setDiscountSubProductRow(payload);
        });
    },
  },
  async mounted() {
      if (this.isediting == "edit") {
        this.getDetail();
      }
  },
};
</script>

<style>
</style>
