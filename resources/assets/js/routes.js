import VueRouter from 'vue-router';

let routes = [
    {
        name: 'home',
        path: '/',
        component: require('./components/Home')
    },
    {
        name: 'profile',
        path: '/profile/:id',
        component: require('./components/Profile')
    },
    {
        name: 'search',
        path: '/search',
        component: require('./components/MobileSearch')
    }


]

export default new VueRouter({

    mode: 'history',

    routes

});
