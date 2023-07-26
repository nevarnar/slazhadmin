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
            <div class="contents" v-if="inOrOut == 'out'">
                <div
                    class="contents"
                    v-for="(floor, idx) in subproduct.floor"
                    :key="idx"
                >
                    <div class="contents" v-if="idx == 0">
                        <td class="sec-table-td">
                            {{ floor.name }}
                        </td>
                        <td class="sec-table-td">{{ floor.quantity }}</td>
                    </div>
                </div>
            </div>
            <div class="contents" v-if="inOrOut == 'in'">
                <div
                    class="contents"
                    v-for="(floor, idxxx) in subproduct.to_floor"
                    :key="idxxx"
                >
                    <div class="contents" v-if="idxxx == 0">
                        <td class="sec-table-td">
                            {{ floor.name }}
                        </td>
                        <td class="sec-table-td">{{ floor.quantity }}</td>
                    </div>
                </div>
            </div>
            <td class="sec-table-td">{{ subproduct.total_quantity }}</td>
        </tr>
        <div class="contents" v-if="inOrOut == 'out'">
            <tr v-for="(flr, idxx) in subproduct.floor" :key="idxx">
                <div class="contents" v-if="idxx != 0">
                    <td colspan="6" class="sec-table-td"></td>
                    <td class="sec-table-td">{{ flr.name }}</td>
                    <td class="sec-table-td" style="text-align: center">
                        {{ flr.quantity }}
                    </td>
                    <td class="sec-table-td"></td>
                </div>
            </tr>
        </div>
        <div class="contents" v-if="inOrOut == 'in'">
            <tr v-for="(flr, idxxxxx) in subproduct.to_floor" :key="idxxxxx">
                <div class="contents" v-if="idxxxxx != 0">
                    <td colspan="6" class="sec-table-td"></td>
                    <td class="sec-table-td">{{ flr.name }}</td>
                    <td class="sec-table-td" style="text-align: center">
                        {{ flr.quantity }}
                    </td>
                    <td class="sec-table-td"></td>
                </div>
            </tr>
        </div>

        <tr>
            <!-- for underline -->
            <td colspan="9" class="py-3">
                <hr class="my-02 h-0" />
            </td>
        </tr>
    </div>
</template>
<script>
export default {
    name: "InventoryTransferDetailRow",
    props: ["subproduct", "index", "inOrOut"],
};
</script>
