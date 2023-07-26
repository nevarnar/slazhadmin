<template lang="">
    <div class="contents">
        <tr>
            <td class="sec-table-td">{{ index }}</td>
            <td class="sec-table-td">{{ item?.item?.sub_product.product.name_translations[0].name }}</td>
            <td class="sec-table-td">{{  item?.item?.sub_product.product.thing.sub_categories[0]
                .name_translations[0].name  }}</td>
            <td class="sec-table-td">{{  item?.item?.sub_product.product.thing.brands[0]
                .name_translations[0].name }}</td>
            <td class="sec-table-td">{{ item?.item?.sub_product.color.name_translations[0]
                .name }}</td>
            <td class="sec-table-td">{{ item?.item?.sub_product.size.name }}</td>
            <div  v-for="(floor, idx) in item?.item?.floors" :key="idx">
            <td class="sec-table-td">
                <div>{{ floor.name }}</div>
                <br />
                <br />
            </td>
            <td class="sec-table-td">
                <div v-if="isAdding">
                    <input
                    @input="checkMaxAmount(floor.id)"
                    v-model="item?.item?.floors[idx].transfer_amount"
                        type="number"
                        class="pt-1 pb-1 px-1 secondary-input-form w-20"
                        placeholder=""
                    />
                    <p :class="floor.max_amount_validation?'text-red-600':''">( Maximum Stock : {{ floor.quantity }} )</p>
                   </div>
                   <p v-if="!isAdding">{{ floor.transfer_amount }}</p>
            </td>

            </div>
            <td>
                <button
                    v-if="isAdding"
                    @click.prevent="checkTotal"
                    class="text-gray-500"
                    type="button"
                    title="Confirm"
                >
                    <a href="#">
                        <i class="fal fa-check"></i>
                    </a>
                </button>
                <button
                    @click.prevent="isAdding = true"
                    v-if="!isAdding"
                    class="text-gray-500"
                    type="button"
                    title="Edit"
                >
                    <a href="#">
                        <i class="fal fa-file"></i>
                    </a>
                </button>
            </td>
            <td class="sec-table-td relative" style="text-align: right">
                <p>{{ item?.amount }}</p>
                <span v-if="item?.amountValidation && showHideValidation" class="text-validation block absolute right-0 pt-1">
                    Maximum Limit Exceeded!
                </span>
            </td>
            <td class="sec-table-td">
                <button @click.prevent="removeTransferItemHandaler(item?.item?.id)" type="button" title="Delete" :id="item?.item?.id">
                    <a href="#">
                        <i class="fal fa-trash"></i>
                    </a>
                </button>
            </td>
        </tr>
        <!-- <tr>
            <td colspan="6" class="sec-table-td"></td>
            <td class="sec-table-td">A2</td>
            <td class="sec-table-td">
                <input
                    type="text"
                    class="pt-1 pb-1 px-1 secondary-input-form w-20"
                    placeholder="50"
                />
                <p>( Maximum Stock : 50 )</p>
            </td>

            <td
                colspan="2"
                class="sec-table-td relative"
                style="text-align: right"
            ></td>
        </tr>
        <tr>-->
            <td colspan="11">
                <hr class="mt-3 mb-2 h-0" />
            </td>
        </tr>
    </div>
</template>
<script>
import { mapMutations } from 'vuex';
export default {
    name: "InventoryTransferCreateRow",
    props:['itemStock','index'],
    data() {
        return {
            isAdding: false,
            item:null,
            checkTotalValidation:true,
            showHideValidation:false,
        };
    },
    methods: {
        ...mapMutations(["removeTransferItem",'setValidateErr']),
        checkMaxAmount(floor_id){
        console.log('floor',floor_id);
        console.log(this.item.item.floors);
        const found = this.item.item.floors.find(floor => floor.id == floor_id);
        const foundindex = this.item.item.floors.find(floor => floor.id == floor_id);
        console.log(found);
        if(parseInt(found.transfer_amount)>found.quantity){
           found.max_amount_validation=true;
        //    return true;
        }
        else {
           found.max_amount_validation=false;
            // return false;
        }
        this.$forceUpdate();
        },
        checkTotal(){
            this.showHideValidation= true;
            let total = 0;
            this.item.item.floors.forEach(floor => {
                total+=parseInt(floor.transfer_amount);
            });
            console.log(total,this.item.amount);
            if(total>parseInt(this.item.amount) || total==0){
                this.item.amountValidation = true;
            }
            else {
                this.isAdding=false;
                this.item.amountValidation = false;
            }
        },
        removeTransferItemHandaler(id){
            this.removeTransferItem(id);
            // this.$forceUpdate();
        }
    },
    mounted () {
        this.item = this.itemStock;
    },
    watch: {
        itemStock(newVal, oldVal) {
            this.item = this.itemStock;
        },
    }
};
</script>
<style lang=""></style>
