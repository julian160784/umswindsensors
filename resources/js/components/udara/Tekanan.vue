<template>
  <el-card>
    <div class="text-right">
      <el-radio-group v-model="unit" size="mini" @change="getData">
        <el-radio-button label="inHg"></el-radio-button>
        <el-radio-button label="hPa"></el-radio-button>
      </el-radio-group>
    </div>
    <v-chart :options="chartOptions" class="echarts"></v-chart>
  </el-card>
</template>

<script>
import "echarts/lib/component/title";
import "echarts/lib/chart/line";

export default {
  props: ["height"],
  data() {
    return {
      unit: "inHg",
      fetchInterval: null,
      chartOptions: {
        grid: {
          left: "60px",
          bottom: "20px"
        },
        title: {
          text: "TEKANAN UDARA",
          subtext: this.height + "m",
          textStyle: {
            fontSize: 13
          },
          subtextStyle: {
            color: "#333",
            fontSize: 13,
            fontWeight: "bold"
          }
        },
        xAxis: {
          type: "category",
          boundaryGap: false,
          data: ["00:00", "01:00", "02:00", "03:00", "04:00", "05:00"]
        },
        yAxis: {
          type: "value",
          splitNumber: 5,
          axisLabel: {
            formatter: "{value}"
          }
        },
        axisLine: {
          lineStyle: {
            opacity: 0
          }
        },
        series: [
          {
            type: "line",
            label: {
              show: true,
              position: "top",
              color: "#000",
              fontWeight: "bold"
            },
            data: [NaN, NaN, NaN, NaN, NaN, NaN]
          }
        ]
      }
    };
  },
  methods: {
    getData() {
      const parameter = {
        100: "data5",
        10: "data14",
        2: "data16"
      };

      const params = {
        date: moment().format("YYYY-MM-DD"),
        parameter: parameter[this.height],
        unit: this.unit
      };
      axios
        .get("sensorLog/getTekanan", { params })
        .then(r => {
          this.chartOptions.series[0].data = r.data.value;
          this.chartOptions.xAxis.data = r.data.category;
        })
        .catch(e => {
          this.chartOptions.series[0].data = [NaN, NaN, NaN, NaN, NaN, NaN];
          this.chartOptions.xAxis.data = [
            "00:00",
            "01:00",
            "02:00",
            "03:00",
            "04:00",
            "05:00"
          ];
        });
    }
  },
  mounted() {
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
  max-width: 375px;
  margin: auto;
}
</style>
