<template>
  <el-card class="text-center">
    <strong>RADIASI MATAHARI</strong>
    <br />
    <br />
    <v-chart :options="chartOptions" class="echarts"></v-chart>
  </el-card>
</template>

<script>
import "echarts/lib/chart/gauge";

export default {
  props: ["height"],
  data() {
    return {
      fetchInterval: null,
      chartOptions: {
        series: [
          {
            min: 0,
            max: 1800,
            type: "gauge",
            startAngle: 200,
            endAngle: -20,
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
            title: {
              offsetCenter: [0, "90%"],
              fontSize: 12
            },
            data: [{ value: NaN, name: "Watt/m2" }]
          }
        ]
      }
    };
  },
  methods: {
    getData() {
      const params = { parameter: "data26" };
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
