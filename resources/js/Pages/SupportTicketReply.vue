<template>
  <div class="inner-main-container pb-12">
    <div class="mx-4 px-4" id="reply_ticket_box">
      <div class="mb-4">
        <p class="text-black text-lg primary-font block mb-1">Reply Ticket</p>
        <button type="button" class="primary-font block text-gray-600">
          <i class="fal fa-comment-lines mr-3"></i>{{ ticket_id }}
        </button>
      </div>
      <div>
        <div class="mb-3">
          <p class="text-base primary-font">{{ title }}</p>
          <span class="text-sm text-gray-500 primary-font">
            {{ format_date(date_time) }}
          </span>
        </div>
        <div class="mb-6">
          <p class="text-sm text-gray-500">
            {{ description }}
          </p>
        </div>
        <div class="px-28 py-28 bg-gray-400 relative w-0">
          <img
            :src="photo"
            class="h-full w-full absolute top-0 left-0"
            alt=""
          />
        </div>
        <hr class="mb-4 mt-6 h-0" />
      </div>

      <template v-for="ticket_reply in getMyReplyList" >
         <div>
            <div class="mb-3">
              <p class="text-sm text-gray-500">
               {{ticket_reply.comment}}
              </p>
            </div>
            <div class="flex justify-between mb-3">
              <span class="text-sm text-gray-500">{{format_date(ticket_reply.date_time)}}</span>
              <p class="text-sm text-black" v-if="ticket_reply.replyable_type=='admin'"> reply by {{ticket_reply.replyable.user_name}}</p>
                 <p class="text-sm text-black" v-if="ticket_reply.replyable_type=='user'"> reply by {{ticket_reply.replyable.name}}</p>
            </div>
            <hr class="mb-6 mt-6 h-0" />
          </div>
     </template>



      <div>
        <div class="mb-3">
          <p class="text-black text-lg primary-font">Reply Your Ticket</p>
        </div>
        <div class="mb-8">
          <label for="comment" class="text-base primary-font pb-3"
            >Comment</label
          >
          <input
            v-model="form_data.comment"
            type="text"
            class="form-control block input-ui mt-3"
            id="comment"
            placeholder="Comment"
          />
            <p
                class="text-red-600 text-xs"
                v-show="validationMsg.comment"
            >
                {{ validationMsg.comment }}
            </p>
        </div>
        <div class="mb-12">
          <label for="photo_upload" class="bg-white border py-2 px-4">
            <!-- Browse
            <input @click="uploadImage($event)"
             type="file" class="appearance-none hidden" /> -->
            <input
              @change="uploadImage"
              type="file"
              ref="fileref"
              class="appearance-none"
              accept=".png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
            />
          </label>
        </div>
        <div class="mb-4">
          <button
            type="button"
            class="primary-button px-12"
            @click="onSubmit()"
          >
            Reply
          </button>

          <button type="button" id="ticket_btn" class="btn-clear px-3">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import moment from "moment";
import Multiselect from "vue-multiselect";
import apiLoading from "./../Components/apiLoadingComponent";
export default {
  name: "SupportTicketReply",
  components: {
    Multiselect,
    apiLoading,
  },

  async mounted() {
    if (this.isediting == "edit") {
      this.getDetail();
    }
  },
  data() {
    return {
      id: "",
      ticket_id: "",
      title: "",
      description: "",
      date_time: "",
      admin: "",
      user: "",
      photo: "",
      successValidationRules:false,
      form_data: {
        photo: {},
        comment: "",
      },
      validationMsg:{
        comment:'',
      }
    };
  },
  computed: {
    ...mapGetters(["getMyReplyList"]),
  },
  methods: {
    ...mapActions(["getWebData","getApiData", "postWebForm",]),
    ...mapMutations(["setApiLoading",'setMyReplyList']),
    paginationUrl() {
      return `ticket_reply?support_ticket_id=${this.id}`;
    },

    format_date(value) {
      if (value) {
        return moment(String(value)).format("hh:mm A D MMM-YYYY");
      }
    },
    formClear(){
        this.form_data.comment="";
        this.$refs.fileref.value="";
    },
    uploadImage(event) {
      if (event.target.files[0].size > 4000000) {
        //4M
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "Size cannot exceed 4M.",
        });
        return;
      }
      this.form_data.photo = {
        name: event.target.files[0].name,
        data: event.target.files[0],
      };
    },
    resetvalidateRulesMsg() {
      this.validationMsg.comment = "";
    },
    validateRules() {
      this.successValidationRules = true;
      this.resetvalidateRulesMsg();
        if (this.form_data.comment.trim() == "" ) {
            this.validationMsg.comment = "Comment is required.";
            this.successValidationRules = false;
          }
    },
    async getDetail() {
      var baseUrl = window.location.href; // You can also use document.URL
      var id = baseUrl.substring(baseUrl.lastIndexOf("/") + 1);
      let res = await axios.get(`/support_tickets/${id}`);
      res = res.data.data;
      this.id = res.id;
      this.ticket_id = res.ticket_id;
      this.title = res.title;
      this.description = res.description;
      this.date_time = res.date_time;
      this.user = res.user;
      this.photo = res.photo;
    },
    async getReplyList(){
     var baseUrl = window.location.href; // You can also use document.URL
      var id = baseUrl.substring(baseUrl.lastIndexOf("/") + 1);
      let res = await axios.get(`/get_replies?support_ticket_id=${id}`);
       this.setMyReplyList(res.data.data);
    },
    onSubmit() {
        this.validateRules();
      let formData = new FormData();
      formData.append("support_ticket_id", this.id);
      formData.append("comment", this.form_data.comment);
    //   formData.append("photo", this.form_data.photo);
    if (Object.keys(this.form_data.photo).length > 0) {
            formData.append(
            "photo",
            this.form_data.photo.data,
            this.form_data.photo.name
        );
    }
      formData.append("type", 'admin');
      let payload = {
        url: "reply_ticket/create",
        form_data: formData,
      };
      if(this.successValidationRules==true){
         this.postWebForm(payload)
        .then((res) => {
        //   this.setApiLoading(false);
         this.formClear();
          this.$swal({
            icon: "success",
            title: "Created!",
            text: `Reply Successfully.`,
            showConfirmButton: false,
            timer: 1000,
          });
        //   window.location.href = `/reply_ticket/${this.id}`;
        })
        .catch((error) => {
        //   this.setApiLoading(false);
        //   this.validateResError(error);
        });
        this.getReplyList()
      }
    },
  },
  mounted() {
    this.getDetail();
    this.getReplyList();
  },
};
</script>

<style>
</style>
