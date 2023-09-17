<template>
  <el-card class="text-center">
    <strong>ARAH ANGIN</strong>
    <br />
    {{height}}m
    <br />
    <Plotly :data="data" :layout="layout" :displayModeBar="false" class="chart"></Plotly>
  </el-card>
</template>

<script>
import { Plotly } from "vue-plotly";

export default {
  components: { Plotly },
  props: ["height"],
  data() {
    return {
      fetchInterval: null,
      data: [
        {
          r: [0, 0, 0, 0, 0, 0, 0, 0],
          theta: ["U", "TM", "T", "TG", "S", "BD", "B", "BL"],
          name: "arah",
          type: "barpolar"
        }
      ],
      layout: {
        width: 200,
        dragmode: false,
        margin: { l: 15, t: 0, b: 0, r: 15 },
        showLegend: false,
        polar: {
          barmode: "overlay",
          bargap: 0,
          radialaxis: { ticksuffix: "", angle: 90, dtick: 20 },
          angularaxis: { direction: "clockwise" }
        }
      }
    };
  },
  methods: {
    getData() {
      const data = {
        100: "data1",
        70: "data6",
        40: "data8",
        10: "data10",
        2: "data19"
      };
      const params = {
        parameter: data[this.height]
      };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.data[0].r = [0, 0, 0, 0, 0, 0, 0, 0];

          let index = 0;
          const value = r.data;

          if (value >= 22.5 && value < 67.5) {
            // timur laut
            index = 1;
          } else if (value >= 67.5 && value < 112.5) {
            // timur
            index = 2;
          } else if (value >= 112.5 && value < 157.5) {
            // tenggara
            index = 3;
          } else if (value >= 157.5 && value < 202.5) {
            // selatan
            index = 4;
          } else if (value >= 202.5 && value < 247.5) {
            // barat daya
            index = 5;
          } else if (value >= 292.5 && value < 292.5) {
            // barat
            index = 6;
          } else if (value >= 337.5 && value < 337.5) {
            // barat laut
            index = 7;
          } else {
            // utara
            index = 0;
          }

          this.data[0].r[index] = 1;
        })
        .catch(e => {
          this.data[0].r = [0, 0, 0, 0, 0, 0, 0, 0];
        });
    }
  },
  created() {
    this.getData();
    this.fetchInterval = setInterval(this.getData, 60000);
  },
  destroyed() {
    clearInterval(this.fetchInterval);
  }
};
</script>

<style lang="scss" scoped>
.chart {
  height: 250px;
  max-width: 200px;
  margin: auto;
}
</style>
