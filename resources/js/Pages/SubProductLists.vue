<!-- products/sub_product_by_product/2 -->
<!-- sub_products -->
<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Sub Products</p>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>SKU</th>
                        <th>Pricing</th>
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody id="tbl">
                    <tr
                        v-for="(sub_product, index) in AllSubProducts"
                        :key="index"
                    >
                        <td>
                            {{
                                subproductType == "subproudcts"
                                    ? sub_product.index
                                    : ++index
                            }}
                        </td>
                        <td>
                            <div
                                v-if="showSubImage(sub_product)"
                                class="item-img-container"
                            >
                                <img alt="" :src="sub_product.photo.name" />
                            </div>
                        </td>
                        <td>
                            {{ sub_product.color.name_translations[0].name }}
                        </td>
                        <td>{{ sub_product.size.name }}</td>
                        <showMoreOrLessColVue :colData="sub_product.sku" />
                        <!-- <td>{{ sub_product.sku ? sub_product.sku : "" }}</td> -->
                        <td>{{ sub_product.product_prices.price }}</td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="sub_product.is_available"
                                    @click="
                                        availableChange({
                                            data: sub_product,
                                            url: 'sub_products',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                v-if="subproductType == 'subproudcts'"
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="sub_products?"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import showMoreOrLessColVue from "../Components/showMoreOrLessCol.vue";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "subProductLists",
    props: ["subproductType"],
    components: {
        showMoreOrLessColVue,
    },

    data() {
        return {
            typeOfSearch: "sub_products",
            mutationName: "setSubProductsLists",
        };
    },
    computed: {
        ...mapGetters(["AllSubProducts"]),
        subProductImages() {
            let image_previews = [];
            this.AllSubProducts.forEach((subproduct) => {
                image_previews.push(subproduct.photo.name);
            });
            return image_previews;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "search",
            "getSubProductOfProduct",
            "availableChange",
        ]),
        showSubImage(sub_product) {
            const itemIndex = this.AllSubProducts.findIndex(
                (item) => item.id === sub_product.id
            );
            if (!this.AllSubProducts[itemIndex - 1]) {
                return true;
            } else {
                if (
                    this.AllSubProducts[itemIndex - 1].color.id !=
                    sub_product.color.id
                ) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        getImages() {
            //load image from s3
            let uniqImages = [...new Set(this.subProductImages)]; //remove duplicate images
            const imageLoadings = uniqImages.map((imageSrc) => {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.src = imageSrc;
                    img.onload = resolve;
                    img.onerror = reject;
                });
            });
            console.log("load images");
            Promise.all(imageLoadings)
                .then(() => {
                    console.log("Images loaded!");
                    this.isLoading = false;
                })
                .catch((error) => {
                    console.error("Some image(s) failed loading!");
                });
        },
    },
    mounted() {
        if (this.subproductType == "subproudcts") {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: "sub_products?",
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
        } else if (this.subproductType == "products") {
            let uri = window.location.href.split("/");
            let uriLast = uri.length - 1;
            this.getSubProductOfProduct(uri[uriLast]);
        }
        this.getImages();
    },
};
</script>
