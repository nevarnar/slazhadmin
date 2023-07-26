<template>
  <div class="inner-main-container">
    <div class="pl-2 flex justify-between">
      <p class="page-tittle">
        {{ isediting == "edit" ? "Edit Variation" : "Create Variation" }}
      </p>
      <div>
          <button
            :disabled="currentApiLoading"
            v-show="isediting == 'create'"
            @click="newVariation"
            type="button"
            class="primary-button bg-black inline-block px-4"
          >
            <api-loading />

            Create
          </button>
          <button
            :disabled="currentApiLoading"
            v-show="isediting == 'edit'"
            @click="edit_variation"
            type="button"
            class="primary-button bg-black inline-block px-4"
          >
            <api-loading />

            Save
          </button>
        </div>
    </div>
    <div class="pt-3 mb-6">
      <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2">
        <!-- start row -->
        <div class="col-span-7">
          <label for="engName" class="form-label label-form"
            >Variation Name</label
          >
        </div>
        <div class="col-span-2">
          <div class="form-group mb-4">
            <input
              v-model="formData.name.name"
              type="text"
              class="form-control input-form mt-3 px-3 py-1.5"
              placeholder="In English"
              :class="validationMsg.name ? 'border-red-500' : 'border-gray-300'"
            />
            <p class="text-red-600 text-xs" v-show="validationMsg.name">
              {{ validationMsg.name }}
            </p>
          </div>
        </div>
        <div class="col-span-2">
          <div class="form-group mb-4">
            <input
              v-model="formData.mm_name.name"
              type="text"
              class="form-control input-form mt-3 px-3 py-1.5"
              id="mmName"
              placeholder="In Myanmar"
              :class="
                validationMsg.mm_name ? 'border-red-500' : 'border-gray-300'
              "
            />
            <p class="text-red-600 text-xs" v-show="validationMsg.mm_name">
              {{ validationMsg.mm_name }}
            </p>
          </div>
        </div>
        <div class="">
          <!-- 3rd grid space -->
        </div>
        <!-- end row -->

        <div class="col-span-7">
          <hr class="my-2 h-0.5" />
        </div>

        <!-- start row -->
        <div class="col-span-7">
          <label for="subEngName" class="form-label label-form"
            >Sub Variation Name</label
          >
        </div>
        <div class="col-span-2">
          <div class="form-group mb-4">
            <input
              v-model="new_sub_variation.sub_variation_name.name"
              type="text"
              class="form-control input-form mt-3 px-3 py-1.5"
              id="sub_variation_name"
              placeholder="In English"
            />
          </div>
        </div>
        <div class="col-span-2">
          <div class="form-group mb-4">
            <input
              v-model="new_sub_variation.sub_variation_mm_name.name"
              type="text"
              class="form-control input-form mt-3 px-3 py-1.5"
              id="sub_variation_mm_name"
              placeholder="In Myanmar"
            />
          </div>
        </div>
        <div class="">
          <button
            @click="addSubVariation"
            type="button"
            class="mt-3 primary-button"
          >
            Add
          </button>
        </div>
        <div class="col-span-2"></div>
        <!-- end row -->

        <!-- start row -->
        <div
          class="contents"
          v-for="sub_variation in sub_variations"
          :key="sub_variation.id"
        >
          <div class="col-span-2">
            <p
              v-show="!sub_variation.isEditingNow"
              class="text-gray-600 pt-2 text-table text-left pl-3"
            >
              {{ sub_variation.sub_variation_name.name }}
            </p>
            <input
              v-show="sub_variation.isEditingNow"
              v-model="edit_sub_variation.sub_variation_name.name"
              type="text"
              class="
                form-control
                input-form
                block
                w-full
                px-3
                py-1.5
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700
                focus:bg-white
                focus:border-blue-600
                focus:shadow-none
                focus:outline-none
              "
              placeholder=""
            />
          </div>
          <div class="col-span-2">
            <p
              v-show="!sub_variation.isEditingNow"
              class="text-gray-600 pt-2 text-table text-left pl-3"
            >
              {{ sub_variation.sub_variation_mm_name.name }}
            </p>
            <input
              v-show="sub_variation.isEditingNow"
              v-model="edit_sub_variation.sub_variation_mm_name.name"
              type="text"
              class="
                form-control
                input-form
                block
                w-full
                px-3
                py-1.5
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700
                focus:bg-white
                focus:border-blue-600
                focus:shadow-none
                focus:outline-none
              "
              placeholder=""
            />
          </div>
          <div class="col-span-3" v-show="!sub_variation.isEditingNow">
            <div class="w-full text-left pl-3">
              <button
                @click="subVariationEdit(sub_variation)"
                type="button"
                class="btn-clear mr-3"
                title="Edit"
                id="edit-button"
              >
                <i class="fal fa-pen fw300" style="color: #68728c"></i>
              </button>
              <button
                @click="removeSubVariation(sub_variation)"
                type="button"
                class="btn-clear"
                title="Delete"
                id="delete-button"
              >
                <i class="fal fa-times fw300" style="color: #68728c"></i>
              </button>
            </div>
          </div>

          <div v-show="sub_variation.isEditingNow" class="col-span-3">
            <div class="w-full text-left">
              <button
                @click="subVariationUpdate"
                type="button"
                class="btn-clear mr-3 pl-4"
                title="Add"
                id=""
              >
                <i class="fal fa-check fw300" style="color: #68728c"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="col-span-7 mt-2">
          <hr class="my-2 h-0.5" />
        </div>
        <!-- start row -->
        <div class="col-span-7">
          <label for="engName" class="form-label label-form"
            >Product Sub Category</label
          >
        </div>
        <div class="col-span-4">
          <div class="form-group mb-4 h-16">
            <multiselect
              v-model="subCategoryValue"
              :options="subCategoryOptions"
              :multiple="true"
              :close-on-select="true"
              :clear-on-select="true"
              :preserve-search="true"
              :custom-label="customLabel"
              track-by="id"
              placeholder="Choose Subcategories"
              :preselect-first="true"
            >
            </multiselect>
            <p
              class="text-red-600 text-xs"
              v-show="validationMsg.sub_categories_ids"
            >
              {{ validationMsg.sub_categories_ids }}
            </p>
          </div>
        </div>

        <div class="col-span-3">
          <!-- 2rd grid space -->
        </div>
        <!-- end row -->

        
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";

