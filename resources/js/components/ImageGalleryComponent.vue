<template>
  <div class="rootEl">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Images</h5>

        <SlickList lockAxis="y" v-model="imgArray" :value="imgArray">
          <SlickItem v-for="(image, index) in imgArray" :index="index" :key="index">
            <div class="img-wrapper">
              <img :src="'/gallery-images/' + image" class="img-thumbnail linkable">
            </div>
          </SlickItem>
        </SlickList>

        <input type="hidden" name="imgs" :value="imgArray">
      </div>
    </div>
  </div>
</template>

<script>
import { SlickList, SlickItem } from "vue-slicksort";

export default {
  props: ["images"],
  data: function() {
    return {
      imgArray: []
    };
  },
  components: {
    SlickItem,
    SlickList
  },
  methods: {},
  mounted() {
    this.imgArray = JSON.parse(this.images);
  }
};
</script>
