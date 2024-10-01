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

    <v-chart :options="chartOptions" class="echarts"></v-chart>

    <!-- <el-tabs>
      <el-tab-pane :label="x" v-for="(x, i) in ['HARI', 'PEKAN', 'BULAN']" :key="i">
        <div class="d-flex flex-wrap justify-content-around">
          <div class="text-center mb-3 hijau tag">0-2 mph</div>
          <div class="text-center mb-3 hijau-muda tag">2-4 mph</div>
          <div class="text-center mb-3 biru tag">4-6 mph</div>
          <div class="text-center mb-3 ungu tag">6-8 mph</div>
          <div class="text-center mb-3 kuning tag">8-10 mph</div>
          <div class="text-center mb-3 orange tag">10-20 mph</div>
          <div class="text-center mb-3 hitam tag">>20 mph</div>
        </div>
      </el-tab-pane>
    </el-tabs>-->
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
      unit: "F",
      period: "HARI",
      fetchInterval: null,
      chartOptions: {
        angleAxis: {
          type: "category",
          startAngle: 112.5,
          data: ["U", "TL", "T", "TG", "S", "BD", "B", "BL"]
        },
        radiusAxis: { type: "log" },
        polar: {},
        series: [
          //   {
          //     type: "bar",
          //     data: [1, 2, 3, 4, 3, 5, 1, 4],
          //     coordinateSystem: "polar",
          //     name: "A",
          //     stack: "a"
          //   },
          //   {
          //     type: "bar",
          //     data: [2, 4, 6, 1, 3, 2, 1, 3],
          //     coordinateSystem: "polar",
          //     name: "B",
          //     stack: "a"
          //   },
          //   {
          //     type: "bar",
          //     data: [1, 2, 3, 4, 1, 2, 5, 2],
          //     coordinateSystem: "polar",
          //     name: "C",
          //     stack: "a"
          //   }
        ],
        legend: {
          show: true,
          bottom: 0,
          left: "center",
          data: []
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
          this.chartOptions.series = r.data.series;
          this.chartOptions.legend.data = r.data.legend;
        })
        .catch(e => {
          this.chartOptions.series = [];
          this.chartOptions.legend.data = [];
        });
    }
  },
  created() {
    // this.getData();
    // this.fetchInterval = setInterval(this.getData, 60000);
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

.hijau {
  background-color: #07ab88;
}

.hijau-muda {
  background-color: #99bba7;
}

.biru {
  background-color: #318ac4;
}

.ungu {
  background-color: #c49bad;
}

.kuning {
  background-color: #f9ad3f;
}

.orange {
  background-color: #f14a28;
}

.hitam {
  background-color: #1a3749;
}

.tag {
  color: #fff;
  border-radius: 2px;
  font-size: 10px;
  font-weight: bold;
  width: 80px;
}
</style>
