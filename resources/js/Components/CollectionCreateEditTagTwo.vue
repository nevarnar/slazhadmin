<template>
    <div>
        <p>
            <span
                class="text-sm cursor-pointer"
                :class="!isAddingProduct ? 'text-gray-500' : ''"
                @click="isAddingProduct = true"
                >Add product</span
            ><span
                class="ml-3 text-sm cursor-pointer"
                :class="isAddingProduct ? 'text-gray-500' : ''"
                @click="isAddingProduct = false"
                >Add style</span
            >
             <span class="text-red-600 text-xs">{{ this.validatedproductstyle }} </span>
        </p>
        <div class="pt-6 mb-6">
            <template v-if="isAddingProduct">
                <div class="grid grid-cols-8 gap-y-2 gap-x-8 mx-2">
                    <div class="col-span-3">
                        <div class="form-group mb-4">
                            <multiselect
                                v-model="productValue"
                                :options="productOptions"
                                :close-on-select="true"
                                :show-labels="false"
                                :custom-label="customProductLabel"
                                :searchable="true"
                                placeholder="Search Product"
                            ></multiselect>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <button
                            class="primary-button"
                            @click="addHandler('product')"
                        >
                            Add
                        </button>
                    </div>

                    <div class="col-span-8">
                        <hr class="my-2 h-0.5" />
                    </div>
                    <!-- end row -->
                </div>
                <div class="my-4">
                    <table class="secondary-table overflow-hidden">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th"></th>
                                <th class="sec-thead-th">Name</th>
                                <th class="sec-thead-th">Item Code</th>
                                <th class="sec-thead-th">
                                    Product SubCategory
                                </th>
                                <th class="sec-thead-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(
                                    product, index
                                ) in my_collection_product_rows"
                                :key="index"
                            >
                                <td class="sec-table-td">{{ ++index }}</td>
                                <td class="sec-table-td">
                                    {{
                                        product.name_translations[0]
                                            .name
                                    }}
                                </td>
                                <td class="sec-table-td">
                                    {{ product.sku }}
                                </td>
                                <td class="sec-table-td">
                                    {{
                                        product.thing.sub_categories[0]
                                            .name_translations[0].name
                                    }}
                                </td>
                                <td class="sec-table-td"></td>
                                <td class="sec-table-td"></td>
                                <td class="px-5 py-1.5 text-center">
                                    <button
                                        @click="
                                            deleteCollectionRow({
                                                type: 'product',
                                                data: product,
                                            })
                                        "
                                        type="button"
                                        class="btn-clear"
                                        title="Delete"
                                        id="delete-button"
                                    >
                                        <i
                                            class="fal fa-trash"
                                            style="color: #68728c"
                                        ></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>

            <div class="" v-if="!isAddingProduct">
                <template>
                    <div class="grid grid-cols-8 gap-y-2 gap-x-8 mx-2">
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <multiselect
                                    v-model="styleValue"
                                    :options="styleOptions"
                                    :searchable="true"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    :custom-label="customLabel"
                                    placeholder="Choose Style"
                                ></multiselect>
                            </div>
                        </div>

                        <div class="col-span-4">
                            <button
                                class="primary-button"
                                @click="addHandler('style')"
                            >
                                Add
                            </button>
                        </div>

                        <div class="col-span-8">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->
                    </div>
                    <div class="my-4">
                        <table class="secondary-table overflow-hidden">
                            <thead class="secondary-table-thead">
                                <tr>
                                    <th class="sec-thead-th"></th>
                                    <th class="sec-thead-th">Style Name</th>
                                    <th class="sec-thead-th">
                                        Style Item Code
                                    </th>
                                    <th class="sec-thead-th">Style Category</th>
                                    <th class="sec-thead-th"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        style, index
                                    ) in my_collection_style_rows"
                                    :key="index"
                                >
                                    <td class="sec-table-td">{{ ++index }}</td>
                                    <td class="sec-table-td">
                                        {{ style.name_translations[0].name }}
                                    </td>
                                    <td class="sec-table-td">
                                        {{ style.item_code }}
                                    </td>
                                    <td class="sec-table-td">
                                        {{
                                            style.thing?.categories[0]
                                                ?.name_translations[0].name
                                        }}
                                    </td>
                                    <td class="sec-table-td"></td>
                                    <td class="sec-table-td"></td>
                                    <td class="px-5 py-1.5 text-center">
                                        <button
                                            @click="
                                                deleteCollectionRow({
                                                    type: 'style',
                                                    data: style,
                                                })
                                            "
                                            type="button"
                                            class="btn-clear"
                                            title="Delete"
                                            id="delete-button"
                                        >
                                            <i
                                                class="fal fa-trash"
                                                style="color: #68728c"
                                            ></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
            </div>
            <div class="flex justify-end mb-8">
                <button
                    :disabled="currentApiLoading"
                    @click="onPublish"
                    type="button"
                    title="Create"
                    class="primary-button bg-black"
                >
                    <api-loading />

                    {{ isediting == "create" ? "Create" : "Edit" }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
    name: "styleCreateEditTagTwo",
    components: {
        Multiselect,
        apiLoading,
    },
    props: ["isediting",'validatedproductstyle'],
    data() {
        return {
            styleValue: "",
            styleOptions: [],
            productValue: "",
            productOptions: [],
            isAddingProduct: true,
        };
    },
    computed: {
        ...mapGetters([
            "my_collection_styles",
            "my_collection_style_rows",
            "my_collection_products",
            "my_collection_product_rows",
            "currentApiLoading",
        ]),
    },
    methods: {
        ...mapActions(["getCollectionStyles", "getApiData"]),
        ...mapMutations([
            "removeCollectionStyleRow",
            "setCollectionStyleRow",
            "removeCollectionProductRow",
            "setCollectionProductRow",
        ]),
        onPublish() {
            this.clearValidation();
            let imageArr = [];
            let validation_count = 0;
            this.mySubProducts.forEach((sub) => {
                this.colorValue.forEach((color) => {
                    if (
                        color.color_code == sub.color.color_code &&
                        sub.first_color_sub_product == true &&
                        Object.keys(sub.image_file).length <= 0
                    ) {
                        sub.image_validation_msg = "Image is required";
                        validation_count++;
                    } else {
                        if (Object.keys(sub.image_file).length > 0) {
                            imageArr.push(sub.image_file.data);
                        }
                    }
                });
            });
            if (validation_count == 0) {
                this.$emit("onPublish", {
                    imageArr: imageArr,
                    sub_product: this.mySubProducts,
                });
            }
        },

        toggleSelected(e) {
            console.log("es", e.target.value);
        },
        customLabel(option) {
            return `${option.name_translations[0].name} - ${option.item_code}`;
        },
        customProductLabel(option) {
            return `${option?.name_translations[0].name}`;
        },

        addHandler(type) {
            if (type == "style" && this.styleValue) {
                this.setCollectionStyleRow(this.styleValue);
                let deleteItem = this.styleOptions.findIndex(
                    (s) => s.id === this.styleValue.id
                );
                this.styleOptions.splice(deleteItem, 1);
                this.styleValue = "";
            } else if (type == "product" && this.productValue) {
                console.log(this.productValue, this.my_collection_product_rows);
                let deleteItem = this.my_collection_product_rows.findIndex(
                    (s) => s.id == this.productValue.id
                );
                console.log("deleteItem", deleteItem);

                if (deleteItem >= 0) {
                    this.$swal({
                        icon: "error",
                        title: "Error!",
                        text: "Product already exits.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    return;
                } else {
                    this.setCollectionProductRow(this.productValue);
                }

                this.productValue = "";
            } else {
                this.$swal({
                    icon: "warning",
                    title: "Warning!",
                    text: "Fill all required fields.",
                    showConfirmButton: false,
                    timer: 1000,
                });
            }
        },
        onPublish() {
            this.$emit("onPublish", "onPublish"); //this.myStyleProductsRows will get from vuex
        },
        async getCollectionProducts() {
            let res = await this.getApiData({ url: "products_for_style" });
            this.productOptions = res.data.data;
        },
        deleteCollectionRow({ type, data }) {
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
                    if (type == "style") {
                        this.removeCollectionStyleRow(data);
                        this.styleOptions.push(data);
                    } else if (type == "product") {
                        this.removeCollectionProductRow(data);
                    }
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
    mounted() {
        if (this.isediting == "edit") {
            this.$emit("getCollectionDetail");
        }
        this.getCollectionStyles().then(
            (res) => (this.styleOptions = this.my_collection_styles)
        );
        this.getCollectionProducts();
        console.log(this.my_collection_styles);
    },
};
</script>

<style lang="scss" scoped></style>
