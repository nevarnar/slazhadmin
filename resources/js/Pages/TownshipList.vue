<template>
  <div class="inner-main-container">
    <div>
      <p class="page-tittle">Delivery Fees</p>
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
          <multiselect
            v-model="divisionValue"
            :options="divisionOptions"
            :searchable="true"
            :close-on-select="true"
            :custom-label="customItemLabel"
            :show-labels="false"
            :allow-empty="true"
            track-by="id"
            placeholder="Division"
            label="name"
            @input="getPaginatedData"
          ></multiselect>
        </div>
        <div class="list-component">
          <SearchBox
            :pagination-url="paginationUrl"
            :mutationName="mutationName"
          />
        </div>
      </div>
      <div>
        <button class="btn-clear create-btn" type="button" @click="onCreate()">
          <a href="#">Add Township</a>
        </button>
      </div>
    </div>
    <div class="block">
      <table class="primary-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Township</th>
            <th>Division</th>
            <th>Amount</th>
            <th>Duration (Day)</th>
            <th>Action</th>
          </tr>
        </thead>  
        <tbody>
          <tr v-for="(data, index) in getMyTownshipPaginatedData" :key="index">
            <td>
              {{ ++index }}
            </td>
            <td>
              {{ data.name_translations[0].name }}
            </td>
            <td>
              {{ data.division.name_translations[0].name }}
            </td>
            <td>
              {{ data.delivery_fee }}
            </td>
            <td>
              {{ data?.duration }}
            </td>
            <td>
              <button
                @click="getDetail(data.id)"
                type="button"
                title="Edit Delivery Fees"
                id="edit-button"
                data-bs-toggle="modal"
                data-toggle="modal"
                data-bs-target="#edit_modal"
              >
                <i class="fal fa-file-edit"></i>
              </button>
              <button
                @click="destroy(data.id)"
                type="button"
                title="Delete"
                id="delete_button"
              >
                <a class="a-clear" href="#">
                  <i class="fal fa-trash"></i>
                </a>
              </button>
            </td>
          </tr>
           <tr
              v-if="getMyTownshipPaginatedData.length==0"
              class="whitespace-nowrap table-border-bottom"
          >
              <td
                  colspan="5"
                  class="px-5 py-2 text-table"
              >
                  No Data Found!
              </td>
          </tr>
        </tbody>
      </table>
      <table-pagination
        :pagination-lists="getPaginatedData"
        :max-visible-buttons="5"
        :mutationName="mutationName"
        :pagination-url="paginationUrl"
      />
      <!-- Modal -->
      <div
        class="
          modal
          fade
          fixed
          top-0
          left-0
          hidden
          w-full
          h-full
          outline-none
          overflow-x-hidden overflow-y-auto
        "
        id="edit_modal"
        tabindex="-1"
        aria-labelledby="editModalLabel"
        aria-hidden="true"
        ref="modal"
      >
        <div class="modal-dialog relative w-auto pointer-events-none">
          <form>
            <div
              class="
                modal-content
                border-none
                shadow-lg
                relative
                flex flex-col
                w-full
                pointer-events-auto
                bg-white bg-clip-padding
                rounded-md
                outline-none
                text-current
              "
            >
              <div class="modal-header border-b-0 px-2">
                <p class="pt-8 px-8 text-base">Edit Delivery Fees</p>
              </div>
              <div class="modal-body px-2 mx-2">
                <div class="block p-6 rounded-lg bg-white">
                  <div class="form-group mb-6" v-if="township">
                    <label for="name" class="form-label label-form">
                      {{township.name_translations[0].name!=null ?township.name_translations[0].name:''}}
                    </label>
                  </div>

                  <div class="form-group mb-6">
                    <label for="name" class="form-label label-form"
                      >Charges</label
                    >
                    <input
                      type="number"
                      class="form-control input-form mt-3"
                      v-model="form_data.delivery_fee"
                      id="name"
                      placeholder=""
                    />
                    <p
                      class="text-red-600 text-xs"
                      v-show="validationMsg.delivery_fee"
                    >
                      {{ validationMsg.delivery_fee }}
                    </p>
                  </div>
                </div>
              </div>

              <div
                class="
                  modal-footer modal-footer-box
                  justify-start
                  px-8
                  pt-0
                  pb-8
                  mx-2
                "
              >
                <button
                  @click="saveModel()"
                  type="button"
                  class="px-6 py-2.5 mr-6 primary-button"
                >
                  <api-loading />
                  Save
                </button>
                <button
                  type="button"
                  class="btn btn-light px-3"
                  data-bs-dismiss="modal"
                  id="cancel"
                >
                  Cancel
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Createbtn from "../Components/createButtonComponent.vue";
import SearchBox from "./../Components/searchBoxComponent";
import apiLoading from "./../Components/apiLoadingComponent";

