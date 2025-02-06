import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../Views/HomeView.vue';
import BookDetailView from '../Views/BookDetailView.vue';
import CreateBookView from '../Views/CreateBookView.vue';
import CreatePatronView from '../Views/CreatePatronView.vue';
import PatronList from '../Views/PatronList.vue';
import PatronDetailView from '../Views/PatronDetail.vue';
import NotFoundView from '../Views/NotFoundView.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView,
    },
    {
        path: '/books/:id',
        name: 'book-detail',
        component: BookDetailView,
        props: true,
    },
    {
        path: '/books/create',
        name: 'book-create',
        component: CreateBookView,
    },
    {
        path: '/patrons/create',
        name: 'patron-create',
        component: CreatePatronView,
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
