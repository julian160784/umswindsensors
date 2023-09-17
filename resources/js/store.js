import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        // untuk prakiraan cuaca
        suhu: NaN,
        kelembaban: NaN,
        unit: 'F',
    },
    mutations: {
        setSuhu(state, suhu) {
            state.suhu = suhu
        },
        setKelembaban(state, kelembaban) {
            state.kelembaban = kelembaban
        },
        setUnit(state, unit) {
            state.unit = unit
        }
    }
})
