<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Size Management</p>
        </div>
        <div class="relative flex justify-between">
            <!-- <SearchBox
                pagination-url="sizes?"
                :mutationName="mutationName"
            /> -->
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="size in mySizes" :key="size.id">
                        <td>
                            {{ size.index }}
                        </td>
                        <td>
                            {{ size.name }}
                        </td>
                        <td>
                            
                            <button
                                type="button"
                                class="btn-clear"
                                title="Edit"
                                id="edit-button"
                                @click="open_edit_modal(size.id)"
                            >
                                <i
                                    class="fal fa-file-edit fw300"
                                    style="color: #68728c"
                                ></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="mySizes.length == 0"
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
                pagination-url="occasions?"
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
                        <div class="modal-content content-modal-normal w-full">
                            <div class="modal-header border-b-0 px-2">
                                <p class="pt-8 px-8 text-base">
                                    {{
                                        getisEditing
                                            ? "Edit Size"
                                            : "Create Size"
                                    }}
                                </p>
                            </div>
                            <div class="modal-body px-4">
                                <div class="block p-6 rounded-lg bg-white">
                                    <div class="form-group mb-4">
                                        <label
                                            for="name"
                                            class="form-label label-form"
                                            >Size Name </label
                                        >
                                        <input
                                            v-model="formData.name"
                                            type="text"
                                            class="form-control input-form mt-2 px-3 py-1.5"
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
                            </div>

                            <div
                                class="modal-footer modal-footer-box justify-start px-8 mx-2 pt-0 pb-8 mb-2"
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

import { mapActions, mapGetters, mapMutations } from "vuex";
import ImgPreview from "../Components/imgPreview.vue";
export default {
    name: "SizeList",
    components: {
        Createbtn,
        SearchBox,
        apiLoading,
        ImgPreview,
    },
    data() {
        return {
            typeOfSearch: "size",
            mutationName: "setSizes",
            formData: {
                id: "",
                name:"",
            },
            validationMsg: {
                name: "",
            },
        };
    },
    computed: {
        ...mapGetters(["mySizes", "getisEditing", "currentApiLoading"]),
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "updateOrCreateData",
            "search",
            "availableChange",
        ]),
        ...mapMutations(["setisEditing", "setApiLoading"]),
        // onChange(event) {
        //     if (event.target.files[0].size > 4000000) {
        //         //4M
        //         this.$swal({
        //             icon: "error",
        //             title: "Error!",
        //             text: "Size cannot exceed 4M.",
        //         });
        //         return;
        //     }
        //     this.formData.icon = {
        //         name: event.target.files[0].name,
        //         data: event.target.files[0],
        //     };
        //     this.iconpreview = URL.createObjectURL(event.target.files[0]);
        // },

        open_edit_modal(size_id) {
            this.validationMsg.name = null;
            this.setisEditing(true);
            axios
                .get(`/sizes/${size_id}`)
                .then((res) => {
                    this.formData.id = res.data.data.id;
                    this.formData.name = res.data.data.name;
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
            if (this.formData.name.name === null) {
                this.validationMsg.name = "Name is required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            if (this.getisEditing) {
                form_data.append("id", this.formData.id);
            }
            form_data.append("name", this.formData.name);
            return form_data;
        },
        validateResError(error) {
            // if (error.response.data.message[0]) {
            //     error.response.data.message.forEach((nameError) => {
            //         if (nameError.language_code == "en") {
            //             this.validationMsg.name = nameError.message;
            //         }
            //         if (nameError.language_code == "mm") {
            //             this.validationMsg.mm_name = nameError.message;
            //         }
            //     });
            // } else {
            //     if (error.response.data.message.icon != null) {
            //         this.validationMsg.icon = error.response.data.message.icon;
            //     }
            // }
        },
        async createOrUpdate(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validateRules();

            if (
                this.validationMsg.name == "" 
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    type: this.getisEditing ? "update" : "create",
                    url: "sizes",
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
                            text: `Size has been ${
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
            this.formData.name = null;
            this.validationMsg.name = null;
        },
        deleteImage() {
            this.formData.icon = {};
            this.icon_preview = null;
            this.$refs.iconFile.value = null;
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "sizes?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
    },
};
</script>