import Multiselect from "vue-multiselect";
export default {
  name: "variationCreateEdit",
  components: {
    Multiselect,
    apiLoading,
  },
  props: {
    isediting: String,
  },

  data() {
    return {
      formData: {
        id: "",
        name: {
          name: "",
          language_code: "en",
        },
        mm_name: {
          name: "",
          language_code: "mm",
        },
      },
      new_sub_variation: {
        id: null,
        local_id: null,
        isEditingNow: false,
        sub_variation_name: {
          name: "",
          language_code: "en",
        },
        sub_variation_mm_name: {
          name: "",
          language_code: "mm",
        },
      },
      edit_sub_variation: {
        id: null,
        local_id: null,
        isEditingNow: false,
        sub_variation_name: {
          name: "",
          language_code: "en",
        },
        sub_variation_mm_name: {
          name: "",
          language_code: "mm",
        },
      },
      isOneSubVariationEditing: false,
      sub_variations: [],

      validationMsg: {
        name: "",
        mm_name: "",
        sub_categories_ids: "",
        sub_variations: "",
      },
      subCategoryValue: [],
      subCategoryOptions: [],
    };
  },
  computed: {
    ...mapGetters(["currentApiLoading"]),
  },
  methods: {
    ...mapActions(["updateOrCreateVariation", "search"]),
    ...mapMutations(["setApiLoading"]),
    customLabel(option) {
      return `${option.name_translations[0].name}`;
    },
    addSubVariation() {
      if (
        this.new_sub_variation.sub_variation_name.name &&
        this.new_sub_variation.sub_variation_mm_name.name
      ) {
        if (this.sub_variations.length) {
          var lastVariationArr = this.sub_variations.length - 1;
          var newSubVariationId =
            this.sub_variations[lastVariationArr].local_id + 1;
        } else {
          var newSubVariationId = 1;
        }
        this.new_sub_variation.local_id = newSubVariationId;
        this.sub_variations.push(this.new_sub_variation);
        this.new_sub_variation = {
          id: null,
          local_id: null,
          isEditingNow: false,
          sub_variation_name: {
            name: "",
            language_code: "en",
          },
          sub_variation_mm_name: {
            name: "",
            language_code: "mm",
          },
        };
        $("#sub_variation_name").focus();
      }
    },
    removeSubVariation(sub_variation) {
      const deleteItem = this.sub_variations.findIndex(
        (item) => item.local_id === sub_variation.local_id
      );
      this.sub_variations.splice(deleteItem, 1);
    },
    subVariationEdit(sub_variation) {
      if (!this.isOneSubVariationEditing) {
        //none of subvariation is edition
        this.edit_sub_variation = sub_variation;
        this.isOneSubVariationEditing = true;

        const editItem = this.sub_variations.find(
          (item) => item.local_id === sub_variation.local_id
        );
        editItem.isEditingNow = true;
      } else {
        this.$swal("Error!", "Updated the first one.", "error");
      }
    },
    subVariationUpdate() {
      const updateItem = this.sub_variations.find(
        (item) => item.local_id === this.edit_sub_variation.local_id
      );
      updateItem.isEditingNow = false;
      updateItem.sub_variation_name.name =
        this.edit_sub_variation.sub_variation_name.name;
      updateItem.sub_variation_mm_name.name =
        this.edit_sub_variation.sub_variation_mm_name.name;
      this.isOneSubVariationEditing = false;
    },
    validateRules() {
      if (this.formData.name.name.trim() === "") {
        this.validationMsg.name = "Name is required.";
      }
      if (this.formData.mm_name.name.trim() === "") {
        this.validationMsg.mm_name = "Name(mm) is required.";
      }
      if (this.subCategoryValue.length == 0) {
        this.validationMsg.sub_categories_ids = "Subcategories are required.";
      }
      if (this.sub_variations.length == 0) {
        this.validationMsg.sub_variations = "Subvariations are required.";
      }
    },
    //for create form & edit form
    formDataToSubmit() {
      let form_data = new FormData();
      if (this.isediting == "edit") {
        form_data.append("id", this.formData.id);
      }
      let submitData = [this.formData.name, this.formData.mm_name];

      let sub_categories_ids = [];
      this.subCategoryValue.forEach((subcategory) => {
        sub_categories_ids.push(subcategory.id);
      });
      form_data.append("data", JSON.stringify(submitData));
      form_data.append("sub_category_ids", JSON.stringify(sub_categories_ids));
      let sub_variation_arr = [];
      this.sub_variations.forEach((sub_variation) => {
        let sub_variation_obj = {
          id: null,
          names: [],
        };
        sub_variation_obj.names.push(
          sub_variation.sub_variation_name,
          sub_variation.sub_variation_mm_name
        );
        sub_variation_obj.id = sub_variation.id;
        sub_variation_arr.push(sub_variation_obj);
      });
      form_data.append("sub_variations", JSON.stringify(sub_variation_arr));
      return form_data;
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
      }
    },
    async newVariation(e) {
      e.preventDefault;
      this.validateRules();
      if (
        this.formData.name.name &&
        this.formData.mm_name.name &&
        this.subCategoryValue &&
        this.sub_variations.length > 0
      ) {
        let form_data = this.formDataToSubmit();

        let payload = { form_data: form_data, type: "create" };
        this.setApiLoading(true);

        this.updateOrCreateVariation(payload)
          .then((res) => {
            this.setApiLoading(false);

            this.$swal({
              icon: "success",
              title: "Created!",
              text: "Variation has been created.",
              showConfirmButton: false,
              timer: 1000,
            });
            window.location.href = "/variations_lists";
          })
          .catch((error) => {
            this.scrollToTop();
            this.setApiLoading(false);
            this.validateResError(error);
          });
      } else {
        //without data
      }
    },
    async edit_variation(e) {
      e.preventDefault;
      this.validateRules();
      if (
        this.formData.name.name &&
        this.formData.mm_name.name &&
        this.subCategoryValue.length > 0 &&
        this.sub_variations.length > 0
      ) {
        let form_data = this.formDataToSubmit();
        let payload = {
          form_data: form_data,
          type: "edit",
          edit_id: this.formData.id,
        };
        this.setApiLoading(true);

        this.updateOrCreateVariation(payload)
          .then((res) => {
            this.setApiLoading(false);

            this.$swal({
              icon: "success",
              title: "Edited!",
              text: "Variation has been Edtied.",
              showConfirmButton: false,
              timer: 1000,
            });
            window.location.href = "/variations_lists";
          })
          .catch((error) => {
            this.scrollToTop();
            this.validateResError(error);
          });
      } else {
        //without data
      }
    },

    async getVariationDetail() {
      let uri = window.location.href.split("/");
      let uriLast = uri.length - 1;
      let res = await axios.get(`/variations/${uri[uriLast]}`);
      res = res.data.data;
      this.formData.id = res.id;
      this.subCategoryValue = res.sub_categories;
      res.name_translations.forEach((name_translation) => {
        if (name_translation.language_code == "en") {
          this.formData.name.name = name_translation.name;
        }
        if (name_translation.language_code == "mm") {
          this.formData.mm_name.name = name_translation.name;
        }
      });
      res.sub_variations.forEach((subvariation) => {
        let sub_variation = {
          id: subvariation.id,
          local_id: subvariation.id,
          isEditingNow: false,
          sub_variation_name: {
            name: subvariation.name_translations[0].name,
            language_code: "en",
          },
          sub_variation_mm_name: {
            name: subvariation.name_translations[1].name,
            language_code: "mm",
          },
        };
        this.sub_variations.push(sub_variation);
      });
    },
    async getSubCategories() {
      let res = await axios.get("/get_sub_categories_for_variation");
      this.subCategoryOptions = res.data.data;
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
  },
  //s
  mounted() {
    if (this.isediting == "edit") {
      this.getVariationDetail();
    }
    this.getSubCategories();
  },
};
</script>
