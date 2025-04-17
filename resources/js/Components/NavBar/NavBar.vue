<script lang="ts" setup>
import { ref } from 'vue';
import {useMediaQuery} from '../../Composables/useMediaQuery'
import { FaHamburger } from 'vue3-icons/fa';
import { useUserInfo } from '../../Composables/useUserInfo';

defineOptions({
    name: 'Navbar',
})

const isMobile = useMediaQuery('(max-width: 600px)');
const menuShown = ref(false);
const {userInfo} = useUserInfo();

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
            class="hamburgerIcon" size="2em"
        />
        <!-- <div class="userName" v-if="userInfo !== null">{{userInfo.name}}</div> -->
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
                    <div class="nav-link-container">
                        <router-link class="nav-link" to="/">Home</router-link>
                        <router-link class="nav-link" to="/distributables">Distributables</router-link>
                        <router-link v-if="userInfo?.token" class="nav-link" to="/patrons/list">Patrons</router-link>
                    </div>
                </nav>
            </div>
        </Transition>
    </div>
    <div
        class="navbarWrapper"
        v-else>
        <nav class="nav-element">
            <div>
                <router-link class="nav-link" to="/">Home</router-link>
                <router-link class="nav-link" to="/distributables">Distributables</router-link>
                <router-link v-if="userInfo?.token" class="nav-link" to="/patrons/list">Patrons</router-link>
            </div>
            <div class="userName" v-if="userInfo?.name">{{userInfo.name}}</div>
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
}

.userName{
    justify-self: flex-end;
    padding: 4px;
}

.nav-link {
    padding: 4px;
    padding-left: 8px;
    padding-right: 8px;
}

.nav-link-container{
    display: flex;
    flex-direction: column;
    width: 100%;
}

.nav-element{
    width: 100%;
    display: flex;
    justify-content: space-between;
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
    .nav-element{
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
