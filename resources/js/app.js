require('./bootstrap');

import moment from "moment";
import VueRouter from "vue-router";
import Vuex from 'vuex';
import Index from './components/Index';
import FatalError from './shared/FatalError';
import Rating from './bookable/Rating';
import Success from './shared/Success';
import Errors from './shared/Errors';
import storeDefinition from './store';
import router from './routes';

window.Vue = require('vue').default;
Vue.use(VueRouter);
Vue.use(Vuex);

Vue.filter('fromNow', value => moment(value).fromNow());

Vue.component('rating', Rating);
Vue.component('fatal-error', FatalError);
Vue.component('success', Success);
Vue.component('errors', Errors);

const store = new Vuex.Store(storeDefinition);
const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        index: Index
    },
    beforeCreate() {
        // this.$store.dispatch('setDefaultBasket');
        // this.$store.dispatch('setDefaultSearch');
        axios.get('/sanctum/csrf-cookie')
            .then(() => {
            axios.post('/login', {
                email: 'jaylan09@example.net',
                password: 'password'
            });
        }).then(() => {
            axios.get('/user');
        })
    }
});
