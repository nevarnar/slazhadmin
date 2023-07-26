<template lang="">
    <div v-if="imgPreview" class="mt-3 flex flex-nowrap">
        <div class="mt-3 file-name-box">
            <button class="cancel-btn" @click.prevent="deleteImage(type)">
                X
            </button>
            <div class="item-img-container">
                <img alt="" :src="imgPreview" />
            </div>
        </div>
    </div>
</template>
<script>
//
export default {
    name: "ImagePreview",
    props: {
        imgPreview: {},
        deleteImage: {
            type: Function,
        },
        type: {
            type: String,
            default: "icon",
        },
    },
};
</script>
<style lang=""></style>
