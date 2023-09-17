<template>
  <div style="padding:20px">
    <div class="d-flex">
      <h3 class="flex-grow-1">SENSOR SETTING</h3>
      <el-form class="flex-grow-0" inline @submit.native.prevent="() => { return }">
        <el-form-item>
          <el-button type="primary" icon="el-icon-plus" @click="openForm({})">TAMBAH SENSOR</el-button>
        </el-form-item>
        <el-form-item>
          <el-input
            v-model="keyword"
            placeholder="Cari"
            prefix-icon="el-icon-search"
            :clearable="true"
            @change="(v) => { keyword = v; requestData(); }"
          ></el-input>
        </el-form-item>
      </el-form>
    </div>

    <el-table
      @sort-change="sortChange"
      :default-sort="{prop: sort, order: order}"
      :data="tableData"
      stripe
      v-loading="loading"
    >
      <el-table-column prop="id" label="ID" width="60px" sortable="custom"></el-table-column>
      <el-table-column prop="description" label="Keterangan" min-width="150px" sortable="custom"></el-table-column>
      <el-table-column
        prop="parameter"
        label="Parameter"
        align="center"
        header-align="center"
        sortable="custom"
      ></el-table-column>
      <el-table-column
        prop="height"
        label="Ketinggian (m)"
        align="center"
        header-align="center"
        sortable="custom"
      ></el-table-column>
      <el-table-column prop="min_value" label="Nilai Min." align="center" header-align="center"></el-table-column>
      <el-table-column prop="max_value" label="Nilai Max." align="center" header-align="center"></el-table-column>
      <el-table-column prop="unit" label="Unit" align="center" header-align="center"></el-table-column>
      <el-table-column
        prop="value_formatter"
        label="Rumus Nilai"
        align="center"
        header-align="center"
      ></el-table-column>

      <el-table-column width="40px" align="center" header-align="center">
        <template slot="header">
          <el-button
            type="text"
            @click="() => { page = 1; keyword = ''; requestData(); }"
            icon="el-icon-refresh"
          ></el-button>
        </template>
        <template slot-scope="scope">
          <el-dropdown>
            <span class="el-dropdown-link">
              <i class="el-icon-more"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item
                icon="el-icon-edit-outline"
                @click.native.prevent="openForm(scope.row)"
              >Edit</el-dropdown-item>
              <el-dropdown-item
                icon="el-icon-delete"
                @click.native.prevent="deleteData(scope.row.id)"
              >Hapus</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog
      :visible.sync="showForm"
      :title="!!formModel.id ? 'EDIT SENSOR SETTING' : 'TAMBAH SENSOR SETTING'"
      v-loading="loading"
      :close-on-click-modal="false"
    >
      <el-alert
        type="error"
        title="ERROR"
        :description="error.message + '\n' + error.file + ':' + error.line"
        v-show="error.message"
        style="margin-bottom:15px;"
      ></el-alert>

      <el-form label-width="150px" label-position="left">
        <el-form-item label="Parameter" :class="formErrors.parameter ? 'is-error' : ''">
          <el-input placeholder="Parameter" v-model="formModel.parameter"></el-input>
          <div class="el-form-item__error" v-if="formErrors.parameter">{{formErrors.parameter[0]}}</div>
        </el-form-item>

        <el-form-item label="Keterangan" :class="formErrors.description ? 'is-error' : ''">
          <el-input
            type="textarea"
            autosize
            placeholder="Keterangan"
            v-model="formModel.description"
          ></el-input>
          <div
            class="el-form-item__error"
            v-if="formErrors.description"
          >{{formErrors.description[0]}}</div>
        </el-form-item>

        <el-form-item label="Ketinggian" :class="formErrors.height ? 'is-error' : ''">
          <el-input type="number" placeholder="Ketinggian" v-model="formModel.height"></el-input>
          <div class="el-form-item__error" v-if="formErrors.height">{{formErrors.height[0]}}</div>
        </el-form-item>

        <el-form-item label="Nilai Min." :class="formErrors.min_value ? 'is-error' : ''">
          <el-input type="number" placeholder="Nilai Min." v-model="formModel.min_value"></el-input>
          <div class="el-form-item__error" v-if="formErrors.min_value">{{formErrors.min_value[0]}}</div>
        </el-form-item>

        <el-form-item label="Nilai Max." :class="formErrors.max_value ? 'is-error' : ''">
          <el-input type="number" placeholder="Nilai Max." v-model="formModel.max_value"></el-input>
          <div class="el-form-item__error" v-if="formErrors.max_value">{{formErrors.max_value[0]}}</div>
        </el-form-item>

        <el-form-item label="Unit" :class="formErrors.unit ? 'is-error' : ''">
          <el-input placeholder="Unit" v-model="formModel.unit"></el-input>
          <div class="el-form-item__error" v-if="formErrors.unit">{{formErrors.unit[0]}}</div>
        </el-form-item>

        <el-form-item label="Rumus Nilai" :class="formErrors.value_formatter ? 'is-error' : ''">
          <el-input placeholder="Rumus Nilai" v-model="formModel.value_formatter"></el-input>
          <div
            class="el-form-item__error"
            v-if="formErrors.value_formatter"
          >{{formErrors.value_formatter[0]}}</div>
        </el-form-item>

        <!-- <el-form-item
          label="Keterangan Nilai"
          :class="formErrors.value_formatter ? 'is-error' : ''"
        >
          <el-input placeholder="Keterangan Nilai" v-model="formModel.value_formatter"></el-input>
          <div
            class="el-form-item__error"
            v-if="formErrors.value_description"
          >{{formErrors.value_description[0]}}</div>
        </el-form-item>-->
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button icon="el-icon-error" @click="showForm = false">BATAL</el-button>
        <el-button
          type="primary"
          icon="el-icon-success"
          @click="() => !!formModel.id ? update() : store()"
        >SIMPAN</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showForm: false,
      formErrors: {},
      error: {},
      formModel: {},
      keyword: "",
      tableData: [],
      loading: false,
      sort: "id",
      order: "ascending"
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
    openForm(data) {
      this.error = {};
      this.formErrors = {};
      this.formModel = JSON.parse(JSON.stringify(data));
      this.showForm = true;
    },
    store() {
      this.loading = true;
      axios
        .post("/sensorSetting", this.formModel)
        .then(r => {
          this.showForm = false;
          this.$message({
            message: "Data berhasil disimpan.",
            type: "success",
            showClose: true
          });
          this.requestData();
        })
        .catch(e => {
          if (e.response.status == 422) {
            this.error = {};
            this.formErrors = e.response.data.errors;
          }

          if (e.response.status == 500) {
            this.formErrors = {};
            this.error = e.response.data;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    update() {
      this.loading = true;
      axios
        .put("/sensorSetting/" + this.formModel.id, this.formModel)
        .then(r => {
          this.showForm = false;
          this.$message({
            message: "Data berhasil disimpan.",
            type: "success",
            showClose: true
          });
          this.requestData();
        })
        .catch(e => {
          if (e.response.status == 422) {
            this.error = {};
            this.formErrors = e.response.data.errors;
          }

          if (e.response.status == 500) {
            this.formErrors = {};
            this.error = e.response.data;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    deleteData(id) {
      this.$confirm("Anda yakin akan menghapus data ini?", "Warning", {
        type: "warning"
      })
        .then(() => {
          axios
            .delete("/sensorSetting/" + id)
            .then(r => {
              this.requestData();
              this.$message({
                message: r.data.message,
                type: "success",
                showClose: true
              });
            })
            .catch(e => {
              this.$message({
                message: e.response.data.message,
                type: "error",
                showClose: true
              });
            });
        })
        .catch(() => console.log(e));
    },
    requestData() {
      let params = {
        keyword: this.keyword,
        sort: this.sort,
        order: this.order
      };

      this.loading = true;

      axios
        .get("/sensorSetting", { params })
        .then(r => (this.tableData = r.data))
        .catch(e => {
          if (e.response.status == 500) {
            this.$message({
              message: e.response.data.message,
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
