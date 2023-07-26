<template>
    <div
        class="flex justify-start mt-4 mb-24"
        v-if="getTotalPages > 1 || currentPage > 1"
    >
        <nav aria-label="Page navigation example">
            <ul class="flex list-style-none">
                <li class="page-item">
                    <button
                        @click="onClickPreviousPage"
                        :disabled="isInFirstPage"
                        class="pagination-link page-link"
                    >
                        Previous
                    </button>
                </li>
                <li
                    class="page-item"
                    v-for="(page, index) in pages"
                    :key="index"
                >
                    <button
                        class="pagination-link page-link"
                        @click="onClickPage(page.number)"
                        :disabled="page.isDisabled"
                        :class="
                            isPageActive(page.number)
                                ? 'active-pagination'
                                : 'normal-pagination'
                        "
                    >
                        {{ page.number }}
                    </button>
                </li>
                <li class="page-item" :class="isInLastPage ? 'disabled' : ''">
                    <button
                        @click="onClickNextPage"
                        :disabled="isInLastPage"
                        class="pagination-link page-link normal-pagination"
                    >
                        Next({{ getTotalPages }})
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from "vuex";
export default {
    name: "tablePagination",

    props: {
        maxVisibleButtons: { type: Number },
        paginationLists: { type: Function },

        mutationName: {
            type: String,
        },
        paginationUrl: {
            type: String,
        },
    },
    computed: {
        ...mapGetters([
            "getTotalPages",
            "getSearchInput",
            "currentPage",
            "nextClickCount",
        ]),
        startPage() {
            if (this.nextClickCount === 1) return 1;
            if (this.currentPage === 1) return 1;
            return (this.nextClickCount - 1) * this.maxVisibleButtons;
        },
        endPage() {
            //3
            return Math.min(
                this.startPage + this.maxVisibleButtons - 1,
                this.getTotalPages
            );
        },
        pages() {
            let range = [];
            for (let i = this.startPage; i <= this.endPage; i += 1) {
                range.push({
                    number: i,
                    isDisabled: i === this.currentPage,
                });
            }
            return range;
        },
        isInFirstPage() {
            return this.nextClickCount == 1 || this.currentPage == 1;
        },
        isInLastPage() {
            return this.endPage >= this.getTotalPages;
        },
    },
    methods: {
        ...mapActions(["search"]),
        ...mapMutations(["setCurrentPage", "setNextClickCount"]),
        onClickPreviousPage() {
            this.setNextClickCount(this.nextClickCount - 1);
            // this.nextClickCount -= 1;
            this.setCurrentPage(this.currentPage - this.maxVisibleButtons);
            if (this.currentPage == 0) {
                this.setCurrentPage(1);
                // this.currentPage = 1;
            }
            this.searchOrLists(this.currentPage);
            this.setCurrentPage(this.currentPage);
        },
        searchOrLists(page) {
            if (this.getSearchInput) {
                let payload = {
                    page: page,
                    url: `${
                        this.paginationUrl
                    }&search_input=${this.getSearchInput.trim()}`,
                    paginateMutation: this.mutationName,
                };
                this.paginationLists(payload);
            } else {
                let payload = {
                    page: page,
                    url: this.paginationUrl,
                    paginateMutation: this.mutationName,
                };
                this.paginationLists(payload);
            }
        },
        onClickPage(page) {
            this.searchOrLists(page);
            this.setCurrentPage(page);
        },
        onClickNextPage() {
            this.setNextClickCount(this.nextClickCount + 1);
            this.setCurrentPage(this.currentPage + this.maxVisibleButtons);

            if (this.isInLastPage) {
                this.setCurrentPage(this.getTotalPages);
            }

            this.searchOrLists(this.currentPage);

            this.$emit("pagechanged", this.currentPage + 1);
        },
        isPageActive(page) {
            return this.currentPage === page;
        },
    },
    mounted() {
        // console.log(this.getSearchInput);
    },
};
</script>

<style lang="scss" scoped></style>
