<template>
  <div class="rootEl">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Images</h5>

        <SlickList lockAxis="y" v-model="imgArray" :value="imgArray">
          <SlickItem v-for="(image, index) in imgArray" :index="index" :key="index">
            <img
              v-on:click="showImage"
              :src="'/gallery-images/' + image"
              class="img-thumbnail linkable"
            >
          </SlickItem>
        </SlickList>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img v-if="this.fullSizeImg" :src="this.fullSizeImg" class="full-size-img">
          </div>
        </div>
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
      fullSizeImg: null,
      imgArray: []
    };
  },
  components: {
    SlickItem,
    SlickList
  },
  methods: {
    showImage: function(e) {
      this.fullSizeImg = e.currentTarget.getAttribute("src");
      $("#imgModal").modal("show");
    }
  },
  mounted() {
    this.imgArray = JSON.parse(this.images);
  }
};
</script>
