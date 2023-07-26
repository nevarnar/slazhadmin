<template>
    <div class="inner-main-container">
        <div>
            <div>
                <div>
                    <p class="page-tittle">
                        {{
                            isediting == "edit"
                                ? "Edit Delivery Man"
                                : "Create Delivery Man"
                        }}
                    </p>
                </div>

                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-8 gap-y-0 gap-x-8 mx-2">
                        <div class="md:col-span-3 col-span-8 mb-4">
                            <label for="" class="label-form"
                                >Delivery Man Name (In English)</label
                            >
                            <div class="form-group mb-2">
                                <input
                                    v-model="formData.name.name"
                                    type="text"
                                    class="form-control input-form mt-2"
                                    placeholder="In English"
                                />
                            </div>
                            <p
                                class="text-validation whitespace-nowrap"
                                v-show="validationMsg.name"
                            >
                                {{ validationMsg.name }}
                            </p>
                        </div>

                        <div class="col-span-3">
                            <label for="" class="label-form"
                                >Delivery Man Name (In Myanmar)</label
                            >
                            <div class="form-group mb-2">
                                <input
                                    v-model="formData.mm_name.name"
                                    type="text"
                                    class="form-control input-form mt-2"
                                    placeholder="In Myanmar"
                                />
                            </div>

                            <p
                                class="text-validation whitespace-nowrap"
                                v-show="validationMsg.mm_name"
                            >
                                {{ validationMsg.mm_name }}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <!-- free space for grid -->
                        </div>

                        <!-- start row -->
                        <div class="col-span-3">
                            <label for="link" class="label-form"
                                >Phone Number
                            </label>
                            <div class="form-group mb-4">
                                <input
                                    v-model="formData.phone_number"
                                    type="number"
                                    class="mt-2 input-form"
                                    placeholder="Phone Number"
                                />
                            </div>
                            <p
                                class="text-validation whitespace-nowrap"
                                v-show="validationMsg.phone_number"
                            >
                                {{ validationMsg.phone_number }}
                            </p>
                        </div>
                        <div class="col-span-5"></div>

                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-3 mb-4">
                            <label for="link" class="label-form"
                                >Delivery Name
                            </label>
                            <div>
                                <div class="form-group block mb-2 relative">
                                    <multiselect
                                        class="mt-3"
                                        v-model="deliveryValues"
                                        :options="deliveryOptions"
                                        :close-on-select="true"
                                        :clear-on-select="true"
                                        :preserve-search="true"
                                        :custom-label="customLabel"
                                        placeholder="Choose Type"
                                        :preselect-first="true"
                                        id="tag_ids"
                                        track-by="name"
                                    >
                                    </multiselect>
                                    <p
                                        class="text-validation whitespace-nowrap"
                                        v-show="validationMsg.delivery_ids"
                                    >
                                        {{ validationMsg.delivery_ids }}
                                    </p>
                                    <button
                                        class="absolute top-0 -right-8"
                                        title="Add Delivery Name"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#add_delivery"
                                        data-toggle="modal"
                                    >
                                        <i
                                            class="fal fa-plus text-gray-700 pl-3 py-2"
                                        ></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-5"></div>
                        <!-- end row -->
                    </div>

                    <div class="flex justify-start mb-8 ml-2">
                        <button
                            :disabled="currentApiLoading"
                            @click="updateOrCreateDeli"
                            type="button"
                            title="Create"
                            class="primary-button bg-black"
                        >
                            <api-loading />

                            {{
                                isediting == "create"
                                    ? "CreateOrUpdate"
                                    : "Save"
                            }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade primary-modal"
            id="add_delivery"
            tabindex="-1"
            aria-labelledby="exampleModalCenterTitle"
            aria-modal="true"
            role="dialog"
        >
            <div class="modal-dialog modal-dialog-centered modal-box">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
                >
                    <form>
                        <div class="modal-header border-b-0">
                            <p class="pt-8 px-8 text-base">Add New Delivery</p>
                        </div>
                        <div class="modal-body px-2">
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group mb-6">
                                    <label
                                        for="name"
                                        class="form-label label-form"
                                        >Delvery Name</label
                                    >
                                    <input
                                        v-model="formData.delivery_name"
                                        type="text"
                                        autocomplete="off"
                                        class="form-control input-form mt-2"
                                        id="name"
                                        placeholder="Delivery Name"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8"
                        >
                            <button
                                @click="OncreateDelivery"
                                type="button"
                                class="primary-button bg-black"
                            >
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
    name: "supplierCreateEdit",
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
                phone_number: "",

                delivery_name: "",
            },
            validationMsg: {
                name: "",
                mm_name: "",
                phone_number: "",
                delivery_ids: "",
            },
            deliveryValues: "",
            deliveryOptions: [],
        };
    },
    computed: {
        ...mapGetters(["currentApiLoading"]),
    },
    methods: {
        ...mapActions([
            "updateOrCreate",
            "search",
            "getApiData",
            "createDelivery",
            "setApiLoading",
        ]),
        customLabel(option) {
            return `${option.name}`;
        },
        validateRules() {
            if (this.formData.name.name.trim() === "") {
                this.validationMsg.name = "Name is required.";
            }
            if (this.formData.mm_name.name.trim() == "") {
                this.validationMsg.mm_name = "Myanmar Name is required.";
            }
            if (this.formData.phone_number.trim() == "") {
                this.validationMsg.phone_number = "Phone no is required.";
            }
            if (this.deliveryValues == "") {
                this.validationMsg.delivery_ids = "Delivery is required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            if (this.isediting == "edit") {
                form_data.append("id", this.formData.id);
            }
            let deli_name = [this.formData.name, this.formData.mm_name];
            form_data.append("data", JSON.stringify(deli_name));
            form_data.append("phone_number", this.formData.phone_number);
            form_data.append("phone_number", this.formData.phone_number);
            form_data.append("delivery_id", this.deliveryValues.id);
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
                if (error.response.data.message.phone_number != null) {
                    this.validationMsg.phone_number =
                        error.response.data.message.phone_number;
                }
            }
        },

        async updateOrCreateDeli(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.delivery_ids = "";
            this.validationMsg.mm_name = "";
            this.validationMsg.phone_number = "";
            this.validateRules();
            if (
                this.validationMsg.name == "" &&
                this.validationMsg.mm_name == "" &&
                this.validationMsg.phone_number == "" &&
                this.validationMsg.delivery_ids == ""
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    // type: "edit",
                    url: "delivery_men",
                };

                this.setApiLoading(true);

                this.updateOrCreate(payload)
                    .then((res) => {
                        this.setApiLoading(false);

                        this.$swal({
                            icon: "success",
                            title: `${
                                this.isediting == "create"
                                    ? "Created!"
                                    : "Edited"
                            }`,
                            text: `Delivery has been ${this.isediting}d`,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        window.location.href = "/delivery_men_lists";
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
        async getDeliveries() {
            let res = await this.getApiData({ url: "deliveries" });
            this.deliveryOptions = res.data.data;
        },

        closeModal() {
            document.getElementById("cancel").click();
        },
        OncreateDelivery() {
            let form_data = new FormData();
            // let subData = { name: this.formData.delivery_name };
            form_data.append("name", this.formData.delivery_name);
            if (this.formData.delivery_name == "") {
                return;
            }
            this.createDelivery(form_data)
                .then((res) => {
                    console.log("res", res);

                    this.$swal({
                        icon: "success",
                        title: "Created!",
                        text: "Delivery has been created.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    this.closeModal();
                    this.formData.delivery_name = null;
                    this.getDeliveries();
                })
                .catch((error) => {
                    this.$swal(
                        "Error!",
                        error.response.data.message[0].message,
                        "error"
                    );
                });
        },
        async getDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/delivery_men/${uri[uriLast]}`);
            res = res.data.data;
            console.log("res", res);
            this.formData.id = res.id;
            this.formData.name.name = res.name_translations[0].name;
            this.formData.mm_name.name = res.name_translations[1].name;
            this.formData.phone_number = res.phone_number;
            this.deliveryValues = res.delivery;
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
    },
    mounted() {
        if (this.isediting == "edit") {
            this.getDetail();
        }
        this.getDeliveries();
    },
};
</script>
