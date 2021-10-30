import VueRouter from 'vue-router'
import Index from "./components/Index";
import Bookable from "./bookables/Bookable";
import BookableDetail from "./bookable/BookableDetail";
import Review from "./review/Review";
import Basket from "./basket/Basket";
import Login from "./auth/Login";

const routes = [
    {
        path: '/',
        component: Bookable,
        name: 'home'
    },
    {
        path: '/bookables/:id',
        component: BookableDetail,
        name: 'bookable'
    },
    {
        path: '/review/:id',
        component: Review,
        name: 'review'
    },
    {
        path: '/basket',
        component: Basket,
        name: 'basket'
    },
    {
        path: '/auth/login',
        component: Login,
        name: 'login'
    },
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;
