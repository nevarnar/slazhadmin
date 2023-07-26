<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Category Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox
                pagination-url="categories?"
                :mutationName="mutationName"
            />

            <createbtn v-on:open_create_modal="clearFormData" />
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(category, index) in myCategories" :key="index">
                        <td>
                            {{ category.index }}
                        </td>
                        <td>
                            <div class="item-img-container">
                                <img alt="" :src="category.icon" />
                            </div>
                        </td>
                        <td>
                            <div
                                v-for="name_translation in category.name_translations"
                                :key="name_translation.id"
                            >
                                <p
                                    class="text-sm"
                                    v-if="
                                        name_translation.language_code == 'en'
                                    "
                                >
                                    {{ name_translation.name }}
                                </p>
                            </div>
                        </td>

                        <td>
                            Male
                        </td>
                        <td>
                            {{ category?.type }}
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="category.is_available"
                                    @click="
                                        availableChange({
                                            data: category,
                                            url: 'categories',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <!-- v-show="category.type == 'product'" -->
                            <button
                                type="button"
                                title="Edit"
                                id="edit-button"
                                @click="open_edit_modal(category.id)"
                            >
                                <i class="fal fa-file-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myCategories.length == 0"
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
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="categories?"
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
                <div class="modal-dialog relative w-auto pointer-events-none">
                    <form>
                        <div
                            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
                        >
                            <div class="modal-header border-b-0 px-2">
                                <p class="pt-8 px-8 text-base">
                                    {{
                                        getisEditing
                                            ? "Edit Category"
                                            : "Create Category"
                                    }}
                                </p>
                            </div>
                            <div class="modal-body px-2 mx-2">
                                <div class="block p-6 rounded-lg bg-white">
                                    <div class="form-group mb-6">
                                        <label
                                            for="name"
                                            class="form-label label-form"
                                            >Category Name ( in English )</label
                                        >
                                        <input
                                            v-model="formData.name.name"
                                            type="text"
                                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 focus:shadow-none bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            :class="
                                                validationMsg.name
                                                    ? 'border-red-500'
                                                    : 'border-gray-300'
                                            "
                                            id="name"
                                            placeholder=""
                                        />
                                        <p
                                            class="text-red-600 text-sm"
                                            v-show="validationMsg.name"
                                        >
                                            {{ validationMsg.name }}
                                        </p>
                                    </div>

                                    <div class="form-group mb-6">
                                        <label
                                            for="mm_name"
                                            class="form-label label-form"
                                            >Category Name ( in Myanmar )</label
                                        >
                                        <input
                                            v-model="formData.mm_name.name"
                                            type="text"
                                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 focus:shadow-none bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            :class="
                                                validationMsg.mm_name
                                                    ? 'border-red-500'
                                                    : 'border-gray-300'
                                            "
                                            id="mm_name"
                                            placeholder=""
                                        />
                                        <p
                                            class="text-red-600 text-sm"
                                            v-show="validationMsg.mm_name"
                                        >
                                            {{ validationMsg.mm_name }}
                                        </p>
                                    </div>

                                    <div class="form-group mb-6" v-show="formData.type=='product'">
                                        <label
                                            for="icon"
                                            class="form-label label-form"
                                            >Category Icon</label
                                        >
                                        <input
                                            @change="onChange"
                                            type="file"
                                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                                        />
                                        <p
                                            class="text-red-600 text-sm"
                                            v-show="validationMsg.icon"
                                        >
                                            {{ validationMsg.icon }}
                                        </p>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label
                                            for="mm_name"
                                            class="form-label label-form"
                                            >Gender</label
                                        >
                                        <multiselect
                                            class="mt-2"
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
                                            class="text-red-600 text-sm"
                                            v-show="validationMsg.gender"
                                        >
                                            {{ validationMsg.gender }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="modal-footer modal-footer-box justify-start px-8 pt-0 pb-8 mx-2"
                            >
                                <button
                                    :disabled="currentApiLoading"
                                    @click="createOrUpdate"
                                    type="button"
                                    class="px-6 py-2.5 mr-6 primary-button"
                                >
                                    <!-- <div
                                        class="spinner-border color-white animate-spin inline-block w-4 h-4 border-3 mr-1 rounded-full"
                                        role="status"
                                    >
                                        <span class="visually-hidden"
                                            >Loading...</span
                                        >
                                    </div> -->
                                    <api-loading />
                                    <!-- data-bs-dismiss="modal" -->
                                    {{ getisEditing ? "Save" : "Create" }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-light px-3"
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
import Createbtn from "./../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import apiLoading from "./../Components/apiLoadingComponent";
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters, mapMutations } from "vuex";
import ImgPreview from "../Components/imgPreview.vue";

export default {
    name: "Category",
    components: {
        Createbtn,
        SearchBox,
        apiLoading,
        Multiselect,
        ImgPreview,
    },
    data() {
        return {
            typeOfSearch: "category",
            mutationName: "setCategories",
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
                icon: {},
                type:'product',
            },
            icon_preview: "",
            genderValue: null,
            genderOptions: [],
            validationMsg: {
                name: "",
                mm_name: "",
                icon: "",
                gender: "",
            },
        };
    },
    computed: {
        ...mapGetters(["myCategories", "getisEditing", "currentApiLoading"]),
        images() {
            let image_previews = [];
            this.myCategories.forEach((element) => {
                image_previews.push(element.icon);
            });
            return image_previews;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "updateOrCreateData",
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
        onPageChange(page) {
            this.currentPage = page;
        },

        open_edit_modal(category_id) {
            this.validationMsg.name = null;
            this.validationMsg.mm_name = null;
            this.validationMsg.icon = null;
            this.validationMsg.gender = null;
            this.setisEditing(true);
            axios
                .get(`/categories/${category_id}`)
                .then((res) => {
                    this.formData.id = res.data.data.id;
                    res.data.data.name_translations.forEach(
                        (name_translation) => {
                            if (name_translation.language_code == "en") {
                                this.formData.name.name = name_translation.name;
                            }
                            if (name_translation.language_code == "mm") {
                                this.formData.mm_name.name =
                                    name_translation.name;
                            }
                        }
                    );
                    this.genderValue = res.data.data.gender;
                    this.formData.type=res.data.data.type;
                    this.icon_preview = res.data.data.icon;
                    this.$refs.iconFile.value = null;
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
            if (this.formData.name.name.trim() === null) {
                this.validationMsg.name = "Name is required.";
            }
            if (this.formData.mm_name.name.trim() == null) {
                this.validationMsg.mm_name = "Myanmar Name is required.";
            }
            if (this.genderValue == null) {
                this.validationMsg.gender = "Gender is required.";
            }
            if (
                Object.keys(this.formData.icon).length == 0 &&
                this.getisEditing == false
            ) {
                this.validationMsg.icon = "Icon image is required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            let submitData = [this.formData.name, this.formData.mm_name];
            form_data.append("data", JSON.stringify(submitData));
            form_data.append("gender_id", this.genderValue.id);
            form_data.append("type", this.formData.type);
            if (this.getisEditing) {
                form_data.append("id", this.formData.id);
            }
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
                if (error.response.data.message.icon != null) {
                    this.validationMsg.icon = error.response.data.message.icon;
                }
                if (error.response.data.message.gender != null) {
                    this.validationMsg.gender =
                        error.response.data.message.gender;
                }
            }
        },
        async createOrUpdate(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.mm_name = "";
            this.validationMsg.icon = "";
            this.validationMsg.gender = "";
            this.validateRules();
            if (
                this.validationMsg.name == "" &&
                this.validationMsg.mm_name == "" &&
                this.validationMsg.icon == "" &&
                this.validationMsg.gender == ""
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    type: this.getisEditing ? "update" : "create",
                    url: "categories",
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
                            text: `Category has been ${
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
            this.formData.mm_name.name = null;
            this.genderValue = null;
            this.validationMsg.name = null;
            this.validationMsg.mm_name = null;
            this.validationMsg.icon = null;
            this.validationMsg.gender = null;
            this.$refs.iconFile.value = null;
            this.icon_preview = null;
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
        async getGender() {
            let res = await this.getApiData({ url: "get_genders" });
            this.genderOptions = res.data.data;
        },
        deleteImage(icon = "") {
            this.formData.icon = {};
            this.$refs.iconFile.value = null;
            this.icon_preview = "";
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "categories?",
            paginateMutation: this.mutationName,
        };
        this.getGender();
        this.getPaginatedData(payload);
        this.getImages();
    },
};
</script>
