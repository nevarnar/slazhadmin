<template>
    <div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Name </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(guide, index) in size_guides">
                        <td> {{ guide.id }} </td>
                        <td> {{ guide.name }} </td>
                        <td>
                            <button type="button" title="Edit" id="edit-button">
                                <!-- <a :href="`size_guide/${guide.id}/edit`"> -->
                                <a :href="'size_chart/'+guide.id">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>

                            <button type="button" title="Delete" :id="guide.id" @click="onDeleteSizeGuideButtonClicked(index)">
                                    <i class="fal fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters, mapMutations } from "vuex";
    export default {
        name: "SizeGuideLists",
        components: {

        },

        props: [],
        data() {
            return {
                size_guides: [],
                size_chart_region_id: null,
                table_as_text: "",

                size_charts: [],
                size_chart_edit_form_data: null,
                edited_table_as_text: "",
                chart_id: null,

                size_guide_name: "",

            };
        },

        mounted(){
            this.getSizeGuides();
        },

        methods: {
            ...mapActions(["getApiData", "postWebForm", "postApiWithToken"]),

            async getSizeGuides(){
                this.getApiData({
                    url: `get_size_guides`,
                }).then((res) => {
                    this.size_guides = res.data.size_guides;
                });
            },

            onDeleteSizeGuideButtonClicked(index){
                let size_guide_id = event.currentTarget.id;
                let form_data = new FormData();
                form_data.append("size_guide_id", size_guide_id);
                let payload = {
                    url: "delete_size_guide",
                    form_data: form_data,
                };
                this.postWebForm(payload)
                .then((res) => {
                    // update size guide table by removing deleted size guide
                    this.size_guides.splice(index,1);
                    alert("OK, size guide deleted");
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });

            }
        },
    }

</script>
