<template>
  <el-card class="text-center">
    <strong>ARAH ANGIN</strong>
    <br />
    {{height}}m
    <br />
    <v-chart :options="chartOptions" class="echarts"></v-chart>
  </el-card>
</template>

<script>
import "echarts/lib/component/tooltip";
import "echarts/lib/component/legend";
import "echarts/lib/chart/gauge";
import "echarts/lib/component/polar";

export default {
  props: ["height"],
  data() {
    return {
      fetchInterval: null,
      chartOptions: {
        grid: {
          bottom: "0px"
        },
        angleAxis: {
          type: "category",
          startAngle: 112.5,
          data: ["U", "TL", "T", "TG", "S", "BD", "B", "BL"]
        },
        radiusAxis: {
          splitNumber: 1,
          splitLine: {
            show: false
          }
        },
        axisTick: {
          show: false
        },
        polar: {},
        series: [
          {
            type: "bar",
            data: [0, 0, 0, 0, 0, 0, 0, 0],
            coordinateSystem: "polar"
          }
        ]
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
          this.chartOptions.series[0].data = [0, 0, 0, 0, 0, 0, 0, 0];

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

          this.chartOptions.series[0].data[index] = 1;
        })
        .catch(e => {
          this.chartOptions.series[0].data = [0, 0, 0, 0, 0, 0, 0, 0];
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
.echarts {
  height: 250px;
  max-width: 200px;
  margin: auto;
}
</style>
