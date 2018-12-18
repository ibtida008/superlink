require('./bootstrap');
import router from './routes_user.js';

const app = new Vue({
    el: '#app_user',
    router:router
});
