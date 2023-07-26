<template>
  <div>
    <button 
      @click="open_create_modal"
      class="btn-clear create-btn"
      type="button"
      data-bs-toggle="modal"
      data-bs-target="#create_modal"
      data-toggle="modal"
    >
      Add New
    </button>
  </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
  name: "Createbtn",
  methods: {
    ...mapMutations(["setisEditing"]),
    open_create_modal() {
      this.setisEditing(false);
      this.$emit('open_create_modal');
    },
  },
};
</script>

<style lang="scss" scoped>
</style>