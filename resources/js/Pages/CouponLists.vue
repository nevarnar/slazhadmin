<template>
  <div class="inner-main-container">
    <div>
      <p class="page-tittle">Coupon</p>
    </div>
    <div class="relative flex justify-between">
      <div class="flex">
        <div class="list-component">
          <SearchBox pagination-url="coupons?" :mutationName="mutationName" />
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
            placeholder="Item"
          >
            <option value="" disabled selected>Item</option>
            <option value="1">Small</option>
            <option value="1">Medium</option>
            <option value="1">Large</option>
          </select>
        </div>
      </div>
      <div>
        <!-- <button class="btn-clear create-btn" type="button">
          <a href="#">Add</a>
        </button> -->
        <createbtn v-on:open_create_modal="onCreate" />
      </div>
    </div>
    <div class="block">
      <table class="primary-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Coupon Name</th>
            <th>Code</th>
            <th>Discount Amount</th>
            <th>End Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-if="discountLists.length == 0"
            class="whitespace-nowrap table-border-bottom"
          >
            <td colspan="5" class="px-5 py-2 text-red-500 text-table text-left">
              Not Data Found!
            </td>
          </tr>
          <tr v-for="(coupon, index) in discountLists" :key="index">
            <td>{{ coupon.index }}</td>
            <td>{{ coupon.name_translations[0].name }}</td>
            <td>{{ coupon.code }}</td>
            <td>{{ coupon.discount_value }}</td>
            <td>{{ coupon.end_date }}</td>
            <td>
              <button
                @click="onEdit(coupon.id)"
                type="button"
                title="Edit"
                class="mr-3"
              >
                <i class="fal fa-file"></i>
              </button>
              
              <button
                @click="onDelete(coupon.id)"
                type="button"
                title="Delete"
                class=""
                v-if="checkCanDelete(coupon.start_date, coupon.end_date)"
              >
                <i class="fal fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <table-pagination
        :pagination-lists="getPaginatedData"
        :max-visible-buttons="5"
        :mutationName="mutationName"
        pagination-url="coupons?"
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
  name: "CouponsList",
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
    ...mapGetters(["discountLists", "currentPage"]),
  },
  methods: {
    ...mapMutations(["setCurrentPage"]),
    ...mapActions(["getPaginatedData", "deleteWebData"]),
    onCreate(id) {
      window.location.href = `/coupon/create`;
    },
    onEdit(id) {
      window.location.href = `/coupon/edit/${id}`;
    },
    async onDelete(id) {
      let payload = {
        url: `coupons/${id}`,
      };
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
          this.deleteWebData(payload)
            .then((res) => {
              this.$swal({
                icon: "success",
                title: "Deleted!",
                text: "Item has been deleted.",
                showConfirmButton: false,
                timer: 1000,
              });
              this.getData(this.currentPage);
            })
            .catch((error) => {
              this.$swal(
                "Error!",
                error.response.data.message[0].message,
                "error"
              );
            });
        } else {
          // this.$swal("Cancelled", "Your file is still intact", "info");
        }
      });
    },
    getData(page) {
      let paginatePage = page;
      let payload = {
        page: paginatePage,
        url: "coupons?",
        paginateMutation: this.mutationName,
      };
      this.getPaginatedData(payload);
    },
    formatDate(date) {
      return moment(date).format("DD MM YYYY");
    },
    checkCanEdit(start_date, end_date) {
      //check new Date () isBefore start_date
      if (moment(new Date()).isBefore(start_date)) {
        console.log("first");
        return true;
      }
      if (moment(new Date()).isBefore(end_date)) {
        console.log("second");
        return true;
      }
      return false;
    },
    checkCanDelete(start_date, end_date) {
      //check new Date () isBefore start_date
      if (moment(new Date()).isBefore(start_date)) {
        console.log("first");
        return true;
      }
      if (moment(new Date()).isAfter(end_date)) {
        console.log("second");
        return true;
      }
      // return true;
    },
  },
  mounted() {
    console.log(moment(new Date()).format("DD MM YYYY"));
    this.getData(this.currentPage);
  },
};
</script>

<style>
</style>
