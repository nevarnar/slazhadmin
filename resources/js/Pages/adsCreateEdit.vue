<template>
    <div class="inner-main-container">
        <div>
            <div>
                <div>
                    <p class="page-tittle">
                        {{
                            isediting == "edit"
                                ? "Edit Ads"
                                : "CreateOrUpdate Ads"
                        }}
                    </p>
                </div>

                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-7 gap-y-0 gap-x-8 mx-2">
                        <div class="col-span-3">
                            <label for="" class="label-form">Ads Name</label>
                        </div>
                        <div class="col-span-3">
                            <label for="" class="label-form">Ads Type</label>
                        </div>
                        <div class="col-span-1">
                            <!-- free space for grid -->
                        </div>

                        <!-- start row -->
                        <div class="col-span-3 mb-4">
                            <div class="form-group mb-2">
                                <input
                                    v-model="formData.name.name"
                                    type="text"
                                    class="form-control input-form mt-3"
                                    placeholder="Ads Name"
                                />
                            </div>

                            <p
                                class="text-validation whitespace-nowrap"
                                v-show="validationMsg.name"
                            >
                                {{ validationMsg.name }}
                            </p>
                        </div>

                        <div class="col-span-3 mb-4">
                            <div class="form-group mb-2 mt-3">
                                <multiselect
                                    v-model="typeValues"
                                    :options="typeOptions"
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
                            </div>

                            <p
                                class="text-validation whitespace-nowrap"
                                v-show="validationMsg.type_ids"
                            >
                                {{ validationMsg.type_ids }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <button
                                class="block mt-3"
                                title="Add Tag"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#add_tag"
                                data-toggle="modal"
                            >
                                <i
                                    class="fal fa-plus text-gray-700 pl-3 py-2"
                                ></i>
                            </button>
                        </div>

                        <!-- start row -->
                        <div class="col-span-3">
                            <label for="" class="label-form"> Type</label>
                        </div>
                        <div
                            class="col-span-4"
                            v-if="formData.adsTypeValue.value == 'none'"
                        ></div>

                        <div
                            class="col-span-3"
                            v-if="formData.adsTypeValue.value == 'url'"
                        >
                            <label for="link" class="label-form">Link </label>
                        </div>
                        <div
                            class="col-span-3"
                            v-if="
                                formData.adsTypeValue.value !== 'url' &&
                                formData.adsTypeValue.value !== 'none'
                            "
                        >
                            <label for="item" class="label-form">Item </label>
                        </div>
                        <div
                            class="col-span-1"
                            v-if="formData.adsTypeValue.value !== 'none'"
                        ></div>

                        <div class="col-span-3 mb-2">
                            <div class="form-group mb-6 mt-3">
                                <multiselect
                                    :disabled="
                                        isediting == 'edit' ? true : false
                                    "
                                    v-model="formData.adsTypeValue"
                                    :options="formData.adsTypeOptions"
                                    :searchable="false"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :allow-empty="false"
                                    track-by="name"
                                    label="name"
                                    placeholder="Choose Type"
                                    @input="changeAdsType"
                                ></multiselect>
                                <p
                                    class="text-red-600 text-xs"
                                    v-show="validationMsg.ads_type"
                                >
                                    {{ validationMsg.ads_type }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="col-span-3"
                            v-if="
                                formData.adsTypeValue.value != 'url' &&
                                formData.adsTypeValue.value != 'none'
                            "
                        >
                            <div class="form-group mb-6">
                                <multiselect
                                    class="mt-3"
                                    v-model="formData.itemValue"
                                    :options="formData.itemOptions"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customItemLabel"
                                    :searchable="true"
                                    :max-height="200"
                                    :internal-search="false"
                                    placeholder="Search Item"
                                ></multiselect>

                                <p
                                    class="text-red-600 text-xs"
                                    v-show="validationMsg.ads_item"
                                >
                                    {{ validationMsg.ads_item }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="col-span-4"
                            v-if="formData.adsTypeValue.value == 'none'"
                        ></div>

                        <div
                            class="col-span-3 mb-4"
                            v-if="formData.adsTypeValue.value == 'url'"
                        >
                            <div class="form-group mb-4">
                                <input
                                    v-model="formData.link"
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="URL"
                                />
                            </div>
                            <p
                                class="text-red-600 text-xs"
                                v-show="validationMsg.link"
                            >
                                {{ validationMsg.link }}
                            </p>
                        </div>
                        <div
                            class="col-span-1"
                            v-if="formData.adsTypeValue.value !== 'none'"
                        ></div>

                        <!-- end row -->

                        <!-- for marketing message-->

                        <div
                            class="col-span-3 mb-4"
                            v-if="typeValues.name == 'Marketing Message'"
                        >
                            <div class="form-group mb-2">
                                <label for="" class="form-label label-form">
                                    Title
                                </label>
                                <input
                                    v-model="formData.title"
                                    type="text"
                                    class="form-control input-form mt-3"
                                    placeholder="Title"
                                />
                                <p
                                    class="text-validation whitespace-nowrap"
                                    v-show="validationMsg.title"
                                >
                                    {{ validationMsg.title }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="col-span-3 mb-4"
                            v-if="typeValues.name != 'Marquee'"
                        >
                            <div class="form-group mb-4">
                                <label for="" class="form-label label-form">
                                    Upload Image
                                </label>
                                <input
                                    @change="onChange"
                                    type="file"
                                    class="form-control input-form mt-3"
                                    placeholder=""
                                    ref="iconFile"
                                    accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                                    value=""
                                />
                                <img-preview
                                    :img-preview="icon_preview"
                                    :type="'icon'"
                                    :delete-image="deleteImage"
                                />
                                <p
                                    class="text-validation whitespace-nowrap"
                                    v-show="validationMsg.photo"
                                >
                                    {{ validationMsg.photo }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="col-span-3 mb-4"
                            v-if="
                                typeValues.name != 'Marquee' && showMobilePhoto
                            "
                        >
                            <div class="form-group mb-4">
                                <label for="" class="form-label label-form">
                                    Upload Image(Mobile)
                                </label>
                                <input
                                    @change="onChangeMobile"
                                    type="file"
                                    class="form-control input-form mt-3"
                                    placeholder=""
                                    ref="iconFileMobile"
                                    accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                                    value=""
                                />
                                <img-preview
                                    :type="'photo'"
                                    :img-preview="icon_preview_mobile"
                                    :delete-image="deleteImage"
                                />
                                <p
                                    class="text-validation whitespace-nowrap"
                                    v-show="validationMsg.mobile_photo"
                                >
                                    {{ validationMsg.mobile_photo }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="col-span-3 mb-4"
                            v-if="
                                typeValues.name == 'Marketing Message' ||
                                typeValues.name == 'Marquee'
                            "
                        >
                            <div class="form-group mb-2">
                                <label for="" class="form-label label-form">
                                    Title
                                </label>
                                <textarea
                                    v-model="formData.text"
                                    name=""
                                    class="input-form text-table text-left animated-textarea mt-2"
                                    id=""
                                    cols="30"
                                    rows="7"
                                    style="border: 1px solid #e5e7eb"
                                    placeholder="In English"
                                ></textarea>
                                <p
                                    class="text-validation whitespace-nowrap"
                                    v-show="validationMsg.text"
                                >
                                    {{ validationMsg.text }}
                                </p>
                            </div>
                        </div>

                        <!-- end -->

                        <!-- start row -->

                        <!-- end row -->

                        <div class="col-span-5"></div>
                    </div>

                    <div class="flex justify-start mb-8 ml-2">
                        <button
                            :disabled="currentApiLoading"
                            @click="updateOrCreateAds"
                            type="button"
                            title="Create"
                            class="primary-button bg-black"
                        >
                            <api-loading />

                            {{ isediting == "create" ? "Create" : "Save" }}
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
                        <p class="pt-8 px-8 text-base">Create Type</p>
                    </div>
                    <div class="modal-body px-2 mx-2">
                        <form>
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group">
                                    <label
                                        for="Name"
                                        class="form-label label-form"
                                        >Name</label
                                    >
                                    <input
                                        v-model="formData.type_name"
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
                            @click="OncreateType"
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
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";
import Multiselect from "vue-multiselect";
import ImgPreview from "../Components/imgPreview.vue";
export default {
    name: "AdsCreateEdit",
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
                title: "",
                text: "",
                type_name: "",
                link: "",
                photo: {},
                mobile_photo: {},
                adsable_type: "",
                adsable_id: "",
                itemValue: "",
                itemOptions: [],
                adsTypeValue: "",
                adsTypeOptions: [
                    { name: "Product", value: "product" },
                    { name: "Style", value: "style" },
                    { name: "Collection", value: "collection" },
                    { name: "Series", value: "series" },
                    { name: "Tag", value: "tag" },
                    { name: "Style Category", value: "category" },
                    { name: "URL", value: "url" },
                    { name: "None", value: "none" },
                ],
            },
            icon_preview: "",
            icon_preview_mobile: "",
            validationMsg: {
                name: "",
                type_ids: "",
                link: "",
                photo: "",
                mobile_photo:"",
                ads_type: "",
                ads_item: "",
                text: "",
                title: "",
            },
            typeValues: "",
            typeOptions: [],
        };
    },
    computed: {
        ...mapGetters(["currentApiLoading"]),
        showMobilePhoto() {
            if (!this.typeValues) {
                return false;
            }
            if (
                this.typeValues.name === "Home Slider Ads Men" ||
                this.typeValues.name === "Home Slider Ads Women" ||
                this.typeValues.name === "Style Home Slider Men" ||
                this.typeValues.name === "Style Home Slider Women"
            ) {
                return true;
            } else {
                return false;
            }
        },
    },
    methods: {
        ...mapActions(["updateOrCreate", "search", "getApiData", "createType"]),
        ...mapMutations(["setApiLoading"]),

        customLabel(option) {
            return `${option.name}`;
        },
        customItemLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        changeAdsType() {
            console.log("aaaaaa");
            console.log(this.formData.adsTypeValue.value);
            this.formData.itemValue = null;
            this.formData.itemOptions = [];
            if (this.formData.adsTypeValue == null) {
                return;
            }
            if (
                this.formData.adsTypeValue.value !== "url" &&
                this.formData.adsTypeValue.value !== "none"
            ) {
                let payload = {
                    url: `get_ads_type_data?type=${this.formData.adsTypeValue.value}`,
                };
                this.getApiData(payload).then((res) => {
                    this.formData.itemOptions = res.data.data;
                });
            }
        },
        validateRules() {
            if (this.formData.name.name.trim() === "") {
                this.validationMsg.name = "Name is required.";
            }
            if (
                this.formData.adsTypeValue.value == "url" &&
                this.formData.link.trim() == ""
            ) {
                this.validationMsg.link = "Link is required.";
            }
            if (this.formData.adsTypeValue == "") {
                this.validationMsg.ads_type = "Type is required.";
            }

            if (
                this.typeValues.name == "Marketing Message" &&
                this.formData.text == ""
            ) {
                this.validationMsg.text = "Text is required";
            } else {
                this.validationMsg.text = "";
            }
            if (
                this.typeValues.name == "Marketing Message" &&
                this.formData.title == ""
            ) {
                this.validationMsg.title = "Title is required.";
            } else {
                this.validationMsg.title = "";
            }

            if (
                this.formData.adsTypeValue.value !== "url" &&
                this.formData.adsTypeValue.value !== "none" &&
                this.formData.itemValue == ""
            ) {
                this.validationMsg.ads_item = "Data is required.";
            }
            if (this.formData.adsTypeValue == "") {
                this.validationMsg.ads_type = "Type is required.";
            }

            if (
                Object.keys(this.formData.photo).length <= 0 &&
                this.isediting == "create" &&
                this.typeValues.name != "Marquee"
            ) {
                // console.log(this.typeValues.name);
                // console.log('aaaa');
                this.validationMsg.photo = "Photo is required.";
            }

            if (this.typeValues == "") {
                this.validationMsg.type_ids = "Type is required.";
            }
            if (
                this.showMobilePhoto &&
                Object.keys(this.formData.photo).length <= 0 &&
                this.isediting == "create" &&
                this.typeValues.name != "Marquee"
            ) {
                this.validationMsg.mobile_photo = "Mobile photo is required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            if (this.isediting == "edit") {
                form_data.append("id", this.formData.id);
            }
            let ads_name = [this.formData.name];
            form_data.append("data", JSON.stringify(ads_name));
            form_data.append("link", this.formData.link);
            form_data.append("title", this.formData.title);
            form_data.append("text", this.formData.text);
            if (
                this.formData.adsTypeValue.value !== "url" &&
                this.formData.adsTypeValue.value !== "none"
            ) {
                console.log(this.formData.adsTypeValue.value);
                form_data.append("adsable_id", this.formData.itemValue.id);
                form_data.append(
                    "adsable_type",
                    this.formData.adsTypeValue.value
                );
            }
            if (Object.keys(this.formData.photo).length > 0) {
                form_data.append(
                    "photo",
                    this.formData.photo.data,
                    this.formData.photo.name
                );
            }
            if (Object.keys(this.formData.mobile_photo).length > 0) {
                form_data.append(
                    "mobile_photo",
                    this.formData.mobile_photo.data,
                    this.formData.mobile_photo.name
                );
            }
            form_data.append("ads_type_id", this.typeValues.id);
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
                if (error.response.data.message.photo != null) {
                    this.validationMsg.photo =
                        error.response.data.message.photo;
                }
                if (error.response.data.message.phone_number != null) {
                    this.validationMsg.phone_number =
                        error.response.data.message.phone_number;
                }
                // if (error.response.data.message.link != null) {
                //   this.validationMsg.link = error.response.data.message.link;
                // }
            }
        },

        async updateOrCreateAds(e) {
            e.preventDefault;
            this.validationMsg.name = "";
            this.validationMsg.type_ids = "";
            this.validationMsg.link = "";
            this.validationMsg.photo = "";
            this.validationMsg.ads_type = "";
            this.validationMsg.ads_item = "";
            this.validateRules();
            if (
                this.validationMsg.name == "" &&
                this.validationMsg.link == "" &&
                this.validationMsg.photo == "" &&
                this.validationMsg.type_ids == "" &&
                this.validationMsg.ads_type == "" &&
                this.validationMsg.ads_item == "" &&
                this.validationMsg.title == "" &&
                this.validationMsg.text == ""
            ) {
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    // type: "edit",
                    url: "ads",
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
                            text: `Ads has been ${this.isediting}d`,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        window.location.href = "/ads_lists";
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
        async getType() {
            let res = await this.getApiData({ url: "get_ads_type" });
            console.log("work", res);
            this.typeOptions = res.data.data;
        },
        onChange(event) {
            this.formData.photo = {
                name: event.target.files[0].name,
                data: event.target.files[0],
            };
            this.icon_preview = URL.createObjectURL(event.target.files[0]);
            console.log("icon", this.icon_preview);
        },
        onChangeMobile(event) {
            this.formData.mobile_photo = {
                name: event.target.files[0].name,
                data: event.target.files[0],
            };
            this.icon_preview_mobile = URL.createObjectURL(
                event.target.files[0]
            );
        },
        OncreateType() {
            if (this.formData.type_name == "") {
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
            // let subData = { name: this.formData.type_name };
            form_data.append("name", this.formData.type_name);
            if (this.formData.type_name == "") {
                return;
            }
            this.createType(form_data)
                .then((res) => {
                    console.log("res", res);

                    this.$swal({
                        icon: "success",
                        title: "Created!",
                        text: "Type has been created.",
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    this.formData.type_name = null;
                    this.getType();
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
        async getAdsDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/ads/${uri[uriLast]}`);
            res = res.data.data;
            this.formData.id = res.id;
            this.icon_preview = res.photo;
            if (res.adsable_type == "category") {
                this.formData.adsTypeValue = {
                    name: "Category",
                    value: "category",
                };
            } else if (res.adsable_type == "collection") {
                this.formData.adsTypeValue = {
                    name: "Collection",
                    value: "collection",
                };
            } else if (res.adsable_type == "tag") {
                this.formData.adsTypeValue = { name: "Tag", value: "tag" };
            } else if (res.adsable_type == "product") {
                this.formData.adsTypeValue = {
                    name: "Product",
                    value: "product",
                };
            } else if (res.adsable_type == "style") {
                this.formData.adsTypeValue = { name: "Style", value: "style" };
            } else if (res.adsable_type == "series") {
                this.formData.adsTypeValue = {
                    name: "Series",
                    value: "series",
                };
            }
             else if (
                res.ads_type.name == "Marketing Message" ||
                res.ads_type.name == "Marquee"
            ) {
                this.formData.adsTypeValue = { name: "None", value: "none" };
                this.formData.title = res.title;
                this.formData.text = res.text;
            } 
            else if (
                res.link == null
            ){
                this.formData.adsTypeValue = { name: "None", value: "none" };
            }
            else {
                this.formData.adsTypeValue = { name: "URL", value: "url" };
                this.formData.link = res.link;
            }
            this.formData.name.name = res.name_translations[0].name;
            this.typeValues = res.ads_type;
            if (res.adsable_type != "url" && res.adsable_type != "none") {
                this.formData.itemOptions = res.ads_type_data;
                this.formData.itemValue = res.adsable;
            }
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
        deleteImage(icon = null) {
            console.log(icon);
            if (icon == "icon") {
                this.formData.photo = {};
                this.icon_preview = null;
                this.$refs.iconFile.value = null;
            } else {
                this.formData.mobile_photo = {};
                this.icon_preview_mobile = null;
                this.$refs.iconFileMobile.value = null;
            }
        },
    },
    mounted() {
        if (this.isediting == "edit") {
            this.getAdsDetail();
        }
        this.getType();
    },
};
</script>
