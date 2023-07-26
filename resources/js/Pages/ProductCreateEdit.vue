<template>

  <div class="inner-main-container pb-4">
     
    
    <div class="tab-content" id="tabs-tabContentFill">
      <div
        class="tab-pane fade"
        :class="{
          show: !isValidationSuccess,
          active: !isValidationSuccess,
        }"
        id="tabs-first"
        role="tabpanel"
        aria-labelledby="tabs-first-tabJustify"
      >
        <div class="pt-1 mb-6">
          <div>
            <p class="page-tittle mb-3 pl-2">
              {{ isediting == "edit" ? "Edit" : "Create" }}
              Product
            </p>
          </div>
          <div class="grid grid-cols-3 gap-y-2 gap-x-8 mx-2">
            <!-- {{-- product name --}} -->
            <!-- start row -->
            <div class="">
              <div class="form-group mb-4">
                <label for="" class="label-form">Product Name</label>
                <input
                  v-model="formData.name.name"
                  type="text"
                  class="form-control input-form mt-3"
                  id=""
                  placeholder="In English"
                />
                <p class="text-red-600 text-xs" v-show="validationMsg.name">
                  {{ validationMsg.name }}
                </p>
              </div>
            </div>
            <div class="">
              <div class="form-group mb-4">
                <label for="" class="label-form">Product Name</label>
                <input
                  v-model="formData.mm_name.name"
                  type="text"
                  class="form-control input-form mt-3"
                  id=""
                  placeholder="In Myanmar"
                />
                <p class="text-red-600 text-xs" v-show="validationMsg.mm_name">
                  {{ validationMsg.mm_name }}
                </p>
              </div>
            </div>
            <div>
              <!-- for space -->
            </div>
            <div class="">
              <div class="form-group mb-4">
                <label for="subCategoryName" class="label-form"
                  >Product Sub Category</label
                >
                <multiselect
                  class="mt-3"
                  v-model="subCategoryValue"
                  :options="subCategoryOptions"
                  :disabled="isediting == 'edit' ? true : false"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  :custom-label="customLabel"
                  placeholder="Choose subCategory"
                  @input="onSubCategoryGetVariation"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.sub_category_id"
                >
                  {{ validationMsg.sub_category_id }}
                </p>
              </div>
            </div>
            <div class="">
              <div class="form-group mb-4">
                <label for="subCategoryName" class="label-form"
                  >Gender</label
                >
                <multiselect
                  class="mt-3"
                  :options="subCategoryOptions" 
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  :custom-label="customLabel"
                  placeholder="Choose Gender"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.sub_category_id"
                >
                  {{ validationMsg.sub_category_id }}
                </p>
              </div>
            </div>
            <!-- end row -->

            <div class="col-span-full mt-2">
              <hr class="my-2 h-0.5" />
            </div>
            <!-- {{-- sku --}} -->
            <!-- start row -->

            <div class="">
              <div class="form-group mb-4">
                <label for="price" class="label-form">Default Price</label>
                <input
                  v-model="formData.default_price"
                  type="number"
                  class="form-control input-form mt-3"
                  id="default_price"
                  placeholder="MMKs"
                />
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.default_price"
                >
                  {{ validationMsg.default_price }}
                </p>
              </div>
            </div>
            <div class="">
              <div class="form-group mb-4">
                <label for="engName" class="label-form">Tax Class</label>
                <multiselect
                  class="mt-3"
                  v-model="taxClassValue"
                  :options="taxClassOptions"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  label="amount"
                  track-by="id"
                  placeholder="Choose Unit Type"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.taxClass_id"
                >
                  {{ validationMsg.taxClass_id }}
                </p>
              </div>
            </div>
            <!-- end row -->
            <!-- Description -->
            <div class="col-span-2">
              <div class="form-group mb-6">
                <label for="" class="form-label block label-form mb-3"
                  >Product Description</label
                >
                <!-- <textarea
                  v-model="formData.description_name.name"
                  name=""
                  placeholder="In English"
                ></textarea> -->
                <editor
                  v-model="formData.description_name.name"
                  api-key="no-api-key"
                  :init="{
                    height: 500,
                    menubar: false,
                    plugins: [
                      'advlist autolink lists link image charmap print preview anchor',
                      'searchreplace visualblocks code fullscreen',
                      'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar:
                      'undo redo | formatselect | bold italic backcolor | \
                      alignleft aligncenter alignright alignjustify | \
                      bullist numlist outdent indent | removeformat | help'
                  }"
                />
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.description_name"
                >
                  {{ validationMsg.description_name }}
                </p>
              </div>
            </div>
            <div class="col-span-1"></div>
            <div class="col-span-2">
              <div class="form-group mb-6">
                <!-- <textarea
                  v-model="formData.description_mm_name.name"
                  name=""
                  class="animated-textarea input-form text-table text-left"
                  id=""
                  cols="30"
                  rows="7"
                  style="border: 1px solid #e5e7eb"
                  placeholder="In Myanmar"
                ></textarea> -->
                <editor
                  v-model="formData.description_mm_name.name"
                  api-key="no-api-key"
                  :init="{
                    height: 500,
                    menubar: false,
                    plugins: [
                      'advlist autolink lists link image charmap print preview anchor',
                      'searchreplace visualblocks code fullscreen',
                      'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar:
                      'undo redo | formatselect | bold italic backcolor | \
                      alignleft aligncenter alignright alignjustify | \
                      bullist numlist outdent indent | removeformat | help'
                  }"
                />
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.description_mm_name"
                >
                  {{ validationMsg.description_mm_name }}
                </p>
              </div>
            </div>
            <div class="col-span-1"></div>
            <!-- {{-- Brand --}} -->
            <!-- start row -->
            <div class="">
              <div class="form-group mb-4">
                <label for="" class="label-form">Brand</label>
                <multiselect
                  v-model="brandValue"
                  :options="brandOptions"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  :custom-label="customLabel"
                  placeholder="Choose brand"
                ></multiselect>
                <p class="text-red-600 text-xs" v-show="validationMsg.brand_id">
                  {{ validationMsg.brand_id }}
                </p>
              </div>
            </div>
            <div class="">
              <div class="form-group mb-4">
                <label for="engName" class="label-form">Gender</label>
                <multiselect
                  v-model="genderValue"
                  :options="genderOptions"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  label="name"
                  track-by="id"
                  placeholder="Choose Unit Type"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.gender_id"
                >
                  {{ validationMsg.gender_id }}
                </p>
              </div>
            </div>
            <div class="">
              <!-- for grid -->
            </div>
            <!-- end row -->
            <!-- {{-- tag --}} -->
            <!-- start row -->
            <div class="col-span-3">
              <div class="form-group">
                <label for="price" class="label-form">Series (optional)</label>
              </div>
            </div>
            <div class="col-span-2 mb-4">
              <div>
                <multiselect
                  v-model="seriesValues"
                  :options="seriesOptions"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customLabel"
                  placeholder="Choose series"
                  :preselect-first="true"
                  id="tag_ids"
                  track-by="id"
                >
                </multiselect>
              </div>
            </div>

            <div class="col-span-1">
              <button
                class="block"
                title="Add Series"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#add_series"
                data-toggle="modal"
              >
                <i class="fal fa-plus text-gray-700 pr-3 py-2"></i>
              </button>
            </div>
            <div class="col-span-3">
              <div class="form-group">
                <label for="price" class="label-form">Tag</label>
              </div>
            </div>
            <div class="col-span-2 mb-4">
              <div>
                <multiselect
                  v-model="tagValues"
                  :options="tagOptions"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customLabel"
                  placeholder="Choose tags"
                  :preselect-first="true"
                  id="tag_ids"
                  track-by="id"
                >
                </multiselect>
                <p class="text-red-600 text-xs" v-show="validationMsg.tag_ids">
                  {{ validationMsg.tag_ids }}
                </p>
              </div>
            </div>

            <div class="col-span-1">
              <button
                class="block"
                title="Add Tag"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#add_tag"
                data-toggle="modal"
              >
                <i class="fal fa-plus text-gray-700 pr-3 py-2"></i>
              </button>
            </div>
            <!-- end row -->
            <!-- season -->
            <!-- start row -->
            <div class="">
              <div class="form-group mb-4">
                <label for="engName" class="form-label label-form"
                  >Seasons</label
                >
                <multiselect
                  v-model="seasonValue"
                  :options="seasonOptions"
                  :multiple="true"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  label="name"
                  track-by="id"
                  placeholder="Choose Season Type"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.season_id"
                >
                  {{ validationMsg.season_id }}
                </p>
              </div>
            </div>
            <div class="">
              <div class="form-group mb-4">
                <label for="" class="form-label label-form">Occassions</label>
                <multiselect
                  v-model="occasionValue"
                  :options="occasionOptions"
                  :searchable="false"
                  :multiple="true"
                  :close-on-select="true"
                  :show-labels="false"
                  :custom-label="customLabel"
                  placeholder="Choose occasions"
                  track-by="id"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.occasion_id"
                >
                  {{ validationMsg.occasion_id }}
                </p>
              </div>
            </div>
            <div class="">
              <!-- 3rd grid space -->
            </div>
            <!-- end row -->

            <div class="col-span-full mt-2">
              <hr class="my-2 h-0.5" />
            </div>

            <!-- start row -->
            <div class="col-span-3">
              <label for="engName" class="form-label label-form font-normal"
                >Product Variations (optional)</label
              >
              <!-- <p
                                class="text-red-600 text-xs"
                                v-show="validationMsg.product_variation"
                            >
                                {{ validationMsg.product_variation }}
                            </p> -->
            </div>
            <div v-if="productVariation">
              <div
                v-for="(variation, index) in productVariation"
                :key="index"
                class="col-span-2"
              >
                <div class="form-group mb-4">
                  <label
                    for="engName"
                    class="form-label label-form font-extralight"
                    >{{ variation.label[0].name }}</label
                  >
                  <multiselect
                    v-model="productVariation[index].value"
                    :options="productVariation[index].options"
                    :searchable="false"
                    :close-on-select="true"
                    :show-labels="false"
                    :custom-label="customLabel"
                    placeholder="Choose "
                  ></multiselect>
                </div>
              </div>
            </div>

            <div>
              <!-- for grid space -->
            </div>
            <!-- end row -->

            <div class="col-span-full mt-2">
              <hr class="my-2 h-0.5" />
            </div>

            <!-- start row -->
            <div class="col-span-2">
              <div class="form-group mb-4">
                <label for="price" class="form-label label-form"
                  >Product Photo</label
                >
                <input
                  @change="onChange"
                  type="file"
                  ref="iconFile"
                  class="form-control input-form mt-3"
                  accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                />
                <img-preview :img-preview="icon_preview" :delete-image="deleteImage"/>
                <p class="text-red-600 text-xs" v-show="validationMsg.icon">
                  {{ validationMsg.icon }}
                </p>
              </div>
            </div>
            <div></div>

            <!-- end row -->
            <div class="col-span-full mt-2">
              <hr class="my-2 h-0.5" />
            </div>

            <!-- start row -->
            <div class="col-span-2">
              <div class="form-group mb-4">
                <label for="price" class="form-label label-form"
                  >Avaliable Color
                  <span v-if="isediting == 'edit'"
                    >(
                    <span
                      class="text-xs text-badge"
                      v-for="(severColor, index) in severColors"
                      :key="index"
                      >{{ severColor.name_translations[0].name }},</span
                    >
                    )
                  </span>
                </label>

                <multiselect
                  class="mt-2.5"
                  v-model="colorValue"
                  :options="colorOptions"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customLabel"
                  placeholder="Choose colors"
                  :preselect-first="true"
                  id="color_ids"
                  track-by="id"
                >
                </multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.color_ids"
                >
                  {{ validationMsg.color_ids }}
                </p>
              </div>
            </div>
            <div></div>
            <div class="col-span-2">
              <div class="form-group mb-4">
                <label for="price" class="form-label label-form"
                  >Sizes

                  <span v-if="isediting == 'edit'">
                    (
                    <span v-if="isNumbering">
                      <span
                        v-for="(severSize, index) in severSizes"
                        :key="index"
                        >{{ severSize }},</span
                      >
                    </span>
                    <span v-if="!isNumbering">
                      <span
                        v-for="(severSize, index) in severSizes"
                        :key="index"
                        >{{ severSize.name }},</span
                      >
                    </span>
                    )
                  </span>
                </label>
                <multiselect
                  v-if="!isNumbering"
                  v-model="formData.size.AlphabeticalSizesValue"
                  :options="formData.size.AlphabeticalSizes"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  label="name"
                  placeholder="Choose sizes"
                  :preselect-first="false"
                  id="size_ids"
                  track-by="id"
                >
                </multiselect>
                <input
                  v-if="isNumbering"
                  v-model="formData.size.numberSizes"
                  type="text"
                  class="form-control input-form mt-3"
                  id=""
                  placeholder=""
                />
                <p class="text-red-600 text-xs" v-show="validationMsg.size_ids">
                  {{ validationMsg.size_ids }}
                </p>
              </div>
            </div>
            <div></div>
            <!-- end row -->
            <!-- start row -->
            <div class="col-span-2">
              <div class="form-group mb-4">
                <label for="price" class="form-label label-form"
                  >Size Guides</label
                >
                <multiselect
                  v-model="sizeGuideValue"
                  :options="sizeGuideOptions"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  label="name"
                  placeholder="Choose "
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.size_guide_id"
                >
                  {{ validationMsg.size_guide_id }}
                </p>
              </div>
            </div>
            <div></div>

            <!-- end row -->
            <div class="col-span-full mt-2">
              <hr class="my-2 h-0.5" />
            </div>

            <div class="col-span-2"></div>
            <!-- end row -->
          </div>
        </div>
      </div>
      <div
        class="tab-pane fade"
        :class="{
          show: isValidationSuccess,
          active: isValidationSuccess,
        }"
        id="tabs-second"
        role="tabpanel"
        aria-labelledby="tabs-second-tabJustify"
      >
        <sub-product-create
          @onPublish="onPublish"
          @onEditSubProduct="onEditSubProduct"
          :number-oralphabetical="isNumbering"
          :isediting="isediting"
          :color-value="colorValue"
          :is-loading="isLoading"
        />
      </div>
    </div>
    <!-- <img :src="subProducts[0].image_preview" alt="" /> -->
    <!-- <div
            :style="{
                'background-image': `url(${subProducts[0].image_preview})`,
            }"
        ></div>
        <div
            :style="{ backgroundImage: `url(${subProducts[0].image_preview})` }"
        ></div>

        <input type="text" :value="subProducts[0].image_preview" /> -->
    <ul
      class="nav nav-tabs flex flex-col md:flex-row prev-next-box"
      id="tabs-tabFill"
      role="tablist"
    >
      <li class="" role="presentation">
        <button
          v-if="isValidationSuccess"
          @click="toggleTabs"
          class="primary-button"
          id="previousBtn"
        >
          Prev
        </button>
      </li>
      <li class="" role="presentation">
        <button
          v-if="!isValidationSuccess"
          class="primary-button"
          @click="checkValidation"
        >
          Next
        </button>
      </li>
    </ul>
    <!-- Modal -->
    <div
      class="modal fade primary-modal"
      id="add_tag"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-box">
        <div class="modal-content content-modal">
          <!-- <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-base">CreateOrUpdate Tag</p>
        </div> -->
          <div class="modal-body px-2 mx-2">
            <form>
              <div class="block p-6 rounded-lg bg-white">
                <div class="form-group mb-6">
                  <label for="engName" class="form-label label-form"
                    >Tag Name</label
                  >
                  <input
                    v-model="formData.tag_name.name"
                    type="text"
                    class="form-control input-form mt-3"
                    placeholder=""
                  />
                </div>
                <div class="form-group">
                  <div class="form-check">
                    <input
                      v-model="formData.tag_feature"
                      class="
                        form-check-input
                        appearance-none
                        h-4
                        w-4
                        border border-gray-300
                        rounded-sm
                        bg-white
                        checked:bg-blue-600 checked:border-blue-600
                        focus:outline-none
                        transition
                        duration-200
                        mt-1
                        align-top
                        bg-no-repeat bg-center bg-contain
                        float-left
                        mr-2
                      "
                      type="checkbox"
                      value=""
                      id="flexCheckDisabled"
                    />
                    <label
                      class="form-check-label inline-block text-gray-800"
                      for="flexCheckDisabled"
                    >
                      Feature
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="modal-footer modal-btn-container">
            <button
              @click="OncreateTag"
              type="button"
              class="primary-button bg-black"
              data-bs-dismiss="modal"
            >
              Add
            </button>
            <button
              id="cancel"
              type="button"
              class="btn btn-light"
              data-bs-dismiss="modal"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade primary-modal"
      id="add_series"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
      <series-modal
        @oncreateSeries="oncreateSeries"
        :isSeriesCreated="isSeriesCreated"
        :showErrorBrandSub="showErrorBrandSub"
      />
    </div>
  </div>
