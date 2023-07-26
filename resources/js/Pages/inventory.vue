<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Inventory Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox
                :method="search"
                :typeOfSearch="typeOfSearch"
                :mutationName="mutationName"
            />
            <!-- @include('layouts.search_box')  -->
            <createbtn v-on:open_create_modal="showCreateModal" />
            <!-- @include('layouts.create_button')  -->
        </div>
        <div class="block">
            <table class="w-full">
                <thead class="bgcolor-table-header">
                    <tr>
                        <th class="px-5 py-2 text-xs text-gray-500 text-left">
                            ID
                        </th>
                        <th class="px-6 py-2 text-xs text-gray-500">Name</th>
                        <th class="px-6 py-2 text-xs text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr
                        v-for="(color, index) in myColors"
                        :key="color.id"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td
                            class="px-5 py-2 text-black-500 text-table text-left"
                        >
                            {{ ++index }}
                        </td>
                        <td class="px-5 py-2">
                            <div
                                class="text-gray-600 text-table"
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
                        <td class="px-5 py-2 text-center">
                            <button
                                type="button"
                                class="btn-clear"
                                title="Edit"
                                id="edit-button"
                                @click="open_edit_modal(color.id)"
                            >
                                <!-- data-bs-toggle="modal" -->
                                <!-- data-bs-target="#edit_modal" -->

                                <i
                                    class="fal fa-file-edit fw300"
                                    style="color: #68728c"
                                ></i>
                            </button>
                            <button
                                type="button"
                                class="btn-clear"
                                title="Edit"
                                id="edit-button"
                            >
                                <a
                                    class="a-clear"
                                    href="#"
                                    @click="delete_color(color.id)"
                                >
                                    <i
                                        class="fal fa-trash fw300"
                                        style="color: #68728c"
                                    ></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

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
                                            : "CreateOrUpdate Color"
                                    }}
                                </p>
                            </div>
                            <div class="modal-body px-2">
                                <div
                                    class="block p-6 rounded-lg bg-white max-w-sm"
                                >
                                    <div class="form-group mb-6">
                                        <label
                                            for="name"
                                            class="form-label label-form"
                                            >Color Name</label
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
                                            class="text-red-600 text-xs"
                                            v-show="validationMsg.name"
                                        >
                                            {{ validationMsg.name }}
                                        </p>
                                    </div>

                                    <div class="form-group mb-6">
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
                                    </div>
                                    <div class="form-group mb-6">
                                        <label
                                            for="sku_name"
                                            class="form-label label-form"
                                            >Color SKU Number
                                        </label>
                                        <input
                                            v-model="formData.sku_name"
                                            type="text"
                                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 focus:shadow-none bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                                    v-show="getisEditing"
                                    @click="edit_color"
                                    type="submit"
                                    class="px-6 py-2.5 mr-5 bg-black text-white font-medium text-xs leading-tight shadow-md hover:bg-black hover:shadow-lg focus:bg-black focus:shadow-lg focus:outline-none focus:ring-0 active:bg-black active:shadow-lg transition duration-150 ease-in-out"
                                >
                                    Edit
                                </button>
                                <button
                                    v-show="!getisEditing"
                                    @click="newColor"
                                    type="button"
                                    class="px-6 py-2.5 mr-5 bg-black text-white font-medium text-xs leading-tight shadow-md hover:bg-black hover:shadow-lg focus:bg-black focus:shadow-lg focus:outline-none focus:ring-0 active:bg-black active:shadow-lg transition duration-150 ease-in-out"
                                >
                                    <!-- data-bs-dismiss="modal" -->
                                    Create
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
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "Color",
    components: {
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "inventory",
            mutationName: "setInventories",
            formData: {
                id: "",
                name: {
                    name: "",
                    language_code: "en",
                },
                color_code: "",
            },
            validationMsg: {
                name: "",
                color_code: "",
            },
        };
    },
    computed: {
        ...mapGetters(["myColors", "getisEditing"]),
    },
    methods: {
        ...mapActions([
            "getColorsLists",
            "deleteColor",
            "updateOrCreateColor",
            "search",
        ]),
        ...mapMutations(["setisEditing"]),
        onChange(event) {
            this.formData.icon = {
                name: event.target.files[0].name,
                data: event.target.files[0],
            };
        },
        delete_color(color_id) {
            this.$swal({
                title: "Are you sure?",
                text: "You can't revert your action",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes Delete it!",
                confirmButtonColor: "#f27474",
                cancelButtonText: "No, Keep it!",
                showCloseButton: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.value) {
                    this.deleteColor(color_id).then(
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: "You successfully deleted this file",
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    );
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
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
                    // this.formData.icon = res.data.data.icon;
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
                this.validationMsg.color_code = "Color code is required.";
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
        async newColor(e) {
            e.preventDefault;
            this.validateRules();
            if (Object.keys(this.formData.icon).length == 0) {
                this.validationMsg.icon = "Icon image is required.";
            }
            if (
                this.formData.name.name &&
                this.formData.color_code &&
                this.formData.sku_name &&
                Object.keys(this.formData.icon).length
            ) {
                let form_data = this.formDataToSubmit();
                let payload = { form_data: form_data, type: "create" };

                this.updateOrCreateColor(payload)
                    .then((res) => {
                        this.closeModal();

                        this.$swal({
                            icon: "success",
                            title: "Created!",
                            text: "Color has been created.",
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
                        this.validateResError(error);
                        $("#create_modal").modal("show");
                    });
            } else {
                let element = this.$refs.modal.$el;
                $(element).modal("show");
                $("#create_modal").modal("show");
            }
        },

        edit_color(e) {
            e.preventDefault();
            this.validateRules();
            if (
                this.formData.name.name &&
                this.formData.color_code &&
                this.formData.sku_name
            ) {
                let form_data = this.formDataToSubmit();
                let payload = { form_data: form_data, type: "update" };
                this.updateOrCreateColor(payload)
                    .then((res) => {
                        this.closeModal();
                        this.$swal(
                            "Updated!",
                            "Color has been updated.",
                            "success"
                        );
                        this.formData.name.name = "";
                        this.formData.color_code = "";
                        this.formData.sku_name = "";
                        this.formData.icon = {};
                        this.$refs.iconFile.value = null;
                    })
                    .catch((error) => {
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
    },
    mounted() {
        this.getColorsLists();
    },
};
</script>
