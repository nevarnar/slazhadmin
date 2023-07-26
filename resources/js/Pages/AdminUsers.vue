<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Admin Users Management</p>
        </div>
        <div class="flex justify-between">
            <div class="relative flex justify-start">
                <SearchBox
                    :pagination-url="paginationUrl"
                    :mutationName="mutationName"
                />
                <!-- <div class="inline-block mx-1.5">
                    <div class="form-group mb-1">
                        <multiselect
                            v-model="departmentValue"
                            :options="departmentOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            track-by="id"
                            :custom-label="customLabel"
                            placeholder="Choose Department"
                            @input="changeDepartment"
                        ></multiselect>
                    </div>
                </div> -->
            </div>
            <createbtn v-on:open_create_modal="onCreate" />
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin user Name</th>
                        <th>Permissions</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="admin in adminUsers" :key="admin.id">
                        <td>
                            {{ admin.index }}
                        </td>
                        <td>
                            {{ admin.user_name }}
                        </td>
                        <td >
                            <span v-for="(permission, index) in admin.permissions" :key="index">{{ permission.name }},</span>
                            <!-- {{ admin.department.name }} -->
                        </td>
                        <td>
                            {{ admin.phone_number }}
                        </td>
                        <td>
                            <button
                                @click="changePasswordFun(admin.id)"
                                data-bs-toggle="modal"
                                data-bs-target="#add_category"
                                data-toggle="modal"
                                type="button"
                                title="Change Password"
                                class="px-2 btn-clear transition duration-150 ease-in-out"
                            >
                                <i class="fal fa-unlock-alt"></i>
                            </button>
                            <button
                                @click="onEdit(admin.id)"
                                type="button"
                                title="Edit"
                                id="edit-button"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                            <button
                                @click="onDelete(admin.id)"
                                type="button"
                                title="Delete"
                                id="delete_button"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="adminUsers.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td
                            colspan="5"
                            class="px-5 py-2 text-red-500 text-table text-left"
                        >
                            No Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="20"
                :mutationName="mutationName"
                :pagination-url="paginationUrl"
            />
        </div>
        <div
            class="modal fade primary-modal"
            id="add_category"
            tabindex="-1"
            aria-labelledby="createModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-box">
                <div class="modal-content content-modal">
                    <div class="modal-header border-b-0 mx-2">
                        <p class="pt-8 px-8 text-base">Change Password</p>
                    </div>
                    <div class="modal-body px-2 mx-2">
                        <form>
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group mb-3">
                                    <label
                                        for="Name"
                                        class="form-label label-form"
                                        >Admin Password</label
                                    >
                                    <input
                                        v-model="changePassword.admin_password"
                                        type="password"
                                        class="form-control input-form mt-1"
                                        id="Name"
                                        placeholder=""
                                    />
                                    <p
                                        class="text-red-600 text-xs"
                                        v-show="validationMsg.admin_password"
                                    >
                                        {{ validationMsg.admin_password }}
                                    </p>
                                </div>
                                <div class="form-group mb-3">
                                    <label
                                        for="mmName"
                                        class="form-label label-form"
                                        >New Password</label
                                    >
                                    <input
                                        v-model="changePassword.password"
                                        type="password"
                                        class="form-control input-form mt-1"
                                        id="mmName"
                                        placeholder=""
                                    />
                                    <p
                                        class="text-red-600 text-xs"
                                        v-show="validationMsg.password"
                                    >
                                        {{ validationMsg.password }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="mmName"
                                        class="form-label label-form"
                                        >Confirm Password</label
                                    >
                                    <input
                                        v-model="
                                            changePassword.password_confirmation
                                        "
                                        type="password"
                                        class="form-control input-form mt-1"
                                        id="mmName"
                                        placeholder=""
                                    />
                                    <p
                                        class="text-red-600 text-xs"
                                        v-show="
                                            validationMsg.password_confirmation
                                        "
                                    >
                                        {{
                                            validationMsg.password_confirmation
                                        }}
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer modal-btn-container mt-0">
                        <button
                            @click="changePasswordHandler"
                            type="button"
                            class="primary-button bg-black"
                        >
                            <!-- data-bs-dismiss="modal" -->

                            Change
                        </button>
                        <button
                            id="cancel"
                            type="button"
                            class="btn btn-light cancel"
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
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";

export default {
    name: "AdminUsers",
    components: {
        Createbtn,
        SearchBox,
        Multiselect,
    },
    data() {
        return {
            typeOfSearch: "admins",
            mutationName: "setAdminUsers",
            departmentValue: null,
            departmentOptions: [],
            changePassword: {
                id: null,
                admin_password: "",
                password: "",
                password_confirmation: "",
            },
            validationMsg: {
                admin_password: "",
                password: "",
                password_confirmation: "",
            },
        };
    },
    computed: {
        ...mapGetters(["adminUsers"]),
        paginationUrl() {
            return `admins?department_id=${
                this.departmentValue == null ? "" : this.departmentValue.id
            }`;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "deleteAdminUser",
            "getApiData",
            "postApiForm",
        ]),
        customLabel(option) {
            return `${option.name}`;
        },
        onEdit(admin_id) {
            window.location.href = `/admin_users/edit/${admin_id}`;
        },
        onCreate(admin_id) {
            window.location.href = `/admin_users/create`;
        },
        onDelete(admin_id) {
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
                    this.deleteAdminUser(admin_id).then(
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
        changeDepartment() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: `admins?department_id=${
                    this.departmentValue != null ? this.departmentValue.id : ""
                }`,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
        },
        async getDepartments() {
            let url = `departments`;
            let res = await this.getApiData({ url: url });
            this.departmentOptions = res.data;
        },
        validateRules() {
            if (this.changePassword.admin_password.trim() === "") {
                this.validationMsg.admin_password =
                    "Current password is required.";
            }
            if (this.changePassword.password.trim() == "") {
                this.validationMsg.password = "Password is required.";
            }
            if (this.changePassword.password_confirmation.trim() == "") {
                this.validationMsg.password_confirmation =
                    "Password confirmation is required.";
            }
        },
        changePasswordFun(id) {
            this.changePassword.id = id;
            this.changePassword.admin_password = "";
            this.changePassword.password = "";
            this.changePassword.password_confirmation = "";
        },
        changePasswordHandler(id) {
            this.validationMsg.admin_password = "";
            this.validationMsg.password = "";
            this.validationMsg.password_confirmation = "";
            this.validateRules();
            if (
                id &&
                this.changePassword.admin_password.trim() &&
                this.changePassword.password.trim() &&
                this.changePassword.password_confirmation
            ) {
                let data = {
                    id: this.changePassword.id,
                    old_password: this.changePassword.admin_password,
                    new_password: this.changePassword.password,
                    new_password_confirmation:
                        this.changePassword.password_confirmation,
                };
                let payload = {
                    form_data: data,
                    url: "admins/change_password",
                };
                this.postApiForm(payload)
                    .then((res) => {
                        this.closeModal();

                        this.$swal({
                            icon: "success",
                            title: "Updated!",
                            text: "Admin user password is updated",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    })
                    .catch((error) => {
                        console.log(error.response.data.message.old_password);
                        if (error.response.data.message.old_password) {
                            this.validationMsg.admin_password =
                                error.response.data.message.old_password;
                        }
                        if (error.response.data.message.new_password) {
                            this.validationMsg.password =
                                error.response.data.message.new_password;
                        }
                        if (
                            error.response.data.message
                                .new_password_confirmation
                        ) {
                            this.validationMsg.password_confirmation =
                                error.response.data.message.new_password_confirmation;
                        }
                        // this.scrollToTop();
                    });
            }
        },
        closeModal() {
            document.getElementById("cancel").click();
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "admins?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
        this.getDepartments();
    },
};
</script>
