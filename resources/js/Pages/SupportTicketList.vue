<template>
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Support Box</p>
        </div>
        <div class="relative flex justify-start">
            <div class="flex">
                <div class="list-component">
                    <!-- <SearchBox
                        :pagination-url="paginationUrl"
                        :mutationName="mutationName"
                    /> -->
                </div>
                <div class="list-component">
                    <multiselect
                        v-model="typeValue"
                        :options="typeOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="name"
                        label="name"
                        placeholder="Choose Type"
                        @input="changeType"
                    ></multiselect>
                </div>
            </div>
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket Number</th>
                        <th>Topic</th>
                        <th>Status</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody >
                    <tr v-for="(support_ticket,index) in getMySupportTicketList" :key="support_ticket.id">
                        <td>
                           {{++index}}
                        </td>
                        <td>
                           {{support_ticket.ticket_id}}
                        </td>
                        <td>
                           {{support_ticket.title}}
                        </td>
                        <!-- <td>
                        <p class="whitespace-normal text-left pl-4 text-ellipsis">
                        {{
                            showFullText
                                ? support_ticket.description
                                : support_ticket.description.length > 50
                                ? support_ticket.description.substring(0, 50) + ".."
                                : support_ticket.description
                        }}
                        <button
                            v-if="support_ticket.description.length > 50"
                            @click="showFullText = showFullText ? false : true"
                            class="ml-4 text-gray-400 text"
                        >
                            See {{ showFullText ? "Less" : "More" }}
                        </button>
                        </p>
                        </td> -->
                         <td>
                            {{support_ticket.status}}
                        </td>
                        <td>
                            {{support_ticket.user.name}}
                        </td>
                        <td>
                            <div
                                class="form-check form-switch inline-block align-middle"
                            >
                                <input
                                    class="form-check-input switch"
                                    type="checkbox"
                                    role="switch"
                                    :disabled="support_ticket.status=='close'"
                                    :checked="support_ticket.status=='close' ? false : true "
                                    @change="toggleTicket($event,support_ticket.id)"
                                    id="flexSwitchCheckDefault56"
                                />
                            </div>
                            <button
                                v-if="support_ticket.status!=='close'"
                                type="button"
                                title="Reply Ticket"
                                class="mr-3"
                                @click="detail(support_ticket.id)"
                            >
                                <i class="fas fa-reply" style="color:rgba(248, 20, 20, 0.6)" v-if="support_ticket.ticket_reply.length>0">
                                </i>
                                <i class="fas fa-reply" style="color:rgba(128, 128, 128, 128)" v-else>
                                </i>
                            </button>
                             <button
                                type="button"
                                title="Delete"
                                class=""
                                @click="destroy(support_ticket.id)"
                            >
                                 <!-- v-if="support_ticket.status=='close'" -->
                                <i class="fal fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        class="whitespace-nowrap table-border-bottom"
                        v-if="getMySupportTicketList.length<=0"
                    >
                        <td colspan="5" class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getSupportTicketList"
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="paginationUrl()"
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
        name:"SupportTicketList",
        components:{
            Createbtn,
            SearchBox,
            Multiselect,
        },
        data(){
            return {
                showFullText:false,
                mutationName:"setMySupportTicketList",
                typeValue:'',
                typeOptions:[
                    { name: "Open", value: "open" },
                    { name: "In Process", value: "inprocess" },
                    { name: "Close", value: "close" },
                ],
            }
        },
        computed:{
            ...mapGetters(['getMySupportTicketList']),
            paginationUrl() {
                // return `support_tickets?type=${ this.typeValue == null ? "" : this.typeValue.value}`;
                 return `support_tickets?`;
            },
        },
        methods:{
            ...mapActions(["getPaginatedWebData", "getApiData","deleteWebData","toggleSupportTicket"]),
            onEdit(edit_id) {
                window.location.href = `/support_tickets/${edit_id}`;
            },
            detail(edit_id) {
                window.location.href = `/reply_ticket/${edit_id}`;
            },
            format_date(value) {
                if (value) {
                    return moment(String(value)).format("D MMM-YYYY");
                }
            },
            changeType() {
                let paginatePage = 1;
                let payload = {
                    page: paginatePage,
                    url: `support_tickets?status=${this.typeValue!=null ?this.typeValue.value : ""}`,
                    paginateMutation: this.mutationName,
                };
                this.getPaginatedWebData(payload);
            },
            toggleTicket(event,id){
               let payload={
                    id:id
                }
                 this.$swal({
                    title: "Are you sure?",
                    text: "You can't revert your action",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes Close it!",
                    confirmButtonColor: "#f27474",
                    cancelButtonText: "No, Keep it!",
                    showCloseButton: true,
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    this.toggleSupportTicket(payload)
                    .then((res) => {
                         this.$swal({
                            icon: "success",
                            title: "Updated",
                            text: "Ticket has been closed successfully",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    })
                    .catch((error) => { 
                        this.$swal(
                            "Failed!",
                            error?.response?.data?.message,
                            "error"
                        );

                    });
                });
                this.getSupportTicketList();

            },
            getSupportTicketList() {
                let paginatePage = 1;
                let payload = {
                    page: paginatePage,
                    url: this.paginationUrl,
                    paginateMutation: this.mutationName,
                };
                this.getPaginatedWebData(payload);
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
                            url: `support_tickets/${id}`,
                        };
                        this.deleteWebData(payload).then((res) => {
                            this.$swal({
                                icon: "success",
                                title: "Deleted",
                                text: "You successfully deleted this file",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                            this.getSupportTicketList();
                        }) .catch((error) => { 
                            this.$swal(
                                "Failed!",
                                error?.response?.data?.message,
                                "error"
                            );
                        });
                    } else {
                        // this.$swal("Cancelled", "Your file is still intact", "info");
                    }
                });
            },
        },
        mounted(){
            this.getSupportTicketList();
        }
    }
</script>

<style>

</style>