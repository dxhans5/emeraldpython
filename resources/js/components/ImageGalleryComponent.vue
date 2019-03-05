<template>
  <div class="rootEl">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Images</h5>

        <div class="row">
          <SlickList lockAxis="y" v-model="sortedImages">
            <SlickItem v-for="image in JSON.parse(this.images)" :index="index" :key="index">
              <img
                v-on:click="showImage"
                :src="'/gallery-images/' + image"
                class="img-thumbnail linkable"
              >
            </SlickItem>
          </SlickList>
        </div>
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
            <img v-if="this.fullSizeImg" :src="this.fullSizeImg">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ContainerMixin, ElementMixin } from "vue-slicksort";

export default {
  props: ["images"],
  data: function() {
    return {
      fullSizeImg: null
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
  mounted() {}
};
</script>
