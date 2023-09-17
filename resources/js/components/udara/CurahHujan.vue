<template>
  <el-card class="text-center">
    <strong>CURAH HUJAN</strong>
    <v-chart :options="chartOptions" class="echarts"></v-chart>
    <br />
    <el-radio-group v-model="unit" size="mini" @change="requestData">
      <el-radio-button label="inch"></el-radio-button>
      <el-radio-button label="mm"></el-radio-button>
    </el-radio-group>
  </el-card>
</template>

<script>
import "echarts/lib/chart/bar";

export default {
  props: ["height"],
  data() {
    return {
      unit: "inch",
      fetchInterval: null,
      chartOptions: {
        grid: {
          top: "20px",
          left: "70px",
          bottom: "20px"
        },
        xAxis: {
          type: "category",
          data: ["Bulan", "Tahun"]
        },
        yAxis: {
          type: "value",
          splitNumber: 2,
          axisLabel: {
            formatter: "{value}"
          }
        },
        axisLine: {
          lineStyle: {
            type: "dashed",
            opacity: 0
          }
        },
        series: [
          {
            type: "bar",
            label: {
              show: true,
              position: "top",
              color: "#000",
              fontWeight: "bold"
            },
            data: [
              { value: 0, itemStyle: { color: "#38926e" } },
              { value: 0, itemStyle: { color: "#55a9ce" } }
            ]
          }
        ]
      }
    };
  },
  methods: {
    getData(data, index) {
      const params = { parameter: data, unit: this.unit };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[index].value = r.data;
        })
        .catch(e => {
          this.chartOptions.series[0].data[index].value = 0;
        });
    },
    requestData() {
      this.getData("data30", 0);
      this.getData("data31", 1);
    }
  },
  created() {
    this.requestData();
    this.fetchInterval = setInterval(() => {
      this.requestData();
    }, 60000);
  },
  destroyed() {
    clearInterval(this.fetchInterval);
  }
};
</script>

<style lang="scss" scoped>
.echarts {
  height: 150px;
  max-width: 200px;
  margin: auto;
}
</style>
