<template>
    <chrome-picker :value="colorCode" @input="updateValue"></chrome-picker>
</template>
<script>
import "../../../node_modules/vue-color/dist/vue-color";
import "../../../node_modules/vue-color/dist/vue-color.min.js";
import { Sketch } from "vue-color";
export default {
    name: "colorPicker",
    components: {
        "chrome-picker": Sketch,
    },
    props: {
        colorCode: {
            type: String,
            default: "#194d33",
        },
    },
    methods: {
        updateValue(value) {
            this.$emit("updateColor", value.hex);
        },
    },
};
</script>
<style lang=""></style>
