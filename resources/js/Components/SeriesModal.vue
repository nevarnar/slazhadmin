<template>
    <div class="modal-dialog modal-dialog-centered modal-box">
        <div class="modal-content content-modal">
            <div class="modal-header border-b-0 mx-2">
                <p class="pt-8 px-8 text-base">Create Series</p>
            </div>
            <div class="modal-body px-2 mx-2">
                <form>
                    <div class="block p-6 rounded-lg bg-white">
                        <div class="form-group">
                            <label for="engName" class="form-label label-form"
                                >Serise Name (English)</label
                            >
                            <input
                                v-model="name.name"
                                type="text"
                                class="form-control input-form mt-3"
                                placeholder=""
                            />
                            <p
                                class="text-red-600 text-xs"
                                v-show="showErrorBrandSub"
                            >
                                Plese select brand and subcategory first
                            </p>
                        </div>
                    </div>
                    <div class="block p-6 rounded-lg bg-white">
                        <div class="form-group">
                            <label for="engName" class="form-label label-form"
                                >Series Name (Myanmar)</label
                            >
                            <input
                                v-model="mm_name.name"
                                type="text"
                                class="form-control input-form mt-3"
                                placeholder=""
                            />
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer modal-btn-container">
                <button
                    @click="oncreateSeries"
                    type="button"
                    class="primary-button bg-black"
                    data-bs-dismiss="modal"
                >
                    Add
                </button>
                <button
                    id="cancel"
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "seriesModal",

    props: {
        isSeriesCreated: {
            type: Boolean,
        },
        showErrorBrandSub: {
            type: Boolean,
        },
    },
    data() {
        return {
            name: {
                name: "",
                language_code: "en",
            },
            mm_name: {
                name: "",
                language_code: "mm",
            },
        };
    },
    computed: {},
    methods: {
        oncreateSeries() {
            if(this.name.name == "" || this.mm_name.name == ""){
                this.$swal({
                        icon: "error",
                        title: "Error!",
                        text: "Fill all fields.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                return;
            }
            this.$emit("oncreateSeries", {
                name: this.name,
                mm_name: this.mm_name,
            });
        },
    },
    watch: {
        isSeriesCreated(newVal, oldVal) {
            if (this.isSeriesCreated == true) {
                (this.name.name = ""), (this.mm_name.name = "");
            }
        },
    },
    mounted() {
        console.log(this.isSeriesCreated);
    },
};
</script>

<style lang="scss" scoped></style>
