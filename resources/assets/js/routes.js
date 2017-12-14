import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./components/Home')
    },
    {
        path: '/profile',
        component: require('./components/Profile')
    }


]

export default new VueRouter({

    mode: 'history',

    routes

});
