window.axios = require('axios');
window.moment = require('moment');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) { }


import Vue from 'vue'
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import router from './router'
import store from './store'
import App from './App'

Vue.use(ElementUI, { locale });
Vue.component('v-chart', require('vue-echarts/components/ECharts').default)

Vue.filter('readableDateTime', function (v) {
    return v ? moment(v).format('DD-MMM-YYYY HH:mm') : ''
})

Vue.filter('readableDate', function (v) {
    return v ? moment(v).format('DD-MMM-YYYY') : ''
})

Vue.filter('formatNumber', function (v) {
    try {
        v += '';
        var x = v.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    } catch (error) {
        return 0
    }

});

const app = new Vue({
    el: '#app',
    router, store,
    render: (h) => h(App)
});