</template>
<script src="https://cdn.tiny.cloud/1/q3izmtpr7smpz3pgax645juzvzebttbz7n4lr0zv0oamhhe2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import subProductCreate from "../Components/subProductCreateComponent.vue";
import seriesModal from "../Components/SeriesModal.vue";
import ImgPreview from "../Components/imgPreview.vue";
import Editor from '@tinymce/tinymce-vue';



export default {
  name: "productCreateEdit",
  components: {
    Multiselect,
    subProductCreate,
    seriesModal,
    ImgPreview,
    'editor': Editor
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
        description_name: {
          name: "",
          language_code: "en",
        },
        description_mm_name: {
          name: "",
          language_code: "mm",
        },
        size: {
          numberSizes: "",
          AlphabeticalSizes: "",
          AlphabeticalSizesValue: [],
        },
        default_price: "",
        icon: {},
        tag_name: {
          name: "",
          language_code: "en",
        },
        tag_feature: 0,
      },
      icon_preview: "",
      validationMsg: {
        sub_category_id: "",
        taxClass_id: "",
        description_mm_name: "",
        description_name: "",
        brand_id: "",
        gender_id: "",
        tag_ids: "",
        season_id: "",
        occasion_id: "",
        color_ids: "",
        default_price: "",
        size_ids: "",
        name: "",
        mm_name: "",
        icon: "",
        product_variation: "",
        size_guide_id: "",
      },
      isSeriesCreated: false,
      image_previews: [],
      severSubproducts: [], //when edit get from sever
      severColors: [], //when edit get from sever
      severSizes: [], //when edit get from sever
      isNumbering: true,
      isValidationSuccess: false,
      subCategoryValue: null,
      subCategoryOptions: [],
      brandValue: null,
      brandOptions: [],
      taxClassValue: "",
      taxClassOptions: [],
      genderValue: "",
      genderOptions: [],
      seasonValue: [],
      seasonOptions: [],
      occasionValue: [],
      occasionOptions: [],
      colorValue: [],
      colorOptions: [],
      productVariation: [],
      tagValues: [],
      tagOptions: [],
      seriesValues: "",
      seriesOptions: [],
      imagePreLoads: [],
      isLoading: false,
      sizeGuideValue: "",
      sizeGuideOptions: [],
    };
  },
  computed: {
    sizeValidation() {
      if (this.isediting == "edit") {
        return false;
      } else if (this.subCategoryValue == "") {
        return true;
      } else {
        if (this.isNumbering && this.formData.size.numberSizes === null) {
          return true;
        } else if (!this.isNumbering) {
          if (
            this.formData.size.AlphabeticalSizesValue === null ||
            this.formData.size.AlphabeticalSizesValue.length === 0
          )
            return true;
        }
      }
    },
    showErrorBrandSub() {
      if (this.subCategoryValue != null && this.brandValue != "") {
        return false;
      } else {
        return true;
      }
    },
    subProductSizes() {
      if (this.isNumbering && this.formData.size.numberSizes) {
        return this.formData.size.numberSizes;
      }
      if (!this.isNumbering && this.formData.size.AlphabeticalSizesValue) {
        return this.formData.size.AlphabeticalSizesValue;
      }
    },

    mySizes() {
      if (this.isNumbering) {
        if (this.subProductSizes) {
          var number_arr = this.subProductSizes.split(",");
        } else {
          var number_arr = [];
        }
        let total_number_arr = [...number_arr, ...this.severSizes];
        var filtered = total_number_arr.filter(function (el) {
          return el != "";
        });
        return filtered;
      } else {
        console.log("isnumber", this.isNumbering);
        let total_number_arr = [...this.subProductSizes, ...this.severSizes];
        return total_number_arr;
      }
    },

    subProducts() {
      // console.log("subproduct_sizes", this.subProductSizes);
      let subProducts = [];
      if (this.isediting == "create") {
        var colors = this.colorValue;
      } else {
        var colors = [...this.severColors, ...this.colorValue];
      }
      colors.forEach((color) => {
        let first_color_sub_product = 1;
        let sizeLength = this.mySizes.length - 1;
        this.mySizes.forEach((size, idx) => {
          let subProductId = Math.random().toString(36).slice(2); //for local edit

          if (this.isNumbering) {
            var sizeObj = { name: size };
          } else {
            var sizeObj = size;
          }
          let skuNumber =
            color.name_translations[0].name.trim() + "-" + sizeObj.name.trim();
          // console.log("sizeObj", this.mySizes);
          let subProduct = {
            id: null,
            local_id: subProductId,
            images: {
              frond_view_id: null,
              front_view: null,
              front_view_file: {},
              front_view_preview: null,
              is_front_view_update: false,

              back_view_id: null,
              back_view: null,
              back_view_file: {},
              back_view_preview: null,
              is_back_view_update: false,

              side_view_id: null,
              side_view: null,
              side_view_file: {},
              side_view_preview: null,
              is_side_view_update: false,

              something_view_id: null,
              something_view: null,
              something_view_file: {},
              something_view_preview: null,
              is_something_view_update: false,
            },
            // image: null,
            // image_file: {},
            // image_preview: null,

            color: color,
            size: sizeObj,
            sku: skuNumber,
            unique_label: skuNumber,
            price: this.formData.default_price,
            available: true,
            isEditingNow: false,
            first_color_sub_product:
              first_color_sub_product == 1 ? true : false,
            last_color_sub_product: sizeLength == idx ? true : false,
          };
          // console.log("first", first_color_sub_product);

          first_color_sub_product++;
          subProducts.push(subProduct);
        });
      });
      this.severSubproducts.forEach((sever_sub_product, index) => {
        let deleteIndex = subProducts.findIndex(
          (sub) => sub.unique_label === sever_sub_product.unique_label
        );
        console.log("befor replace", subProducts[deleteIndex]);
        let first_sub = subProducts[deleteIndex].first_color_sub_product;
        sever_sub_product.first_color_sub_product = first_sub;

        let last_sub = subProducts[deleteIndex].last_color_sub_product;
        sever_sub_product.last_color_sub_product = last_sub;
        subProducts[deleteIndex] = sever_sub_product; //replace by sever product
        // subProducts.splice(deleteIndex, 1);
      });
      return subProducts;
    },
  },
  methods: {
    ...mapActions([
      "updateOrCreateProduct",
      "search",
      "createTag",
      "deleteProductGallaryApi",
      "getApiData",
      "postApiForm",
    ]),
    ...mapMutations(["setSubProducts", "setApiLoading"]),
    customLabel(option) {
      return `${option.name_translations[0].name}`;
    },
    customSizeLabel(option) {
      return `${option.name}`;
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
      this.formData.icon = {
        name: event.target.files[0].name,
        data: event.target.files[0],
      };
      this.icon_preview = URL.createObjectURL(event.target.files[0]);
    },

    checkValidation(e) {
      e.preventDefault();
      this.isValidationSuccess = true;
      let form_data = new FormData();
      let name_translations = [this.formData.name, this.formData.mm_name];
      form_data.append("data", JSON.stringify(name_translations));

      if (Object.keys(this.formData.icon).length > 0) {
        form_data.append(
          "photo",
          this.formData.icon.data,
          this.formData.icon.name
        );
      }
      if (this.isediting == "edit") {
        form_data.append("id", this.formData.id);
      }

      let res = axios
        .post(`/products/validate_product_request`, form_data)
        .then((res) => {})
        .catch((error) => {
          // console.log("fail");
          this.isValidationSuccess = false;
          this.scrollToTop();
          this.validateResError(error);
        });

      this.validateRules();
      if (!this.isValidationSuccess) {
        this.scrollToTop();
      }
      this.setSubProducts(this.subProducts);
    },
    toggleTabs() {
      this.isValidationSuccess = false;
    },
    onPublish(payload) {
      let form_data = new FormData();
      let name_translations = [this.formData.name, this.formData.mm_name];
      form_data.append("data", JSON.stringify(name_translations));

      if (this.isediting == "edit") {
        form_data.append("id", this.formData.id);
      }
      form_data.append("sub_category", JSON.stringify(this.subCategoryValue));
      form_data.append("price", this.formData.default_price);
      form_data.append("isNumbering", this.isNumbering);

      form_data.append("tax", JSON.stringify(this.taxClassValue));

      let description_names = [
        this.formData.description_name,
        this.formData.description_mm_name,
      ];
      form_data.append("description", JSON.stringify(description_names));

      form_data.append("brand", JSON.stringify(this.brandValue));

      form_data.append("gender", JSON.stringify(this.genderValue));

      form_data.append("season", JSON.stringify(this.seasonValue));

      form_data.append("occasion", JSON.stringify(this.occasionValue));

      form_data.append("tag", JSON.stringify(this.tagValues));
      form_data.append("series", JSON.stringify(this.seriesValues));

      form_data.append("sub_variation", JSON.stringify(this.productVariation));
      form_data.append("size_guide_id", this.sizeGuideValue.id);

      if (Object.keys(this.formData.icon).length > 0) {
        form_data.append(
          "photo",
          this.formData.icon.data,
          this.formData.icon.name
        );
      }

      if (this.isediting == "edit") {
        form_data.append(
          "color",
          JSON.stringify([...this.severColors, ...this.colorValue])
        );
      } else {
        form_data.append("color", JSON.stringify(this.colorValue));
      }
      if (this.isNumbering) {
        if (this.isediting == "edit") {
          form_data.append("size", this.mySizes.toString());
        } else {
          form_data.append("size", this.formData.size.numberSizes);
        }
      } else {
        if (this.isediting == "edit") {
          form_data.append("size", JSON.stringify(this.mySizes));
        } else {
          form_data.append(
            "size",
            JSON.stringify(this.formData.size.AlphabeticalSizesValue)
          );
        }
      }
      form_data.append("sub_product", JSON.stringify(payload.sub_product));

      for (const j of Object.keys(payload.imageArr)) {
        console.log(payload.imageArr[j]);
        form_data.append("sub_product_images[]", payload.imageArr[j]);
      }

      this.setApiLoading(true);
      this.updateOrCreateProduct(form_data)

        .then((res) => {
          this.setApiLoading(false);

          this.$swal({
            icon: "success",
            title: "Created!",
            text: "Product has been created.",
            showConfirmButton: false,
            timer: 1000,
          });
          window.location.href = "/products_lists";
        })
        .catch((error) => {
          this.$swal({
            icon: "error",
            title: "Error!",
            text: error,
            showConfirmButton: false,
            timer: 1000,
          });
          this.backPreviousBtn();
          this.scrollToTop();
          this.setApiLoading(false);

          this.validateResError(error);
        });
    },
    oncreateSeries(payload) {
      console.log("creating series", payload);
      let form_data = new FormData();
      let submitData = [payload.name, payload.mm_name];
      form_data.append("data", JSON.stringify(submitData));
      form_data.append("type", "product");
      form_data.append(
        "brands",
        this.brandValue ? JSON.stringify([this.brandValue.id]) : ""
      );
      form_data.append(
        "sub_category_id",
        this?.subCategoryValue ? this?.subCategoryValue.id : ""
      );
      let pl = { form_data: form_data, url: "series/createOrUpdate" };
      this.postApiForm(pl)
        .then((res) => {
          this.closeModal();
          this.$swal({
            icon: "success",
            title: "Created!",
            text: "Series has been created.",
            showConfirmButton: false,
            timer: 1000,
          });
          this.isSeriesCreated = true; //to null in series create modal
          // this.formData.tag_name.name = null;
          this.getSeries();
        })
        .catch((error) => {
          this.$swal("Error!", error.response.data.message[0].message, "error");
        });
    },

    onEditSubProduct(subProduct) {
      const editItem = this.subProducts.find(
        (item) => item.id === subProduct.id
      );
      editItem.isEditingNow = true;
    },

    async onSubCategoryGetVariation() {
      // console.log(
      //     "subcategoryonchange",
      //     this.subCategoryValue.unit_types[0].name
      // );
      this.productVariation = null;
      this.formData.size.AlphabeticalSizes = null;
      this.formData.size.AlphabeticalSizesValue = null;
      console.log("1");
      this.formData.size.numberSizes = null;
      let res = await axios.get(
        `/variations/variation_by_sub_category_id/${this.subCategoryValue.id}`
      );
      res = res.data.data;

      let pv = [];

      res.forEach((variation) => {
        let sub = {};
        sub.label = variation.name_translations;
        sub.value = null;
        sub.options = variation.sub_variations;
        variation.sub_categories.forEach((sub) => {
          if (sub.id == this.subCategoryValue.id) {
            if (sub.unit_types[0].name == "Alphabetical") {
              this.formData.size.AlphabeticalSizes = sub.unit_types[0].sizes;
              this.formData.size.AlphabeticalSizesValue = null;
            }
          }
        });

        pv.push(sub);
      });
      this.productVariation = pv;
      if (this.subCategoryValue.unit_types[0].name == "Number") {
        this.isNumbering = true;
      } else {
        this.isNumbering = false;
      }
      this.$forceUpdate();
    },
    //
    OncreateTag() {
      if (
        this.formData.tag_name.name == null ||
        this.formData.tag_name.name == ""
      ) {
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "Fill tag name.",
          showConfirmButton: false,
          timer: 1000,
        });
        return;
      }
      let form_data = new FormData();
      let submitData = [this.formData.tag_name];
      form_data.append("data", JSON.stringify(submitData));
      form_data.append("is_feature", this.formData.tag_feature ? 1 : 0);

      this.createTag(form_data)
        .then((res) => {
          this.closeModal();

          this.$swal({
            icon: "success",
            title: "Created!",
            text: "Tag has been created.",
            showConfirmButton: false,
            timer: 1000,
          });
          this.formData.tag_name.name = null;
          this.formData.tag_feature = 0;
          this.getTags();
        })
        .catch((error) => {
          this.$swal("Error!", error.response.data.message[0].message, "error");
        });
    },
    closeModal() {
      document.getElementById("cancel").click();
    },
    resetvalidateRulesMsg() {
      this.validationMsg.sub_category_id = "";
      this.validationMsg.taxClass_id = "";
      this.validationMsg.description_mm_name = "";
      this.validationMsg.description_name = "";
      this.validationMsg.brand_id = "";
      this.validationMsg.gender_id = "";
      this.validationMsg.tag_ids = "";
      this.validationMsg.series_id = "";
      this.validationMsg.season_id = "";
      this.validationMsg.occasion_id = "";
      this.validationMsg.color_ids = "";
      this.validationMsg.default_price = "";
      this.validationMsg.size_ids = "";
      this.validationMsg.name = "";
      this.validationMsg.mm_name = "";
      this.validationMsg.icon = "";
    },
    validateRules() {
      this.resetvalidateRulesMsg();
      if (this.formData.name.name.trim() === "") {
        this.validationMsg.name = "Name is required.";
        this.isValidationSuccess = false;
      }
      if (this.formData.mm_name.name.trim() === "") {
        this.validationMsg.mm_name = "Name (myanmar) is required.";
        this.isValidationSuccess = false;
      }
      if (this.subCategoryValue == "") {
        this.validationMsg.sub_category_id = "SubCategory is required.";
        this.isValidationSuccess = false;
      }
      if (this.formData.default_price < 0) {
        this.validationMsg.default_price =
          "Price is required.Must Larger than 0";
        this.isValidationSuccess = false;
      }
      if (this.taxClassValue == "") {
        this.validationMsg.taxClass_id = "Tax is required.";
        this.isValidationSuccess = false;
      }
      if (this.formData.description_name.name.trim() == "") {
        this.validationMsg.description_name = "Description is required.";
        this.isValidationSuccess = false;
      }
      if (this.formData.description_name.name.trim() == "") {
        this.validationMsg.description_mm_name =
          "Description(myanmar) is required.";
        this.isValidationSuccess = false;
      }
      if (this.brandValue == null) {
        this.validationMsg.brand_id = "Brand is required.";
        this.isValidationSuccess = false;
      }
      if (this.genderValue == "") {
        this.validationMsg.gender_id = "Gender is required.";
        this.isValidationSuccess = false;
      }
      if (this.tagValues == "") {
        this.validationMsg.tag_ids = "Tags are required.";
        this.isValidationSuccess = false;
      }

      if (this.seasonValue.length == 0) {
        this.validationMsg.season_id = "Season is required.";
        this.isValidationSuccess = false;
      }
      if (this.sizeGuideValue == "") {
        this.validationMsg.size_guide_id = "Size Guide is required.";
        this.isValidationSuccess = false;
      }
      // if (this.productVariation.length == 0) {
      //     this.validationMsg.product_variation = "Variation is required.";
      //     this.isValidationSuccess = false;
      // }
      // if (this.productVariation.length != 0) {
      //     if (this.productVariation[0].value == null) {
      //         this.validationMsg.product_variation =
      //             "Variation is required.";
      //         this.isValidationSuccess = false;
      //     }
      // }
      if (this.occasionValue.length == 0) {
        this.validationMsg.occasion_id = "Occasion are required.";
        this.isValidationSuccess = false;
      }
      if (this.colorValue == "" && this.isediting == "create") {
        this.validationMsg.color_ids = "Colors are required.";
        this.isValidationSuccess = false;
      }

      if (this.sizeValidation) {
        this.isValidationSuccess = false;
        this.validationMsg.size_ids = "Sizes are required.";
      }
      if (this.productGallaryValidation) {
        this.isValidationSuccess = false;
      }
    },
    formDataToSubmit() {
      let form_data = new FormData();
      let name_translations = [this.formData.name, this.formData.mm_name];

      let sizeMeasur_ids = [];
      this.sizeMeasurValue.forEach((measure) => {
        sizeMeasur_ids.push(measure.id);
      });
      form_data.append("data", JSON.stringify(name_translations));
      if (this.isediting == "edit") {
        form_data.append("id", this.formData.id);
      }
      form_data.append("unit_type_id", this.unitTypeValue.id);
      let unitTypeIsNumering = 1;
      if (this.unitTypeValue.id == unitTypeIsNumering) {
        form_data.append("unit_id", this.unitValue.id);
      }
      form_data.append("category_id", this.categoryValue.id);
      form_data.append("measurement_ids", JSON.stringify(sizeMeasur_ids));

      if (Object.keys(this.formData.icon).length > 0) {
        form_data.append(
          "icon",
          this.formData.icon.data,
          this.formData.icon.name
        );
      }
      return form_data;
    },
    validateResError(error) {
      console.log("1", typeof error.response.data.message);
      if (typeof error.response.data.message == "string") {
        if (error.response.data.message.photo != null) {
          this.validationMsg.icon = error.response.data.message.photo;
        }
        if (error.response.data.message) {
          this.validationMsg.icon = error.response.data.message;
        }
      } else {
        error.response.data.message.forEach((nameError) => {
          if (nameError.language_code == "en") {
            this.validationMsg.name = nameError.message;
          }
          if (nameError.language_code == "mm") {
            this.validationMsg.mm_name = nameError.message;
          }
        });

        console.log("3", error.response.data.message);
      }
    },
    async edit_subcategory(e) {
      e.preventDefault;
      this.validateRules();
      if (
        this.formData.name.name &&
        this.categoryValue &&
        this.unitTypeValue &&
        this.sizeMeasurValue
      ) {
        let form_data = this.formDataToSubmit();
        let payload = { form_data: form_data, type: "edit" };

        this.updateOrCreateSubCategory(payload)
          .then((res) => {
            this.$swal({
              icon: "success",
              title: "Updated!",
              text: "Subcategory has been updated.",
              showConfirmButton: false,
              timer: 1000,
            });

            window.location.href = "/sub_categories";
          })
          .catch((error) => {
            this.scrollToTop();
            this.validateResError(error);
          });
      } else {
        //without data
      }
    },
    //
    async getSubcategory() {
      let res = await this.getApiData({ url: "get_sub_categories" });
      this.subCategoryOptions = res.data.data;
    },
    async getSizeGuides() {
      let res = await this.getApiData({ url: "get_size_guides" });
      this.sizeGuideOptions = res.data.size_guides;
    },
    async getOccasions() {
      let res = await this.getApiData({ url: "get_occasions" });
      this.occasionOptions = res.data.data;
    },
    async getTaxClass() {
      let res = await this.getApiData({ url: "get_taxes" });
      this.taxClassOptions = res.data.data;
    },
    async getGender() {
      let res = await this.getApiData({ url: "get_genders" });
      this.genderOptions = res.data.data;
    },
    async getSeasons() {
      let res = await this.getApiData({ url: "get_seasons" });
      this.seasonOptions = res.data.data;
    },
    async getColors() {
      let res = await this.getApiData({ url: "get_colors" });
      this.colorOptions = res.data.data;
    },
    async getBrands() {
      let res = await this.getApiData({ url: "get_brands" });
      this.brandOptions = res.data.data;
    },
    async getTags() {
      let res = await this.getApiData({ url: "get_tags" });
      this.tagOptions = res.data.data;
    },
    async getSeries() {
      this.seriesOptions = [];
      let url = `get_product_series?type=product&brand_id=${
        this.brandValue == null ? "" : this.brandValue.id
      }&sub_category_id=${
        this.subCategoryValue == "" ? "" : this.subCategoryValue?.id
      }`;
      let res = await this.getApiData({ url: url });
      this.seriesOptions = res.data.data;
    },

    async getProductDetail() {
      let uri = window.location.href.split("/");
      let uriLast = uri.length - 1;
      let res = await axios.get(`/products/${uri[uriLast]}`);
      res = res.data.data;
      this.formData.id = res.id;
      this.formData.default_price = res.price;
      this.seasonValue = res.seasons;
      this.genderValue = res.genders[0];
      this.taxClassValue = res.taxes[0];
      this.brandValue = res.brands[0];
      this.occasionValue = res.occasions;
      this.tagValues = res.tags;
      console.log("series", res.series[0]);
      this.seriesValues = res.series[0];
      this.subCategoryValue = res.sub_categories[0];
      this.sizeGuideValue = res.size_guide;
      this.icon_preview = res.product_photo?.name;
      res?.description_translations.forEach((desc_translation) => {
        if (desc_translation.language_code == "en") {
          this.formData.description_name.name = desc_translation.name;
        }
        if (desc_translation.language_code == "mm") {
          this.formData.description_mm_name.name = desc_translation.name;
        }
      });
      res?.name_translations.forEach((p_name_translation) => {
        if (p_name_translation.language_code == "en") {
          this.formData.name.name = p_name_translation.name;
        }
        if (p_name_translation.language_code == "mm") {
          this.formData.mm_name.name = p_name_translation.name;
        }
      });

      // res.sub_product_photos.forEach((photo) => {
      //         let image_url = `${window.location.origin}/api/download_image/${photo.name}`;
      //         let img = {
      //             id: photo.id,
      //             file: "",
      //             img_preview: image_url,
      //         };
      //         // this.formData.galleryImgs.push(img);
      //         this.image_previews.push(image_url);
      // });
      // this.getProductGallary();

      let same_color = "";
      res?.sub_products.forEach((sub_product) => {
        //front_view, back_view, side_view , something
        let sub_product_photo_objs = res?.sub_product_photos.filter(
          (sub) => sub.color_id === sub_product.color_id
        );
        let sub_product_front_view = sub_product_photo_objs.filter(
          (subs) => subs.type == "front_view"
        );
        let sub_product_back_view = sub_product_photo_objs.filter(
          (subs) => subs.type == "back_view"
        );
        let sub_product_side_view = sub_product_photo_objs.filter(
          (subs) => subs.type == "side_view"
        );
        let sub_product_something_view = sub_product_photo_objs.filter(
          (subs) => subs.type == "something_view"
        );

        // let subPhoto = sub_product_obj.name;
        let unique_label =
          sub_product.color.name_translations[0].name.trim() +
          "-" +
          sub_product.size.name;
        // let image_preview = `${window.location.origin}/api/download_image/${subPhoto}`;
        let front_view_preview = sub_product_front_view[0].name;
        let back_view_preview = sub_product_back_view[0].name;
        let side_view_preview = sub_product_side_view[0].name;
        let something_view_preview = sub_product_something_view[0].name;

        let sub = {
          id: sub_product.id,
          local_id: Math.random().toString(36).slice(2),
          images: {
            front_view_id: sub_product_front_view[0].id,
            front_view: null,
            front_view_file: {},
            front_view_preview: front_view_preview,
            is_front_view_update: false,

            back_view_id: sub_product_back_view[0].id,
            back_view: null,
            back_view_file: {},
            back_view_preview: back_view_preview,
            is_back_view_update: false,

            side_view_id: sub_product_side_view[0].id,
            side_view: null,
            side_view_file: {},
            side_view_preview: side_view_preview,
            is_side_view_update: false,

            something_view_id: sub_product_something_view[0].id,
            something_view: null,
            something_view_file: {},
            something_view_preview: something_view_preview,
            is_something_view_update: false,
          },
          color: sub_product.color,
          size: sub_product.size,
          sku: sub_product.sku,
          unique_label: unique_label,
          price: sub_product.product_prices.price,
          available: sub_product.is_available ? true : false,
          first_color_sub_product:
            same_color == sub_product.color.name_translations[0].name.trim()
              ? false
              : true,
          isEditingNow: false,
        };
        this.imagePreLoads.push(front_view_preview);
        this.imagePreLoads.push(back_view_preview);
        this.imagePreLoads.push(side_view_preview);
        this.imagePreLoads.push(something_view_preview);
        // console.log(
        //     "same_color",
        //     same_color,
        //     sub_product.color.name_translations[0].name.trim()
        // );

        same_color = sub_product.color.name_translations[0].name.trim();
        this.severSubproducts.push(sub);
      });

      if (res?.sizes_by_sub_products[0].unit_type.name == "Number") {
        this.isNumbering = true;
      } else {
        this.isNumbering = false;
      }
      this.formData.size.AlphabeticalSizes = res.all_sizes;

      this.severColors = res.colors_by_sub_products;
      if (res?.sizes_by_sub_products[0].unit_type.name == "Number") {
        let sever_siz = [];
        res?.sizes_by_sub_products.forEach((siz) => {
          sever_siz.push(siz.name);
        });
        this.severSizes = sever_siz;
      } else {
        this.severSizes = res.sizes_by_sub_products;
      }

      res?.sub_variations.forEach((sub_variation) => {
        let product_variation = {
          label: [],
          options: [],
          value: {
            name_translations: [],
          },
        };
        for (let i of Object.keys(sub_variation.variation.name_translations)) {
          product_variation.label.push(
            sub_variation.variation.name_translations[i]
          );
        }
        for (let j of Object.keys(sub_variation.variation.sub_variations)) {
          product_variation.options.push(
            sub_variation.variation.sub_variations[j]
          );
        }
        product_variation.value.name_translations =
          sub_variation.name_translations;
        this.productVariation.push(product_variation);
      });

      let now_colors = res.all_colors;
      res?.colors_by_sub_products.forEach((sever_color) => {
        let colorIndex = now_colors.findIndex(
          (color) => color.id === sever_color.id
        );
        now_colors.splice(colorIndex, 1);
      });
      this.colorOptions = now_colors;

      res?.sizes_by_sub_products.forEach((sever_size) => {
        let sizeIndex = this.formData.size.AlphabeticalSizes.findIndex(
          (size) => size.id === sever_size.id
        );
        this.formData.size.AlphabeticalSizes.splice(sizeIndex, 1);
      });
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
    backPreviousBtn() {
      document.getElementById("previousBtn").click();
    },
    getImages() {
      //load image from s3
      let uniqImages = [...new Set(this.imagePreLoads)]; //remove duplicate images
      const imageLoadings = uniqImages.map((imageSrc) => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.src = imageSrc;
          img.onload = resolve;
          img.onerror = reject;
        });
      });
      Promise.all(imageLoadings)
        .then(() => {
          console.log("Images loaded!");
          this.isLoading = false;
        })
        .catch((error) => {
          console.error("Some image(s) failed loading!");
        });
    },
    // getProductGallary() {
    //     //load image from s3
    //     let uniqImages = [...new Set(this.image_previews)]; //remove duplicate images
    //     const imageLoadings = uniqImages.map((imageSrc) => {
    //         return new Promise((resolve, reject) => {
    //             const img = new Image();
    //             img.src = imageSrc;
    //             img.onload = resolve;
    //             img.onerror = reject;
    //         });
    //     });
    //     console.log("load images");
    //     Promise.all(imageLoadings)
    //         .then(() => {
    //             console.log("Images loaded!");
    //             this.isLoading = false;
    //         })
    //         .catch((error) => {
    //             console.error("Some image(s) failed loading!");
    //         });
    // },
    deleteImage() {
        this.formData.icon = {};
        this.icon_preview = null;
        this.$refs.iconFile.value = null;
    },
  },
  watch: {
    subCategoryValue(newVal, oldVal) {
      this.getSeries();
    },
    brandValue(newVal, oldVal) {
      this.getSeries();
    },
  },
  mounted() {
    if (this.isediting == "edit") {
      this.getProductDetail().then((res) => {
        this.isLoading = true;
        this.getImages();
      });
    } else {
      this.getColors();
    }
    this.getTags();
    this.getSubcategory();
    this.getOccasions();
    this.getBrands();
    this.getTaxClass();
    this.getGender();
    this.getSeasons();
    this.getSeries();
    this.getSizeGuides();

    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | bold italic underline strikethrough | link image media table | blocks fontfamily fontsize | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

  },
};
</script>
