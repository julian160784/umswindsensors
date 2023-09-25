<template>
  <el-card class="text-center">
    <strong>LOG ANGIN</strong>
    <br />
    {{height}}m
    <br />
    <br />

    <el-radio-group v-model="period" size="mini" @change="getData">
      <el-radio-button label="HARI"></el-radio-button>
      <el-radio-button label="PEKAN"></el-radio-button>
      <el-radio-button label="BULAN"></el-radio-button>
    </el-radio-group>
    <br />

    <el-radio-group v-model="unit" size="mini" @change="getData">
      <el-radio-button label="mph"></el-radio-button>
      <el-radio-button label="km/h"></el-radio-button>
    </el-radio-group>

    <br />

    <Plotly :data="data" :layout="layout" :displayModeBar="false" class="chart"></Plotly>
  </el-card>
</template>

<script>
import { Plotly } from "vue-plotly";

export default {
  props: ["height"],
  components: { Plotly },
  data() {
    return {
      unit: "mph",
      period: "HARI",
      fetchInterval: null,
      data: [
        {
          r: [77.5, 72.5, 70.0, 45.0, 22.5, 42.5, 40.0, 62.5],
          theta: ["U", "TM", "T", "TG", "S", "BD", "B", "BL"],
          name: "11-14 mph",
          //   marker: { color: "rgb(106,81,163)" },
          type: "barpolar"
        },
        {
          r: [57.5, 50.0, 45.0, 35.0, 20.0, 22.5, 37.5, 55.0],
          theta: ["U", "TM", "T", "TG", "S", "BD", "B", "BL"],
          name: "8-11 mph",
          //   marker: { color: "rgb(158,154,200)" },
          type: "barpolar"
        },
        {
          r: [40.0, 30.0, 30.0, 35.0, 7.5, 7.5, 32.5, 40.0],
          theta: ["U", "TM", "T", "TG", "S", "BD", "B", "BL"],
          name: "5-8 mph",
          //   marker: { color: "rgb(203,201,226)" },
          type: "barpolar"
        },
        {
          r: [20.0, 7.5, 15.0, 22.5, 2.5, 2.5, 12.5, 22.5],
          theta: ["U", "TM", "T", "TG", "S", "BD", "B", "BL"],
          name: "< 5 mph",
          //   marker: { color: "rgb(242,240,247)" },
          type: "barpolar"
        }
      ],
      layout: {
        width: 200,
        autosize: false,
        margin: { l: 15, t: 0, b: 0, r: 15 },
        legend: { orientation: "h" },
        polar: {
          barmode: "overlay",
          bargap: 0,
          radialaxis: { ticksuffix: "%", angle: 90, dtick: 20 },
          angularaxis: { direction: "clockwise" }
        }
      }
    };
  },
  methods: {
    getData() {
      const data = {
        100: "data2",
        70: "data7",
        40: "data9",
        10: "data11",
        2: "data20"
      };
      const params = {
        parameter: data[this.height],
        unit: this.unit
      };

      axios
        .get("sensorLog/getLogAngin", { params })
        .then(r => {
          //   this.chartOptions.series = r.data.series;
          //   this.chartOptions.legend.data = r.data.legend;
        })
        .catch(e => {
          //   this.chartOptions.series = [];
          //   this.chartOptions.legend.data = [];
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
  max-width: 200px;
  margin: auto;
}
</style>
