<template>
    <div
        v-show="currentApiLoading"
        class="spinner-border color-white animate-spin inline-block w-3 h-3 border-3 mr-1 rounded-full"
        role="status"
    >
        <span class="visually-hidden">Loading...</span>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
export default {
    name: "apiLoadingComponent",
    computed: {
        ...mapGetters(["currentApiLoading"]),
    },
    mounted() {
        console.log(this.currentApiLoading);
    },
};
</script>
