<template lang="`">
    <div
    class="modal-dialog relative w-auto pointer-events-none"
    style="max-width: 28rem"
>
    <div
        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
    >
        <div class="modal-header border-b-0">
            <p class="pt-8 pb-4 px-12 text-base">Add Shelf</p>
        </div>

        <div class="modal-body px-4 mx-2">
            <form>
                <div class="block p-6 rounded-lg bg-white">
                    <div class="form-group mb-4">
                        <label
                            for="name"
                            class="form-label label-form"
                            >Name</label
                        >
                        <multiselect
                        v-model="shelfValue"
                        :options="shelfOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="false"
                        track-by="name"
                        label="name"
                        placeholder="Shelf"
                    ></multiselect>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer-container mr-4">
            <button
                type="button"
                class="btn btn-light text-sm"
                data-bs-dismiss="modal"
            >
                Cancel
            </button>
            <button
                type="button"
                class="px-12 py-2.5 ml-5 mr-0 bg-black primary-button"
                data-bs-dismiss="modal"
                @click.prevent="addHandler"
            >
                Add
            </button>
        </div>
    </div>
</div>
</template>
<script>
import Multiselect from "vue-multiselect";
import { mapActions, mapMutations, mapGetters } from "vuex";

export default {
    name: "RecommendedShelfModal",
    components: {
        Multiselect,
    },
    props: ["subproductId", "authUser"],
    data() {
        return {
            shelfValue: null,
            shelfOptions: [],
        };
    },
    computed: {
        ...mapGetters(["transferAcceptLists"]),
    },
    methods: {
        ...mapMutations(["addRecommendShelf"]),
        ...mapActions(["getApiData"]),
        addHandler() {
            console.log(this.transferAcceptLists.sub_products);
            let findSubproduct = this.transferAcceptLists.sub_products.filter(
                (subproduct) => {
                    return subproduct.id == this.subproductId;
                }
            );
            console.log("found", findSubproduct);
            if (
                findSubproduct[0].recommended_floor.some(
                    (data) => data.id === this.shelfValue.id
                )
            ) {
                console.log("1");
                this.$swal("Error!", "Shelf already exits.", "error");
                return;
            }
            let payload = {
                id: this.subproductId,
                shelf: this.shelfValue,
            };
            this.addRecommendShelf(payload);
            this.shelfValue = null;
        },
        async getFloor() {
            // this.authUser.inventory_id
            let payload = {
                url: `get_floor_by_inventory?inventory_id=${
                    this.authUser.inventory_id
                }&is_admin=${this.authUser.isAdmin ? 1 : 0}`,
            };

            this.getApiData(payload).then((res) => {
                console.log("modal", res.data.data);
                let response = res.data.data;
                response.forEach((floor) => {
                    floor.transfer_amount = 0;
                    floor.max_amount_validation = false;
                });
                this.shelfOptions = response;
            });
            // let ress = await this.postApiForm(payload);
        },
    },
    mounted() {
        this.getFloor();
        console.log("modeal", this.authUser);
    },
};
</script>
<style lang=""></style>
