<template>
    <div id="cometchat">

    </div>
</template>

<script>
import { CometChat } from "@cometchat-pro/chat";
import { mapGetters } from "vuex";

export default {
    name: "ChatsViewInitialize",
    components: {

    },
    props: ["admin"],
    data() {
        return {
            adminData: null,
            // cometchatConfig: {
            //     APP_ID: "23946338614f1b89",
            //     AUTH_KEY: "3e6e25ae02c5cedba698857a0a297ca543db1065",
            //     APP_REGION: "US",
            //     WIDGET_ID: "ef6be874-f611-4776-b740-2cee841f163d",
            //     API_KEY:"784a492e2bb152178d869dcea9944775a14271b8"
            // },
            cometchatSetting: null,
        }
    },
    computed: {
        ...mapGetters(["cometchatConfig"]),
    },
    mounted() {
        // this.adminData = JSON.parse(this.admin);
        // console.log(this.adminData.id);

        // const UID = `SlazhAdmin_${this.adminData.id}`;
        const UID = `SlazhAdmin_1`; //001

        this.cometchatSetting = new CometChat.AppSettingsBuilder()
        .subscribePresenceForRoles(["2"])
        .setRegion(this.cometchatConfig.APP_REGION)
        .build();

        CometChat.init(this.cometchatConfig.APP_ID, this.cometchatSetting).then(response=>{
            console.log("CometChat Initialization completed successfully");
            var user = new CometChat.User(UID);
            user.setName(UID);

            CometChatWidget.init({
                "appID": this.cometchatConfig.APP_ID,
			    "appRegion": this.cometchatConfig.APP_REGION,
			    "authKey": this.cometchatConfig.AUTH_KEY
            }).then(response=>{
                console.log("CometChatWidget Initialization completed successfully");
                CometChatWidget.login({"uid": user.uid}).then(response=>{
                        console.log("CometChatWidget login completed successfully");
                        CometChatWidget.launch({
                            "widgetID": this.cometchatConfig.WIDGET_ID,
					        "target": "#cometchat",
					        "roundedCorners": "true",
					        "height": "800px",
					        "width": "1100px",
					        "defaultID": user.uid, //default UID (user) or GUID (group) to show,
					        "defaultType": 'user' //user or group
                        });
                }, error=>{
                        console.log("CometChatWidget login failed with error ", error);
                });
            },error=>{
                console.log("CometChatWidget Initialization failed with error ", error);
            });

        }, error=>{
            console.log("CometChat Initialization failed with error ", error);
        });
    },
};

</script>
