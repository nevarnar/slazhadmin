<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Subcategory Management</p>
        </div>
        <div class="relative flex justify-between">
            <SearchBox
                :mutationName="mutationName"
                pagination-url="sub_categories?"
            />
            <createbtn v-on:open_create_modal="onCreate" />
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="subCategory in mySubCategories"
                        :key="subCategory.id"
                    >
                        <td>
                            {{ subCategory.index }}
                        </td>
                        <td>
                            <div class="item-img-container">
                                <img alt="" :src="subCategory.icon" />
                            </div>
                        </td>
                        <td>
                            {{ subCategory.name_translations[0].name }}
                        </td>
                        <td>
                            {{ subCategory.category.name_translations[0].name }}
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    :checked="subCategory.is_available"
                                    @click="
                                        availableChange({
                                            data: subCategory,
                                            url: 'sub_categories',
                                        })
                                    "
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <button
                                @click="onEdit(subCategory.id)"
                                type="button"
                                class="btn-clear"
                                title="Edit"
                                id="edit-button"
                            >
                                <a class="a-clear" href="#">
                                    <i
                                        class="fal fa-file-edit fw300"
                                        style="color: #68728c"
                                    ></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="mySubCategories.length == 0">
                        <td class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="sub_categories?"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
    name: "subCategoryLists",
    components: {
        Createbtn,
        SearchBox,
    },
    data() {
        return {
            typeOfSearch: "sub_category",
            mutationName: "setSubCategories",
        };
    },
    computed: {
        ...mapGetters(["mySubCategories"]),
        images() {
            let image_previews = [];
            this.mySubCategories.forEach((element) => {
                image_previews.push(element.icon);
            });
            return image_previews;
        },
    },
    methods: {
        ...mapActions(["getPaginatedData", "search", "availableChange"]),
        onEdit(sub_category_id) {
            window.location.href = `/sub_categories_lists/edit/${sub_category_id}`;
        },
        onCreate(sub_category_id) {
            window.location.href = `/sub_categories_lists/create`;
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
        let paginatePage = 1;
        let payload = {
            page: paginatePage,
            url: "sub_categories?",
            paginateMutation: this.mutationName,
        };
        this.getPaginatedData(payload);
        this.getImages();
    },
};
</script>
