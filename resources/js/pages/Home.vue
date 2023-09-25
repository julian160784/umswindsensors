<template>
  <div>
    <div class="d-flex flex-wrap">
      <KecepatanAngin
        class="flex-fill mr-1 mb-1"
        :height="i"
        v-for="i in [80, 60, 30, 10]"
        :key="'kecepatan-angin'+i"
      />
    </div>
    <div class="d-flex flex-wrap">
      <ArahAngin
        class="flex-fill mr-1 mb-1"
        :height="i"
        v-for="i in [80, 60, 30, 10]"
        :key="'arah-angin'+i"
      />
    </div>

    <div class="d-flex flex-wrap">
      <LogAngin
        class="flex-fill mr-1 mb-1"
        :height="i"
        v-for="i in [80, 60, 30, 10]"
        :key="'log-angin'+i"
      />
    </div>

    <div class="d-flex flex-wrap">
      <Udara class="mr-1 mb-1 flex-fill" v-for="i in [80, 10, 2]" :key="'udara'+i" :height="i" />
    </div>

    <div class="d-flex flex-wrap">
      <PrakiraanCuaca class="mr-1 mb-1 flex-fill" />
      <Kelembaban
        v-for="d in ['hum80', 'hum10', 'hum', 'inhum']"
        :key="d"
        class="mr-1 mb-1 flex-fill"
        :parameter="d"
      />
    </div>
    <div class="d-flex flex-wrap">
      <CurahHujan class="mr-1 mb-1 flex-fill" />
      <!-- <Penguapan class="mr-1 mb-1 flex-fill" /> -->
      <TerbitTerbenam class="mr-1 mb-1 flex-fill" />
      <!-- <Uv class="mr-1 mb-1 flex-fill" />
      <RadiasiMatahari class="mr-1 mb-1 flex-fill" /> -->
      <HujanSaatIni class="mr-1 mb-1 flex-fill" />
    </div>
    
    <el-card class="text-center mr-1 mb-1 flex-wrap" style="background-color:#DBD9D9">
        <h6>DIBANGUN OLEH:</h6>
        <img src="/images/logo-albani.png" alt />
      </el-card>
  </div>
</template>

<script>
// import Angin from "../components/angin/Index";
import KecepatanAngin from "../components/angin/Kecepatan";
import ArahAngin from "../components/angin/Arah";
import LogAngin from "../components/angin/Log";
import Udara from "../components/udara/Index";
import Kelembaban from "../components/udara/Kelembaban";
import CurahHujan from "../components/udara/CurahHujan";
import Penguapan from "../components/udara/Penguapan";
import RadiasiMatahari from "../components/RadiasiMatahari";
import Uv from "../components/Uv";
import HujanSaatIni from "../components/HujanSaatIni";
import PrakiraanCuaca from "../components/PrakiraanCuaca";
import TerbitTerbenam from "../components/TerbitTerbenam";

export default {
  components: {
    // Angin,
    Udara,
    Kelembaban,
    CurahHujan,
    Penguapan,
    RadiasiMatahari,
    Uv,
    HujanSaatIni,
    PrakiraanCuaca,
    TerbitTerbenam,
    KecepatanAngin,
    ArahAngin,
    LogAngin
  }
};
</script>

<style lang="scss" scoped>
</style>
