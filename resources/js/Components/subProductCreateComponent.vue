<template>
    <div>
        <div class="relative flex justify-between pb-3">
            <div>
                <p class="page-tittle">Create Product</p>
            </div>
            <!-- <div>
                <button
                    :disabled="currentApiLoading"
                    @click="onPublish"
                    class="primary-button bg-black"
                >
                    <api-loading />

                    Publish
                </button>
            </div> -->
        </div>
        <div class="block pb-8 relative">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>SKU</th>
                        <th>Pricing</th>
                        <th>Available</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- <tr>
                        <td>
                            1
                        </td>
                        <td>
                            31232132132321
                        </td>
                        <td>
                            1232 dfsf1
                        </td>
                        <td>wwww www</td>
                        <td>
                            <p>222 MMKs</p>
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                        </td>
                        <td>
                            <button type="button" data-bs-toggle="collapse"
                                data-bs-target="#images" aria-expanded="false"
                                aria-controls="images"
                                class="btn-clear mr-3"
                                title="Images"
                                id="img-button"
                            >
                                <i class="far fa-images" style="color: #68728c"></i>
                            </button>
                            <button
                                type="button"
                                class="btn-clear mr-3"
                                title="Edit"
                                id="edit-button"
                            >
                                <i
                                    class="fal fa-pen fw300"
                                    style="color: #68728c"
                                ></i>
                            </button>
                            <button
                                type="button"
                                title="Add Price"
                                id="add_special_price"
                            >
                                <i class="fal fa-check"></i>
                            </button>
                        </td>
                    </tr> -->


                    <div class="contents"  v-for="(subProduct, index) in mySubProducts"
                    :key="index">
                        <tr>
                        <td>
                            {{ ++index }}
                        </td>
                        <!-- <td>
                            <div v-if="subProduct.first_color_sub_product">
                                <div
                                    v-show="!subProduct.isEditingNow"
                                    class="custom-file-input flex justify-center p-0 border-none"
                                >
                                    <label
                                        :for="'input' + subProduct.local_id"
                                        class="text-center border-none p-0"
                                        style="border: none; padding: 0"
                                    >
                                        <div
                                            class="item-img-container border-2"
                                        >
                                            <img
                                                alt=""
                                                :src="subProduct.image_preview"
                                            />
                                        </div>
                                    </label>
                                    <input
                                        @change="onChange($event, subProduct)"
                                        v-show="subProduct.isEditingNow"
                                        type="file"
                                        name=""
                                        :id="'input' + subProduct.local_id"
                                        class="invisible"
                                    />
                                </div>
                            </div>
                            <p
                                class="text-red-600 text-xs"
                                v-show="subProduct.image_validation_msg"
                            >
                                {{ subProduct.image_validation_msg }}
                            </p>
                        </td> -->
                        <td>
                            {{
                                subProduct.first_color_sub_product
                                    ? subProduct.color.name_translations[0].name
                                    : null
                            }}
                        </td>
                        <!-- <td v-if="isediting == 'create'">
                            {{
                                numberOralphabetical
                                    ? subProduct.size
                                    : subProduct.size.name
                            }}
                        </td> -->
                        <td>
                            {{ subProduct.size.name }}
                        </td>
                        <td>{{ subProduct.sku }}</td>
                        <td>
                            <p v-show="!subProduct.isEditingNow">
                                {{ subProduct.price }} MMKs
                            </p>
                            <input
                                v-show="subProduct.isEditingNow"
                                v-model="edit_sub_product.price"
                                type="number"
                                class="input-form"
                            />
                            <p
                                class="text-red-600 text-xs"
                                :id="'validationMsg' + subProduct.local_id"
                            ></p>
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="subProduct.available"
                                    @click="setAvailableChange(subProduct)"
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                        </td>
                        <td>
                            <button
                                v-show="!subProduct.isEditingNow"
                                @click="subProductEdit(subProduct)"
                                type="button"
                                class="btn-clear mr-3"
                                title="Edit"
                                id="edit-button"
                            >
                                <i
                                    class="fal fa-pen fw300"
                                    style="color: #68728c"
                                ></i>
                            </button>
                            <button
                                @click="subProductUpdate"
                                v-show="subProduct.isEditingNow"
                                type="button"
                                title="Add Price"
                                id="add_special_price"
                            >
                                <i class="fal fa-check"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="subProduct.last_color_sub_product">
                        <td  colspan="7" class="pt-3">

                        <div class="inline-block mx-4 mt-3">
                            <div class=" pb-52 pl-36 bg-gray-400 relative">
                                <img :src="subProduct.images.front_view_preview" class="h-full w-full absolute top-0 left-0" alt="">
                            </div>
                            <div class="flex justify-center mt-3 ">
                                <label class="bg-white px-3 py-2 border cursor-pointer block w-fit">
                                    Browse
                                    <input  @change="onChange($event, subProduct ,'front_view')" type="file" class="hidden" accept=".png, .jpg, .jpeg , .svg , .webp" />
                                </label>
                                <!-- <button
                                style="color:red ;margin-left: 7px;"
                                @click="onDeleteImage(supplier.id)"
                                type="button"
                                title="Delete Image"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button> -->
                            </div>
                            <p class="text-sm mt-3 text-gray-600 block">
                                    Front View
                            </p>
                        </div>
                        <div class="inline-block mx-4 mt-3">
                            <div class=" pb-52 pl-36 bg-gray-400 relative">
                                <img :src="subProduct.images.back_view_preview" class="h-full w-full absolute top-0 left-0" alt="">
                                <!-- <img src="/img/test_img1.jpg" class="h-full w-full absolute top-0 left-0" alt=""> -->
                            </div>
                            <div class="flex justify-center mt-3 ">
                                <label class="bg-white px-3 py-2 border cursor-pointer block w-fit">
                                    Browse
                                    <input @change="onChange($event, subProduct ,'back_view')" type="file" class="hidden" accept=".png, .jpg, .jpeg , .svg , .webp">
                                </label>
                                <!-- <button
                                style="color:red ;margin-left: 7px;"
                                @click="onDeleteImage(supplier.id)"
                                type="button"
                                title="Delete Image"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button> -->
                            </div>
                            <p class="text-sm mt-3 text-gray-600 block">
                                    Back View
                            </p>
                        </div>
                        <div class="inline-block mx-4 mt-3">
                            <div class=" pb-52 pl-36 bg-gray-400 relative">
                                <img :src="subProduct.images.side_view_preview" class="h-full w-full absolute top-0 left-0" alt="" >
                            </div>
                            <div class="flex justify-center mt-3 ">
                                <label class="bg-white px-3 py-2 border cursor-pointer block w-fit">
                                    Browse
                                    <input @change="onChange($event, subProduct ,'side_view')" type="file" class="hidden" accept=".png, .jpg, .jpeg , .svg , .webp" >
                                </label>
                                <!-- <button
                                style="color:red ;margin-left: 7px;"
                                @click="onDeleteImage(supplier.id)"
                                type="button"
                                title="Delete Image"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button> -->

                            </div>
                            <p class="text-sm mt-3 text-gray-600 block">
                                    Side View
                            </p>
                        </div>
                        <div class="inline-block mx-4 mt-3">
                            <div class=" pb-52 pl-36 bg-gray-400 relative">
                                <img :src="subProduct.images.something_view_preview" class="h-full w-full absolute top-0 left-0" alt="">
                            </div>
                            <div class="flex justify-center mt-3 ">
                                <label class="bg-white px-3 py-2 border cursor-pointer block w-fit">
                                    Browse
                                    <input @change="onChange($event, subProduct ,'something_view')" type="file" class="hidden" accept=".png, .jpg, .jpeg , .svg , .webp" >
                                </label>
                                <!-- <button
                                style="color:red ;margin-left: 7px;"
                                @click="onDeleteImage(supplier.id)"
                                type="button"
                                title="Delete Image"
                            >
                                <a class="a-clear" href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button> -->
                            </div>

                            <p class="text-sm mt-3 text-gray-600 block">
                                Something
                            </p>
                        </div>
                        </td>
                    </tr>
                    </div>

                </tbody>
            </table>
            <div class="absolute right-0 top-full">
                <button
                    :disabled="currentApiLoading"
                    @click="onPublish"
                    class="primary-button bg-black"
                >
                    <api-loading />

                    Publish
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";

