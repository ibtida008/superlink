require('./bootstrap');
import router from './routes_search.js';

const app = new Vue({
    el: '#app_search',
    router:router
});
