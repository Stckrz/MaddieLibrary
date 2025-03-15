<script>
import Modal from '../Components/Modal/Modal.vue';
import { useToastStore } from '../Stores/toastStore.js';
import { mapStores } from 'pinia';
import toastMixin from '../Mixins/toastMixin.js';
export default {
    name: 'HomeView',
    mixins: [
        toastMixin
    ],
    methods: {
        createToast() {
            this.addToast("Hello I am a toast!", "success")
        },
    }
}
</script>

<template>
    <div>
        <h1>
            Welcome To The Library!
        </h1>
        <div class="homeNavigationLinks">
            <router-link class="nav-link" to="/books">Books</router-link>
            <router-link class="nav-link" to="/patrons/list">Patrons</router-link>
            <button v-on:click="createToast">
                Toast
            </button>
        </div>
    </div>
</template>
<style>
.homeNavigationLinks {
    display: flex;
    flex-direction: column;
}
</style>
