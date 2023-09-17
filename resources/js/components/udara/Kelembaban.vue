<template>
  <el-card class="text-center">
    <strong>KELEMBABAN UDARA</strong>
    <br />
    {{parameters[parameter]}}
    <br />
    <br />
    <v-chart :options="chartOptions" class="echarts"></v-chart>
  </el-card>
</template>

<script>
import "echarts/lib/chart/gauge";

export default {
  props: ["parameter"],
  data() {
    return {
      parameters: {
        data4: "100m",
        data13: "10m",
        data21: "2m (dalam console)",
        data23: "2m (luar console)"
      },
      fetchInterval: null,
      chartOptions: {
        series: [
          {
            min: 0,
            max: 100,
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
              formatter: "{value}%",
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
      const params = { parameter: this.parameter };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[0].value = r.data;
          this.$store.commit("setKelembaban", r.data);
        })
        .catch(e => {
          this.chartOptions.series[0].data[0].value = NaN;
          this.$store.commit("setKelembaban", NaN);
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
