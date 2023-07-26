<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Color Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox pagination-url="colors?" :mutationName="mutationName" />
            <!-- @include('layouts.search_box')  -->
            <createbtn v-on:open_create_modal="showCreateModal" />
            <!-- @include('layouts.create_button')  -->
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="color in myColors" :key="color.id">
                        <td>
                            {{ color.index }}
                        </td>
                        <td>
                            <div
                                v-for="name_translation in color.name_translations"
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
                                    :checked="color.is_available"
                                    @click="
                                        availableChange({
                                            data: color,
                                            url: 'colors',
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
                                @click="open_edit_modal(color.id)"
                            >
                                <!-- data-bs-toggle="modal" -->
                                <!-- data-bs-target="#edit_modal" -->

                                <i class="fal fa-file-edit"> </i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myColors.length == 0"
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
                pagination-url="colors?"
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
                            <div class="modal-header border-b-0">
                                <p class="pt-8 px-8 text-base">
                                    {{
                                        getisEditing
                                            ? "Edit Color"
                                            : "Create Color"
                                    }}
                                </p>
                            </div>
                            <div class="modal-body px-2">
                                <div class="block p-6 rounded-lg bg-white">
                                    <div class="form-group mb-6">
                                        <label
                                            for="name"
                                            class="form-label label-form"
                                            >Color Name</label
                                        >
                                        <input
                                            v-model="formData.name.name"
                                            type="text"
                                            class="form-control input-form mt-3 block"
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

                                    <!-- <div class="form-group mb-6">
                                        <label
                                            for="color_code"
                                            class="form-label label-form"
                                            >Color Code</label
                                        >
                                        <input
                                            v-model="formData.color_code"
                                            type="text"
                                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 focus:shadow-none bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            :class="
                                                validationMsg.color_code
                                                    ? 'border-red-500'
                                                    : 'border-gray-300'
                                            "
                                            id="color_code"
                                            placeholder=""
                                        />
                                        <p
                                            class="text-red-600 text-xs"
                                            v-show="validationMsg.color_code"
                                        >
                                            {{ validationMsg.color_code }}
                                        </p>
                                    </div> -->
                                    <div class="form-group mb-6">
                                        <label
                                            for="color_code"
                                            class="form-label label-form"
                                            >Color Code</label
                                        >
                                        <label
                                            for=""
                                            class="border rounded w-full flex mt-3"
                                        >
                                            <input
                                                v-model="formData.color_code"
                                                type="text"
                                                class="py-2 px-2 w-3/4 focus:outline-none text-gray-800 text-sm rounded-l"
                                                placeholder=""
                                                :class="
                                                    validationMsg.color_code
                                                        ? 'border-red-500'
                                                        : 'border-gray-300'
                                                "
                                                id="color_code"
                                            />
                                            <button
                                                @click.prevent="
                                                    showColorPicker =
                                                        !showColorPicker
                                                "
                                                class="text-sm px-2 w-1/4 py-2 text-gray-700 bg-gray-200 h-full"
                                            >
                                                <i
                                                    class="fal fa-eye-dropper"
                                                ></i>
                                            </button>
                                        </label>
                                        <p
                                            class="text-red-600 text-xs"
                                            v-show="validationMsg.color_code"
                                        >
                                            {{ validationMsg.color_code }}
                                        </p>
                                    </div>
                                    <color-picker
                                        v-show="showColorPicker"
                                        @updateColor="updateColor"
                                        :colorCode="formData.color_code"
                                    />

                                    <div class="form-group mb-6">
                                        <label
                                            for="sku_name"
                                            class="form-label label-form"
                                            >Color SKU Number
                                        </label>
                                        <input
                                            v-model="formData.sku_name"
                                            type="text"
                                            class="form-control input-form mt-3"
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
                                            v-show="validationMsg.sku_name"
                                        >
                                            {{ validationMsg.sku_name }}
                                        </p>
                                    </div>

                                    <div class="form-group mb-6">
                                        <label
                                            for="icon"
                                            class="form-label label-form"
                                            >Color Icon</label
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
                                            placeholder=""
                                            ref="iconFile"
                                            accept=".xlsx, .png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
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
                            </div>

                            <div
                                class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8"
                            >
                                <button
                                    :disabled="currentApiLoading"
                                    @click="createOrUpdate"
                                    type="button"
                                    class="primary-button"
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
import { mapActions, mapGetters, mapMutations } from "vuex";
import colorPicker from "../Components/colorPicker.vue";
import ImgPreview from "../Components/imgPreview.vue";

export default {
    name: "Color",
    components: {
        Createbtn,
        SearchBox,
        colorPicker,
        apiLoading,
        ImgPreview,
    },
    data() {
        return {
            showColorPicker: false,
            typeOfSearch: "color",
            mutationName: "setColors",
            formData: {
                id: "",
                name: {
                    name: "",
                    language_code: "en",
                },
                color_code: "",
                sku_name: "",
                icon: {},
            },
            icon_preview: "",
            validationMsg: {
                name: "",
                color_code: "",
                sku_name: "",
                icon: "",
            },
        };
    },
    computed: {
        ...mapGetters(["myColors", "getisEditing", "currentApiLoading"]),
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "updateOrCreateData",
            "search",
            "availableChange",
        ]),
        ...mapMutations(["setisEditing", "setApiLoading"]),
        updateColor(value) {
            console.log("inparent", value);
            this.formData.color_code = value;
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
        open_edit_modal(color_id) {
            this.validationMsg.name = null;
            this.validationMsg.color_code = null;
            this.validationMsg.sku_name = null;
            this.validationMsg.icon = null;
            this.setisEditing(true);
            axios
                .get(`/colors/${color_id}`)
                .then((res) => {
                    this.formData.id = res.data.data.id;
                    res.data.data.name_translations.forEach(
                        (name_translation) => {
                            if (name_translation.language_code == "en") {
                                this.formData.name.name = name_translation.name;
                            }
                        }
                    );
                    this.formData.color_code = res.data.data.color_code;
                    this.formData.sku_name = res.data.data.sku_name;
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
            if (this.formData.color_code.trim() == null) {
                this.validationMsg.color_code = "Myanmar Name is required.";
            }
            if (this.formData.sku_name.trim() == null) {
                this.validationMsg.sku_name = "Color SKU Name is required.";
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
            if (this.getisEditing) {
                form_data.append("id", this.formData.id);
            }
            let names = [this.formData.name];
            form_data.append("data", JSON.stringify(names));
            form_data.append("color_code", this.formData.color_code);
            form_data.append("sku_name", this.formData.sku_name);
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
                });
            } else {
                if (error.response.data.message.color_code != null) {
                    this.validationMsg.color_code =
                        error.response.data.message.color_code;
                }
                if (error.response.data.message.sku_name != null) {
                    this.validationMsg.sku_name =
                        error.response.data.message.sku_name;
                }
                if (error.response.data.message.icon != null) {
                    this.validationMsg.icon = error.response.data.message.icon;
                }
            }
        },
        async createOrUpdate(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.color_code = "";
            this.validationMsg.sku_name = "";
            this.validationMsg.icon = "";
            this.validateRules();
            if (
                this.validationMsg.name == "" &&
                this.validationMsg.color_code == "" &&
                this.validationMsg.sku_name == "" &&
                this.validationMsg.icon == ""
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    type: this.getisEditing ? "update" : "create",
                    url: "colors",
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
                            text: `Colors has been ${
                                this.getisEditing ? "updated" : "created"
                            }.`,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        this.formData.name.name = "";
                        this.formData.color_code = "";
                        this.formData.sku_name = "";
                        this.formData.icon = {};
                        this.$refs.iconFile.value = null;
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

        showCreateModal() {
            this.formData.name.name = null;
            this.formData.icon = {};
            this.formData.color_code = null;
            this.formData.sku_name = null;
            this.validationMsg.name = null;
            this.validationMsg.color_code = null;
            this.validationMsg.sku_name = null;
            this.validationMsg.icon = null;
            this.$refs.iconFile.value = null;
        },
        deleteImage() {
            this.formData.icon = {};
            this.$refs.iconFile.value = null;
            this.icon_preview = null;
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "colors?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
