<template>
  <el-container>
    <el-header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">MANDALIKA-WEATHER</a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <router-link class="nav-link" to="/">
                  <i class="el-icon-s-data"></i>
                  Chart
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/table">
                  <i class="el-icon-document-copy"></i>
                  Table
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/sensor-setting">
                  <i class="el-icon-setting"></i>
                  Sensor Setting
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/user">
                  <i class="el-icon-user"></i>
                  User
                </router-link>
              </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <span class="nav-link">Welcome, {{user.name}}!</span>
              </li>
              <li class="nav-item">
                <a href="/logout" class="nav-link">Logout</a>
              </li>
              <li class="nav-item">
                <a class="nav-link">Last Update: {{last_update | readableDateTime}}</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </el-header>
    <el-main>
      <router-view></router-view>
    </el-main>
  </el-container>
</template>

<script>
export default {
  data() {
    return {
      user: {},
      last_update: null
    };
  },
  methods: {
    me() {
      axios.get("/me").then(r => (this.user = r.data));
    },
    getLastUpdate() {
      axios.get("/getLastUpdate").then(r => (this.last_update = r.data));
    }
  },
  created() {
    this.me();
    this.getLastUpdate();
    setInterval(this.getLastUpdate, 60000);
  }
};
</script>

<style lang="css" scoped>
.el-header {
  background-color: #343940;
}

.el-main {
  height: calc(100vh - 60px);
  overflow: auto;
}
</style>
