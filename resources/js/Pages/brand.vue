<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Brand Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox :mutationName="mutationName" pagination-url="brands?" />
            <!-- @include('layouts.search_box')  -->
            <createbtn v-on:open_create_modal="clearFormData" />
            <!-- @include('layouts.create_button')  -->
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brand in myBrands" :key="brand.id">
                        <td>
                            {{ brand.index }}
                        </td>
                        <td>
                            <div class="item-img-container">
                                <img alt="" :src="brand.logo" />
                            </div>
                        </td>
                        <td>
                            <div
                                v-for="name_translation in brand.name_translations"
                                :key="name_translation.id"
                            >
                                <p
                                    v-if="
                                        name_translation.language_code == 'en'
                                    "
                                >
                                    {{ name_translation.name }}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="brand.is_available"
                                    @click="
                                        availableChange({
                                            data: brand,
                                            url: 'brands',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <button
                                type="button"
                                title="Edit"
                                id="edit-button"
                                @click="open_edit_modal(brand.id)"
                            >
                                <!-- data-bs-toggle="modal" -->
                                <!-- data-bs-target="#edit_modal" -->

                                <i class="fal fa-file-edit fw300"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myBrands.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="10"
                :mutationName="mutationName"
                pagination-url="brands?"
            />
            <!-- Modal -->
            <div
                class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                id="create_modal"
                tabindex="-1"
                aria-labelledby="createModalLabel"
                aria-hidden="true"
                ref="modal"
            >
                <div class="modal-dialog modal-box">
                    <form>
                        <div class="modal-content content-modal-normal">
                            <div class="modal-header border-b-0">
                                <p class="title-modal">
                                    {{
                                        getisEditing
                                            ? "Edit Brand"
                                            : "Create Brand"
                                    }}
                                </p>
                            </div>
                            <div class="modal-body px-2">
                                <div
                                    class="block px-6 pt-6 rounded-lg bg-white"
                                >
                                    <div class="flex flex-row">
                                        <div class="basis-1/2 mr-4">
                                            <div class="form-group mb-4">
                                                <label
                                                    for="name"
                                                    class="form-label label-form"
                                                    >Brand Name</label
                                                >
                                                <input
                                                    v-model="formData.name.name"
                                                    type="text"
                                                    class="form-control input-form mt-2"
                                                    autocomplete="off"
                                                    :class="
                                                        validationMsg.name
                                                            ? 'border-red-500'
                                                            : 'border-gray-300'
                                                    "
                                                    id="name"
                                                    placeholder=""
                                                />
                                                <p
                                                    class="text-red-600 text-xs"
                                                    v-show="validationMsg.name"
                                                >
                                                    {{ validationMsg.name }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="basis-1/2">
                                            <div class="form-group mb-4">
                                                <label
                                                    for="sku_name"
                                                    class="form-label label-form"
                                                    >Brand SKU Number</label
                                                >
                                                <input
                                                    v-model="formData.sku_name"
                                                    type="text"
                                                    class="form-control input-form mt-2"
                                                    autocomplete="off"
                                                    :class="
                                                        validationMsg.sku_name
                                                            ? 'border-red-500'
                                                            : 'border-gray-300'
                                                    "
                                                    id="sku_name"
                                                    placeholder=""
                                                />
                                                <p
                                                    class="text-red-600 text-xs"
                                                    v-show="
                                                        validationMsg.sku_name
                                                    "
                                                >
                                                    {{ validationMsg.sku_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-row">
                                        <div class="basis-full">
                                            <div class="form-group mb-4">
                                                <label
                                                    for="country_id"
                                                    class="form-label label-form"
                                                    >Country</label
                                                >
                                                <multiselect
                                                    class="mt-2"
                                                    v-model="value"
                                                    :options="options"
                                                    :searchable="true"
                                                    :close-on-select="true"
                                                    :show-labels="false"
                                                    :custom-label="customLabel"
                                                    placeholder="Choose a country"
                                                ></multiselect>
                                                <p
                                                    class="text-red-600 text-xs"
                                                    v-show="
                                                        validationMsg.country_id
                                                    "
                                                >
                                                    {{
                                                        validationMsg.country_id
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label
                                            for="icon"
                                            class="form-label label-form"
                                            >Brand Logo</label
                                        >
                                        <input
                                            @change="onChange"
                                            type="file"
                                            class="form-control input-form mt-2 px-3 py-1.5 text-gray-700 focus:text-gray-700"
                                            :class="
                                                validationMsg.icon
                                                    ? 'border-red-500'
                                                    : 'border-gray-300'
                                            "
                                            id="icon"
                                            placeholder=""
                                            ref="iconFile"
                                            accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                                        />
                                        <img-preview
                                            :img-preview="icon_preview"
                                            :delete-image="deleteImage"
                                            type="icon"
                                        />
                                        <p
                                            class="text-red-600 text-xs"
                                            v-show="validationMsg.icon"
                                            type="image"
                                        >
                                            {{ validationMsg.icon }}
                                        </p>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label
                                            for="photo"
                                            class="form-label label-form"
                                            >Brand Photo</label
                                        >
                                        <input
                                            @change="onChangePhoto"
                                            type="file"
                                            class="form-control input-form mt-2 px-3 py-1.5 text-gray-700 focus:text-gray-700 focus:bg-white"
                                            :class="
                                                validationMsg.photo
                                                    ? 'border-red-500'
                                                    : 'border-gray-300'
                                            "
                                            id="photo"
                                            placeholder=""
                                            ref="photoFile"
                                            accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                                        />
                                        <img-preview
                                            :img-preview="photo_preview"
                                            :delete-image="deleteImage"
                                            type="photo"
                                        />
                                        <p
                                            class="text-red-600 text-xs"
                                            v-show="validationMsg.photo"
                                        >
                                            {{ validationMsg.photo }}
                                        </p>
                                    </div>

                                    <div class="form-group mb-6">
                                        <div class="form-check">
                                            <input
                                                :checked="
                                                    formData.is_women_feature == 1
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
                                                Men Feature
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-6">
                                        <div class="form-check">
                                            <input
                                                :checked="
                                                    formData.is_women_feature == 1
                                                        ? true
                                                        : false
                                                "
                                                v-model="formData.is_women_feature"
                                                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDisabled"
                                            />
                                            <label
                                                class="form-check-label inline-block text-gray-800"
                                                for="flexCheckDisabled"
                                            >
                                                Women Feature
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="modal-footer modal-footer-box justify-start px-8 pt-0 pb-8"
                            >
                                <button
                                    :disabled="currentApiLoading"
                                    @click="createOrUpdate"
                                    type="button"
                                    class="px-6 py-2.5 mr-5 primary-button"
                                >
                                    <!-- data-bs-dismiss="modal" -->
                                    <api-loading />
                                    {{ getisEditing ? "Save" : "Create" }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-light"
                                    data-bs-dismiss="modal"
                                    id="cancel"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import apiLoading from "./../Components/apiLoadingComponent";
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import ImgPreview from "../Components/imgPreview.vue";

export default {
    name: "Brand",
    components: {
        Createbtn,
        SearchBox,
        Multiselect,
        apiLoading,
        ImgPreview,
    },
    data() {
        return {
            typeOfSearch: "brand",
            mutationName: "setBrands",
            formData: {
                id: "",
                name: {
                    name: "",
                    language_code: "en",
                },
                sku_name: "",
                icon: {},
                photo: {},
                is_feature: false,
                is_women_feature: false,
            },
            icon_preview: "",
            photo_preview: "",
            validationMsg: {
                name: "",
                sku_name: "",
                country_id: "",
                icon: "",
                photo: "",
            },
            value: "",
            options: [],
        };
    },
    computed: {
        ...mapGetters([
            "myBrands",
            "getisEditing",
            "myCountries",
            "currentApiLoading",
        ]),
        images() {
            let image_previews = [];
            this.myBrands.forEach((element) => {
                image_previews.push(element.logo);
            });
            return image_previews;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "updateOrCreateData",
            "search",
            "getCountriesLists",
            "availableChange",
            "getApiData",
        ]),
        ...mapMutations(["setisEditing", "setApiLoading"]),
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
        onChangePhoto(event) {
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
            this.photo_preview = URL.createObjectURL(event.target.files[0]);
        },
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        open_edit_modal(brand_id) {
            this.validationMsg.name = null;
            this.validationMsg.sku_name = null;
            this.validationMsg.country_id = null;
            this.validationMsg.icon = null;
            this.validationMsg.photo = null;
            this.value = null;
            this.setisEditing(true); //
            axios
                .get(`/brands/${brand_id}`)
                .then((res) => {
                    this.formData.id = res.data.data.id;
                    res.data.data.name_translations.forEach(
                        (name_translation) => {
                            if (name_translation.language_code == "en") {
                                this.formData.name.name = name_translation.name;
                            }
                        }
                    );
                    this.formData.sku_name = res.data.data.sku_name;
                    this.formData.is_feature = res.data.data.is_feature
                    this.formData.is_women_feature = res.data.data.is_women_feature
                        ? true
                        : false;
                    this.value = res.data.data.country;
                    console.log(res.data.data);
                    this.icon_preview = res.data.data.logo;
                    this.$refs.iconFile.value = null;
                    this.photo_preview = res.data.data.photo;
                    this.$refs.photoFile.value = null;
                    $("#create_modal").modal("show");
                })
                .catch((error) => {
                    console.log(error.response);
                })
                .finally(() => {});
        },
        closeModal() {
            document.getElementById("cancel").click();
        },
        validateRules() {
            if (this.formData?.name?.name === null) {
                this.validationMsg.name = "Name is required.";
            }
            if (this.formData.sku_name.trim() == null) {
                this.validationMsg.sku_name = "Myanmar Name is required.";
            }
            if (this.value == "") {
                this.validationMsg.country_id = "Country is required.";
            }
            if (
                Object.keys(this.formData.icon).length == 0 &&
                this.getisEditing == false
            ) {
                this.validationMsg.icon = "Icon image is required.";
            }
            if (
                Object.keys(this.formData.photo).length == 0 &&
                this.getisEditing == false
            ) {
                this.validationMsg.photo = "Photo image is required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            if (this.getisEditing) {
                form_data.append("id", this.formData.id);
            }
            let names = [this.formData.name];
            form_data.append("data", JSON.stringify(names));
            form_data.append("sku_name", this.formData.sku_name);
            form_data.append("is_feature", this.formData.is_feature ? 1 : 0);
            form_data.append("is_women_feature", this.formData.is_women_feature ? 1 : 0);
            form_data.append("country_id", this.value.id);
            if (Object.keys(this.formData.icon).length > 0) {
                form_data.append(
                    "logo",
                    this.formData.icon.data,
                    this.formData.icon.name
                );
            }
            if (Object.keys(this.formData.photo).length > 0) {
                form_data.append(
                    "photo",
                    this.formData.photo.data,
                    this.formData.photo.name
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
                });
            } else {
                if (error.response.data.message.sku_name != null) {
                    this.validationMsg.sku_name =
                        error.response.data.message.sku_name;
                }
                if (error.response.data.message.icon != null) {
                    this.validationMsg.icon = error.response.data.message.icon;
                }
                if (error.response.data.message.country_id != null) {
                    this.validationMsg.country_id =
                        error.response.data.message.country_id;
                }
                if (error.response.data.message.photo != null) {
                    this.validationMsg.photo =
                        error.response.data.message.photo;
                }
            }
        },
        async createOrUpdate(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.sku_name = "";
            this.validationMsg.country_id = "";
            this.validationMsg.icon = "";
            this.validationMsg.photo = "";
            this.validateRules();

            if (
                this.validationMsg.name == "" &&
                this.validationMsg.sku_name == "" &&
                this.validationMsg.country_id == "" &&
                this.validationMsg.icon == "" &&
                this.validationMsg.photo == ""
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    type: this.getisEditing ? "update" : "create",
                    url: "brands",
                    paginateMutation: this.mutationName,
                };
                this.setApiLoading(true);

                this.updateOrCreateData(payload)
                    .then((res) => {
                        this.setApiLoading(false);

                        this.closeModal();

                        this.$swal({
                            icon: "success",
                            title: `${
                                this.getisEditing ? "Updated!" : "Created"
                            }`,
                            text: `Brands has been ${
                                this.getisEditing ? "updated" : "created"
                            }.`,
                            showConfirmButton: false,
                            timer: 1000,
                        });

                        this.clearFormData();
                    })
                    .catch((error) => {
                        this.setApiLoading(false);
                        this.validateResError(error);
                        $("#create_modal").modal("show");
                    });
            } else {
                let element = this.$refs.modal.$el;
                $(element).modal("show");
                $("#create_modal").modal("show");
            }
        },

        clearFormData() {
            this.formData.name.name = null;
            this.formData.icon = {};
            this.formData.photo = {};
            this.formData.sku_name = null;
            this.value = "";
            this.validationMsg.name = null;
            this.validationMsg.sku_name = null;
            this.validationMsg.country_id = null;
            this.validationMsg.icon = null;
            this.validationMsg.photo = null;
            this.$refs.iconFile.value = null;
            this.$refs.photoFile.value = null;
            this.icon_preview = null;
            this.photo_preview = null;
        },

        async getCountries() {
            let res = await this.getApiData({ url: "countries" });
            this.options = res.data.data;
        },
        getImages() {
            //load image from s3
            let uniqImages = [...new Set(this.images)]; //remove duplicate images
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
        deleteImage(icon = null) {
            console.log(icon);
            if (icon == "icon") {
                this.formData.icon = {};
                this.$refs.iconFile.value = null;
                this.icon_preview = "";
            } else {
                this.formData.photo = {};
                this.$refs.photoFile.value = null;
                this.photo_preview = "";
            }
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "brands?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
        this.getCountries();
        this.getImages();
    },
};
</script>
