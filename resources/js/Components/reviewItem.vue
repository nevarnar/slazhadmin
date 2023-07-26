<template>
    <tr>
        <td class="align-top">{{ review.index }}</td>
        <td class="align-top">
            {{ review.user.name ? review.user.name : "null" }}
        </td>
        <td class="align-top">
            {{ review.reviewable.name_translations[0].name }}
        </td>
        <td class="align-top">{{ review.rating }}</td>
        <td class="align-top">{{ review.title }}</td>
        <td class="align-top">
            <p class="whitespace-normal text-left pl-4 text-ellipsis">
            {{
                showFullText
                    ? review.comment
                    : review.comment.length > 50
                    ? review.comment.substring(0, 50) + ".."
                    : review.comment
            }}
            <button
                v-if="review.comment.length > 50"
                @click="showFullText = showFullText ? false : true"
                class="ml-4 text-gray-400 text"
            >
                See {{ showFullText ? "Less" : "More" }}
            </button>
            </p>
    </td>
        <td >
            <!-- <div class="mt-3 text-left pl-4"> -->
                <button
                    v-show="review.status == 'pending'"
                    @click="onReviewApproved(review)"
                    type="button"
                    title="Approve"
                    id=""
                    class="mr-4 text-black"
                >
                    Approve
                </button>
                <button
                    @click="deleteReview(review)"
                    type="button"
                    title="Delete"
                    id=""
                    class="text-gray-500"
                >
                    Delete
                </button>
            <!-- </div> -->
        </td>
    </tr>
</template>

<script>
import { mapActions, mapMutations } from "vuex";
export default {
    name: "reviewItem",
    props: ["review"],
    data() {
        return {
            showFullText: false,
            muatationName: "removeReview",
        };
    },
    methods: {
        ...mapMutations(["setisEditing"]),
        ...mapActions(["removeRow", "reviewApproved"]),
        open_create_modal() {
            this.setisEditing(false);
            this.$emit("open_create_modal");
        },
        deleteReview(review) {
            this.$swal({
                title: "Are you sure?",
                text: "You can't revert your action",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete!",
                confirmButtonColor: "#f27474",
                cancelButtonText: "Cancle!",
                showCloseButton: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.value) {
                    let payload = {
                        url: `reviews/${review.id}/delete`,
                        id: review.id,
                        mutationName: this.muatationName,
                    };
                    this.removeRow(payload).then(
                        this.$swal({
                            icon: "success",
                            title: "Deleted",
                            text: "You successfully deleted this file",
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    );
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
        onReviewApproved(review) {
            this.$swal({
                title: "Are you sure?",
                text: "You can't revert your action",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Approve!",
                confirmButtonColor: "#f27474",
                cancelButtonText: "Cancle!",
                showCloseButton: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.value) {
                    this.reviewApproved(review).then(
                        this.$swal({
                            icon: "success",
                            title: "Approved",
                            text: "You successfully approved this review",
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    );
                } else {
                    // this.$swal("Cancelled", "Your file is still intact", "info");
                }
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
