<template>
    <div
        class="modal-dialog relative w-auto pointer-events-none"
        style="max-width: 36rem"
    >
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
        >
            <div class="modal-header border-b-0">
                <p class="py-8 px-12 text-base">Add Defect Item</p>
            </div>
            <div class="modal-body px-0">
                <form>
                    <div class="flex mx-12">
                        <div
                            class="flex flex-col md:flex-row md:max-w-xl rounded-lg bg-white"
                        >
                            <img
                                class="w-48 h-48"
                                :src="stock.sub_product.photo.name"
                                alt=""
                            />
                            <div
                                class="pl-8 flex flex-col justify-start text-left"
                            >
                                <h5
                                    class="text-gray-900 text-normal font-medium mb-4"
                                >
                                    Product Information
                                </h5>
                                <p class="text-gray-700 text-13px mb-2">
                                    {{
                                        stock.sub_product.product
                                            .name_translations[0].name
                                    }}
                                </p>
                                <p class="text-gray-700 text-13px mb-2">
                                    {{
                                        stock.sub_product.product.thing
                                            .brands[0]
                                            .name_translations[0].name
                                    }}
                                </p>
                                <p class="text-gray-700 text-13px mb-2">
                                    {{
                                        stock.sub_product.color
                                            .name_translations[0].name
                                    }}
                                </p>
                                <p class="text-gray-700 text-13px mb-4">
                                    {{ stock.sub_product.size.name }}
                                </p>
                                <div class="form-group mb-4">
                                    <label
                                        for="amount"
                                        class="form-label label-form"
                                        >Amount (Max-{{
                                            this.floor.defect_quantity
                                        }})</label
                                    >
                                    <input
                                        v-model="quantity"
                                        type="number"
                                        class="form-control input-form mt-2"
                                        id="amount"
                                        placeholder=""
                                    />
                                    <p
                                        class="text-red-600 text-xs"
                                        v-show="validationMsg.quantity"
                                    >
                                        {{ validationMsg.quantity }}
                                    </p>
                                </div>
                                <div class="form-group mb-8">
                                    <label
                                        for="remark"
                                        class="form-label label-form"
                                        >Remark</label
                                    >
                                    <textarea
                                        v-model="remark"
                                        name=""
                                        class="mt-2 min-h-[160px] focus:shadow-none focus:outline-none rounded animated-textarea active:shadow-none active:outline-none input-form block"
                                        cols="30"
                                        rows="10"
                                        style="border: 1px solid #e5e7eb"
                                    ></textarea>
                                    <p
                                        class="text-red-600 text-xs"
                                        v-show="validationMsg.remark"
                                    >
                                        {{ validationMsg.remark }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer-container mr-4">
                <button
                    type="button"
                    class="btn btn-light text-sm"
                    data-bs-dismiss="modal"
                    :id="'cancel' + stock.id + floor.id"
                >
                    Cancel
                </button>
                <button
                    @click.prevent="addHandler"
                    type="button"
                    class="px-12 py-2.5 ml-5 mr-0 bg-black primary-button"
                >
                    Add
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations } from "vuex";
export default {
    name: "AddDefectItemModal",
    props: ["stock", "floor"],
    data() {
        return {
            quantity: "",
            remark: "",
            validationMsg: {
                quantity: "",
                remark: "",
            },
        };
    },

    methods: {
        ...mapActions(["postWebForm"]),
        validationRules() {
            if (this.remark == "") {
                this.validationMsg.remark = "Remark is required";
            }
            if (this.quantity <= 0) {
                this.validationMsg.quantity = "Quantity is required";
            }
            if (this.quantity > this.floor.defect_quantity) {
                this.validationMsg.quantity = "Must not exceed Max amount";
            }
        },
        addHandler() {
            this.validationMsg.quantity = "";
            this.validationMsg.remark = "";
            this.validationRules();
            if (
                this.validationMsg.remark != "" ||
                this.validationMsg.quantity != ""
            ) {
                return;
            }
            let payload = {
                form_data: {
                    sub_product_id: this.stock.sub_product_id,
                    floor_id: this.floor.id,
                    remark: this.remark,
                    quantity: this.quantity,
                },
                url: "defects",
            };
            this.postWebForm(payload)
                .then((res) => {
                    this.closeModal();
                    this.$swal({
                        icon: "success",
                        title: "Created",
                        text: "Stock has been added.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    this.$emit("getStockPaginatedData");

                    // window.location.href = "/defect_confirm";
                })
                .catch((error) => {
                    // this.validateResError(error);
                });
        },
        closeModal() {
            this.quantity = "";
            this.remark = "";
            let id = "cancel" + this.stock.id + this.floor.id;
            console.log("close", id);

            document.getElementById(id).click();
        },
    },
};
</script>
