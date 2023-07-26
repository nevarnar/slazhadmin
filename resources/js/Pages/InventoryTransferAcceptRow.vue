<template lang="">
    <div class="contents">
        <tr>
            <td class="sec-table-td">{{ index }}</td>
            <td class="sec-table-td">
                {{ subproduct.product.name_translations[0].name }}
            </td>
            <td class="sec-table-td">
                {{
                    subproduct.product.sub_categories.name_translations[0].name
                }}
            </td>
            <td class="sec-table-td">
                {{ subproduct.product.brands.name_translations[0].name }}
            </td>
            <td class="sec-table-td">
                {{ subproduct.color.name_translations[0].name }}
            </td>
            <td class="sec-table-td">
                {{ subproduct.size.name }}
            </td>
            <td class="sec-table-td"></td>
            <td class="sec-table-td" style="text-align: right">
                <p>{{ subproduct.total_quantity }}</p>
                <span v-if="showValidateErr" class="text-validation block pt-1">
                    Maximum Limit Exceeded!
                </span>
            </td>
            <td class="sec-table-td">
                <button
                    v-if="currentState == 'notadd'"
                    @click.prevent="
                        currentState = 'adding';
                        showRecommendedShelf = true;
                    "
                    type="button"
                    title=""
                    id=""
                >
                    <a href="#">
                        <i
                            class="fal fa-list"
                            style="color: rgb(220 38 38)"
                        ></i>
                    </a>
                </button>
                <button
                    v-if="currentState == 'adding'"
                    type="button"
                    title=""
                    id=""
                >
                    <a href="#" @click.prevent="confirmRecommendFloor">
                        <i class="fal fa-check"></i>
                    </a>
                </button>
                <button
                    @click.prevent="
                        showRecommendedShelf = true;
                        currentState = 'adding';
                    "
                    v-if="currentState == 'added'"
                    type="button"
                    title="Delete"
                    id=""
                >
                    <a href="#">
                        <i
                            class="fal fa-list"
                            style="color: rgb(22 163 74)"
                        ></i>
                    </a>
                </button>
            </td>
        </tr>
        <tr
            v-if="showRecommendedShelf"
            style="border-bottom: 1px solid rgb(229, 231, 235) !important"
        >
            <td colspan="5" class="sec-table-td"></td>

            <td colspan="3" class="sec-table-td" style="text-align: left">
                <div class="my-4 pb-2">
                    <div class="flex justify-between mb-1.5">
                        <div>
                            <p class="text-gray-800 text-[14px]">Shelves</p>
                        </div>
                        <div>
                            <button
                                class="text-black"
                                type="button"
                                id="add_btn"
                                data-bs-toggle="modal"
                                :data-bs-target="'#add_shelf' + subproduct.id"
                            >
                                <i class="fal fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-start mb-3">
                        <div>
                            <p class="text-[12px] text-gray-700">
                                Recommended Shelves
                            </p>
                        </div>
                    </div>
                    <div
                        v-for="(floor, id) in subproduct.recommended_floor"
                        :key="id"
                        class="flex justify-between mb-3"
                    >
                        <div>
                            <label class="text-gray-500 text-sm pt-2">{{
                                floor.name
                            }}</label>

                            <input
                                v-model="floor.transfer_amount"
                                type="text"
                                class="ml-4 pt-2 pb-1 px-1 secondary-input-form"
                                placeholder=""
                            />
                        </div>
                        <div>
                            <!-- <button tyep="button" class="pt-3">
                                <i class="fal fa-check"></i>
                            </button> -->
                            <button
                                @click.prevent="
                                    deleteShelf({
                                        id: subproduct.id,
                                        shelf_id: floor.id,
                                    })
                                "
                                tyep="button"
                                class="pt-3 ml-3"
                            >
                                <i class="fal fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
        <div
            class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            :id="'add_shelf' + subproduct.id"
            tabindex="-1"
            aria-labelledby="add_shelf"
            aria-hidden="true"
        >
            <recommended-shelf-modal
                :subproduct-id="subproduct.id"
                :auth-user="authUser"
            />
        </div>
    </div>
</template>
<script>
import { mapMutations } from "vuex";
import RecommendedShelfModal from "../Components/RecommendedShelfModal.vue";

export default {
    name: "InventoryTransferAcceptRow",
    components: {
        RecommendedShelfModal,
    },
    props: ["subproduct", "index", "authUser"],
    data() {
        return {
            currentState: "notadd", //notadd, adding, added    -> for action button show
            showRecommendedShelf: false,
            showValidateErr: false,
        };
    },
    methods: {
        ...mapMutations(["deleteShelf"]),
        confirmRecommendFloor() {
            var totalFloorQty = 0;
            this.subproduct.recommended_floor.forEach((floor) => {
                totalFloorQty += parseInt(floor.transfer_amount);
            });
            if (totalFloorQty != this.subproduct.total_quantity) {
                this.showValidateErr = true;
                return;
            }
            this.currentState = "added";
            this.showRecommendedShelf = false;
            this.showValidateErr = false;
        },
    },
};
</script>
