<script>
import Modal from '../Components/Modal/Modal.vue';
import Toast from '../Components/Toast/Toast.vue';
import { useToastStore } from '../Stores/toastStore.js';
import { mapStores } from 'pinia';
export default {
    name: 'HomeView',
    data() {
        return {
            toastShown: false,
        };
    },
    components: {
        Toast
    },
    computed: {
        ...mapStores(useToastStore)
    },
    methods: {
        addToast() {
            this.toastStore.addToast("Hello I am a toast!", "success");
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
            <button v-on:click="addToast">
                Toast
            </button>
            <Teleport to="body">
                <Toast>
                </Toast>
            </Teleport>
        </div>
    </div>
</template>
<style>
.homeNavigationLinks {
    display: flex;
    flex-direction: column;
}
</style>
