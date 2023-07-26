<script setup>
    import Editor from '@tinymce/tinymce-vue'
</script>

<template>
    <div>
        <div class="inner-main-container">
            <div>
                <p class="page-tittle">
                    Create Size Guide
                </p>
            </div>
            
            <div class="pt-6 mb-6">
                <div class="grid grid-cols-8 gap-x-8 mx-2">
                    <!-- start row -->
                    <div class="col-span-4">
                        <label for="" class="form-label label-form">Size Guide Name</label>
                    </div>
                    <div class="col-span-4"></div>


                    <div class="col-span-2">
                        <div class="form-group mb-6">
                            <input v-model="size_guide_name" type="text" class="form-control input-form mt-2" id=""
                                placeholder="Size Guide Name" style="width: 180px;" />
                        </div>
                    </div>
                    <div class="col-span-6"></div>
                    <!-- end row -->
                    <div class="col-span-8">
                        <p class="page-tittle">
                            Add Size Chart
                        </p>
                    </div>

                    <!-- start row -->
                    <div class=" col-span-2">
                        <label for="" class="form-label label-form">Type</label>
                    </div>
                    <div class=" col-span-6"></div>

                    <div class=" col-span-2 mb-4">
                        <select name="" v-model="size_chart_region_id" @change="onSizeChartRegionSelectChanged"
                            class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2" id=""
                            placeholder="Public">
                            <option disabled selected>Select Region</option>
                            <option v-for="(region, index) in chart_regions"  :value="region.id"> {{ region.name }} </option>
                        </select>
                    </div>

                    <!-- <div class="col-span-2 mb-4">
                        <button class="primary-font text-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" type="button" title="Add" id="add-size-chart-button">
                            <i class="fal fa-edit"></i>
                        </button>
                    </div> -->

                    <div class="col-span-2">
                        <button class="primary-button btn-clear mt-2" @click="onAddSizeChartButtonClicked">
                            Add
                        </button>
                    </div>

                    <div class="col-span-4">

                    </div>


                    <div class="col-span-8 w-full pt-2 mb-6">
                        <table class="secondary-table">
                            <thead class="secondary-table-thead">
                                <tr>
                                    <th class="sec-thead-th"></th>
                                    <th class="sec-thead-th">Sizes</th>
                                    <th class="sec-thead-th"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(size_chart, index) in size_charts">
                                    <td class="sec-table-td">
                                        {{ size_chart.size_chart_id }}
                                    </td>
                                    <td class="sec-table-td">
                                        {{ size_chart.size_chart_region_name }}
                                    </td>
                                    <td class="sec-table-td">
                                        <button class="primary-font text-sm" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" type="button" title="Edit" id="edit-size-chart-button" @click="onSizeChartEditButtonClicked(index)">
                                            <i class="fal fa-edit"></i>
                                        </button>
                                        <button class="primary-font text-sm" type="button" title="Delete"
                                            :id="size_chart.size_chart_id" @click="onSizeChartDeleteButtonClicked(index)">
                                            <i class="fal fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <!-- <button class="primary-button btn-clear mt-2" @click="onSizeChartEditConfirmButtonClicked">
                                            Edit
                                        </button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-span-8">
                        <hr class="my-2 h-0.5" />
                    </div>
                    <!-- end row -->


                </div>

                <div class="flex justify-end pb-4">
                    <button type="button" class="primary-button bg-black" @click="onSizeGuideCreateButtonClicked">
                        Create
                    </button>
                </div>
            </div>

            <div ref="modal" class="modal fade primary-modal" id="exampleModal" tabindex="-1"
                aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-box" style="max-width:60%">
                    <div class="modal-content content-modal" style="width:auto">
                        <form>
                            <div class="modal-body px-2 pt-3 mx-2">
                                <div class="block p-6 pt-3 rounded-lg bg-white">
                                    <Editor
                                        api-key="no-api-key"
                                        v-model="table_as_text"
                                        :init="{
                                            height: 500,
                                            plugins: ['lists', 'link' ,'image' ,'table' ,'code' ,'help' ,'wordcount']
                                        }"
                                    />
                                </div>
                            </div>

                            <div class="modal-footer modal-btn-container">
                                <button type="button" class="primary-button bg-black" data-bs-dismiss="modal"
                                @click="onSizeChartEditConfirmButtonClicked">
                                    Confirm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>


    import { mapActions, mapGetters, mapMutations } from "vuex";
    export default {
        name: "SizeGuideCreate",
        components: {

        },
        props: ["size_guide"],
        data() {
            return {
                chart_regions: [],
                size_chart_region_id: null,
                table_as_text: "",

                size_charts: [],
                size_chart_edit_form_data: null,
                chart_id: null,

                size_guide_name: "",
                size_guide_id: null,

            };
        },

        async mounted(){
            this.getSizeChartRegions();
            this.size_guide_name = this.size_guide.name;
            this.size_guide_id = this.size_guide.id;
            if(this.size_guide_id != null){
                this.getSizeCharts(this.size_guide_id);
            }
        },

        methods: {
            ...mapGetters(["myUrl"]),
            ...mapActions(["getApiData", "postWebForm", "postApiWithToken"]),

            onTinyEditorInput(){

            },

            getSizeCharts(size_guide_id){
                this.getApiData({
                    url: `get_size_charts?size_guide_id=${size_guide_id}`
                }).then((res) => {
                    //this.chart_regions = res.data.regions;
                    //this.size_charts = res.data.charts;
                    res.data.charts.forEach(chart=>{
                        this.size_charts.push(chart);
                    });
                    console.log(this.size_charts);
                });
            },

            async getSizeChartRegions(){
                this.getApiData({
                    url: `get_size_chart_regions`,
                }).then((res) => {
                    this.chart_regions = res.data.regions;
                });
            },

            onSizeChartRegionSelectChanged(){
                this.table_as_text = "";
            },

            onAddSizeChartButtonClicked(){
                if(this.size_chart_region_id == null){
                    alert("Please select size chart region");
                    return null;
                }
                let form_data = new FormData();
                form_data.append("size_chart_region_id", this.size_chart_region_id);
                form_data.append("chart_table", this.table_as_text);

                let payload = {
                    url: "create_size_chart",
                    form_data: form_data,
                };

                this.postWebForm(payload)
                .then((res) => {
                    this.size_charts.push(res.data.size_chart);
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });
            },

            onSizeChartEditButtonClicked(index){
                //console.log(this.table_as_text);
                this.chart_id = this.size_charts[index]["size_chart_id"];

                if(this.size_charts[index]["chart_table"] == "" || this.size_charts[index]["chart_table"] == null){
                    this.table_as_text = "";
                }
                else{
                    this.table_as_text = this.size_charts[index]["chart_table"];
                }

                //console.log(this.table_as_text);
            },

            onSizeChartEditConfirmButtonClicked(){
                if(this.table_as_text == ""){
                    alert("Please edit size chart table first");
                    return null;
                }

                //console.log(this.table_as_text);

                let form_data = new FormData();
                form_data.append("chart_table",this.table_as_text);
                form_data.append("size_chart_id", this.chart_id);

                let payload = {
                    url: "update_size_chart",
                    form_data: form_data
                };
                let edited_size_chart = null;

                this.postWebForm(payload)
                .then((res)=>{
                    edited_size_chart = res.data.size_chart;
                    let foundIndex = this.size_charts.findIndex(size_chart=>size_chart.size_chart_id == edited_size_chart.size_chart_id);
                    this.size_charts[foundIndex] = edited_size_chart;
                });

                this.table_as_text = "";
            },

            onSizeChartDeleteButtonClicked(index){
                let chart_id = event.currentTarget.id;
                let form_data = new FormData();
                form_data.append("size_chart_id", chart_id);
                let payload = {
                    url: "delete_size_chart",
                    form_data: form_data,
                };

                this.postWebForm(payload)
                .then((res) => {
                    // update size chart table by removing deleted size chart
                    this.size_charts.splice(index,1);
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });
            },

            onSizeGuideCreateButtonClicked(){
                if(this.size_charts.length < 1){
                    alert("Please create at least one size chart");
                    return null;
                }
                if(this.size_guide_name == null || this.size_guide_name == ""){
                    alert("Please enter size guide name");
                    return null;
                }

                let form_data = new FormData();
                let chart_ids = [];

                this.size_charts.forEach(function(size_chart){
                    chart_ids.push({
                        size_chart_id: size_chart.size_chart_id
                    });
                });

                chart_ids = JSON.stringify(chart_ids);
                if(this.size_guide_id != null){
                    form_data.append("size_guide_id", this.size_guide_id);
                    form_data.append("size_guide_name", this.size_guide_name);
                }
                form_data.append("size_chart_ids", chart_ids);
                form_data.append("size_guide_name", this.size_guide_name);
                let payload = {
                    url: "create_size_guide",
                    form_data: form_data,
                };
                console.log(this.size_guide_id);
                this.postWebForm(payload)
                .then((res) => {
                    window.location.href="/size_chart";
                })
                .catch((error) => {
                    this.setApiLoading(false);
                    this.validateResError(error);
                });
            }
        }
    };
</script>
