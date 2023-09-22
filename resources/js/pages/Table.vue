<template>
  <div style="padding: 20px">
    <h3>DATA SENSOR</h3>
    <hr />
    <div class="d-flex">
      <el-pagination
        class="flex-grow-1"
        background
        @current-change="(p) => { page = p; requestData(); }"
        @size-change="(s) => { pageSize = s; requestData(); }"
        layout="total, sizes, prev, next"
        :page-size="pageSize"
        :page-sizes="[10, 25, 50, 100]"
        :total="tableData.total"
      ></el-pagination>
      <el-form inline class="flex-grow-0">
        <el-form-item>
          <el-date-picker
            v-model="dateRange"
            @change="requestData"
            type="daterange"
            range-separator="-"
            start-placeholder="Start date"
            end-placeholder="End date"
            format="dd-MMM-yyyy"
            value-format="yyyy-MM-dd"
          ></el-date-picker>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="el-icon-download" @click="exportToExcel">EXPORT KE EXCEL</el-button>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="el-icon-refresh" @click="requestData">REFRESH</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table
      :data="tableData.data"
      stripe
      v-loading="loading"
      @sort-change="sortChange"
      :default-sort="{prop: sort, order: order}"
    >
      <el-table-column type="index" :index="tableData.from" width="55" label="#"></el-table-column>
      <el-table-column label="Waktu" prop="created_at" sortable="custom">
        <template slot-scope="scope">{{scope.row.created_at | readableDateTime}}</template>
      </el-table-column>
      <el-table-column prop="setting.description" label="Parameter">
        <template slot-scope="scope">
          {{scope.row.setting.description}}
          <span
            v-if="scope.row.ketinggian"
          >({{scope.row.ketinggian}}m)</span>
        </template>
      </el-table-column>
      <!-- <el-table-column
        prop="ketinggian"
        label="Ketinggian (m)"
        align="center"
        header-align="center"
      ></el-table-column>-->
      <!-- <el-table-column prop="nilai" label="Nilai Raw" align="center" header-align="center"></el-table-column> -->
      <el-table-column prop="value" label="Nilai" align="center" header-align="center"></el-table-column>
      <el-table-column prop="setting.unit" label="Satuan" align="center" header-align="center"></el-table-column>
    </el-table>

    <br />

    <el-pagination
      background
      @current-change="(p) => { page = p; requestData(); }"
      @size-change="(s) => { pageSize = s; requestData(); }"
      layout="total, sizes, prev, next"
      :page-size="pageSize"
      :page-sizes="[10, 25, 50, 100]"
      :total="tableData.total"
    ></el-pagination>
  </div>
</template>

<script>
import exportFromJSON from "export-from-json";

export default {
  data() {
    return {
      page: 1,
      pageSize: 10,
      keyword: "",
      tableData: {},
      loading: false,
      dateRange: null,
      sort: "created_at",
      order: "descending"
    };
  },
  methods: {
    sortChange(c) {
      if (c.prop != this.sort || c.order != this.order) {
        this.sort = c.prop;
        this.order = c.order;
        this.requestData();
      }
    },
    exportToExcel() {
      const params = {
        dateRange: this.dateRange,
        order: this.order,
        sort: this.sort
      };
      axios
        .get("sensorLog/exportToExcel", { params })
        .then(r => {
          const data = r.data.map(d => {
            let parameter = d.setting.description;

            if (d.ketinggian) {
              parameter += "(" + d.ketinggian + ")";
            }

            return {
              Tanggal: d.created_at,
              Parameter: parameter,
              //   Ketinggian: d.ketinggian,
              //   "Nilai Raw": d.nilai,
              Nilai: d.value,
              Satuan: d.setting.unit
            };
          });

          exportFromJSON({ data, fileName: "sensor-log", exportType: "xls" });
        })
        .catch(e => {
          console.log(e);
          if (e.response.status === 500) {
            this.$message({
              message: e.response.data.message,
              type: "error",
              showClose: true,
              duration: 10000
            });
          }
        });
    },
    requestData() {
      let params = {
        keyword: this.keyword,
        page: this.page,
        pageSize: this.pageSize,
        dateRange: this.dateRange,
        order: this.order,
        sort: this.sort
      };

      this.loading = true;

      axios
        .get("/sensorLog", { params })
        .then(r => (this.tableData = r.data))
        .catch(e => {
          if (e.response.status == 500) {
            this.$message({
              message: e.response.data.message,
              type: "error",
              showClose: true,
              duration: 10000
            });
          }
        })
        .finally(() => (this.loading = false));
    }
  },
  mounted() {
    this.requestData();
  }
};
</script>
