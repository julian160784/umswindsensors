<template>
  <el-card class="text-center">
    <strong>KECEPATAN ANGIN</strong>
    <br />
    {{height}}m
    <br />
    <br />
    <v-chart :options="chartOptions" class="echarts"></v-chart>

    <el-radio-group v-model="unit" size="mini" @change="getData">
      <el-radio-button label="mph"></el-radio-button>
      <el-radio-button label="km/h"></el-radio-button>
    </el-radio-group>
  </el-card>
</template>

<script>
import "echarts/lib/chart/gauge";

export default {
  props: ["height"],
  data() {
    return {
      unit: "mph",
      fetchInterval: null,
      chartOptions: {
        series: [
          {
            min: 0,
            max: 250,
            startAngle: 200,
            endAngle: -20,
            name: "kecepatan",
            type: "gauge",
            pointer: { width: 3 },
            splitNumber: 2,
            axisLine: { lineStyle: { width: 7 } },
            axisTick: { length: 0 },
            splitLine: {
              length: 7,
              lineStyle: { color: "auto" }
            },
            radius: "70",
            detail: {
              fontSize: 22,
              color: "#000",
              offsetCenter: [0, "65%"]
            },
            data: [{ value: NaN }]
          }
        ]
      }
    };
  },
  methods: {
    getData() {
      this.chartOptions.series[0].max = this.unit == "mph" ? 200 : 322;

      const data = {
        100: "data2",
        70: "data7",
        40: "data9",
        10: "data11",
        2: "data18"
      };
      const params = {
        parameter: data[this.height],
        unit: this.unit
      };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[0].value = r.data;
        })
        .catch(e => {
          this.chartOptions.series[0].data[0].value = NaN;
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
  height: 150px;
  max-width: 150px;
  margin: auto;
}
</style>
