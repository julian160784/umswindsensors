<template>
  <el-card class="text-center">
    <strong>KECEPATAN ANGIN</strong>
    <br />
    {{height}}m
    <br />
    <br />
    <v-chart :options="chartOptions" class="echarts"></v-chart>
 
    Kec.Max:<div id=“app”> <p>{{ message }}</p> </div>
    Rerata:<div id=“avg”> <p>{{ pesan }}</p> </div>

    <br />
    <br />

    <el-radio-group v-model="unit" size="mini" @change="getData">
      <el-radio-button label="kmh"></el-radio-button>
      <el-radio-button label="m/s"></el-radio-button>
    </el-radio-group>
  </el-card>
</template>

<script>
import "echarts/lib/chart/gauge";

export default 
{
  props: ["height"],
  data() 
  {
    return {

      message:"0",
      pesan:"0",

      unit: "m/s",
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
      this.chartOptions.series[0].max = this.unit == "m/s" ? 60 : 200;

      const data = {
        80: "wspeed80",
        60: "wspeed60",
        30: "wspeed30",
        10: "wspeed"
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

        .catch(e => {this.chartOptions.series[0].data[0].value = NaN;});
    },
    
    getData2() {

      const data = {
        80: "topspeed80",
        60: "topspeed60",
        30: "topspeed30",
        10: "wgust"
      };                                                                                                                                       
      const params = {
        parameter: data[this.height],
        unit: this.unit
      };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.message = r.data;
        })

        .catch(e => {this.message = "NaN";});
    },
    
    getData3() {

      const data = {
        80: "avg_wind80",
        60: "avg_wind60",
        30: "avg_wind30",
        10: "wlatest"
      };                                                                                                                                       
      const params = {
        parameter: data[this.height],
        unit: this.unit
      };

      axios
        .get("sensorLog/getLastData", { params })
        .then(r => {
          this.pesan = r.data;
        })

        .catch(e => {this.pesan = "NaN";});
    },
    
    getData4() {

      const data = {
        80: "WS80",
        60: "WS60",
        30: "WS30"
      };                                                                                                                               
      const params = {
        parameter: data[this.height],
        unit: this.unit
      };
      axios
        .get("getws3sec")
        .then(r => {
              if(params.parameter == 'WS80' & params.unit == 'kmh')this.chartOptions.series[0].data[0].value = parseInt(r.data.WS80)/10;
              else if(params.parameter == 'WS80' & params.unit == 'm/s')
              {
                let newVal = parseInt(r.data.WS80)/36;
                this.chartOptions.series[0].data[0].value = newVal.toFixed(1);
              }
              if(params.parameter == 'WS60' & params.unit == 'kmh')this.chartOptions.series[0].data[0].value = parseInt(r.data.WS60)/10;
              else if(params.parameter == 'WS60' & params.unit == 'm/s')
              {
                let newVal = parseInt(r.data.WS60)/36;
                this.chartOptions.series[0].data[0].value = newVal.toFixed(1);
              }
              if(params.parameter == 'WS30' & params.unit == 'kmh')this.chartOptions.series[0].data[0].value = parseInt(r.data.WS30)/10;
              else if(params.parameter == 'WS30' & params.unit == 'm/s')
              {
                let newVal = parseInt(r.data.WS30)/36;
                this.chartOptions.series[0].data[0].value = newVal.toFixed(1);
              }
        })

        .catch(e => {this.chartOptions.series[0].data[0].value = 0;});
    }
  },
  created() 
  {
    this.getData();
    this.getData2();
    this.getData3();
    //this.getData4();
    this.fetchInterval = setInterval(this.getData, 60000);
    this.fetchInterval = setInterval(this.getData2, 61000);
    this.fetchInterval = setInterval(this.getData3, 62000);
    //this.fetchInterval = setInterval(this.getData4, 6666);
  },
  destroyed() 
  {
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
