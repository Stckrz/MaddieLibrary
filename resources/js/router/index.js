import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../Views/HomeView.vue';
import DistributablesListView from '../Views/Distributables/DistributablesListView.vue';
import DistributableDetailView from '../Views/Distributables/DistributableDetailView.vue';
import PatronList from '../Views/Patrons/PatronList.vue';
import PatronDetailView from '../Views/Patrons/PatronDetail.vue';
import NotFoundView from '../Views/NotFoundView.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView,
    },
    {
        path: '/distributables',
        name: 'distributables-list',
        component: DistributablesListView,
        props: true,
    },
    {
        path: '/distributable/:id',
        name: 'distributable-detail',
        component: DistributableDetailView,
        props: true,
    },
    {
        path: '/patrons/list',
        name: 'patron-list',
        component: PatronList,
    },
    {
        path: '/patrons/:id',
        name: 'patron-detail',
        component: PatronDetailView,
        props: true,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: NotFoundView,
    },

];
const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router;
