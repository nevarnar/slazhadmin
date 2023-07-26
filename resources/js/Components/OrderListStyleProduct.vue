<template lang="">
    <div class="contents">
        <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
            <img :src="subproduct.sub_product.photo.name" alt="" />
        </div>

        <div class="w-full flex flex-row">
            <div class="w-max">
                <div class="flex justify-start pl-4 pt-4">
                    <p
                        class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        {{
                            subproduct.sub_product.product.name_translations[0]
                                .name
                        }}
                    </p>
                </div>
                <div class="flex justify-start pl-4 pt-4">
                    <p
                        class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        Color
                    </p>
                    <span class="px-3"> : </span>
                    <p class="text-sm text-gray-500 inline-block">
                        {{
                            subproduct.sub_product.color.name_translations[0]
                                .name
                        }}
                    </p>
                </div>
                <div class="flex justify-start pl-4 py-2">
                    <p
                        class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                        style="font-family: 'Roboto', sans-serif"
                    >
                        Size
                    </p>
                    <span class="px-3"> : </span>
                    <p class="text-sm text-gray-500 inline-block">
                        {{ subproduct.sub_product.size.name }}
                    </p>
                </div>
            </div>

            <div class="pl-8 pt-3.5 w-full">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th
                                class="sec-thead-th"
                                style="
                                    padding-top: 0.25rem;
                                    padding-bottom: 0.25rem;
                                "
                            >
                                Count
                            </th>
                            <th
                                class="sec-thead-th"
                                style="
                                    padding-top: 0.25rem;
                                    padding-bottom: 0.25rem;
                                "
                            >
                                SKU
                            </th>
                            <th
                                class="sec-thead-th"
                                style="
                                    padding-top: 0.25rem;
                                    padding-bottom: 0.25rem;
                                "
                            >
                                <!-- Avalibility -->
                            </th>
                            <div
                                class="contents"
                                v-if="!show_avalibility_inventory"
                            >
                                <th
                                    @click="show_avalibility_inventory = true"
                                    class="sec-thead-th cursor-pointer"
                                    style="
                                        padding-top: 0.25rem;
                                        padding-bottom: 0.25rem;
                                    "
                                >
                                    Assign
                                </th>
                            </div>

                            <div class="contents">
                                <th
                                    class="sec-thead-th px-0 w-36"
                                    style="
                                        padding-top: 0.25rem;
                                        padding-bottom: 0.25rem;
                                    "
                                >
                                    <div class="flex">
                                        <multiselect
                                            v-if="show_avalibility_inventory"
                                            class="mt-2"
                                            v-model="avalibility_floor_value"
                                            :options="avalibility_floor_options"
                                            :searchable="false"
                                            :close-on-select="true"
                                            :show-labels="false"
                                            :custom-label="customLabel"
                                            track-by="id"
                                            placeholder="Choose floor"
                                            :disabled="after_select"
                                        ></multiselect>
                                    </div>
                                </th>
                                <th
                                    class="sec-thead-th"
                                    style="
                                        padding-top: 0.25rem;
                                        padding-bottom: 0.25rem;
                                    "
                                >
                                    <div
                                        class="contents"
                                        v-if="
                                            !after_select &&
                                            show_avalibility_inventory
                                        "
                                    >
                                        <button
                                            @click="selectAvailableInventory"
                                            type="button"
                                            class="pr-2"
                                            title=""
                                            id=""
                                        >
                                            <i class="fal fa-check"></i>
                                        </button>
                                        <button
                                            @click="
                                                show_avalibility_inventory = false
                                            "
                                            type="button"
                                            title=""
                                            id=""
                                        >
                                            <i class="fal fa-times"></i>
                                        </button>
                                    </div>
                                    <button
                                        v-if="
                                            after_select &&
                                            show_avalibility_inventory && statusvalue.value !='delivering' && statusvalue.value!='delivered'
                                        "
                                        @click="after_select = false"
                                        type="button"
                                        class="pr-2"
                                        title=""
                                        id=""
                                    >
                                        <i class="fal fa-edit"></i>
                                    </button>
                                </th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sec-table-td">
                                {{ subproduct.buying_quantity }}
                            </td>
                            <td class="sec-table-td">
                                {{ subproduct.sub_product.sku }}
                            </td>
                        </tr>

                        <div
                            class="contents"
                            v-for="(inv, i_id) in subproduct.available_floors"
                            :key="i_id"
                        >
                            <tr>
                                <td class="sec-table-td"></td>
                                <td class="sec-table-td"></td>
                                <td class="sec-table-td">
                                    {{ inv.name }} : {{ inv.qty }}
                                </td>
                                <td class="sec-table-td">
                                    {{ avalibility_floor_value?.name }}
                                </td>
                            </tr>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import { mapGetters, mapMutations } from "vuex";

export default {
    name: "OrderListStyleproduct",
    components: {
        Multiselect,
    },
    props: {
        subproduct: {},
        statusvalue: {},
        styleid: {},
        selectAvailableFloor: {
            type: Function,
        },
        inventoryValue: {},
    },
    computed: {
        ...mapGetters(["reRenderKey"]),
        avalibility_floor_options() {
            if (!this.inventoryValue) {
                return [];
            }
            let floors =
                this.inventoryValue.available_floors_by_sub_product.find(
                    (e) => e.item_id == this.subproduct.id
                );
            if (floors) {
                return floors.floors;
            }
        },
    },
    data() {
        return {
            show_avalibility_inventory: false,
            after_select: this.subproduct?.floor ? true : false,
            avalibility_floor_value: this.subproduct?.floor,
            // avalibility_floor_options: this.subproduct?.available_floors,
        };
    },
    methods: {
        ...mapMutations(["setSendOrdersAvailableFloor"]),
        customLabel(option) {
            return `${option.name} - ${option.qty}`;
        },
        selectAvailableInventory() {
            if (!this.avalibility_floor_value) {
                return;
            }
            this.selectAvailableFloor({
                type:
                    this.subproduct.orderable_type == "sub_product"
                        ? "sub_product"
                        : "style",
                id: this.subproduct.id,
                floor_id: this.avalibility_floor_value.id,
                style_id: this.styleid,
            });
            this.after_select = true;
        },
    },
};
</script>
<style lang=""></style>
