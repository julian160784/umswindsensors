<template>
  <div class="d-flex">
    <Log :height="height" class="flex-fill mb-1 mr-1" />
    <div>
      <Kecepatan :height="height" class="flex-fill mb-1" />
      <Arah :height="height" class="flex-fill mb-1" />
    </div>
  </div>
</template>

<script>
import Arah from "./Arah";
import Kecepatan from "./Kecepatan";
import Log from "./Log";

export default {
  props: ["height"],
  components: { Arah, Kecepatan, Log }
};
</script>

<style lang="scss" scoped>
</style>