export default {
    name: "subProductCreate",
    props: ["numberOralphabetical", "isediting", "colorValue", "isLoading"],
    components: {
        apiLoading,
    },
    data() {
        return {
            isOneSubProductEditing: false,
            edit_sub_product: {
                local_id: null,
                id: null,
                image: {},
                price: null,
            },
        };
    },
    computed: {
        ...mapGetters(["mySubProducts", "currentApiLoading"]),
    },
    methods: {
        ...mapMutations([
            "setSubProductEdit",
            "setSubProductUpdate",
            "setAvailableChange",
            "setImageUpload",
        ]),

        onPublish() {
            if(this.checkImgsValidation()){
                this.$swal({
                        icon: "error",
                        title: "Error!",
                        text: "Choose images."
                    });
                    return;
            }
            // this.clearValidation();
            let imageArr = [];
            let validation_count = 0;
            this.mySubProducts.forEach((sub) => {
                if (
                    sub.last_color_sub_product == true
                    //&& sub.id == null
                ) {
                    if (Object.keys(sub.images.front_view_file).length > 0) {
                        imageArr.push(sub.images.front_view_file.data);
                    }
                    if (Object.keys(sub.images.back_view_file).length > 0) {
                        imageArr.push(sub.images.back_view_file.data);
                    }
                    if (Object.keys(sub.images.side_view_file).length > 0) {
                        imageArr.push(sub.images.side_view_file.data);
                    }
                    if (Object.keys(sub.images.something_view_file).length > 0) {
                        imageArr.push(sub.images.something_view_file.data);
                    }
                }
                // else {
                //     if (Object.keys(sub.image_file).length > 0) {
                //         imageArr.push(sub.image_file.data);
                //     }
                // }
                // this.colorValue.forEach((color) => {
                //     if (
                //         color.color_code == sub.color.color_code &&
                //         sub.first_color_sub_product == true &&
                //         Object.keys(sub.image_file).length <= 0
                //     ) {
                //         sub.image_validation_msg = "Image is required";
                //         validation_count++;
                //     } else {
                //         if (Object.keys(sub.image_file).length > 0) {
                //             imageArr.push(sub.image_file.data);
                //         }
                //     }
                // });
            });

                this.$emit("onPublish", {
                    imageArr: imageArr,
                    sub_product: this.mySubProducts,
                });
        },
        clearValidation() {
            this.mySubProducts.forEach((sub) => {
                sub.image_validation_msg = "";
            });
        },
        checkImgsValidation() {
            var imageLessCount = 0;
            this.mySubProducts.forEach((sub) => {
                if(sub.last_color_sub_product){

                if(sub.images.front_view_preview== null || sub.images.front_view_preview == ''){
                    imageLessCount ++;
                }
                if(sub.images.back_view_preview== null || sub.images.back_view_preview == ''){
                    imageLessCount ++;
                }
                if(sub.images.side_view_preview== null || sub.images.side_view_preview == ''){
                    imageLessCount ++;
                }
                if(sub.images.something_view_preview== null || sub.images.something_view_preview == ''){
                    imageLessCount ++;
                }
                }
            });
            console.log('imagelesscount',imageLessCount);
            if(imageLessCount){
                return true; // img validation
            }
            else {
                return false;
            }
        },
        subProductEdit(subProduct) {
            if (!this.isOneSubProductEditing) {
                //none of subvariation is edition
                this.edit_sub_product = {
                    local_id: subProduct.local_id,
                    price: subProduct.price,
                };
                this.isOneSubProductEditing = true;
                this.setSubProductEdit(subProduct);
                // this.$emit("onEditSubProduct", subProduct);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error!",
                    text: "Updated the first one.",
                    showConfirmButton: false,
                    timer: 1000,
                });
            }
        },
        subProductUpdate() {
            let id = `#validationMsg${this.edit_sub_product.local_id}`;

            if (
                this.edit_sub_product.price == "" ||
                this.edit_sub_product.price <= 0
            ) {
                $(id).text("Price is required");
            } else {
                $(id).text("");
                this.setSubProductUpdate(this.edit_sub_product);
                this.isOneSubProductEditing = false;
            }
        },
        availableChange(sub_product) {
            console.log("availy");
        },
        onChange(event, sub_product, view) {
            console.log('subpro',sub_product.local_id);
            if(event.target.files[0].size > 4000000){   //1M
                this.$swal({
                        icon: "error",
                        title: "Error!",
                        text: "Size cannot exceed 1M."
                    });
                    return;
            }
            let image = {
                name: event.target.files[0].name,
                data: event.target.files[0],
                type:view
            };
            console.log(event.target.files[0].size);
            let payload = {
                image: image,
                sub_product: sub_product,
                isediting: this.isediting,
                view:view
            };
            console.log(payload, "payload");
            this.setImageUpload(payload);
        },
    },
};
</script>

<style lang="scss" scoped></style>
