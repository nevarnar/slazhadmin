<template lang="">
    <div class="inner-main-container">
        <div class="flex justify-between">
            <p class="page-tittle pt-2">Stock Lists</p>

            <div>
                <div v-if="isAdmin" class="inline-block mb-2">
                    <createbtn v-on:open_create_modal="onCreate" />
                </div>
            </div>
        </div>
        <div class="relative flex justify-between">
            <div class="flex">
                <div class="form-check inline-block ml-3 mr-2">
                    <input
                        class="form-check-input input-check float-center"
                        type="checkbox"
                        value=""
                    />
                </div>
                <div class="inline-block mx-1">
                    <multiselect
                        v-model="subCategoryValue"
                        :options="subCategoryOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Subcategory"
                        @input="getStockPaginatedData"
                    ></multiselect>
                    <!-- @input="changeType" -->
                </div>
                <div class="list-component">
                    <multiselect
                        v-model="brandValue"
                        :options="brandOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Brands"
                        @input="getStockPaginatedData"
                    ></multiselect>
                </div>
                <div class="list-component">
                    <multiselect
                        v-model="seriesValue"
                        :options="seriesOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Series"
                        @input="getStockPaginatedData"
                    ></multiselect>
                </div>
                <div class="list-component" v-if="isAdmin">
                    <multiselect
                        v-model="inventoryValue"
                        :options="inventoryOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Inventory"
                        @input="getFloor"
                    ></multiselect>
                </div>
                <div class="list-component">
                    <multiselect
                        v-model="floorValue"
                        :options="floorOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="name"
                        label="name"
                        placeholder="Floors"
                        @input="getStockPaginatedData"
                    ></multiselect>
                </div>
                <div class="list-component">
                    <SearchBox
                        :mutationName="mutationName"
                        :pagination-url="paginationUrl"
                        search-web="web"
                    />
                </div>
            </div>
            <div v-if="!isAdmin" class="inline-block mb-2">
                <createbtn v-on:open_create_modal="onCreate" />
            </div>
            <div v-show="!isAdmin" class="inline-block ml-1.5 mr-2">
                <a
                    href="/inventory_transfer"
                    class="btn-clear create-btn"
                    type="button"
                    style="margin-top: 0px"
                >
                    <i class="fal fa-exchange"></i>
                </a>
            </div>
        </div>
        <div class="block pb-8">
            <table class="table-auto primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Item Code</th>
                        <th>Series</th>
                        <th>Product Sub Category</th>
                        <th>Brand</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <div
                        style="display: contents"
                        v-for="(stock, index) in myStockPaginatedData"
                        :key="stock.id"
                    >
                        <tr>
                            <td>{{ ++index }}</td>
                            <td>
                                {{
                                    stock.sub_product.product
                                        .name_translations[0].name
                                }}
                            </td>
                            <td>{{ stock.sub_product.sku }}</td>
                            <td>
                                {{
                                    stock.sub_product.product.thing?.series
                                        ?.length != 0
                                        ? stock.sub_product.product.thing
                                              ?.series[0].name_translations[0]
                                              .name
                                        : null
                                }}
                            </td>
                            <td>
                                {{
                                    stock.sub_product.product.thing
                                        .sub_categories[0].name_translations[0]
                                        .name
                                }}
                            </td>
                            <td>
                                {{
                                    stock.sub_product.product.thing.brands[0]
                                        .name_translations[0].name
                                }}
                            </td>
                            <td>{{ stock.total_quantity }}</td>
                            <td>
                                <button
                                    data-bs-toggle="collapse"
                                    :data-bs-target="'#detail' + stock.id"
                                    aria-expanded="false"
                                    :aria-controls="'detail' + stock.id"
                                >
                                    <i class="fal fa-list"></i>
                                </button>
                            </td>
                        </tr>

                        <tr class="collapse" :id="'detail' + stock.id">
                            <td colspan="9">
                                <div class="relative flex w-full pt-3">
                                    <div
                                        class="pr-6 pt-3 pl-10 pb-6 bg-inherit inline-block relative"
                                    >
                                        <img
                                            :src="stock.sub_product.photo.name"
                                            alt=""
                                        />
                                    </div>

                                    <div class="w-full flex flex-row">
                                        <div class="w-max">
                                            <div
                                                class="flex justify-start pl-6 pt-4"
                                            >
                                                <p
                                                    class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                                    style="
                                                        font-family: 'Roboto',
                                                            sans-serif;
                                                    "
                                                >
                                                    Color
                                                </p>
                                                <span class="px-3"> : </span>
                                                <p
                                                    class="text-sm text-gray-500 inline-block"
                                                >
                                                    {{
                                                        stock.sub_product.color
                                                            .name_translations[0]
                                                            .name
                                                    }}
                                                </p>
                                            </div>
                                            <div
                                                class="flex justify-start pl-6 py-2"
                                            >
                                                <p
                                                    class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                                    style="
                                                        font-family: 'Roboto',
                                                            sans-serif;
                                                    "
                                                >
                                                    Size
                                                </p>
                                                <span class="px-3"> : </span>
                                                <p
                                                    class="text-sm text-gray-500 inline-block"
                                                >
                                                    {{
                                                        stock.sub_product.size
                                                            .name
                                                    }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="pl-8 pt-3.5 w-full">
                                            <table class="secondary-table">
                                                <thead
                                                    class="secondary-table-thead"
                                                >
                                                    <tr>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="
                                                                padding-top: 0.25rem;
                                                                padding-bottom: 0.25rem;
                                                            "
                                                        >
                                                            Inventory
                                                        </th>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="
                                                                padding-top: 0.25rem;
                                                                padding-bottom: 0.25rem;
                                                            "
                                                        >
                                                            Shelf
                                                        </th>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="
                                                                padding-top: 0.25rem;
                                                                padding-bottom: 0.25rem;
                                                            "
                                                        >
                                                            Amount
                                                        </th>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="
                                                                padding-top: 0.25rem;
                                                                padding-bottom: 0.25rem;
                                                            "
                                                        ></th>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="
                                                                padding-top: 0.25rem;
                                                                padding-bottom: 0.25rem;
                                                            "
                                                        ></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(
                                                            floor, index
                                                        ) in stock.floors"
                                                        :key="index"
                                                    >
                                                        <td
                                                            class="sec-table-td"
                                                        >
                                                            {{
                                                                floor.shelf
                                                                    .inventory
                                                                    .name_translations[0]
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td
                                                            class="sec-table-td"
                                                        >
                                                            {{ floor.name }}
                                                        </td>
                                                        <td
                                                            class="sec-table-td"
                                                        >
                                                            {{ floor.quantity }}
                                                        </td>
                                                        <td
                                                            colspan="2"
                                                            class="pr-10 py-1 text-right w-full"
                                                        >
                                                            <button
                                                                type="button"
                                                                title="Add Defect Item"
                                                                id="defect_button"
                                                                data-bs-toggle="modal"
                                                                :data-bs-target="
                                                                    '#defect_item' +
                                                                    floor.id +
                                                                    stock.id
                                                                "
                                                            >
                                                                <i
                                                                    class="fal fa-info-circle"
                                                                ></i>
                                                            </button>
                                                            <a
                                                                :href="`/invoice_edit/${stock.sub_product_id}/${floor.id}`"
                                                                title="Edit Floor stock"
                                                            >
                                                                <i
                                                                    class="fal fa-file-edit"
                                                                ></i>
                                                            </a>
                                                        </td>

                                                        <div
                                                            class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                                                            :id="
                                                                'defect_item' +
                                                                floor.id +
                                                                stock.id
                                                            "
                                                            tabindex="-1"
                                                            aria-labelledby="defect_item"
                                                            aria-hidden="true"
                                                        >
                                                            <add-defect-item-modal
                                                                @getStockPaginatedData="
                                                                    getStockPaginatedData
                                                                "
                                                                :stock="stock"
                                                                :floor="floor"
                                                            />
                                                        </div>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </div>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedWebData"
                :max-visible-buttons="20"
                :mutationName="mutationName"
                :pagination-url="paginationUrl"
            />
        </div>
    </div>
</template>
<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";
import AddDefectItemModal from "../Components/AddDefectItemModal.vue";

export default {
    name: "StockLists",
    components: {
        Multiselect,
        Createbtn,
        SearchBox,
        AddDefectItemModal,
    },
    props: ["authUser"],
    data() {
        return {
            mutationName: "setStockPaginatedData",
            subCategoryValue: null,
            subCategoryOptions: [],
            brandValue: null,
            brandOptions: [],
            seriesValue: null,
            seriesOptions: [],
            inventoryValue: null,
            inventoryOptions: [],
            floorValue: null,
            floorOptions: [],
            editFloor: null,
            editStock: null,
        };
    },
    computed: {
        ...mapGetters(["myStockPaginatedData"]),
        paginationUrl() {
            let inventory_id = this.isAdmin
                ? this.inventoryValue == null
                    ? ""
                    : this.inventoryValue.id
                : this.authUser.inventory_id;

            return `stocks?sub_category_id=${
                this.subCategoryValue == null ? "" : this.subCategoryValue.id
            }&brand_id=${
                this.brandValue == null ? "" : this.brandValue.id
            }&series_id=${
                this.seriesValue == null ? "" : this.seriesValue.id
            }&floor_id=${
                this.floorValue == null ? "" : this.floorValue.id
            }&inventory_id=${inventory_id}`;
        },
        isAdmin() {
            if (this.authUser.isAdmin) {
                return true;
            } else {
                return false;
            }
        },
        images() {
            let image_previews = [];
            this.myStockPaginatedData.forEach((element) => {
                image_previews.push(element.sub_product.photo.name);
            });
            return image_previews;
        },
    },
    methods: {
        ...mapActions(["getPaginatedWebData", "getApiData"]),
        onCreate() {
            window.location.href = `/stocks/create`;
        },
        customLabel(option) {
            return `${option.name_translations[0]?.name}`;
        },
        async getSubcategory() {
            let res = await this.getApiData({ url: "get_sub_categories" });
            this.subCategoryOptions = res.data.data;
        },
        async getBrands() {
            let res = await this.getApiData({ url: "get_brands" });
            this.brandOptions = res.data.data;
        },
        async getSeries() {
            let res = await this.getApiData({ url: "get_series/product" });
            this.seriesOptions = res.data.data;
        },
        async getInventories() {
            this.getApiData({
                url: `get_inventories`,
            }).then((res) => {
                this.inventoryOptions = res.data.data;
            });
        },
        async getFloor() {
            if (this.isAdmin && this.inventoryValue == null) {
                return;
            }
            let inventory_id = this.isAdmin
                ? this.inventoryValue.id
                : this.authUser.inventory_id;
            // this.authUser.inventory_id
            let payload = {
                url: `get_floor_by_inventory?inventory_id=${inventory_id}&is_admin=${
                    this.isAdmin ? 1 : 0
                }`,
            };

            this.getApiData(payload).then((res) => {
                this.floorOptions = res.data.data;
            });
            this.getStockPaginatedData();
            // let ress = await this.postApiForm(payload);
        },
        getStockPaginatedData() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: this.paginationUrl,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedWebData(payload);
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
        this.getStockPaginatedData();
        if (this.isAdmin) {
            this.getInventories();
        } else {
            this.getFloor();
        }
        this.getImages();

        this.getSubcategory();
        this.getBrands();
        this.getSeries();
    },
};
</script>
