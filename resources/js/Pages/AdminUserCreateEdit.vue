<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                {{ isediting == "edit" ? "Edit  Staff" : "Create Staff" }}
            </p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-3 gap-y-2 gap-x-8 mx-2">
                <div class="">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label label-form">
                            Name</label
                        >
                        <input
                            v-model="formData.user_name"
                            type="text"
                            class="form-control input-form mt-3 px-3 py-1.5 text-gray-700 focus:text-gray-700 focus:bg-white"
                            :class="
                                validationMsg.user_name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="user_name"
                            placeholder=""
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.user_name"
                        >
                            {{ validationMsg.user_name }}
                        </p>
                    </div>
                </div>
                <div class="">
                    <div class="form-group mb-4">
                        <label for="full_name" class="form-label label-form"
                            >Full Name</label
                        >
                        <input
                            v-model="formData.full_name"
                            type="text"
                            class="form-control input-form mt-3 px-3 py-1.5 focus:text-gray-700"
                            :class="
                                validationMsg.full_name
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="full_name"
                            placeholder=""
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.full_name"
                        >
                            {{ validationMsg.full_name }}
                        </p>
                    </div>
                </div>
                <div class="">
                    <!-- 3rd grid space -->
                </div>

                <div class="">
                    <div class="form-group mb-4">
                        <label for="email" class="form-label label-form"
                            >Email</label
                        >
                        <input
                            v-model="formData.email"
                            type="email"
                            class="form-control input-form mt-3 px-3 py-1.5 text-gray-700 focus:text-gray-700"
                            :class="
                                validationMsg.email
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="email"
                            placeholder=""
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.email"
                        >
                            {{ validationMsg.email }}
                        </p>
                    </div>
                </div>

                <div class="">
                    <div class="form-group mb-4" v-if="isediting == 'create'">
                        <label for="password" class="form-label label-form"
                            >Password</label
                        >
                        <input
                            :readonly="isediting == 'edit'"
                            v-model="formData.password"
                            type="password"
                            class="form-control input-form mt-3 px-3 py-1.5 text-gray-700 focus:text-gray-700"
                            :class="
                                validationMsg.password
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="password"
                            placeholder=""
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.password"
                        >
                            {{ validationMsg.password }}
                        </p>
                    </div>
                </div>
                <div class="">
                    <div class="form-group mb-4" v-if="isediting == 'create'">
                        <label
                            for="password_confirmation"
                            class="form-label label-form"
                            >Confirm Password</label
                        >
                        <input
                            :readonly="isediting == 'edit'"
                            v-model="formData.password_confirmation"
                            type="password"
                            class="form-control input-form mt-3 px-3 py-1.5 text-gray-700 focus:text-gray-700"
                            :class="
                                validationMsg.password_confirmation
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="password_confirmation"
                            placeholder=""
                        />
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.password_confirmation"
                        >
                            {{ validationMsg.password_confirmation }}
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
                            class="form-control input-form mt-3 px-3 py-1.5 text-gray-700 focus:text-gray-700"
                            :class="
                                validationMsg.phone_number
                                    ? 'border-red-500'
                                    : 'border-gray-300'
                            "
                            id="phone_number"
                            placeholder=""
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
                    <div class="form-group mb-4">
                        <label for="deparment_id" class="form-label label-form"
                            >Admin Type</label
                        >
                        <multiselect
                            class="mt-3"
                            v-model="adminTypeValue"
                            :options="adminTypeOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            label="name"
                            placeholder="Choose a Admin Type"
                        ></multiselect>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.admin_type_id"
                        >
                            {{ validationMsg.admin_type_id }}
                        </p>
                    </div>
                </div>

                <div
                    v-if="adminTypeValue?.name == 'Admin'"
                    class="col-span-1 row-span-3"
                >
                    <div class="mb-3">
                        <label for="" class="label-form">Permission</label>
                    </div>
                    <div
                        v-for="(permission, index) in permissions"
                        :key="index"
                        class="mb-2"
                    >
                        <label :for="`permission-${index}`" class="label-form">
                            <input
                                :value="permission.id"
                                :checked="isChecked(permission)"
                                type="checkbox"
                                :id="`permission-${index}`"
                                v-on:change="
                                    updatePermissionIds($event, permission)
                                "
                            />
                            {{ permission.name }}
                        </label>
                    </div>
                    <!-- <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox" />
                            Inventory Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox" />
                            Promotion Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox" />
                            Customer Support Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox" />
                            Order Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox" />
                            Admin Management
                        </label>
                    </div> -->
                </div>

                <div class="" v-if="showInventorySelect">
                    <div class="form-group mb-4">
                        <label for="deparment_id" class="form-label label-form"
                            >Inventory</label
                        >
                        <multiselect
                            class="mt-3"
                            v-model="inventoryValue"
                            :options="inventoryOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customInventoryLabel"
                            placeholder="Choose a inventory"
                        ></multiselect>
                        <p
                            class="text-red-600 text-xs"
                            v-show="validationMsg.inventory"
                        >
                            {{ validationMsg.inventory }}
                        </p>
                    </div>
                </div>

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
                <!-- <div class=""></div> -->
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
    name: "adminUserCreateEdit",
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
                user_name: "",
                full_name: "",
                email: "",
                password: "",
                phone_number: "",
                password_confirmation: "",
                address: "",
            },

            adminTypeValue: null,
            adminTypeOptions: [],
            permissions: null,
            permission_ids: [],
            inventoryValue: null,
            inventoryOptions: [],
            validationMsg: {
                email: "",
                full_name: "",
                password: "",
                phone_number: "",
                admin_type_id: "",
                permission_id: "",
                user_name: "",
                password_confirmation: "",
                address: "",
                inventory:"",
            },
            // cometchatConfig: {
            //     APP_ID: "23946338614f1b89",
            //     AUTH_KEY: "3e6e25ae02c5cedba698857a0a297ca543db1065",
            //     APP_REGION: "US",
            //     WIDGET_ID: "ef6be874-f611-4776-b740-2cee841f163d",
            //     API_KEY: "784a492e2bb152178d869dcea9944775a14271b8",
            // },
            // cometchatSetting: null,
        };
    },
    computed: {
        ...mapGetters(["currentApiLoading"]),
        showInventorySelect() {
            return this.permission_ids?.includes(2);
        },
    },
    methods: {
        ...mapActions(["postApiForm"]),
        ...mapMutations(["setApiLoading"]),
        customLabel(option) {
            return `${option.name}`;
        },
        customInventoryLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        validateRules() {
            if (this.formData.user_name.trim() === "") {
                this.validationMsg.user_name = "Name is required.";
                return;
            }
            if (this.formData.email.trim() == "") {
                this.validationMsg.email = "Email is required.";
                return;
            }
            if (this.formData.full_name.trim() == "") {
                this.validationMsg.full_name = "Full Name is required.";
                return;
            }
            if (this.formData.password.trim() == "") {
                this.validationMsg.password = " Password is required.";
            }
            console.log(this.formData.password_confirmation == "");
            if (this.formData.password_confirmation.trim() == "") {
                this.validationMsg.password_confirmation =
                    " Password Confirmation is required.";
            }
            if (this.formData.phone_number.trim() == "") {
                this.validationMsg.phone_number = "Phone is required.";
            }
            if (this.formData.address.trim() == "") {
                this.validationMsg.address = "Address is required.";
            }
            if (this.adminTypeValue == null) {
                this.validationMsg.admin_type_id = "Admin Type  is required.";
            }
        },
        formDataToSubmit() {
            let form_data = new FormData();
            let submitData = [this.formData.name];

            if (this.isediting == "edit") {
                form_data.append("id", this.formData.id);
            }
            form_data.append("password", this.formData.password.trim());
            form_data.append(
                "password_confirmation",
                this.formData.password_confirmation.trim()
            );
            form_data.append("user_name", this.formData.user_name.trim());
            form_data.append("full_name", this.formData.full_name.trim());
            form_data.append("email", this.formData.email.trim());

            form_data.append("phone_number", this.formData.phone_number.trim());
            form_data.append("address", this.formData.address.trim());
            form_data.append("admin_type_id", this.adminTypeValue.id);
            form_data.append(
                "permission_ids",
                JSON.stringify(this.permission_ids)
            );
            form_data.append(
                "inventory_id",
                this.inventoryValue != null ? this.inventoryValue.id : ""
            );
            // form_data.append("department_id", 1);

            return form_data;
        },
        validateResError(error) {
            if (error.response.data.message.email != null) {
                this.validationMsg.email = error.response.data.message.email;
            }
            if (error.response.data.message.user_name != null) {
                this.validationMsg.user_name =
                    error.response.data.message.user_name;
            }
            if (error.response.data.message.password != null) {
                this.validationMsg.password =
                    error.response.data.message.password;
            }
            if (error.response.data.message.password_confirmation != null) {
                this.validationMsg.password_confirmation =
                    error.response.data.message.password_confirmation;
            }
            if (error.response.data.message.phone_number != null) {
                this.validationMsg.phone_number =
                    error.response.data.message.phone_number;
            }
            if (error.response.data.message.admin_type_id != null) {
                this.validationMsg.admin_type_id =
                    error.response.data.message.admin_type_id;
            }
        },
        resetValidationMsg() {
            this.validationMsg.email = "";
            this.validationMsg.full_name = "";
            this.validationMsg.password = "";
            this.validationMsg.phone_number = "";
            this.validationMsg.user_name = "";
            this.validationMsg.admin_type_id = "";
            this.validationMsg.address = "";
            this.validationMsg.inventory="";
        },
        async createOrUpdate(e) {
            e.preventDefault;
            this.resetValidationMsg();
            this.validateRules();
            if (this.showInventorySelect && !this.inventoryValue ) {
                console.log('here')
                this.validationMsg.inventory = "Inventory  is required.";
                return;
            }
            if (
                this.formData.user_name &&
                this.formData.full_name &&
                this.formData.email &&
                this.formData.phone_number &&
                this.formData.address
            ) {
                console.log("1");
                let form_data = this.formDataToSubmit();
                let payload = {
                    form_data: form_data,
                    url: "admins/createOrUpdate",
                };
                this.setApiLoading(true);

                this.postApiForm(payload)
                    .then((res) => {
                        console.log(res);
                        this.setApiLoading(false);

                        this.$swal({
                            icon: "success",
                            title: `${
                                this.isediting == "create"
                                    ? "Created!"
                                    : "Updated!"
                            }`,
                            text: `Staff user has been ${this.isediting}d.`,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        window.location.href = "/admin_users";

                        // if(this.isediting=='edit'){
                        // }
                        // else{
                        //     let id = 16  //002
                        //     this.createCometUser(id);
                        // }
                    })
                    .catch((error) => {
                        this.scrollToTop();
                        this.setApiLoading(false);
                        this.validateResError(error);
                    });
            } else {
                console.log("error");
                //without data
            }
        },

        async getAdminTypes() {
            let res = await axios.get("/get_admin_type"); //delete api
            this.adminTypeOptions = res.data.data;
        },
        // createCometUser(id){
        //     let admin_uid = `SlazhAdmin_${id}`
        //     let user = new CometChat.User(admin_uid);
        //     user.setName(admin_uid);
        //     user.setRole("1");
        //     CometChat.createUser(
        //         user,
        //         this.cometchatConfig.AUTH_KEY
        //     ).then((createdUser) => {
        //         console.log(
        //             "User created in CometChat ",
        //             createdUser
        //         );
        //         window.location.href = "/admin_users";
        //     });
        // },
        async getPermissions() {
            let res = await axios.get("/get_permission");
            console.log("res", res.data);
            this.permissions = res.data.data;
        },
        async getInventories() {
            let res = await axios.get("/get_inventories");
            console.log("res", res.data);
            this.inventoryOptions = res.data.data;
        },
        async getAdminUserDetail() {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            let res = await axios.get(`/admins/${uri[uriLast]}`);
            res = res.data.data;

            this.formData.id = res.id;
            this.formData.user_name = res.user_name;
            this.formData.full_name = res.full_name;
            this.formData.email = res.email;
            this.formData.phone_number = res.phone_number;
            this.departmentValue = res.department;
            this.formData.password = res.password;
            this.formData.password_confirmation = res.password;
            this.formData.address = res.address;
            this.permissionValue = res.permissions;
            this.adminTypeValue = res.admin_type;
            let ids = res.permissions.map((item) => item.id);
            this.permission_ids = ids;
            this.inventoryValue = res.inventory;
        },

        scrollToTop() {
            window.scrollTo(0, 0);
        },
        updatePermissionIds(event, permission) {
            if (event.target.checked) {
                this.permission_ids.push(permission.id);
            } else {
                const index = this.permission_ids.indexOf(permission.id);
                if (index !== -1) {
                    this.permission_ids.splice(index, 1);
                }
            }
        },
        isChecked(permission) {
            return this.permission_ids?.includes(permission.id);
        },
        // initComet() {
        //     this.cometchatSetting = new CometChat.AppSettingsBuilder()
        //         .subscribePresenceForAllUsers()
        //         .setRegion(this.cometchatConfig.APP_REGION)
        //         .autoEstablishSocketConnection(true)
        //         .build();

        //     console.log(this.cometchatSetting);

        //     CometChat.init(
        //         this.cometchatConfig.APP_ID,
        //         this.cometchatSetting
        //     ).then(
        //         () => {
        //             console.log(
        //                 "CometChat Initialization completed successfully"
        //             );
        //         },
        //         (error) => {
        //             console.log(
        //                 "CometChat Initialization failed with error:",
        //                 error
        //             );
        //         }
        //     );
        // },
    },
    mounted() {
        if (this.isediting == "edit") {
            this.getAdminUserDetail();
        }
        // this.initComet();
        this.getAdminTypes();
        this.getPermissions();
        this.getInventories();
    },
};
</script>
