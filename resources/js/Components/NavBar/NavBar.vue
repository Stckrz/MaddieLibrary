<script lang="ts" setup>
import { ref } from 'vue';
import {useMediaQuery} from '../../Composables/useMediaQuery'
import { FaHamburger } from 'vue3-icons/fa';

defineOptions({
    name: 'Navbar',
})

const isMobile = useMediaQuery('(max-width: 600px)');
const menuShown = ref(false);

const toggleMenu = () => {
    menuShown.value = !menuShown.value;
}
</script>

<template>
    <div
        class="navbarWrapper"
        v-if="isMobile"
    >
        <FaHamburger
            @click="toggleMenu"
            class="hamburgerIcon" size="2em"/>
        <Transition
            name="hamburgerMenu"
            tag="div"
        >
            <div
                v-if="menuShown"
                @click="toggleMenu"
                class="hamburgerMenu"
            >
                <nav class="nav-element">
                    <router-link class="nav-link" to="/">Home</router-link>
                    <router-link class="nav-link" to="/distributables">Distributables</router-link>
                    <router-link class="nav-link" to="/patrons/list">Patrons</router-link>
                </nav>
            </div>
        </Transition>
    </div>
    <div
        class="navbarWrapper"
        v-else>
        <nav class="nav-element">
            <router-link class="nav-link" to="/">Home</router-link>
            <router-link class="nav-link" to="/distributables">Distributables</router-link>
            <router-link class="nav-link" to="/patrons/list">Patrons</router-link>
        </nav>
    </div>
</template>

<style scoped>

.hamburgerMenu-enter-active,
.hamburgerMenu-leave-active {
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.hamburgerMenu-enter-from,
.hamburgerMenu-leave-to {
    opacity: 0;
    transform: translateX(-100%);
}

.hamburgerMenu{
    background-color: var(--main-bg-color);
    height: 100dvh;
    z-index: 99;
}

.hamburgerIcon{
    margin: 10px;
    cursor: pointer;
}

nav {
    display: flex;
    gap: 10px;
    font-size: 24px;
    border-bottom: 1px solid gray;
    margin-left: 10px;
    margin-right: 10px;
}

.nav-link {
    padding: 4px;
}

.nav-link:hover {
    background-color: gray;
    color: black;
}

@media screen and (max-width: 600px){
    nav{
        border: none;
        flex-direction: column;
    }
}
</style>