import Multiselect from "vue-multiselect";
export default {
  name: "TownshipList",
  components: {
    Createbtn,
    SearchBox,
    Multiselect,
    apiLoading,
  },
  data() {
    return {
      mutationName: "setTownshipPaginatedData",
      divisionValue: null,
      divisionOptions: [],
      form_data: {
        id: "",
        delivery_fee: "",
      },
      successValidationRules: false,
      validationMsg: {
        delivery_fee: "",
      },
      township: null,
    };
  },
  computed: {
    ...mapGetters(["getMyTownshipPaginatedData"]),
    paginationUrl() {
      return `townships?division_id=${
        this.divisionValue == null ? "" : this.divisionValue.id
      }`;
    },
  },
  methods: {
    ...mapActions(["getPaginatedData", "getApiData", "deleteWebData","postWebForm"]),
    ...mapMutations(["setApiLoading","setisEditing"]),

    customItemLabel(option) {
      return `${option.name_translations[0].name} `;
    },
    onEdit(edit_id) {
      window.location.href = `/townships_edit/${edit_id}`;
    },
    onCreate(id) {
      window.location.href = `/townships_create`;
    },
    async getDivisions() {
      this.getApiData({
        url: `get_divisions`,
      }).then((res) => {
        this.divisionOptions = res.data.data;
      });
    },
    // getPaginatedData() {
    //    this.validationMsg.delivery_fee="";  
    //   let paginatePage = 1;
    //   let payload = {
    //     page: paginatePage,
    //     url: this.paginationUrl,
    //     paginateMutation: this.mutationName,
    //   };
    //   this.getPaginatedWebData(payload);
    // },
    closeModal() {
      document.getElementById("cancel").click();
    },
    validateRules() {
      this.successValidationRules = true;
      if (
        this.form_data.delivery_fee === null || this.form_data.delivery_fee ==="" ) {
        this.validationMsg.delivery_fee = "Amount is required.";
        this.successValidationRules = false;
        $("#edit_model").modal("show");
      }
    },
    async getDetail(id) {
      this.validationMsg.delivery_fee=""
        this.setisEditing(true);
         let res = await axios.get(`/townships/${id}`);
          res = res.data.data;
          this.form_data.id = res.id;
          this.form_data.delivery_fee = res.delivery_fee;
          this.township = res;
          $("#edit_model").modal("show");
    },
    saveModel() {
     this.validateRules();
      let form_data = new FormData();
      form_data.append("id", this.form_data.id);
      form_data.append("delivery_fee", this.form_data.delivery_fee);
          let payload = {
            url: "townships/update",
            form_data: form_data,
          };
          if(this.successValidationRules==true){
             this.postWebForm(payload)
            .then((res) => {
              this.setApiLoading(false);
              this.closeModal();
            this.getPaginatedData();
              this.$swal({
                icon: "success",
                title: "Updated!",
                text: `Delivery fee has been updated successfully.`,
                showConfirmButton: false,
                timer: 1000,
              });
            })
            .catch((error) => {
              this.setApiLoading(false);
              // this.validateResError(error);
              $("#create_modal").modal("show");
            });
          }
         

    },
    destroy(id) {
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
          let payload = {
            url: `townships/${id}`,
          };
          this.deleteWebData(payload).then((res) => {
            this.$swal({
              icon: "success",
              title: "Deleted",
              text: "You successfully deleted this file",
              showConfirmButton: false,
              timer: 1000,
            });
            this.getPaginatedData();
          });
        } else {
          // this.$swal("Cancelled", "Your file is still intact", "info");
        }
      });
    },
  },
  mounted() {
    this.getDivisions();
    let paginatePage = 1;
    let payload = {
            page: paginatePage,
            url: "townships?",
            paginateMutation: this.mutationName,
        };
    this.getPaginatedData(payload);

  },
};
</script>

<style>
</style>