window.axios = require('axios');
//
// window.axios = axios.create({
//     baseUrl : 'https://api.sparkpost.com/api/v1',
//     timeout : 5000,
//     headers : {
//         'Content-Type' : 'application/json',
//         'Accept' : 'application/json',
//         'Authorization' : 'Bearer '
//     },
// });

window.Vue = require('vue');


Vue.component('promotion', require('./components/Promotion.vue').default);


const app = new Vue({
    el: '#app'
});
