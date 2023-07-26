<template>
  <div class="inner-main-container">
    <div>
      <div>
        <div>
          <p class="page-tittle">
            {{ isediting == "edit" ? "Edit" : "Create" }}
            {{ filterValue.name }}
          </p>
        </div>
        <div class="pt-6 mb-6">
          <div class="grid grid-cols-8 gap-y-2 gap-x-8 mx-2">
            <div class="col-span-2">
              <label for="" class="label-form"
                >{{ filterValue.name }} Name</label
              >
            </div>
            <div class="col-span-2">
              <label for="" class="label-form">&nbsp;</label>
            </div>
            <div class="col-span-2">
              <label for="" class="label-form"
                >{{ filterValue.name }} Item Code</label
              >
            </div>
            <div class="col-span-2">
              <!-- free space for grid -->
            </div>

            <!-- start row -->

            <div class="col-span-2">
              <div class="form-group mb-4">
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
            <div class="col-span-2">
              <div class="form-group mb-4">
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
            <div class="col-span-2">
              <div class="form-group mb-4">
                <input
                  v-model="formData.item_code"
                  type="text"
                  class="mt-3 input-form"
                  id=""
                  placeholder=""
                />
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.item_code"
                >
                  {{ validationMsg.item_code }}
                </p>
              </div>
            </div>
            <div class="col-span-2">
              <!-- free space for grid  -->
            </div>

            <div class="col-span-8">
              <hr class="my-2 h-0.5" />
            </div>
            <!-- end row -->

            <!-- start row -->
            <div class="col-span-2">
              <label for="gender" class="label-form">Gender</label>
            </div>
            <div class="col-span-2">
              <label for="filterType" class="label-form">Type</label>
            </div>
            <div class="col-span-2">
              <label for="tag" class="label-form">Tag (optional)</label>
            </div>
            <div class="col-span-2"></div>
            <div class="col-span-2">
              <div class="form-group mb-4">
                <multiselect
                  v-model="genderValue"
                  :options="genderOptions"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  label="name"
                  track-by="id"
                  placeholder="Choose "
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.gender_id"
                >
                  {{ validationMsg.gender_id }}
                </p>
              </div>
            </div>
            <div class="col-span-2">
              <div class="form-group mb-4">
                <multiselect
                  v-model="filterValue"
                  :options="filterOptions"
                  :searchable="false"
                  :close-on-select="true"
                  :show-labels="false"
                  :disabled="isediting == 'edit' ? true : false"
                  :allow-empty="false"
                  track-by="name"
                  label="name"
                  placeholder="Choose Type"
                  @input="changeType"
                ></multiselect>
              </div>
            </div>
            <div class="col-span-2">
              <div class="form-group mb-4 block">
                <multiselect
                  v-model="tagValues"
                  :options="tagOptions"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :show-labels="false"
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
            <div class="col-span-2">
              <button
                class="block -ml-5"
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

            <!-- start row -->
            <div class="col-span-2">
              <label for="brand" class="label-form">Brand (Optinoal**)</label>
            </div>
            <div class="col-span-2">
              <label for="Color" class="label-form">Color</label>
            </div>
            <div class="col-span-2">
              <label for="style_category" class="label-form"
                >{{ filterValue.name }} Category (optional)</label
              >
            </div>

            <div class="col-span-2"></div>

            <div class="col-span-2">
              <div class="form-group mb-4">
                <multiselect
                  v-model="brandValues"
                  :options="brandOptions"
                  :multiple="true"
                  :searchable="true"
                  :close-on-select="true"
                  :show-labels="false"
                  :custom-label="customLabel"
                  placeholder="Choose brand"
                  track-by="id"
                ></multiselect>
                <p class="text-red-600 text-xs" v-show="validationMsg.brand_id">
                  {{ validationMsg.brand_id }}
                </p>
              </div>
            </div>
            <div class="col-span-2">
              <div class="form-group mb-4">
                <multiselect
                  v-model="colorValue"
                  :options="colorOptions"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customLabel"
                  :show-labels="false"
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
            <div class="col-span-2">
              <div class="form-group mb-4">
                <multiselect
                  v-model="styleCategoryValue"
                  :options="styleCategoryOption"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customStyleLabel"
                  :show-labels="false"
                  placeholder="Choose category"
                  :preselect-first="true"
                  id="color_ids"
                  track-by="id"
                >
                </multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.style_category"
                >
                  {{ validationMsg.style_category }}
                </p>
              </div>
            </div>
            <div class="col-span-2">
              <button
                class="block -ml-5"
                title="Add Style Category"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#add_category"
                data-toggle="modal"
              >
                <i class="fal fa-plus text-gray-700 pr-3 py-2"></i>
              </button>
            </div>
            <!-- end row -->

            <!-- start row -->
            <div class="col-span-2">
              <label for="season" class="label-form">Seasons</label>
            </div>
            <div class="col-span-2">
              <label for="occassion" class="label-form">Occassions</label>
            </div>
            <div class="col-span-2">
              <label for="style_category" class="label-form"
                >Series (optional)</label
              >
            </div>
            <div class="col-span-2"></div>

            <div class="col-span-2">
              <div class="form-group mb-4">
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
            <div class="col-span-2">
              <div class="form-group mb-4">
                <multiselect
                  v-model="occasionValue"
                  :options="occasionOptions"
                  :searchable="false"
                  :multiple="true"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :show-labels="false"
                  :custom-label="customLabel"
                  placeholder="Choose occasion"
                  track-by="id"
                  id="occasion_id"
                ></multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.occasion_id"
                >
                  {{ validationMsg.occasion_id }}
                </p>
              </div>
            </div>
            <div class="col-span-2">
              <div>
                <multiselect
                  v-model="seriesValues"
                  :options="seriesOptions"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customLabel"
                  :show-labels="false"
                  placeholder="Choose series"
                  :preselect-first="true"
                  id="tag_ids"
                  track-by="id"
                >
                </multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.series_id"
                >
                  {{ validationMsg.series_id }}
                </p>
              </div>
            </div>
            <div class="col-span-2">
              <button
                class="block -ml-5"
                title="Add Series"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#add_series"
                data-toggle="modal"
              >
                <i class="fal fa-plus text-gray-700 pr-3 py-2"></i>
              </button>
            </div>

            <div class="col-span-4">
              <div>
                <multiselect
                  v-model="stylistValues"
                  :options="stylistOptions"
                  :close-on-select="true"
                  :clear-on-select="true"
                  :preserve-search="true"
                  :custom-label="customLabel"
                  :show-labels="false"
                  placeholder="Choose stylists"
                  :preselect-first="true"
                  id="stylelist_id"
                  track-by="id"
                >
                </multiselect>
                <p
                  class="text-red-600 text-xs"
                  v-show="validationMsg.stylist_id"
                >
                  {{ validationMsg.stylist_id }}
                </p>
              </div>
            </div>
            <div class="col-span-1">
              <button
                class="block -ml-5"
                title="Add Series"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#add_stylist"
                data-toggle="modal"
              >
                <i class="fal fa-plus text-gray-700 pr-3 py-2"></i>
              </button>
            </div>
            <div class="col-span-2">
              <div class="form-group">
                <div class="form-check">
                  <input
                    :checked="formData.is_feature == 1 ? true : false"
                    v-model="formData.is_feature"
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
            <div class="col-span-8">
              <hr class="my-2 h-0.5" />
            </div>
            <!-- end row -->

            <!-- start row -->
            <div class="col-span-6">
              <div class="form-group mb-6">
                <label for="" class="form-label block label-form mb-3">
                  {{ filterValue.name }} Description
                </label>
                <textarea
                  v-model="formData.description_name.name"
                  name=""
                  class="input-form text-table text-left animated-textarea"
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
            <div class="col-span-2"></div>
            <div class="col-span-6">
              <div class="form-group mb-6">
                <textarea
                  v-model="formData.description_mm_name.name"
                  name=""
                  class="input-form text-table text-left animated-textarea"
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
            <div class="col-span-2"></div>
            <div class="col-span-8">
              <hr class="my-2 h-0.5" />
            </div>
            <!-- end row -->

            <div class="col-span-6">
              <div class="form-group mb-4">
                <label for="" class="form-label label-form">
                  Style Photo
                </label>
                <input
                  @change="onChange"
                  type="file"
                  class="form-control input-form mt-3"
                  accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                />
                <img-preview :img-preview="icon_preview" :delete-image="deleteImage"/>
                <p class="text-red-600 text-xs" v-show="validationMsg.icon">
                  {{ validationMsg.icon }}
                </p>
              </div>
            </div>
            <div class="col-span-2"></div>
            <div class="col-span-6">
              <div class="form-group mb-4">
                <label for="" class="form-label label-form">
                  Style Gallery ( Optional,3-5 Photos)
                </label>
                <input
                  @change="addGalleryImgs"
                  multiple
                  type="file"
                  class="form-control input-form mt-3"
                  placeholder="MMKs"
                  ref="formGallaryImgs"
                  accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                />
                <p
                  class="text-red-600 text-xs"
                  v-show="productGallaryValidation"
                >
                  Product Gallary need 3 to 5 photos
                </p>
                <div class="mt-3 flex flex-nowrap">
                  <div
                    class="mt-3 file-name-box"
                    v-for="gallary in formData.galleryImgs"
                    :key="gallary.name"
                  >
                    <button
                      class="cancel-btn"
                      @click="deleteProductGallary(gallary)"
                    >
                      X
                    </button>
                    <!-- <p class="text-table">
                                            {{ gallary.img_preview }}
                                        </p> -->
                    <div class="item-img-container">
                      <img alt="" :src="gallary.img_preview" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-2"></div>
          </div>
        </div>
      </div>
      <!-- <div
                class="tab-pane fade"
                :class="{
                    show: isValidationSuccess,
                    active: isValidationSuccess,
                }"
                id="tabs-second"
                role="tabpanel"
                aria-labelledby="tabs-second-tabJustify"
            > -->
      <div>
        <style-create-edit-tag-two
          @onPublish="onPublish"
          :isediting="isediting"
        />
      </div>
    </div>

    <div
      class="modal fade primary-modal"
      id="add_category"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-box">
        <div class="modal-content content-modal">
          <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-base">
              Create {{ filterValue.name }} Category
            </p>
          </div>
          <div class="modal-body px-2 mx-2">
            <form>
              <div class="block p-6 rounded-lg bg-white">
                <div class="form-group">
                  <label for="Name" class="form-label label-form"
                    >Name (In English)</label
                  >
                  <input
                    v-model="formData.style_category_name.name"
                    type="text"
                    class="form-control input-form mt-3"
                    id="Name"
                    placeholder=""
                  />
                </div>
                <div class="form-group">
                  <label for="mmName" class="form-label label-form"
                    >Name (In Myanmar)</label
                  >
                  <input
                    v-model="formData.style_category_mm_name.name"
                    type="text"
                    class="form-control input-form mt-3"
                    id="mmName"
                    placeholder=""
                  />
                </div>
                <div class="form-group mb-3">
                    <label
                        for="mm_name"
                        class="form-label label-form"
                        >Gender</label
                    >
                    <multiselect class="mt-2"
                    v-model="categoryGenderValue"
                    :options="genderOptions"
                    :searchable="false"
                    :close-on-select="true"
                    :show-labels="false"
                    label="name"
                    track-by="id"
                    placeholder="Choose "
                ></multiselect>
                    <p
                        class="text-red-600 text-sm"
                        v-show="validationMsg.gender"
                    >
                        {{ validationMsg.gender }}
                    </p>
                </div>
              </div>
            </form>
          </div>

          <div class="modal-footer modal-btn-container">
            <button
              @click="onCreateStyleCategory"
              type="button"
              class="primary-button bg-black"
              data-bs-dismiss="modal"
            >
              Add
            </button>
            <button
              type="button"
              class="btn btn-light cancel"
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
      id="add_tag"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-box">
        <div class="modal-content content-modal">
          <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-base">Create Tag</p>
          </div>
          <div class="modal-body px-2 mx-2">
            <form>
              <div class="block p-6 rounded-lg bg-white">
                <div class="form-group mb-6">
                  <label for="Name" class="form-label label-form">Name</label>
                  <input
                    v-model="formData.tag_name.name"
                    type="text"
                    class="form-control input-form mt-3"
                    id="Name"
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
        :showErrorBrandSub="false"
      />
    </div>
    <div
      class="modal fade primary-modal"
      id="add_stylist"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-box">
        <div class="modal-content content-modal">
          <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-base">Create Stylist</p>
          </div>
          <div class="modal-body px-2 mx-2">
            <form>
              <div class="block p-6 rounded-lg bg-white">
                <div class="form-group">
                  <label for="Name" class="form-label label-form">Name</label>
                  <input
                    v-model="formData.stylist.name"
                    type="text"
                    class="form-control input-form mt-3"
                    id="Name"
                    placeholder=""
                  />
                </div>
              </div>
            </form>
          </div>

          <div class="modal-footer modal-btn-container">
            <button
              @click="OncreateStylist"
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
  </div>

  <!-- Modal -->
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import styleCreateEditTagTwo from "../Components/StyleCreateEditTagTwo.vue";
import seriesModal from "../Components/SeriesModal.vue";
import ImgPreview from "../Components/imgPreview.vue";
export default {
  name: "styleCreateEdit",
  components: {
    Multiselect,
    styleCreateEditTagTwo,
    seriesModal,
    ImgPreview
  },
  props: {
    isediting: String,
  },

  data() {
    return {
      formData: {
        id: "",
        item_code: "",
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
        is_feature: 0,
        style_category_name: {
          name: "",
          language_code: "en",
        },
        style_category_mm_name: {
          name: "",
          language_code: "mm",
        },
        icon: {},
        galleryImgs: [],
        tag_name: {
          name: "",
          language_code: "en",
        },
        tag_feature: 0,

        stylist: {
          name: "",
          language_code: "en",
        },
      },
      icon_preview: "",
      validationMsg: {
        icon: "",
        item_code: "",
        description_mm_name: "",
        description_name: "",
        gender_id: "",
        tag_ids: "",
        series_id: "",
        style_category: "",
        season_id: "",
        occasion_id: "",
        color_ids: "",
        name: "",
        mm_name: "",
        stylist_id: "",
      },
      filterValue: { name: "Style", value: "style" },
      filterOptions: [
        { name: "Style", value: "style" },
        { name: "Pack", value: "pack" },
      ],
      isSeriesCreated: false,
      image_previews: [],
      isValidationSuccess: false,
      brandValues: [],
      brandOptions: [],
      genderValue: "",
      genderOptions: [],
      categoryGenderValue:null,
      seasonValue: [],
      seasonOptions: [],
      occasionValue: "",
      occasionOptions: [],
      colorValue: [],
      colorOptions: [],
      tagValues: [],
      tagOptions: [],
      seriesValues: "",
      seriesOptions: [],
      stylistValues: "",
      stylistOptions: [],
      styleCategoryValue: "",
      styleCategoryOption: [],
    };
  },
  computed: {
    ...mapGetters(["myStyleProductsRows"]),

    productGallaryValidation() {
      let noOfImgs = this.formData.galleryImgs.length;
      if (noOfImgs <= 0 && this.isediting == "edit") {
        return false;
      } else {
        if (noOfImgs > 2 && noOfImgs < 6) {
          return false;
        } else {
          return true;
        }
      }
    },
  },
  methods: {
    ...mapActions([
      "updateOrCreateStyle",
      "search",
      "createTag",
      "createStyleCategory",
      "deleteProductGallaryApi",
      "getApiData",
      "postApiForm",
    ]),
    ...mapMutations(["setApiLoading", "setStyleProductsRows"]),

    customLabel(option) {
      return `${option.name_translations[0].name}`;
    },
    customStyleLabel(option) {
      return `${option.name_translations[0].name} - ${option.name_translations[1].name}`;
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
      this.icon_preview= URL.createObjectURL(event.target.files[0]);
    },
    addGalleryImgs(event) {
      let tempImgs = event.target.files;
      for (const i of Object.keys(tempImgs)) {
        if (tempImgs[i].size > 4000000) {
          //4M
          this.$swal({
            icon: "error",
            title: "Error!",
            text: "Size cannot exceed 4M.",
          });
          return;
        }
        let img = {};
        img.id = "";
        img.img_preview = URL.createObjectURL(tempImgs[i]);
        img.file = tempImgs[i];
        this.formData.galleryImgs.push(img);
        // this.formData.galleryImgs.push(tempImgs[i]);
      }
      this.$refs.formGallaryImgs.value = null;
    },

    deleteProductGallary(gallary) {
      console.log(gallary);
      if (gallary.id == "") {
        var gallaries = this.formData.galleryImgs.filter((g) => {
          return g.file.name != gallary.file.name;
        });
        console.log(gallaries);
        this.formData.galleryImgs = gallaries;
      } else {
        let form_data = {
          id: gallary.id,
          type: "style",
        };
        this.deleteProductGallaryApi(form_data);

        var gallaries = this.formData.galleryImgs.filter((g) => {
          return g.id != gallary.id;
        });
        this.formData.galleryImgs = gallaries;
      }
    },
    checkValidation(e) {
      e.preventDefault();
      this.isValidationSuccess = true;
      let form_data = new FormData();
      let name_translations = [this.formData.name, this.formData.mm_name];
      form_data.append("data", JSON.stringify(name_translations));

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

      // this.validateRules();
      // if (!this.isValidationSuccess) {
      //     this.scrollToTop();
      // }
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
          console.log("res", res);
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
    OncreateStylist() {
      if (
        this.formData.stylist.name == null ||
        this.formData.stylist.name == ""
      ) {
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "Fill stylist name.",
          showConfirmButton: false,
          timer: 1000,
        });
        return;
      }
      let form_data = new FormData();
      let submitData = [this.formData.stylist];
      form_data.append("data", JSON.stringify(submitData));

      let pl = { form_data: form_data, url: "style_name" };
      this.postApiForm(pl)
        .then((res) => {
          this.closeModal();
          this.$swal({
            icon: "success",
            title: "Created!",
            text: "Stylist has been created.",
            showConfirmButton: false,
            timer: 1000,
          });

          this.formData.stylist.name = null;
          this.getStylists();
        })
        .catch((error) => {
          this.$swal("Error!", error.response.data.message[0].message, "error");
        });
    },
    oncreateSeries(payload) {
      console.log("creating series", payload);
      let form_data = new FormData();
      let submitData = [payload.name, payload.mm_name];
      form_data.append("data", JSON.stringify(submitData));
      form_data.append("type", this.filterValue.value);

      let brandIdArray = [];
      this.brandValues.forEach((b) => {
        brandIdArray.push(b.id);
      });
      form_data.append(
        "brands",
        brandIdArray.length > 0 ? JSON.stringify(brandIdArray) : ""
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
    onCreateStyleCategory() {
      if (
        this.formData.style_category_name.name == "" ||
        this.formData.style_category_mm_name.name == "" ||
        this.formData.categoryGenderValue == "" 
      ) {
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "Fill all fields.",
          showConfirmButton: false,
          timer: 1000,
        });
        return;
      }
      let form_data = new FormData();
      let style_category = [
        this.formData.style_category_name,
        this.formData.style_category_mm_name,
      ];
      form_data.append("data", JSON.stringify(style_category));
      form_data.append("gender_id", this.categoryGenderValue.id);
      if (this.filterValue.value == "style") {
        form_data.append("type", "style");
      } else {
        form_data.append("type", "pack");
      }
      this.createStyleCategory(form_data)
        .then((res) => {
          console.log("res", res);
          this.closeModal();

          this.$swal({
            icon: "success",
            title: "Created!",
            text: `${this.filterValue.name} Category has been created.`,
            showConfirmButton: false,
            timer: 1000,
          });

          this.formData.style_category_name.name = null;
          this.formData.style_category_mm_name.name = null;
          this.categoryGenderValue = null;

          this.getStylePackCategory({
            url:
              this.filterValue.value == "style"
                ? "get_style_categories"
                : "get_pack_categories",
          });
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
      this.validationMsg.gender_id = "";
      this.validationMsg.season_id = "";
      this.validationMsg.occasion_id = "";
      this.validationMsg.color_ids = "";
      this.validationMsg.name = "";
      this.validationMsg.mm_name = "";
      this.validationMsg.item_code = "";
      this.validationMsg.stylist_id = "";
    },
    validateRules() {
      this.isValidationSuccess = true;
      this.resetvalidateRulesMsg();
      if (this.formData.name.name.trim() === "") {
        this.validationMsg.name = "Name is required.";
        this.isValidationSuccess = false;
      }
      if (this.formData.mm_name.name.trim() === "") {
        this.validationMsg.mm_name = "Name (myanmar) is required.";
        this.isValidationSuccess = false;
      }
      if (this.formData.item_code.trim() === "") {
        this.validationMsg.item_code = `${this.filterValue.name} Item Code is required.`;
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

      if (this.genderValue == "") {
        this.validationMsg.gender_id = "Gender is required.";
        this.isValidationSuccess = false;
      }
      if (this.seasonValue.length == 0) {
        this.validationMsg.season_id = "Season is required.";
        this.isValidationSuccess = false;
      }
      if (this.occasionValue == "") {
        this.validationMsg.occasion_id = "Occasion is required.";
        this.isValidationSuccess = false;
      }
      if (this.stylistValues.length == 0) {
        this.validationMsg.stylist_id = "Stylist is required.";
        this.isValidationSuccess = false;
      }
      if (this.colorValue == "") {
        this.validationMsg.color_ids = "Colors are required.";
        this.isValidationSuccess = false;
      }
      if (
        Object.keys(this.formData.icon).length <= 0 &&
        this.isediting == "create"
      ) {
        this.validationMsg.icon = "Photo is required";
        this.isValidationSuccess = false;
      }
      if (this.productGallaryValidation) {
        this.isValidationSuccess = false;
      }
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
    //

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
    async getStylists() {
      let res = await this.getApiData({ url: "get_style_name" });
      this.stylistOptions = res.data.data;
    },
    async getSeries() {
      let brandIdArray = [];
      if (this.brandValues != "") {
        this.brandValues.forEach((b) => {
          brandIdArray.push(b.id);
        });
      }
      let url = `get_product_series?type=${this.filterValue.value}&brand_id=${
        this.brandValues == "" ? "" : brandIdArray
      }`;
      let res = await this.getApiData({ url: url });
      this.seriesOptions = res.data.data;
    },
    async getStylePackCategory(payload) {
      let res = await axios.get(`/${payload.url}`);
      this.styleCategoryOption = res.data.data;
    },

    changeType() {
      console.log(this.filterValue.name);
      this.getStylePackCategory({
        url:
          this.filterValue.value == "style"
            ? "get_style_categories"
            : "get_pack_categories",
      });
    },
    onPublish(payload) {
      // console.log("onpublish", this.myStyleProductsRows);
      let form_data = new FormData();
      if (this.isediting == "edit") {
        form_data.append("id", this.formData.id);
      }
      let name_translations = [this.formData.name, this.formData.mm_name];
      form_data.append("type", this.filterValue.value);
      form_data.append("data", JSON.stringify(name_translations));
      form_data.append("item_code", this.formData.item_code);
      form_data.append("is_feature", this.formData.is_feature ? 1 : 0);

      form_data.append("brands", JSON.stringify(this.brandValues));
      form_data.append("gender", JSON.stringify(this.genderValue));
      form_data.append("tag", JSON.stringify(this.tagValues));
      form_data.append("series", JSON.stringify(this.seriesValues));
      form_data.append("season", JSON.stringify(this.seasonValue));
      form_data.append("occasion", JSON.stringify(this.occasionValue));
      form_data.append("color", JSON.stringify(this.colorValue));
      form_data.append("stylist", JSON.stringify(this.stylistValues));
      form_data.append(
        "style_category",
        JSON.stringify(this.styleCategoryValue)
      );

      let description_names = [
        this.formData.description_name,
        this.formData.description_mm_name,
      ];
      form_data.append("description", JSON.stringify(description_names));

      if (Object.keys(this.formData.icon).length > 0) {
        form_data.append(
          "photo",
          this.formData.icon.data,
          this.formData.icon.name
        );
      }
      for (const k of Object.keys(this.formData.galleryImgs)) {
        if (this.formData.galleryImgs[k].file) {
          form_data.append("gallery[]", this.formData.galleryImgs[k].file);
        }
      }

      let style_product_data = [];
      this.myStyleProductsRows.forEach((row) => {
        let product = {
          product_id: row.id,
          color_id:
            this.isediting == "edit"
              ? row.colors[0].id
              : row.thing.colors[0].id,
        };
        style_product_data.push(product);
      });
      form_data.append("products", JSON.stringify(style_product_data));

      this.validateRules();
      if (!this.isValidationSuccess) {
        this.scrollToTop();
      } else {
        this.setApiLoading(true);
        this.updateOrCreateStyle(form_data)
          .then((res) => {
            this.setApiLoading(false);

            console.log("res", res);
            let msg = this.isediting == "create" ? "Created !" : "Updated !";

            this.$swal({
              icon: "success",
              title: msg,
              text: `${this.filterValue.name} has been created.`,
              showConfirmButton: false,
              timer: 1000,
            });

            window.location.href = "/style_lists";
          })
          .catch((error) => {
            this.scrollToTop();
            this.setApiLoading(false);
            this.validateResError(error);
          });
      }
    },
    getImages() {
      //load image from s3
      let uniqImages = [...new Set(this.image_previews)]; //remove duplicate images
      const imageLoadings = uniqImages.map((imageSrc) => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.src = imageSrc;
          img.onload = resolve;
          img.onerror = reject;
        });
      });
      console.log("load images");
      Promise.all(imageLoadings)
        .then(() => {
          console.log("Images loaded!");
          this.isLoading = false;
        })
        .catch((error) => {
          console.error("Some image(s) failed loading!");
        });
    },
    async getStyleDetail() {
      let uri = window.location.href.split("/");
      let uriLast = uri.length - 1;
      let res = await axios.get(`/styles/${uri[uriLast]}`);
      res = res.data.data;
      console.log("res", res);
      this.formData.id = res.id;
      this.formData.item_code = res.item_code;
      if (res.type == "style") {
        this.filterValue = { name: "Style", value: "style" };
      } else {
        this.filterValue = { name: "Pack", value: "pack" };
      }

      res.style_photos.forEach((photo) => {
        if (photo.type == "gallery") {
          let image_url = photo.name;
          let img = {
            id: photo.id,
            file: "",
            img_preview: image_url,
          };
          this.formData.galleryImgs.push(img);
          this.image_previews.push(image_url);
        }
        if (photo.type == "gallery") {
          let image_url = photo.name;
          this.icon_preview = photo.name;
          this.image_previews.push(image_url);
        }
      });
      res.name_translations.forEach((p_name_translation) => {
        if (p_name_translation.language_code == "en") {
          this.formData.name.name = p_name_translation.name;
        }
        if (p_name_translation.language_code == "mm") {
          this.formData.mm_name.name = p_name_translation.name;
        }
      });
      res.description_translations.forEach((desc_translation) => {
        if (desc_translation.language_code == "en") {
          this.formData.description_name.name = desc_translation.name;
        }
        if (desc_translation.language_code == "mm") {
          this.formData.description_mm_name.name = desc_translation.name;
        }
      });
      this.brandValues = res.thing.brands;
      this.genderValue = res.thing.genders[0];
      this.tagValues = res.thing.tags;
      this.seasonValue = res.thing.seasons[0];
      this.occasionValue = res.thing.occasions;
      this.colorValue = res.thing.colors[0];
      this.styleCategoryValue = res.thing.categories;
      this.seriesValues = res.series[0];
      this.stylistValues = res.style_names[0];
      this.formData.is_feature = res.is_feature ? true : false;
      this.setStyleProductsRows(res.products);
      this.getImages();
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
    deleteImage() {
        this.formData.icon = {};
        this.icon_preview = null;
        this.$refs.iconFile.value = null;
    },
  },
  watch: {
    brandValues(newVal, oldVal) {
      this.getSeries();
    },
  },
  mounted() {
    if (this.isediting == "edit") {
      this.getStyleDetail().then((res) => {});
    }
    this.getColors();

    this.getTags();
    this.getStylePackCategory({ url: "get_style_categories" });

    this.getOccasions();
    this.getBrands();
    this.getTaxClass();
    this.getGender();
    this.getSeasons();
    this.getSeries();
    this.getStylists();
  },
};
</script>
