<template>
    <div class="inner-main-container">
        <div>
            <div>
                <div>
                    <p class="page-tittle">
                        {{ isediting == "edit" ? "Edit" : "CreateOrUpdate" }}
                        Collection
                    </p>
                </div>
                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-7 gap-y-2 gap-x-8 mx-2">
                        <div class="col-span-2">
                            <label for="" class="label-form"
                                >Collection Name</label
                            >
                        </div>
                        <div class="col-span-2">
                            <label for="" class="label-form">&nbsp;</label>
                        </div>
                        <div class="col-span-2">
                            <label for="" class="label-form"
                                >Collection Item Code</label
                            >
                        </div>
                        <div class="col-span-1">
                            <!-- free space for grid -->
                        </div>

                        <!-- start row -->
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    v-model="formData.name.name"
                                    type="text"
                                    class="form-control input-form mt-2"
                                    id=""
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
                                    type="text"
                                    class="form-control input-form mt-2"
                                    id=""
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
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    v-model="formData.item_code"
                                    type="text"
                                    class="mt-2 input-form"
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
                        <div class="col-span-1">
                            <!-- free space for grid  -->
                        </div>

                        <div class="col-span-7">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-2">
                            <label for="brand" class="label-form"
                                >Brand (Optinoal**)</label
                            >
                        </div>
                        <div class="col-span-2">
                            <label for="gender" class="label-form"
                                >Gender</label
                            >
                        </div>
                        <div class="col-span-2">
                            <label for="tag" class="label-form"
                                >Tag (optional)</label
                            >
                        </div>
                        <div class="col-span-1">
                            <!-- free space -->
                        </div>
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
                                <p
                                    class="text-red-600 text-xs"
                                    v-show="validationMsg.brand_id"
                                >
                                    {{ validationMsg.brand_id }}
                                </p>
                            </div>
                        </div>
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
                        <div class="col-span-2">
                            <div class="form-group mb-4 block">
                                <multiselect
                                    v-model="tagValues"
                                    :options="tagOptions"
                                    :multiple="true"
                                    :close-on-select="true"
                                    :clear-on-select="true"
                                    :preserve-search="true"
                                    :custom-label="customLabel"
                                    :show-labels="false"
                                    placeholder="Choose tags"
                                    :preselect-first="true"
                                    id="tag_ids"
                                    track-by="id"
                                >
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <button
                                class="block -ml-3"
                                title="Add Tag"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#add_tag"
                                data-toggle="modal"
                            >
                                <i
                                    class="fal fa-plus text-gray-700 pr-3 py-2"
                                ></i>
                            </button>
                        </div>

                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-2">
                            <label for="occassion" class="label-form"
                                >Occassions</label
                            >
                        </div>
                        <div class="col-span-4">
                            <label for="season" class="label-form"
                                >Seasons</label
                            >
                        </div>

                        <div class="col-span-1"></div>

                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <multiselect
                                    :multiple="true"
                                    v-model="occasionValue"
                                    :options="occasionOptions"
                                    :searchable="false"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customLabel"
                                    placeholder="Choose occasion"
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
                        <div class="col-span-3">
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
                            <div class="form-group">
                                <div class="form-check">
                                    <input
                                        :checked="
                                            formData.is_feature == 1
                                                ? true
                                                : false
                                        "
                                        v-model="formData.is_feature"
                                        class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2"
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
                        <!-- end row     -->

                        <!-- start row -->
                        <div class="col-span-2">
                            <label for="Color" class="label-form">Color</label>
                        </div>
                        <div class="col-span-4">
                            <label for="collection_category" class="label-form"
                                >Collection Category (optional)</label
                            >
                        </div>
                        <div class="col-span-1"></div>

                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <multiselect
                                    v-model="colorValue"
                                    :options="colorOptions"
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
                        <div class="col-span-4">
                            <div class="form-group mb-4 block">
                                <multiselect
                                    v-model="collectionCategoryValue"
                                    :options="collectionCategoryOption"
                                    :multiple="true"
                                    :close-on-select="true"
                                    :clear-on-select="true"
                                    :preserve-search="true"
                                    :custom-label="customStyleLabel"
                                    :show-labels="false"
                                    placeholder="Choose Category"
                                    :preselect-first="true"
                                    id="color_ids"
                                    track-by="id"
                                >
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <button
                                class="block -ml-3"
                                title="Add Collection Category"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#add_category"
                                data-toggle="modal"
                            >
                                <i
                                    class="fal fa-plus text-gray-700 pr-3 py-2"
                                ></i>
                            </button>
                        </div>

                        <div class="col-span-7">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-6">
                            <div class="form-group mb-6">
                                <label
                                    for=""
                                    class="form-label block label-form mb-3"
                                >
                                    Collection Description
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
                        <div class="col-span-1"></div>
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
                        <div class="col-span-1"></div>
                        <div class="col-span-7">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->

                        <div class="col-span-6">
                            <div class="form-group mb-4">
                                <label for="" class="form-label label-form">
                                    Collection Photo
                                </label>
                                <input
                                    @change="onChange"
                                    type="file"
                                    class="form-control input-form mt-3"
                                    accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                                    ref="iconFile"
                                />
                                <img-preview
                                    :img-preview="icon_preview"
                                    :delete-image="deleteImage"
                                />
                                <p
                                    class="text-red-600 text-xs"
                                    v-show="validationMsg.icon"
                                >
                                    {{ validationMsg.icon }}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2"></div>
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
                <collection-create-edit-tag-two
                    @onPublish="onPublish"
                    @getCollectionDetail="getCollectionDetail"
                    :isediting="isediting"
                    :validatedproductstyle="validationMsg.product_or_style"
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
                            Create Collection Category
                        </p>
                    </div>
                    <div class="modal-body px-2 mx-2">
                        <form>
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group">
                                    <label
                                        for="Name"
                                        class="form-label label-form"
                                        >Name (In English)</label
                                    >
                                    <input
                                        v-model="
                                            formData.collection_category_name
                                                .name
                                        "
                                        type="text"
                                        class="form-control input-form mt-3"
                                        id="Name"
                                        placeholder=""
                                    />
                                </div>
                                <div class="form-group">
                                    <label
                                        for="mmName"
                                        class="form-label label-form"
                                        >Name (In Myanmar)</label
                                    >
                                    <input
                                        v-model="
                                            formData.collection_category_mm_name
                                                .name
                                        "
                                        type="text"
                                        class="form-control input-form mt-3"
                                        id="mmName"
                                        placeholder=""
                                    />
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer modal-btn-container">
                        <button
                            @click="onCreateCollectionCategory"
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
                                    <label
                                        for="Name"
                                        class="form-label label-form"
                                        >Name</label
                                    >
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
                                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2"
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
    </div>

    <!-- Modal -->
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import collectionCreateEditTagTwo from "../Components/CollectionCreateEditTagTwo.vue";
import ImgPreview from "../Components/imgPreview.vue";
export default {
    name: "collectionCreateEdit",
    components: {
        Multiselect,
        collectionCreateEditTagTwo,
        ImgPreview,
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
                is_feature: false,
                description_mm_name: {
                    name: "",
                    language_code: "mm",
                },

                collection_category_name: {
                    name: "",
                    language_code: "en",
                },
                collection_category_mm_name: {
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
            },
            icon_preview: "",
            validationMsg: {
                icon: "",
                item_code: "",
                description_mm_name: "",
                description_name: "",
                gender_id: "",
                season_id: "",
                occasion_id: "",
                color_ids: "",
                name: "",
                mm_name: "",
                product_or_style: "",
            },
            isValidationSuccess: false,
            brandValues: [],
            brandOptions: [],
            genderValue: "",
            genderOptions: [],
            seasonValue: [],
            seasonOptions: [],
            occasionValue: [],
            occasionOptions: [],
            colorValue: "",
            colorOptions: [],
            tagValues: [],
            tagOptions: [],
            collectionCategoryValue: "",
            collectionCategoryOption: [],
        };
    },
    computed: {
        ...mapGetters([
            "my_collection_style_rows",
            "my_collection_product_rows",
        ]),
    },
    methods: {
        ...mapActions([
            "updateOrCreateCollection",
            "search",
            "createTag",
            "createStyleCategory",
            "getApiData",
            "postApiForm",
        ]),
        ...mapMutations([
            "setCollectionStyleRows",
            "setApiLoading",
            "setCollectionProductRows",
        ]),
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
            this.icon_preview = URL.createObjectURL(event.target.files[0]);
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
                    this.$swal({
                        icon: "error",
                        title: "Error!",
                        text: error.response.data.message[0].message,
                        showConfirmButton: false,
                        timer: 1000,
                    });
                });
        },
        onCreateCollectionCategory() {
            if (
                this.formData.collection_category_name.name == "" ||
                this.formData.collection_category_mm_name.name == ""
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
            let collection_category = [
                this.formData.collection_category_name,
                this.formData.collection_category_mm_name,
            ];
            form_data.append("data", JSON.stringify(collection_category));
            form_data.append("type", "collection");
            this.createStyleCategory(form_data)
                .then((res) => {
                    console.log("res", res);
                    this.closeModal();

                    this.$swal({
                        icon: "success",
                        title: "Created!",
                        text: "Collection Category has been created.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    this.formData.collection_category_name.name = null;
                    this.formData.collection_category_mm_name.name = null;
                    this.getCollectionCategory();
                })
                .catch((error) => {
                    this.$swal(
                        "Error!",
                        error.response.data.message[0].message,
                        "error"
                    );
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
            this.validationMsg.product_or_style = "";
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
                this.validationMsg.item_code =
                    "Collection Item Code is required.";
                this.isValidationSuccess = false;
            }

            if (this.formData.description_name.name.trim() == "") {
                this.validationMsg.description_name =
                    "Description is required.";
                this.isValidationSuccess = false;
            }
            if (this.formData.description_name.name.trim() == "") {
                this.validationMsg.description_mm_name =
                    "Description(myanmar) is required.";
                this.isValidationSuccess = false;
            }

            if (this.genderValue.length == 0) {
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
            if (
                this.my_collection_style_rows.length == 0 &&
                this.my_collection_product_rows.length == 0
            ) {
                console.log("rrrr");
                this.validationMsg.product_or_style =
                    "Product or style required";
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
            let res = await this.getApiData({ url: "brands" });
            this.brandOptions = res.data.data.data;
        },
        async getTags() {
            let res = await this.getApiData({ url: "get_tags" });
            this.tagOptions = res.data.data;
        },
        async getCollectionCategory() {
            let res = await this.getApiData({
                url: "get_collection_categories",
            });
            this.collectionCategoryOption = res.data.data;
        },

        onPublish(payload) {
            // console.log("onpublish", this.my_collection_style_rows);
            let form_data = new FormData();
            if (this.isediting == "edit") {
                form_data.append("id", this.formData.id);
            }
            let name_translations = [this.formData.name, this.formData.mm_name];
            form_data.append("data", JSON.stringify(name_translations));
            form_data.append("is_feature", this.formData.is_feature ? 1 : 0);

            form_data.append("item_code", this.formData.item_code);
            form_data.append("brands", JSON.stringify(this.brandValues));
            form_data.append("gender", JSON.stringify(this.genderValue));
            form_data.append("tag", JSON.stringify(this.tagValues));
            form_data.append("season", JSON.stringify(this.seasonValue));
            form_data.append("occasion", JSON.stringify(this.occasionValue));
            form_data.append("color", JSON.stringify(this.colorValue));
            form_data.append(
                "collection_category",
                JSON.stringify(this.collectionCategoryValue)
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

            let style_data = [];
            this.my_collection_style_rows.forEach((row) => {
                let style = {
                    style_id: row.id,
                };
                style_data.push(style);
            });
            form_data.append("styles", JSON.stringify(style_data));

            let product_data = [];
            this.my_collection_product_rows.forEach((row) => {
                let product = {
                    product_id: row.id,
                };
                product_data.push(product);
            });
            form_data.append("products", JSON.stringify(product_data));
            // form_data.append(
            //     "sub_products",
            //     JSON.stringify(this.my_collection_product_rows)
            // );

            this.validateRules();
            if (!this.isValidationSuccess) {
                this.scrollToTop();
            } else {
                this.setApiLoading(true);

                this.updateOrCreateCollection(form_data)
                    .then((res) => {
                        this.setApiLoading(false);

                        console.log("res", res);
                        let msg =
                            this.isediting == "create"
                                ? "Created !"
                                : "Updated !";
                        this.$swal(
                            msg,
                            "Collections has been created.",
                            "success"
                        );
                        window.location.href = "/collection_lists";
                    })
                    .catch((error) => {
                        this.scrollToTop();
                        this.setApiLoading(false);
                        this.validateResError(error);
                    });
            }
        },
        async getCollectionDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/collections/${uri[uriLast]}`);
            res = res.data.data;
            this.formData.id = res.id;
            this.formData.item_code = res.item_code;
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
                    this.formData.description_mm_name.name =
                        desc_translation.name;
                }
            });
            this.formData.is_feature = res.is_feature ? true : false;
            this.brandValues = res.thing.brands;
            this.genderValue = res.thing.genders[0];
            this.tagValues = res.thing.tags;
            this.seasonValue = res.thing.seasons;
            this.occasionValue = res.thing.occasions[0];
            this.colorValue = res.thing.colors[0];
            this.collectionCategoryValue = res.thing.categories;
            this.setCollectionStyleRows(res.styles);
            console.log(res.sub_products);
            this.setCollectionProductRows(res.products);
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
    mounted() {
        //in collectionCreateEditTwo
        // if (this.isediting == "edit") {
        //     this.getCollectionDetail().then((res) => {});
        // }//
        this.getColors();

        this.getTags();
        this.getCollectionCategory();

        this.getOccasions();
        this.getBrands();
        this.getTaxClass();
        this.getGender();
        this.getSeasons();
    },
};
</script>
