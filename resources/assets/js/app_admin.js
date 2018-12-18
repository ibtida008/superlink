require('./bootstrap');
import router from './routes_admin.js';

const app = new Vue({
    el: '#app_admin',
    router:router
});
