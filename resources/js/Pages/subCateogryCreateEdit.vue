<template>
    <div class="inner-main-container">
        <div class="pl-2">
            <p class="page-tittle">
                {{
                    isediting == "edit"
                        ? "Edit SubCategory"
                        : "Create SubCategory"
                }}
            </p>
        </div>
        <div class="pt-3 mb-6">
            <div class="grid grid-cols-3 gap-x-8 mx-2">
                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Sub Category Name</label
                    >
                </div>
                <div class="col-span-1">
                    <label for="" class="form-label label-form"
                        >Sub Category SKU Name</label
                    >
                </div>

                <div class="col-span-1">
                    <div class="form-group mb-4">
                        <input
                            v-model="formData.name.name"
                            type="text"
                            class="input-form mt-3"
                            :class="
                                validationMsg.name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            placeholder="In English"
                        />
                        <p class="text-validation" v-show="validationMsg.name">
                            {{ validationMsg.name }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="form-group mb-4">
                        <input
                            v-model="formData.mm_name.name"
                            type="text"
                            class="form-control input-form mt-3"
                            :class="
                                validationMsg.mm_name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            placeholder="In Myanmar"
                        />
                        <p
                            class="text-validation"
                            v-show="validationMsg.mm_name"
                        >
                            {{ validationMsg.mm_name }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="form-group mb-4">
                        <!-- <label for="engName" class="form-label label-form">Sub Category SKU Name</label> -->
                        <input
                            v-model="formData.sku_name"
                            type="text"
                            class="form-control input-form mt-3"
                            :class="
                                validationMsg.sku_name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            placeholder="In English"
                        />
                        <p
                            class="text-validation"
                            v-show="validationMsg.sku_name"
                        >
                            {{ validationMsg.sku_name }}
                        </p>
                    </div>
                </div>
                <!-- end row -->

                <!-- start row -->
                <!-- <div class="col-span-1">
                    <label for="" class="form-label label-form"
                        >Category</label
                    >
                </div><div class="col-span-1">
                    <label for="" class="form-label label-form"
                        >Unit Type</label
                    >
                </div>
                <div class="col-span-1"></div> -->

                <!-- <div class="col-span-1">
                    <div class="form-group mb-4 mt-3">
                        <multiselect
                            v-model="categoryValue"
                            :options="categoryOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customLabel"
                            placeholder="Choose Category"
                        ></multiselect>
                        <p
                            class="text-validation"
                            v-show="validationMsg.category_id"
                        >
                            {{ validationMsg.category_id }}
                        </p>
                    </div>
                </div> -->
                <!-- <div class="col-span-1">
                    <div class="form-group mb-4 mt-3"> -->
                <!-- //nubmering alpherphetic -->
                <!-- <multiselect
                            v-model="unitTypeValue"
                            :options="unitTypeOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :disabled="isediting == 'edit' ? true : false"
                            label="name"
                            track-by="id"
                            placeholder="Choose Unit Type"
                        ></multiselect>
                        <p
                            class="text-validation"
                            v-show="validationMsg.unitType_id"
                        >
                            {{ validationMsg.unitType_id }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1"></div> -->
                <!-- end row -->

                <div class="col-span-1">
                    <div class="form-group mb-4">
                        <label for="engName" class="form-label label-form"
                            >Category</label
                        >
                        <multiselect
                            class="mt-3"
                            v-model="categoryValue"
                            :options="categoryOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customLabel"
                            placeholder="Choose Category"
                        ></multiselect>
                        <p
                            class="text-validation"
                            v-show="validationMsg.category_id"
                        >
                            {{ validationMsg.category_id }}
                        </p>
                    </div>
                </div>

                <div class="col-span-1">
                    <div class="form-group mb-4">
                        <label for="engName" class="form-label label-form"
                            >Unit type</label
                        >
                        <!-- //nubmering alpherphetic -->
                        <multiselect
                            class="mt-3"
                            v-model="unitTypeValue"
                            :options="unitTypeOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :disabled="isediting == 'edit' ? true : false"
                            label="name"
                            track-by="id"
                            placeholder="Choose Unit Type"
                        ></multiselect>
                        <p
                            class="text-validation"
                            v-show="validationMsg.unitType_id"
                        >
                            {{ validationMsg.unitType_id }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="form-group">
                        <div class="form-check mt-10">
                            <input
                                :checked="
                                    formData.is_feature == 1 ? true : false
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

                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <label for="engName" class="form-label label-form"
                            >Size Charts Measurement</label
                        >
                        <multiselect
                            class="mt-3"
                            v-model="sizeMeasurValue"
                            :options="sizeMeasurOptions"
                            :multiple="true"
                            :close-on-select="true"
                            :clear-on-select="true"
                            :preserve-search="true"
                            label="name"
                            track-by="id"
                            placeholder="Choose Size Chart Measurement"
                            :preselect-first="true"
                        >
                        </multiselect>
                        <p
                            class="text-validation"
                            v-show="validationMsg.sizeMeasur_ids"
                        >
                            {{ validationMsg.sizeMeasur_ids }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1"></div>

                <div class="col-span-1" v-show="checkUnitTypeNumber">
                    <div class="form-group mb-6">
                        <label for="engName" class="form-label label-form"
                            >Unit</label
                        >
                        <multiselect
                            class="mt-3"
                            v-model="unitValue"
                            :options="unitOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            label="name"
                            track-by="id"
                            placeholder="Choose Unit "
                        ></multiselect>
                        <p
                            class="text-validation"
                            v-show="validationMsg.unit_id"
                        >
                            {{ validationMsg.unit_id }}
                        </p>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="form-group mb-7">
                        <label for="engName" class="form-label label-form"
                            >SubCategory Icon</label
                        >
                        <input
                            @change="onChange"
                            type="file"
                            class="form-control input-form mt-3"
                            :class="
                                validationMsg.icon
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="icon"
                            ref="iconFile"
                            placeholder="Choose Icon"
                            accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                        />
                        <img-preview
                            :img-preview="icon_preview"
                            :delete-image="deleteImage"
                        />
                        <p class="text-validation" v-show="validationMsg.icon">
                            {{ validationMsg.icon }}
                        </p>
                    </div>
                </div>

                <div class="col-span-3">
                    <button
                        :disabled="currentApiLoading"
                        @click="updateOrCreate"
                        type="button"
                        class="primary-button bg-black"
                    >
                        <api-loading />
                        {{ isediting == "create" ? "Create" : "Save" }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";
import Multiselect from "vue-multiselect";
import ImgPreview from "../Components/imgPreview.vue";

export default {
    name: "subcategoryCreateEdit",
    components: {
        Multiselect,
        apiLoading,
        ImgPreview,
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
                sku_name: "",
                icon: {},
                is_feature: 0,
            },
            icon_preview: "",
            validationMsg: {
                name: "",
                mm_name: "",
                sku_name: "",
                icon: "",
                category_id: "",
                unitType_id: "",
                sizeMeasur_ids: "",
                unit_id: "",
            },
            categoryValue: "",
            categoryOptions: [],
            unitTypeValue: "",
            unitTypeOptions: [],
            unitValue: "",
            unitOptions: [],
            sizeMeasurValue: [],
            sizeMeasurOptions: [],
        };
    },
    computed: {
        ...mapGetters(["currentApiLoading"]),
        checkUnitTypeNumber() {
            if (this.unitTypeValue.id == 1 || this.unitTypeValue == "") {
                return true;
            } else {
                return false;
            }
        },
    },
    methods: {
        ...mapActions(["postApiForm", "search", "getApiData"]),
        ...mapMutations(["setApiLoading"]),
        customLabel(option) {
            return `${option.name_translations[0].name}`;
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
        validateRules() {
            if (this.formData.name.name.trim() === "") {
                this.validationMsg.name = "Name is required.";
            }
            if (this.formData.mm_name.name.trim() === "") {
                this.validationMsg.mm_name = "Name (myanmar) is required.";
            }
            if (this.formData.sku_name.trim() == "") {
                this.validationMsg.sku_name = "Sku Name is required.";
            }
            if (this.categoryValue == "") {
                this.validationMsg.category_id = "Category is required.";
            }
            if (this.unitTypeValue == "") {
                this.validationMsg.unitType_id = "Unit Type is required.";
            }
            if (this.sizeMeasurValue == "") {
                this.validationMsg.sizeMeasur_ids =
                    "Size Measurements are required.";
            }
            if (
                Object.keys(this.formData.icon).length == 0 &&
                this.isediting == "create"
            ) {
                this.validationMsg.icon = "Icon image is required.";
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
            form_data.append("sku_name", this.formData.sku_name);
            form_data.append("unit_type_id", this.unitTypeValue.id);
            let unitTypeIsNumering = 1;
            if (this.unitTypeValue.id == unitTypeIsNumering) {
                form_data.append("unit_id", this.unitValue.id);
            }
            form_data.append("category_id", this.categoryValue.id);
            form_data.append("measurement_ids", JSON.stringify(sizeMeasur_ids));
            form_data.append("is_feature", this.formData.is_feature ? 1 : 0);

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
                if (error.response.data.message.sku_name != null) {
                    this.validationMsg.sku_name =
                        error.response.data.message.sku_name;
                }
                if (error.response.data.message.mesurement_ids != null) {
                    this.validationMsg.mesurement_ids =
                        error.response.data.message.mesurement_ids;
                }
                if (error.response.data.message.category_id != null) {
                    this.validationMsg.category_id =
                        error.response.data.message.category_id;
                }
                if (error.response.data.message.unit_type_id != null) {
                    this.validationMsg.unit_type_id =
                        error.response.data.message.unit_type_id;
                }
                if (error.response.data.message.icon != null) {
                    this.validationMsg.icon = error.response.data.message.icon;
                }
            }
        },
        async updateOrCreate(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.mm_name = "";
            this.validationMsg.sku_name = "";
            this.validationMsg.icon = "";
            this.validationMsg.category_id = "";
            this.validationMsg.unitType_id = "";
            this.validationMsg.sizeMeasur_ids = "";
            this.validationMsg.unit_id = "";
            this.validateRules();

            if (
                this.validationMsg.name == "" &&
                this.validationMsg.mm_name == "" &&
                this.validationMsg.sku_name == "" &&
                this.validationMsg.icon == "" &&
                this.validationMsg.category_id == "" &&
                this.validationMsg.unitType_id == "" &&
                this.validationMsg.sizeMeasur_ids == "" &&
                this.validationMsg.unit_id == ""
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    url: "sub_categories/create_or_update",
                };
                this.setApiLoading(true);
                this.postApiForm(payload)
                    .then((res) => {
                        this.setApiLoading(false);

                        this.$swal({
                            icon: "success",
                            title: `${
                                this.isediting == "create"
                                    ? "Created!"
                                    : "Updated!"
                            }`,
                            text: `Subcategory has been ${this.isediting}d.`,
                            showConfirmButton: false,
                            timer: 1000,
                        });

                        window.location.href = "/sub_categories_lists";
                    })
                    .catch((error) => {
                        this.scrollToTop();
                        this.setApiLoading(false);
                        this.validateResError(error);
                    });
            } else {
                return;
            }
        },

        async getCategories() {
            let res = await this.getApiData({ url: "get_product_categories" });
            this.categoryOptions = res.data.data;
        },
        async getUnitTypes() {
            let res = await this.getApiData({ url: "unit_types" });
            this.unitTypeOptions = res.data.data;
            this.unitOptions = res.data.data[0].units;
        },
        async getMeasurements() {
            let res = await this.getApiData({ url: "measurements" });
            this.sizeMeasurOptions = res.data.data;
        },
        async getSubCategoryDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/sub_categories/${uri[uriLast]}`);
            res = res.data.data;
            this.formData.id = res.id;
            this.formData.sku_name = res.sku_name;
            this.formData.is_feature = res.is_feature ? true : false;
            this.categoryValue = res.category;
            this.sizeMeasurValue = res.measurements;
            this.unitTypeValue = res.unit_types[0];
            this.unitValue = res.units[0];
            this.icon_preview = res.icon;
            res.name_translations.forEach((name_translation) => {
                if (name_translation.language_code == "en") {
                    this.formData.name.name = name_translation.name;
                }
                if (name_translation.language_code == "mm") {
                    this.formData.mm_name.name = name_translation.name;
                }
            });
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
        deleteImage(icon = null) {
            this.formData.icon = {};
            this.$refs.iconFile.value = null;
            this.icon_preview = "";
        },
    },
    mounted() {
        if (this.isediting == "edit") {
            this.getSubCategoryDetail();
        }
        this.getCategories();
        this.getUnitTypes();
        this.getMeasurements();
    },
};
</script>
