<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Images</h5>

      <div class="row">
        <div class="col-sm-2 mb-2" v-for="image in JSON.parse(this.images)">
          <img :src="'/gallery-images/' + image" class="img-thumbnail">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["images"],
  mounted() {}
};
</script>
