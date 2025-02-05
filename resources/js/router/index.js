import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../Views/HomeView.vue';
import BookDetailView from '../Views/BookDetailView.vue';
import CreateBookView from '../Views/CreateBookView.vue';
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
