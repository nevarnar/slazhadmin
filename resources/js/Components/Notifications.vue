<template lang="">
     <div class="dropdown relative inline-block ml-3 mr-8 pb-2">
            <a class="dropdown-toggle text-xl flex items-center  hidden-arrow" href="#" id="dropdownMenuButton2"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fal fa-bell">  <p id="count" class=" nav-ul-a pl-0 pb-1">
                                {{ notifications?.count }}
                            </p></i>
            </a>
            <div class="dropdown-menu min-w-max max-w-[40vw] overflow-y-auto h-[85vh] absolute hidden nav-ul"
                aria-labelledby="dropdownMenuButton2">
                <ul>
                    <p class=" nav-ul-a pl-8 text-sm hover:bg-transparent">
                        Slazh Notification
                    </p>
                    <hr class="h-0 my-2 border border-solid border-t-0 border-gray-700 opacity-25 w-[90%] ml-[5%]" />
                    <!-- <li class="px-4">
                        <a class=" nav-ul-a pt-0" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1">
                                Marketing Message Title
                            </p>
                            <p class=" break-words whitespace-normal w-96 text-gray-400 mb-2">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe, est. Explicabo ipsa
                                error ducimus eaque
                            </p>
                            <p class="text-[13px] text-stone-700 leading-5">
                                12 Hours Ago
                            </p>
                        </a>
                    </li>
                    <li class="px-4">
                        <a class=" nav-ul-a pt-0" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1">
                                Marketing Message Title
                            </p>
                            <p class=" break-words whitespace-normal w-96 text-gray-400 mb-2">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe, est. Explicabo ipsa
                                error ducimus eaque
                            </p>
                            <p class="text-[13px] text-stone-700 leading-5">
                                12 Hours Ago
                            </p>
                        </a>
                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" /> -->
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Order Status
                        </p>
                    </li>
                      <input type="hidden" id="fcm_order_id">
                      <div class="contents" @click="readNotification_fcm('order')" id="fcm_message_order">

                      </div>
                    <li class="px-4" v-for="(noti, index) in notifications.data?.order" :key="index">
                        <a @click="readNotification(noti.id)" class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>
                                <!-- <img src="/img/jean_pant.jpg" class=" w-16 h-16 inline-block" alt=""> -->
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font">
                                        {{ noti.notify.notifiable.order_id }}
                                    </p>
                                    <p class="text-[13px] text-stone-700 leading-5">
                                       {{ noti.notify.notifiable.date }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                              {{ getDateAgo(noti.notify.notifiable.date ) }}
                            </p>
                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Sale Returns
                        </p>
                    </li>
                      <input type="hidden" id="fcm_sale_return_id">
                      <div class="contents" @click="readNotification_fcm('sale_return')" id="fcm_message_sale_return">

                      </div>
                    <li class="px-4" v-for="(noti, index) in notifications.data?.sale_return" :key="index">
                        <a @click="readNotification(noti.id)" class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>
                                <!-- <img src="/img/jean_pant.jpg" class=" w-16 h-16 inline-block" alt=""> -->
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font">
                                        {{ noti.order_id }} - ({{noti.reason}})
                                    </p>
                                    <p class="text-[13px] text-stone-700 leading-5">
                                       {{ noti.notify.date_time }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                              {{ getDateAgo(noti.notify.date_time ) }}
                            </p>
                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Customer Support
                        </p>
                    </li>
                        <input type="hidden" id="fcm_support_ticket_id">
                      <div class="contents" @click="readNotification_fcm('support_ticket')" id="fcm_message_support_ticket">

                      </div>
                    <li class="px-4" v-for="(noti, index) in notifications.data?.support_ticket" :key="index">
                        <a @click="readNotification(noti.id)" class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>

                                <p class=" w-2/5 mb-2 primary-font pr-4">
                                    A New Reply was arrived in your support ticket #{{ noti.notify.notifiable.ticket_id }}
                                </p>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                                                             {{ getDateAgo(noti.notify.date_time ) }}
                            </p>
                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Coupon
                        </p>
                    </li>
                    <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between" href="#">
                            <div>
                                <img src="/img/jean_pant.jpg" class=" w-16 h-16 inline-block" alt="">
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font text-stone-700">
                                        You received new coupon
                                    </p>
                                    <p class="text-[13px] text-gray-400 leading-5">
                                        Coupon Name
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                                3 Days Ago
                            </p>

                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <a class="dropdown-item nav-ul-a text-center" href="#">See all Notification</a>
            </div>
        </div>
</template>
<script>
import { mapActions } from "vuex";
import moment from "moment";

export default {
  name: "Notifications",
  data() {
    return {
      notifications: [],
      id: null,
      images: [],
    };
  },
  methods: {
    ...mapActions(["getApiData", "postApiForm"]),
    async getNotifications() {
      let payload = {
        url: "notification_list",
      };
      let res = await this.getApiData(payload);
      this.notifications = res.data;
      document.getElementById("count").innerHTML = this.notifications.count;
      // res.data?.coupon.forEach((coupon) => {
      //   this.images.push(coupon.notify.notifiable.photo);
      // });
      this.getImages();
    },
    async readNotification(id) {
      let payload = {
        url: `read_notification?id=${id}&is_read=1`,
      };
      let res = await this.getApiData(payload);
      this.getNotifications();
    },
    async readNotification_fcm(type) {
      console.log("fcm");
      if (type == "order") {
        var id = $("#fcm_order_id").val();
      }
      if (type == "coupon") {
        var id = $("#fcm_coupon_id").val();
      }
      if (type == "support_ticket") {
        var id = $("#fcm_support_ticket_id").val();
      }
      let fcm_id = parseInt(id);
      this.id = fcm_id;
      //   this.readNotification(fcm_id);
      console.log("id", this.id);
      let payload = {
        url: `read_notification?id=${this.id}&is_read=1`,
      };
      let res = await this.getApiData(payload);
      this.getNotifications();
    },
    getImages() {
      //load image from s3
      let uniqImages = [...new Set(this.images)]; //remove duplicate images
      const imageLoadings = uniqImages.map((imageSrc) => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.src = imageSrc;
          img.onload = resolve;
          img.onerror = reject;
        });
      });
      console.log("load images");
      Promise.all(imageLoadings)
        .then(() => {
          console.log("Images loaded!");
          this.isLoading = false;
        })
        .catch((error) => {
          console.error("Some image(s) failed loading!");
        });
    },
    getDateAgo(date) {
      var now = moment(new Date());
      var from = moment(date);
      let dif_days = moment(now).diff(from, "days");
      let dif_hours = moment(now).diff(from, "hours");
      let dif_min = moment(now).diff(from, "minutes");
      return dif_days
        ? `${dif_days} Days Ago`
        : dif_hours
        ? `${dif_hours} Hours Ago`
        : `${dif_min} Minutes Ago`;
    },
  },

  mounted() {
    this.getNotifications();

    const firebaseConfig = {
      apiKey: "AIzaSyDQzEz3WPCdScs2AWanYem3Ay-G4lCgsZ4",
      authDomain: "slazh-68944.firebaseapp.com",
      projectId: "slazh-68944",
      storageBucket: "slazh-68944.appspot.com",
      messagingSenderId: "162667308297",
      appId: "1:162667308297:web:e656bc777fad48592a1fd8",
      measurementId: "G-THQLE5YNQ5",
    };
    // firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    messaging.onMessage(function (payload) {
      console.log("onMessageprofilenotification", payload);
      getMessage(payload);
      const notificationOption = {
        body: payload.notification.body,
        icon: "",
        // icon: payload.notification.icon
      };

      if (Notification.permission === "granted") {
        console.log("Notification.permission", notificationOption);
        var notification = new Notification(
          payload.notification.title,
          notificationOption
        );

        notification.onclick = function (ev) {
          ev.preventDefault();
          window.open(payload.notification.click_action, "_blank");
          notification.close();
        };
      } else {
        console.log("else");
      }
    });
    messaging.onTokenRefresh(function () {
      messaging
        .getToken()
        .then(function (newtoken) {
          console.log("New Token : " + newtoken);
        })
        .catch(function (reason) {
          console.log(reason);
        });
    });
    // IntitalizeFireBaseMessaging();
    function getMessage(payload) {
      //   this.data = payload;
      console.log('fcm-message',payload)
      document.getElementById("count").innerHTML =
        payload.data.notification_count;
      if (payload.data.type == "order") {
        $("#fcm_order_id").val(payload.data.id);
        var id = "fcm_message_order";
        var html = `
              <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font">
                                         ${payload.data.order_id}
                                    </p>
                                    <p class="text-[13px] text-stone-700 leading-5">
                                        ${payload.data.order_date}
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                             Now
                            </p>
                        </a>

                    </li>
          `;
      }
      if (payload.data.type == "sale_return") {
        $("#fcm_sale_return_id").val(payload.data.id);
        var id = "fcm_message_sale_return";
        var html = `
              <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font">
                                         ${payload.data.order_id} - (${payload.data.reason})
                                    </p>
                                    <p class="text-[13px] text-stone-700 leading-5">
                                        ${payload.data.date}
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                             Now
                            </p>
                        </a>

                    </li>
          `;
      }
      if (payload.data.type == "support_ticket") {
        $("#fcm_support_ticket_id").val(payload.data.id);
        var id = "fcm_message_support_ticket";
        var html = `
              <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font">
                                          A New Reply was arrived in your support ticket # ${payload.data.ticket_id}
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                             Now
                            </p>
                        </a>

                    </li>
          `;
      }
      console.log('id',id)
      document.getElementById(id).innerHTML = html;
    }
  },
};
</script>
<style lang="">
</style>
