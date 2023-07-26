<template lang="">
    <div class="modal-dialog modal-box !max-w-[70vw]">
        <div class="modal-content content-modal" style="width: auto">
            <form>
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-end pr-4 pt-4"
                >
                    <button
                        :id="'cancel'+saleReturn.id"
                        type="button"
                        class="btn-close text-xs box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body px-8 mx-2">
                    <div>
                        <section
                            class="text-gray-700 body-font overflow-hidden bg-white"
                        >
                            <div
                                class="container px-5 pt-4 pb-8 lg:pb-12 mx-auto"
                            >
                                <div class="flex flex-wrap">
                                    <div
                                        :key="reRender"
                                        class="lg:w-1/2 w-full object-cover object-center flex"
                                    >
                                        <div class="mr-3">
                                            <ul>
                                                <li
                                                    v-for="(
                                                        image, idx
                                                    ) in images"
                                                    :key="idx"
                                                    class="mb-3"
                                                >
                                                    <img
                                                        @click="
                                                            mainImage = image
                                                        "
                                                        alt="ecommerce"
                                                        class="w-20 rounded border border-gray-200 cursor-pointer"
                                                        :src="image"
                                                    />
                                                </li>
                                            </ul>
                                        </div>
                                        <img
                                            alt="product"
                                            class="w-3/4 object-cover object-center rounded border border-gray-200"
                                            :src="mainImage"
                                        />
                                    </div>

                                    <div
                                        class="lg:w-1/2 w-full pl-0 lg:pl-10 lg:pb-6 lg:pt-3 mt-6 lg:mt-0 text-left"
                                    >
                                        <p>
                                            <span
                                                class="text-sm title-font text-gray-900 pb-2 font-louis dark:text-white"
                                            >
                                                {{
                                                    data?.brand
                                                        ? data?.brand[0]?.name
                                                        : ""
                                                }}
                                            </span>
                                        </p>

                                        <div class="">
                                            <h1
                                                class="text-gray-500 text-xl title-font font-light mb-2 font-louis"
                                            >
                                                {{
                                                    getName(
                                                        data?.name_translations
                                                    )
                                                }}
                                            </h1>
                                            <div class="flex">
                                                <p
                                                    class="text-gray-900 md:text-lg text-2xl md:mb-1 mb-0.5 mr-3 font-louis"
                                                >
                                                    {{
                                                        formattedPrice(
                                                            size?.discount
                                                                ? size?.price -
                                                                      size
                                                                          ?.discount
                                                                          .discount_value
                                                                : size?.price
                                                        )
                                                    }}
                                                </p>
                                                <p
                                                    v-if="
                                                        size?.discount
                                                            ?.discount_value
                                                    "
                                                    class="text-gray-700 dark:text-gray-400 md:text-ls text-xl font-louis md:mb-4 mb-0.5 line-through decoration-red-600"
                                                >
                                                    {{
                                                        formattedPrice(
                                                            size?.price
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr class="my-4 h-0" />
                                        <div class="mb-4 flex">
                                            <p
                                                class="mr-3 text-lg font-semibold mb-1 font-louis dark:text-white"
                                            >
                                                {{ $t("Color") }}
                                            </p>
                                            <div class="pt-1">
                                                <div
                                                    v-for="(
                                                        color, index
                                                    ) in data?.avaliable_colors"
                                                    :key="index"
                                                    class="contents"
                                                >
                                                    <button
                                                        @click="
                                                            color_id = color.id
                                                        "
                                                        :class="
                                                            color.id == color_id
                                                                ? ' color-active-btn'
                                                                : 'border-transparent'
                                                        "
                                                        type="button"
                                                        class="btn-clear border relative h-fit w-fit rounded-full mr-2"
                                                    >
                                                        <img
                                                            :src="color.icon"
                                                            class="color-active2 rounded-full h-5 w-5"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4 flex">
                                            <p
                                                class="text-lg dark:text-white font-semibold inline-block mr-3 font-louis"
                                            >
                                                {{ $t("Sizes") }}
                                            </p>
                                            <select
                                                v-model="size"
                                                class="py-1.5 px-2 rounded-md border bg-white border-gray-800 font-louis"
                                            >
                                                <option
                                                    :selected="
                                                        sizee?.id == size?.id
                                                            ? true
                                                            : false
                                                    "
                                                    v-for="(
                                                        sizee, id
                                                    ) in available_sizes"
                                                    :value="sizee"
                                                >
                                                    {{ sizee.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-4 flex">
                                            <p
                                                class="text-lg dark:text-white font-semibold inline-block mr-3 font-louis"
                                            >
                                                Inventory
                                            </p>
                                            <multiselect v-if="data?.inventories"
                                                class="mt-2"
                                                v-model="inventory_value"
                                                :options="data?.inventories"
                                                :searchable="false"
                                                :close-on-select="true"
                                                :show-labels="false"
                                                :custom-label="customLabel"
                                                track-by="id"
                                                placeholder="Choose inventory"
                                            ></multiselect>
                                        </div>
                                        <!-- <div class="mb-4 flex">
                                            <p
                                                class="text-lg dark:text-white font-semibold inline-block mr-3 font-louis"
                                            >
                                                Inventory
                                            </p>
                                            <select
                                                v-model="inventory_value"
                                                class="py-1.5 px-2 rounded-md border bg-white border-gray-800 font-louis"
                                            >
                                                <option
                                                    v-for="(
                                                        inventory, id
                                                    ) in data?.inventories"
                                                    :value="inventory"
                                                >
                                                    {{ inventory.name_translations[0].name }} 
                                                </option>
                                            </select>
                                        </div> -->
                                        <div class="mb-4 flex">
                                            <p
                                                class="text-lg dark:text-white font-semibold inline-block mr-3 font-louis"
                                            >
                                                Available Floors
                                            </p>
                                            <multiselect 
                                                class="mt-2"
                                                v-model="selected_floor"
                                                :options="available_floors"
                                                :searchable="false"
                                                :close-on-select="true"
                                                :show-labels="false"
                                                :custom-label="customLabeltwo"
                                                track-by="id"
                                                placeholder="Choose floor"
                                            ></multiselect>
                                        </div>
                                        <button @click.prevent="confirmNewReturnItem"
                                            class="primary-button flex-grow m-0 rounded-none w-1/2 basis-1/2"
                                        >
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
export default {
    name: "SubproductModal",
    components: {
        Multiselect
    },
    props: {
        productId: {},
        setNewReturnItem: {
            type: Function,
        },
        saleReturn:{}
    },
    data() {
        return {
            data: null,
            images: [],
            color_images: [],
            mainImage: null,
            reRender: 0,
            color_id: null,
            size: this.saleReturn?.sale_return_product?.size,
            available_sizes: [],
            selected_floor: this.saleReturn?.sale_return_product?.floor,
            inventory_value:this.saleReturn?.sale_return_product?.inventory
        };
    },
    computed: {
        ...mapGetters(["languageCode"]),
        color_name(){
            if(!this.data && !this.color_id){
                return null
            }
            let color_name = this.data.avaliable_colors.find(color=> color.id == this.color_id)
            return color_name;
        },
        available_floors(){
            if(!this.inventory_value || !this.size){
                return [];
            }
            if(this.saleReturn.sale_return_product){
                return this.saleReturn.sale_return_product.available_floors;
            }
            const ava_floors= this.inventory_value.available_floor_of_sub_product.find((floor)=> floor.sub_product_id == this.size.sub_product_id);
            return ava_floors.available_floor;
        }
    },
    methods: {
        ...mapActions(["getApiData"]),
        customLabel(option) {
            return `${option?.name_translations[0]?.name}`;
        },
        customLabeltwo(option) {
            return `${option?.name} | Qty: ${option?.qty}`;
        },
        async getProductDetail() {
            let payload = {
                url: `product_details?product_id=${this.productId}`,
            };
            let res = await this.getApiData(payload);
            this.data = res.data.product;

            let local_id = localStorage.getItem("color_id");
            let first_color_id = this.data?.avaliable_colors[0].id;
            if (first_color_id) {
                var filter_c = this.data?.avaliable_colors.filter(
                    (col) => col.id == first_color_id
                );

                if (filter_c.length != 0) {
                    this.size = filter_c[0]?.available_sizes[0];
                    this.available_sizes = filter_c[0]?.available_sizes;
                    // this.productDetail?.avaliable_colors[0]?.available_sizes;
                    this.color_id = first_color_id;
                }
            }
            if (local_id) {
                var filter_c = this.data?.avaliable_colors.filter(
                    (col) => col.id == local_id
                );
                if (filter_c.length != 0) {
                    this.size = filter_c[0]?.available_sizes[0];
                    this.available_sizes = filter_c[0]?.available_sizes;
                    this.color_id = local_id;
                }
            }

            this.data.avaliable_colors.forEach((element) => {
                this.color_images.push(element.icon);
            });
        },
        afterLogin() {},
        selectSize(size) {
            this.size = size;
        },
        getName(names) {
            if (!names) {
                return;
            }
            let lang_name = names.filter(
                (name) => name.language_code == this.languageCode
            );
            return lang_name[0]?.name;
        },
        getImages() {
            //load image from s3
            let uniqImages = [...new Set(this.images)]; //remove duplicate images
            const imageLoadings = uniqImages.map((imageSrc) => {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.src = imageSrc;
                    img.onload = resolve;
                    img.onerror = reject;
                });
            });
            Promise.all(imageLoadings)
                .then(() => {
                    this.isLoading = false;
                })
                .catch((error) => {});
        },
        getColorImages() {
            //load image from s3
            let uniqImages = [...new Set(this.color_images)]; //remove duplicate images
            const imageLoadings = uniqImages.map((imageSrc) => {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.src = imageSrc;
                    img.onload = resolve;
                    img.onerror = reject;
                });
            });
            Promise.all(imageLoadings)
                .then(() => {
                    this.isLoading = false;
                })
                .catch((error) => {});
        },
        closeModal() {
            var id = 'cancel'+this.saleReturn.id;
            document.getElementById(id).click();
        },
        formattedPrice(price) {
            if (!price) {
                return;
            }
            // Convert the price to a string
            let priceString = price.toString();

            // Insert commas every three digits from the end
            let formattedPrice = priceString.replace(
                /\B(?=(\d{3})+(?!\d))/g,
                ","
            );

            return `${formattedPrice} MMK`;
        },
        confirmNewReturnItem(){
          var item = {
              "type": "sub_product",
              "floor_id": this.selected_floor.id,
              "id": this.size.sub_product_id,
              "quantity": this.saleReturn.qty,
                "return_item_detail":{
                name: this.data.name_translations,
                size: this.size.name,
                color: this.color_name.name,
                floor: this.selected_floor.name
            }
          }
    
          this.setNewReturnItem(item);
          this.closeModal();
        }
    },
    watch: {
        productId() {
            this.getProductDetail();
        },
        color_id() {
            let filter = this.data.avaliable_colors.filter(
                (color) => color.id == this.color_id
            );
            let product_images = [];
            filter[0].photos.forEach((img) => {
                product_images.push(img.name);
            });
            this.images = product_images;
            this.mainImage = product_images[0];
            this.available_sizes = filter[0].available_sizes;
            this.size = filter[0].available_sizes[0];
            this.getImages();
            this.reRender++;
        },
    },
    mounted() {
        if (this.productId != 0) {
            this.getProductDetail();
            this.getColorImages();
        }
    },
};
</script>
<style>
.check-container {
    cursor: pointer;
}

.checkMark {
    color: #cdd4e0;
}

.checkMark::before {
    position: relative;
    top: 1px;
}

.check-container input:checked ~ .checkMark {
    color: #888;
}
</style>
