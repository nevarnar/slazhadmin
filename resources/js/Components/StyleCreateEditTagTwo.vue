<template>
  <div>
    <div class="pt-6 mb-6">
      <template v-if="isediting == 'create'">
        <div class="grid grid-cols-8 gap-y-2 gap-x-8 mx-2">
          <div class="col-span-2">
            <div class="form-group mb-4">
              <multiselect
                v-model="productValue"
                :options="productOptions"
                :searchable="true"
                :close-on-select="true"
                :show-labels="false"
                :custom-label="customLabel"
                @input="onAvailableColorByProduct"
                placeholder="Choose product"
              ></multiselect>
            </div>
          </div>
          <div class="col-span-2">
            <div class="form-group mb-4">
              <multiselect
                v-model="colorValue"
                :options="colorOptions"
                :searchable="false"
                :close-on-select="true"
                :show-labels="false"
                :custom-label="customLabel"
                placeholder="Choose Color"
              ></multiselect>
            </div>
          </div>
          <div class="col-span-4">
            <button class="primary-button" @click="addHandler">Add</button>
          </div>

          <div class="col-span-8">
            <hr class="my-2 h-0.5" />
          </div>
          <!-- end row -->
        </div>
      </template>
      <div class="my-4">
        <table class="secondary-table overflow-hidden">
          <thead class="secondary-table-thead">
            <tr>
              <th class="sec-thead-th"></th>
              <th class="sec-thead-th">Product Name</th>
              <th class="sec-thead-th">Product Sub Category</th>
              <th class="sec-thead-th">Brand</th>
              <th class="sec-thead-th">Color</th>
              <th class="sec-thead-th">Sizes</th>
              <th class="sec-thead-th">Price</th>
              <th class="sec-thead-th"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in myStyleProductsRows" :key="index">
              <td class="sec-table-td">{{ ++index }}</td>
              <td class="sec-table-td">
                {{ product.name_translations[0].name }}
              </td>
              <td v-if="isediting == 'create'" class="sec-table-td">
                {{
                  product?.thing?.sub_categories[0]?.name_translations[0]?.name
                }}
              </td>
              <td v-else class="sec-table-td">
                {{ product?.sub_categories[0]?.name_translations[0]?.name }}
              </td>

              <td v-if="isediting == 'create'" class="sec-table-td">
                {{ product?.thing?.brands[0]?.name_translations[0]?.name }}
              </td>
              <td v-else class="sec-table-td">
                {{ product?.brands[0]?.name_translations[0]?.name }}
              </td>

              <td v-if="isediting == 'create'" class="sec-table-td">
                {{ product?.thing?.colors[0]?.name_translations[0]?.name }}
              </td>
              <td v-else class="sec-table-td">
                {{ product?.colors[0]?.name_translations[0]?.name }}
              </td>

              <td class="sec-table-td">
                <span v-for="size in product.sizes" :key="size.id"
                  >{{ size.name }},
                </span>
              </td>
              <td class="sec-table-td">
                {{ product?.sub_product_pirce?.price }}
              </td>
              <td class="px-5 py-1.5 text-center">
                <button
                  @click="deleteStyleProductRow(product)"
                  type="button"
                  class="btn-clear"
                  title="Delete"
                  id="delete-button"
                >
                  <i class="fal fa-trash" style="color: #68728c"></i>
                </button>
              </td>
            </tr>
            <!-- <tr>
                            <td class="sec-table-td">2</td>
                            <td class="sec-table-td">Pant</td>
                            <td class="sec-table-td">zxc-9</td>
                            <td class="sec-table-td">Pant</td>
                            <td class="sec-table-td">Levis</td>
                            <td class="sec-table-td">Blue</td>
                            <td class="px-5 py-1.5 text-center">
                                <button
                                    type="button"
                                    class="btn-clear"
                                    title="Delete"
                                    id="delete-button"
                                >
                                    <i
                                        class="fal fa-trash"
                                        style="color: #68728c"
                                    ></i>
                                </button>
                            </td>
                        </tr> -->
          </tbody>
        </table>

        <div class="w-full">
          <hr class="my-2 h-0.5" />
        </div>
        <div class="flex justify-end mr-12 mt-3">
          <p class="font-semibold text-sm inline-block">Style Price</p>
          <p class="font-normal text-sm inline-block ml-4">
            {{ totalPrices }} (Min)
          </p>
        </div>
      </div>

      <div class="flex justify-end mb-8">
        <button
          :disabled="currentApiLoading"
          @click="onPublish"
          type="button"
          title=""
          class="primary-button bg-black"
        >
          <api-loading />

          {{ isediting == "create" ? "Create" : "Save" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import apiLoading from "./../Components/apiLoadingComponent";

import Multiselect from "vue-multiselect";

export default {
  name: "styleCreateEditTagTwo",
  components: {
    Multiselect,
  },
  props: ["isediting"],
  data() {
    return {
      productValue: "",
      productOptions: [],
      colorValue: "",
      colorOptions: [],
    };
  },
  computed: {
    ...mapGetters([
      "myStyleProducts",
      "myStyleProductsRows",
      "currentApiLoading",
    ]),
    totalPrices() {
      let total_prices = 0;
      this.myStyleProductsRows.forEach((element) => {
        total_prices += parseInt(element?.sub_product_pirce?.price);
      });
      return total_prices;
    },
  },
  methods: {
    ...mapActions([
      "getStyleProducts",
      "availableColorByProduct",
      "styleProductsWithSizes",
    ]),
    ...mapMutations(["removeStyleProductRow"]),
    onPublish() {
      this.clearValidation();
      let imageArr = [];
      let validation_count = 0;
      this.mySubProducts.forEach((sub) => {
        this.colorValue.forEach((color) => {
          if (
            color.color_code == sub.color.color_code &&
            sub.first_color_sub_product == true &&
            Object.keys(sub.image_file).length <= 0
          ) {
            sub.image_validation_msg = "Image is required";
            validation_count++;
          } else {
            if (Object.keys(sub.image_file).length > 0) {
              imageArr.push(sub.image_file.data);
            }
          }
        });
      });
      if (validation_count == 0) {
        this.$emit("onPublish", {
          imageArr: imageArr,
          sub_product: this.mySubProducts,
        });
      }
    },

    // onChange(event, sub_product) {
    //     let image = {
    //         name: event.target.files[0].name,
    //         data: event.target.files[0],
    //     };
    //     let payload = {
    //         image: image,
    //         sub_product: sub_product,
    //         isediting: this.isediting,
    //     };
    //     // console.log(payload, "payload");
    //     this.setImageUpload(payload);
    // },
    customLabel(option) {
      return `${option.name_translations[0].name}`;
    },
    async onAvailableColorByProduct() {
      // console.log("async", this.productValue.id);
      if (this.productValue) {
        this.availableColorByProduct(this.productValue.id).then((res) => {
          let alreadyChooseColors = [];
          this.myStyleProductsRows.forEach((row) => {
            if (row.id == this.productValue.id) {
              alreadyChooseColors.push(row.thing.colors[0]);
            }
          });
          console.log(alreadyChooseColors);
          alreadyChooseColors.forEach((alreadyColor) => {
            const deleteItem = res.findIndex((p) => p.id === alreadyColor.id);
            console.log("delete", deleteItem);
            res.splice(deleteItem, 1);
          });
          this.colorOptions = res;
          console.log(res);
        });
      } else {
        this.colorOptions = [];
        this.colorValue = "";
      }
    },
    addHandler() {
      if (this.productValue && this.colorValue) {
        let payload = {
          product_id: this.productValue.id,
          color_id: this.colorValue.id,
        };
        // let isProductExit = this.myStyleProductsRows.find(
        //     (row) => row.id == payload.product_id
        // );
        // console.log(isProductExit);
        this.styleProductsWithSizes(payload).then((res) => {
          // const deleteItem = this.productOptions.findIndex(
          //     (p) => p.id === this.productValue.id
          // );
          // this.productOptions.splice(deleteItem, 1);
          this.productValue = "";
          this.colorValue = "";
          this.colorOptions = [];
        });
        console.log("ok");
      } else {
        this.$swal({
          icon: "warning",
          title: "Warning!",
          text: "Fill all required fields.",
          showConfirmButton: false,
          timer: 1000,
        });
      }
    },
    onPublish() {
      this.$emit("onPublish", "onPublish"); //this.myStyleProductsRows will get from vuex
    },
    deleteStyleProductRow(product) {
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
          this.removeStyleProductRow(product);
          this.productValue = "";
        } else {
          // this.$swal("Cancelled", "Your file is still intact", "info");
        }
      });
    },
  },
  mounted() {
    this.getStyleProducts().then(
      (res) => (this.productOptions = this.myStyleProducts)
    );
    console.log(this.myStyleProducts);
  },
};
</script>

<style lang="scss" scoped></style>
