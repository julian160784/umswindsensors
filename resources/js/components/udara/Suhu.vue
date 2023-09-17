<template>
  <el-card>
    <div class="text-right">
      <el-radio-group v-model="unit" size="mini" @change="requestData">
        <el-radio-button label="F"></el-radio-button>
        <el-radio-button label="C"></el-radio-button>
      </el-radio-group>
    </div>
    <v-chart :options="chartOptions" class="echarts"></v-chart>
  </el-card>
</template>

<script>
import "echarts/lib/component/title";
import "echarts/lib/chart/bar";

export default {
  props: ["height"],
  data() {
    return {
      unit: "F",
      fetchInterval: null,
      chartOptions: {
        grid: {
          left: "50px"
        },
        title: {
          text: "SUHU UDARA",
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
          data: [
            "Outside Temp",
            "Wind Chill",
            "Heat Index",
            "Dew Point",
            "Inside Temp"
          ],
          axisLabel: {
            interval: 0,
            rotate: this.height == 2 ? 40 : 0
          },
          splitLine: {
            show: false
          }
        },
        yAxis: {
          type: "value",
          splitNumber: 2,
          axisLabel: {
            formatter: "{value}"
          }
        },
        axisLine: {
          lineStyle: { opacity: 0 }
        },
        series: [
          {
            type: "bar",
            barWidth: "75%",
            label: {
              show: true,
              position: "top",
              color: "#000",
              fontWeight: "bold"
            },
            data: [
              { value: NaN, itemStyle: { color: "#c52728" } },
              { value: NaN, itemStyle: { color: "#3387c3" } },
              { value: NaN, itemStyle: { color: "#e88021" } },
              { value: NaN, itemStyle: { color: "#38926e" } },
              { value: NaN, itemStyle: { color: "#55a9ce" } }
            ]
          }
        ]
      }
    };
  },
  methods: {
    getData() {
      const data = { 100: "data3", 10: "data12", 2: "data22" };
      const params = { parameter: data[this.height], unit: this.unit };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[0].value = r.data;
          if (this.height == 2) {
            this.$store.commit("setSuhu", r.data);
            this.$store.commit("setUnit", this.unit);
          }
        })
        .catch(e => {
          this.chartOptions.series[0].data[0].value = NaN;
          if (this.height == 2) {
            this.$store.commit("setSuhu", NaN);
          }
        });
    },
    getInsideTemperatur() {
      const params = { parameter: "data17", unit: this.unit };
      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[3].value = r.data;
        })
        .catch(e => {
          this.chartOptions.series[0].data[3].value = NaN;
        });
    },
    getDewPoint() {
      const params = { parameter: "data35", unit: this.unit };
      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[4].value = r.data;
        })
        .catch(e => {
          this.chartOptions.series[0].data[4].value = NaN;
        });
    },
    getHeatIndex() {
      const params = { parameter: "data36", unit: this.unit };
      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[2].value = r.data;
        })
        .catch(e => {
          this.chartOptions.series[0].data[2].value = NaN;
        });
    },
    getWindChill() {
      const params = { parameter: "data37", unit: this.unit };
      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.chartOptions.series[0].data[1].value = r.data;
        })
        .catch(e => {
          this.chartOptions.series[0].data[1].value = NaN;
        });
    },
    requestData() {
      if (this.height == 2) {
        this.chartOptions.xAxis.data = [
          "Outside Temp",
          "Wind Chill",
          "Heat Index",
          "Dew Point",
          "Inside Temp"
        ];

        this.getDewPoint();
        this.getHeatIndex();
        this.getWindChill();
        this.getInsideTemperatur();
      } else {
        this.chartOptions.xAxis.data = ["Outside Temp"];
      }

      this.getData();
    }
  },
  created() {
    this.requestData();

    this.fetchInterval = setInterval(() => {
      this.getData();
      if (this.height == 2) {
        this.getDewPoint();
        this.getHeatIndex();
        this.getWindChill();
        this.getInsideTemperatur();
      }
    }, 60000);
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
