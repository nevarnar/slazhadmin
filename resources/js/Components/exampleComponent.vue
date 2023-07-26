<template>
  <div>
    <div v-if="isLoading">Loading...</div>
    <img :src="imagesToPreload[0]" alt="" />
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Multiselect from "vue-multiselect";

// register globally

export default {
  components: { Multiselect },
  name: "exampleComponent",
  mounted() {
    const images = this.imagesToPreload.map((imageSrc) => {
      console.log("imagscr", imageSrc);
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = imageSrc;
        img.onload = resolve;
        img.onerror = reject;
      });
    });
    console.log(images);
    Promise.all(images)
      .then(() => {
        console.log("Images loaded!");
        this.isLoading = false;
      })
      .catch((error) => {
        console.error("Some image(s) failed loading!");
        console.error(error.message);
      });
  },
  data() {
    return {
      isLoading: true,
      imagesToPreload: [
        "http://localhost:8000/api/download_image/T0rmXbHghOVmoIQQ1DNdsSStj4ZxhpPv2cbV281q.png",
        "http://localhost:8000/api/download_image/T0rmXbHghOVmoIQQ1DNdsSStj4ZxhpPv2cbV281q.png",
        "http://localhost:8000/api/download_image/T0rmXbHghOVmoIQQ1DNdsSStj4ZxhpPv2cbV281q.png",
        "http://localhost:8000/api/download_image/T0rmXbHghOVmoIQQ1DNdsSStj4ZxhpPv2cbV281q.png",
      ],
      isOk: true,
    };
  },
};
</script>

<style lang="scss" scoped></style>
