
window.Vue = require('vue');


Vue.component('promotion', require('./components/Promotion.vue').default);


const app = new Vue({
    el: '#app'
});
