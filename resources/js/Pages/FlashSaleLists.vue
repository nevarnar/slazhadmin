<template>
  <div class="inner-main-container">
    <div>
      <p class="page-tittle">Flash Sale Lists</p>
    </div>
    <div class="relative flex justify-between">
      <div class="flex">
        <div class="list-component">
          <SearchBox pagination-url="discounts?" :mutationName="mutationName" />
        </div>
        <div class="list-component">
          <select
            name=""
            class="
              w-full
              text-gray-500 text-xs
              border
              rounded-[5px]
              bg-white
              px-3
              py-2
              mt-0
            "
            id=""
            placeholder="S/M/L"
          >
            <option value="" disabled selected>Bulk Action</option>
            <option value="1">Small</option>
            <option value="1">Medium</option>
            <option value="1">Large</option>
          </select>
        </div>
      </div>
      <div>
        <createbtn v-on:open_create_modal="onCreate" />
      </div>
    </div>
    <div class="block">
      <table class="primary-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Time</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(discount, index) in discountLists" :key="index">
            <td>
              {{ discount.index }}
            </td>
            <td>
              {{ discount.flashsaleable_type == "style" ? "Style" : "Product" }}
            </td>
            <td>{{ discount.start_time }} - {{ discount.end_time }}</td>
            <td>{{ discount.start_date }}</td>
            <td>
              {{ discount.end_date }}
            </td>
            <td>
              <div class="form-check form-switch inline-block align-middle">
                <input
                  :checked="discount.is_available"
                  @click="
                    availableChange({
                      data: discount,
                      url: 'flash_sales',
                    })
                  "
                  class="form-check-input switch"
                  type="checkbox"
                  role="switch"
                  id="flexSwitchCheckDefault56"
                />
              </div>
              <button
                @click="onEdit(discount.id)"
                type="button"
                title="Edit"
                class="mr-3"
              >
                <i class="fal fa-file"></i>
              </button>
            </td>
          </tr>
          <tr
            v-if="discountLists.length == 0"
            class="whitespace-nowrap table-border-bottom"
          >
            <td colspan="5" class="px-5 py-2 text-red-500 text-table text-left">
              Not Data Found!
            </td>
          </tr>
        </tbody>
      </table>
      <table-pagination
        :pagination-lists="getPaginatedData"
        :max-visible-buttons="5"
        :mutationName="mutationName"
        pagination-url="flash_sales?"
      />
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import Multiselect from "vue-multiselect";
import moment from "moment";
export default {
  name: "FlashSaleLists",
  data() {
    return {
      mutationName: "setDiscountLists",
    };
  },
  components: {
    Createbtn,
    SearchBox,
    Multiselect,
  },
  computed: {
    ...mapGetters(["discountLists"]),
  },
  methods: {
    ...mapActions(["getPaginatedData", "availableChange"]),
    onCreate(id) {
      window.location.href = `/flash-sale/create`;
    },
    onEdit(id) {
      window.location.href = `/flash-sale/edit/${id}`;
    },
    // checkCanEdit(start_date, end_date) {
    //   //check new Date () isBefore start_date
    //   if (moment(new Date()).isBefore(start_date)) {
    //     console.log("first");
    //     return true;
    //   }
    //   if (moment(new Date()).isAfter(end_date)) {
    //     console.log("second");
    //     return true;
    //   }
    //   return false;
    // },
  },
  mounted() {
    let paginatePage = 1;
    let payload = {
      page: paginatePage,
      url: "flash_sales?",
      paginateMutation: this.mutationName,
    };
    this.getPaginatedData(payload);
  },
};
</script>

<style>
</style>
