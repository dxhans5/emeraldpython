<template>
  <div class="productAttributes">
    <div class="row">
      <div class="col-sm-6">
        <h5>{{ this.title }}</h5>
      </div>
      <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-success btn-sm">
          <i class="fas fa-plus"></i> Add Attribute
        </button>
      </div>
    </div>

    <div class="row" v-for="(value, key) in this.attributeData">{{ key }}: {{ value }}</div>

    <pre>{{ this.attributeData }}</pre>
  </div>
</template>

<script>
export default {
  props: ["title", "attributeData"],
  mounted() {
    console.log(this.title);
    console.log(this.attributeData);
  }
};
</script>
