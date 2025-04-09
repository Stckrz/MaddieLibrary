<script lang="ts" setup>
import { useToastStore } from '../Stores/toastStore';
import {useMediaQuery} from '../Composables/useMediaQuery'

const isMobile = useMediaQuery('(max-width: 600px)');
const toastStore = useToastStore();

const createToast = () => {
    console.log(isMobile.value);
    toastStore.addToast("Hello I am a toast!", "success");
};

</script>

<template>
    <div>
        <h1>
            Welcome To The Library!
        </h1>
        <div class="homeNavigationLinks">
            <router-link class="nav-link" to="/distributables">Distributables</router-link>
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
