<template>
  <div>
    <Suhu :height="height" class="mb-1" />
    <Tekanan :height="height" />
  </div>
</template>

<script>
import Suhu from "./Suhu";
import Tekanan from "./Tekanan";

export default {
  props: ["height"],
  components: { Suhu, Tekanan }
};
</script>

<style lang="scss" scoped>
</style>
