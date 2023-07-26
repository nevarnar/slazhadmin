<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Product Management</p>
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
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Bulk Action</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Filter</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="list-component">
                    <SearchBox
                        :pagination-url="paginationUrl"
                        :mutationName="mutationName"
                    />
                </div>
                <div class="list-component">
                    <div class="form-group mb-2">
                        <multiselect
                            v-model="filterValue"
                            :options="filterOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            :custom-label="customLabel"
                            placeholder="Choose Series"
                            track-by="id"
                            @input="changeType"
                        ></multiselect>
                    </div>
                </div>
            </div>
            <div>
                <createbtn v-on:open_create_modal="onCreate" />
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Item Code</th>
                        <th>Product Sub Category</th>
                        <th>Brand</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbl">
                    <tr v-for="product in myProducts" :key="product.id">
                        <td @click="getSubProducts(product)">
                            {{ product.index }}
                        </td>
                        <td @click="getSubProducts(product)">
                            {{ product.name_translations[0].name }}
                        </td>
                        <td @click="getSubProducts(product)">
                            {{ product.sku }}
                        </td>
                        <td @click="getSubProducts(product)">
                            {{
                                product.thing.sub_categories[0]
                                    .name_translations[0].name
                            }}
                        </td>
                        <td @click="getSubProducts(product)">
                            {{
                                product.thing.brands[0].name_translations[0]
                                    .name
                            }}
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="product.is_available"
                                    @click="
                                        availableChange({
                                            data: product,
                                            url: 'products',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <button
                                @click="onEdit(product.id)"
                                type="button"
                                title="Edit"
                                id="edit_button"
                                class="edit-btn"
                            >
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr
                        v-if="myProducts.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td
                            colspan="6"
                            class="px-5 py-2 text-table "
                        >
                            No Data Found!
                        </td>
                    </tr>
                    <table-pagination
                        :pagination-lists="getPaginatedData"
                        :max-visible-buttons="5"
                        :mutationName="mutationName"
                        :pagination-url="paginationUrl"
                    />
                </tbody>
            </table>
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
    name: "productLists",
    components: {
        Multiselect,
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "product",
            mutationName: "setProducts",
            filterValue: "",
            filterOptions: [],
        };
    },
    computed: {
        ...mapGetters(["myProducts"]),
        paginationUrl() {
            var url ;
            if(this.filterValue){
                url =  `products?series=${
                this.filterValue  ? this.filterValue.id : ""
            }`;
            }else{
                url = `products?`;
            }
            return url;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "search",
            "availableChange",
            "getApiData",
        ]),
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        onEdit(product_id) {
            window.location.href = `/products_lists/edit/${product_id}`;
        },
        onCreate(product_id) {
            window.location.href = `/products_lists/create`;
        },
        getSubProducts(product) {
            window.location.href = `/products_lists/sub_product_by_product/${product.id}`;
        },
        changeType() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: `products?series=${
                    this.filterValue != null ? this.filterValue.id : ""
                }`,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
        },
        async getSeries() {
            let url = `get_series/product`;
            let res = await this.getApiData({ url: url });
            this.filterOptions = res.data.data;
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "products?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
        this.getSeries();
    },
};
</script>
