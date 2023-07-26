<template>
  <div class="w-full pt-2 mb-6">
    <table class="secondary-table">
      <thead class="secondary-table-thead">
        <tr>
          <th class="sec-thead-th">Name</th>
          <th class="sec-thead-th">Item Code</th>
          <th class="sec-thead-th">Brand</th>
          <th class="sec-thead-th">Product Category</th>
          <th class="sec-thead-th">Type</th>
          <th class="sec-thead-th">Discount Value</th>
          <th class="sec-thead-th"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(data, index) in addPromotionItemRows" :key="index">
          <td class="sec-table-td" v-if="data.type == 'sub_product'">
            {{ data.item.product?.name_translations[0].name }}
          </td>
          <td class="sec-table-td" v-else>
            {{ data.item.name_translations[0].name }}
          </td>

          <td class="sec-table-td">
            {{ data.item.sku }} {{ data.item.item_code }}
          </td>

          <td class="sec-table-td" v-if="data.type == 'sub_product'">
            {{
              data.item?.product?.thing?.brands[0]?.name_translations[0].name
            }}
          </td>
          <td class="sec-table-td" v-if="data.type == 'style'">
            {{ data.item?.thing?.brands[0]?.name_translations[0].name }}
          </td>
          <!-- <td class="sec-table-td" v-else></td> -->

          <td class="sec-table-td" v-if="data.type == 'sub_product'">
            {{
              data?.item?.product?.thing?.sub_categories[0]
                ?.name_translations[0]?.name
            }}
          </td>
          <td class="sec-table-td" v-if="data.type == 'style'">
            {{ data?.item?.thing?.categories[0]?.name_translations[0]?.name }}
          </td>

          <td class="sec-table-td">
            {{ data.type }}
          </td>
          <td class="sec-table-td">
            {{ data?.discount_value }}
          </td>

          <td class="sec-table-td">
            <button
              @click="deletePromotionItemRow(data)"
              type="button"
              title="Delete"
              id="delete-button"
            >
              <a href="#">
                <i class="fal fa-trash"></i>
              </a>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  name: "FlashSaleCreateEditTable",
  props: ["isediting"],
  computed: {
    ...mapGetters(["addPromotionItemRows"]),
  },
  methods: {
    ...mapMutations(["removePromotionItemRows"]),
    async deletePromotionItemRow(data) {
      console.log("data", data);
      this.$swal({
        title: "Are you sure?",
        text: "You can't revert your action",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes Delete it!",
        confirmButtonColor: "#f27474",
        cancelButtonText: "No, Keep it!",
        showCloseButton: true,
        showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value) {
          if (this.isediting == "create" || data.is_new == true) {
            this.removePromotionItemRows(data.local_id);
          } else {
            this.deleteItem(data)
              .then((res) => {
                //   console.log("model", res.data.data);
                this.removePromotionItemRows(data.local_id);
              })
              .catch((error) => {
                this.$swal("Error!", error.response.data.message, "error");
              });
          }
        } else {
          // this.$swal("Cancelled", "Your file is still intact", "info");
        }
      });
    },
    async deleteItem(data) {
      let res = await axios.get(
        `/delete_item?id=${data.item.flash_sale_item_id}&type=${data.type}`
      );
      return res;
    },
  },
};
</script>

<style></style>
