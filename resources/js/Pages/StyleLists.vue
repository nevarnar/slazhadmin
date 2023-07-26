<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Styles Management</p>
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
                        :mutationName="mutationName"
                        :pagination-url="paginationUrl"
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
                            :allow-empty="false"
                            track-by="name"
                            label="name"
                            placeholder="Choose Type"
                            @input="changeType"
                        ></multiselect>
                    </div>
                </div>
                <div class="list-component">
                    <div class="form-group mb-2">
                        <multiselect
                            v-model="seriesValue"
                            :options="seriesOptions"
                            :searchable="false"
                            :close-on-select="true"
                            :show-labels="false"
                            track-by="id"
                            :custom-label="customLabel"
                            placeholder="Choose Series"
                            @input="changeSeries"
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
                    <tr v-for="style in myStylePaginatedData" :key="style.id">
                        <td>{{ style.index }}</td>
                        <td>{{ style.name_translations[0].name }}</td>
                        <td>{{ style.item_code }}</td>
                        <td>
                            {{
                                style.thing.categories[0]?.name_translations[0]
                                    .name
                            }}
                        </td>
                        <td>
                            {{
                                style.thing.brands.length
                                    ? style.thing.brands[0].name_translations[0]
                                          .name
                                    : ""
                            }}
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="style.is_available"
                                    @click="
                                        availableChange({
                                            data: style,
                                            url: 'styles',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <button
                                @click="onEdit(style.id)"
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
                        v-if="myStylePaginatedData.length == 0"
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td
                            colspan="6"
                            class="px-5 py-2 text-table"
                        >
                            Not Data Found!
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
    name: "styleLists",
    components: {
        Multiselect,
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            // typeOfSearch: "style",
            mutationName: "setStylePaginatedData",
            filterValue: { name: "Style", value: "style" },
            filterOptions: [
                { name: "Style", value: "style" },
                { name: "Pack", value: "pack" },
            ],
            seriesValue: "",
            seriesOptions: [],
        };
    },
    computed: {
        ...mapGetters(["myStylePaginatedData"]),
        paginationUrl() {
            return `styles?series=${
                this.seriesValue == null ? "" : this.seriesValue.id
            }&type=${this.filterValue.value}`;
        },
        typeOfSearch() {
            return this.filterValue.value;
        },
    },
    methods: {
        ...mapActions([
            "getPaginatedData",
            "search",
            "availableChange",
            "getApiData",
        ]),
        onEdit(style_id) {
            window.location.href = `/style_lists/edit/${style_id}`;
        },
        customLabel(option) {
            return `${option.name_translations[0].name}`;
        },
        onCreate(product_id) {
            window.location.href = `/style_lists/create`;
        },
        changeType() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: `styles?type=${this.filterValue.value}`,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
        },
        changeSeries() {
            let paginatePage = 1;
            let payload = {
                page: paginatePage,
                url: `styles?series=${
                    this.seriesValue != null ? this.filterValue.id : ""
                }&type=${this.filterValue.value}`,
                paginateMutation: this.mutationName,
            };
            this.getPaginatedData(payload);
        },
        async getSeries() {
            let url = `get_series/${this.filterValue.value}`;
            let res = await this.getApiData({ url: url });
            this.seriesOptions = res.data.data;
        },
    },
    mounted() {
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: `styles?type=${this.filterValue.value}`,
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
        this.getSeries();
    },
};
</script>
