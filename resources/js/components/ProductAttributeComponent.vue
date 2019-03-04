<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{ this.title }}</h5>

      <table class="table table-sm table-borderless">
        <tbody>
          <tr v-for="(attribute, key) in JSON.parse(this.attributeData)">
            <td>
              <input type="text" class="form-control" :value="key">
            </td>
            <td>
              <input type="text" class="form-control" :value="attribute">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ["title", "attributeData"],
  mounted() {}
};
</script>
