<template>
  <el-card class="text-center">
    <strong>TERBIT/TERBENAM</strong>
    <br />
    <br />

    <h5>{{terbit}}</h5>
    <div style="font-size:55px">
      <i class="el-icon-sunrise-1"></i>
    </div>
    <h5>{{terbenam}}</h5>
  </el-card>
</template>

<script>
export default {
  data() {
    return {
      terbit: "-",
      terbenam: "-"
    };
  },
  methods: {
    getData() {
      axios.get("getTerbitTerbenam").then(r => {
        this.terbit = r.data.terbit;
        this.terbenam = r.data.terbenam;
      });
    }
  },
  created() {
    this.getData();
  }
};
</script>

<style lang="scss" scoped>
</style>
