<template>
    <div class="inner-main-container">
        <div class="pl-2">
            <p class="page-tittle">
                {{
                    isediting == "edit"
                        ? "Edit Supplier"
                        : "Create Supplier"
                }}
            </p>
        </div>
        <div class="pt-3 mb-6">
            <div class="grid grid-cols-3 gap-y-2 gap-x-8 mx-2">
                <div class="">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label label-form"
                            >Supplier Company Name</label
                        >
                        <input
                            v-model="formData.name.name"
                            type="text"
                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
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
                <div class="">
                    <div class="form-group mb-4">
                        <label for="sku_name" class="form-label label-form"
                            >Supplier SKU Name</label
                        >
                        <input
                            v-model="formData.sku_name"
                            type="text"
                            class="form-control input-form mt-3 block w-full px-3 py-1.5 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
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
                </div>
                <div class="">
                    <!-- 3rd grid space -->
                </div>

                <div class="">
                    <div class="form-group mb-4">
                        <label for="contact_name" class="form-label label-form"
                            >Contact Name</label
                        >
                        <input
                            v-model="formData.contact_name"
                            type="text"
                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                            :class="
                                validationMsg.contact_name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="contact_name"
                            placeholder="In Myanmar"
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.contact_name"
                        >
                            {{ validationMsg.contact_name }}
                        </p>
                    </div>
                </div>

                <div class="">
                    <div class="form-group mb-4">
                        <label for="phone_number" class="form-label label-form"
                            >Phone Number</label
                        >
                        <input
                            v-model="formData.phone_number"
                            type="text"
                            class="form-control input-form mt-3 block w-full px-3 py-1.5 text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                            :class="
                                validationMsg.phone_number
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="phone_number"
                            placeholder="Phone number"
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.phone_number"
                        >
                            {{ validationMsg.phone_number }}
                        </p>
                    </div>
                </div>
                <div class="">
                    <!-- 3rd grid space -->
                </div>

                <div class="">
                    <div class="form-group mb-4">
                        <label for="country_id" class="form-label label-form"
                            >Country</label
                        >
                        <multiselect
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
                            v-show="validationMsg.country_id"
                        >
                            {{ validationMsg.country_id }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2">
                    <!-- two grid space -->
                </div>

                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <label for="brand_ids" class="form-label label-form"
                            >Brands</label
                        >
                        <multiselect
                            v-model="brandValue"
                            :options="brandOptions"
                            :searchable="true"
                            :multiple="true"
                            :close-on-select="true"
                            :clear-on-select="true"
                            :preserve-search="true"
                            :custom-label="customLabel"
                            placeholder="Choose brands"
                            :preselect-first="true"
                            id="brand_ids"
                            track-by="id"
                        >
                        </multiselect>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.brand_ids"
                        >
                            {{ validationMsg.brand_ids }}
                        </p>
                    </div>
                </div>
                <div></div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <label for="address" class="form-label block label-form"
                            >Address</label
                        >
                        <textarea
                            v-model="formData.address"
                            name=""
                            class="focus:shadow-none focus:outline-none rounded w-full animated-textarea active:shadow-none active:outline-none input-form block"
                            :class="
                                validationMsg.address
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            cols="30"
                            rows="10"
                            style="border: 1px solid #e5e7eb"
                        ></textarea>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.address"
                        >
                            {{ validationMsg.address }}
                        </p>
                    </div>
                </div>
                <div class=""></div>



                <div>
                    <button
                        :disabled="currentApiLoading"
                        @click="createOrUpdate"
                        type="button"
                        class="px-6 py-2.5 mr-5 bg-black text-white font-medium text-xs leading-tight shadow-md hover:bg-black focus:bg-black focus:outline-none focus:ring-0 active:bg-black transition duration-150 ease-in-out"
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
                sku_name: "",
                contact_name: "",
                phone_number: "",
                address: "",
            },
            validationMsg: {
                name: "",
                sku_name: "",
                contact_name: "",
                phone_number: "",
                address: "",
                country_id: "",
                brand_ids: "",
            },
            value: "",
            options: [],
            brandValue: [],
            brandOptions: [],
        };
    },
    computed: {
        ...mapGetters(["currentApiLoading"]),
    },
    methods: {
        ...mapActions(["postApiForm", "search"]),
        ...mapMutations(["setApiLoading"]),
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        validateRules() {
            if (this.formData.name.name.trim() === "") {
                this.validationMsg.name = "Name is required.";
            }
            if (this.formData.sku_name.trim() == "") {
                this.validationMsg.sku_name = "Sku Name is required.";
            }
            if (this.formData.contact_name.trim() == "") {
                this.validationMsg.contact_name = "Contact Name is required.";
            }
            if (this.formData.phone_number.trim() == "") {
                this.validationMsg.phone_number = "Phone number is required.";
            }
            if (this.formData.address.trim() == "") {
                this.validationMsg.address = "Address is required.";
            }
            if (this.value == "") {
                this.validationMsg.country_id = "Country is required.";
            }
            if (this.brandValue == "") {
                this.validationMsg.brand_ids = "Brands are required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            let submitData = [this.formData.name];
            let brand_ids = [];
            this.brandValue.forEach((brand) => {
                brand_ids.push(brand.id);
            });
            if (this.isediting == "edit") {
                form_data.append("id", this.formData.id);
            }
            form_data.append("data", JSON.stringify(submitData));
            form_data.append("sku_name", this.formData.sku_name);
            form_data.append("contact_name", this.formData.contact_name);
            form_data.append("phone_number", this.formData.phone_number);
            form_data.append("address", this.formData.address);
            form_data.append("country_id", this.value.id);
            form_data.append("brand_ids", JSON.stringify(brand_ids));
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
                if (error.response.data.message.phone_number != null) {
                    this.validationMsg.phone_number =
                        error.response.data.message.phone_number;
                }
            }
        },
        async createOrUpdate(e) {
            e.preventDefault;
            this.validateRules();
            if (
                this.formData.name.name &&
                this.formData.sku_name &&
                this.value &&
                this.formData.contact_name &&
                this.formData.phone_number &&
                this.formData.address &&
                this.brandValue
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    url: "suppliers/create_or_update",
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
                            text: `Supplier has been ${this.isediting}d.`,
                            showConfirmButton: false,
                            timer: 1000,
                        });

                        window.location.href = "/suppliers_lists";
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

        async getCountries() {
            let res = await axios.get("/countries");
            this.options = res.data.data;
        },
        async getBrands() {
            let res = await axios.get("/brands");
            this.brandOptions = res.data.data.data;
        },
        async getSupplierDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/suppliers/${uri[uriLast]}`);
            res = res.data.data;
            this.formData.id = res.id;
            this.formData.sku_name = res.sku_name;
            this.formData.contact_name = res.contact_name;
            this.formData.address = res.address;
            this.formData.phone_number = res.phone_number;
            this.value = res.country;
            this.brandValue = res.brands;
            res.name_translations.forEach((name_translation) => {
                if (name_translation.language_code == "en") {
                    this.formData.name.name = name_translation.name;
                }
            });
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
    },
    mounted() {
        if (this.isediting == "edit") {
            this.getSupplierDetail();
        }
        this.getCountries();
        this.getBrands();
    },
};
</script>
