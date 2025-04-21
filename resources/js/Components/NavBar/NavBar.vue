<script lang="ts" setup>
import { computed, ref } from 'vue';
import { useMediaQuery } from '../../Composables/useMediaQuery'
import { FaHamburger } from 'vue3-icons/fa';
import { useUserInfo } from '../../Composables/useUserInfo';

defineOptions({
    name: 'Navbar',
})

const isMobile = useMediaQuery('(max-width: 600px)');
const menuShown = ref(false);
const { userInfo, clearUserInfo } = useUserInfo()
const isAuthenticated = computed(() => !!userInfo.value?.token)
const userDropdownShown = ref(false);

const toggleMenu = () => {
    menuShown.value = !menuShown.value;
}

const userLogoutHandler = () => {
    clearUserInfo();
    userDropdownShown.value = false;
}

const toggleUserDropdownHandler = () => {
    userDropdownShown.value = !userDropdownShown.value;
}

</script>

<template>
    <div class="navbarWrapper" v-if="isMobile">
        <FaHamburger @click="toggleMenu" class="hamburgerIcon" size="2em" />
        <!-- <div class="userName" v-if="userInfo !== null">{{userInfo.name}}</div> -->
        <Transition name="hamburgerMenu" tag="div">
            <div v-if="menuShown" @click="toggleMenu" class="hamburgerMenu">
                <nav class="nav-element">
                    <div class="nav-link-container">
                        <router-link class="nav-link" to="/">Home</router-link>
                        <router-link class="nav-link" to="/distributables">Distributables</router-link>
                        <router-link v-if="isAuthenticated" class="nav-link" to="/patrons/list">Patrons</router-link>
                    </div>
                </nav>
            </div>
        </Transition>
    </div>
    <div class="navbarWrapper" v-else>
        <nav class="nav-element">
            <div>
                <router-link class="nav-link" to="/">Home</router-link>
                <router-link class="nav-link" to="/distributables">Distributables</router-link>
                <router-link v-if="userInfo?.token" class="nav-link" to="/patrons/list">Patrons</router-link>
            </div>
            <div class="userName" v-if="userInfo?.name">
                <div @click="toggleUserDropdownHandler">
                    {{ userInfo.name }}
                </div>
                <div @click="userLogoutHandler" v-if="userDropdownShown" class="userDropdown">Logout</div>
            </div>
            <div @click="" v-else class="userName">
                <router-link class="nav-link-login" to="/login">Log In</router-link>
            </div>
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

.hamburgerMenu {
    position: fixed;
    width: 100%;
    background-color: var(--main-bg-color);
    height: 100dvh;
    z-index: 2;
}

.hamburgerIcon {
    margin: 10px;
    cursor: pointer;
}

nav {
    display: flex;
    gap: 10px;
    font-size: 24px;
    border-bottom: 1px solid gray;
}

.userName {
    justify-self: flex-end;
    padding: 4px;
    position: relative;
    cursor: pointer;
    user-select: none;
    border-radius: 0.25rem;
}

.userDropdown {
    border: 1px solid white;
    pointer-events: auto;
    position: absolute;
    background-color: var(--main-bg-color);
    padding: 6px;
    right: 2px;
    border-radius: 0.25rem;
}
.userDropdown:hover {
    background-color: gray;
    color: black;
}

.nav-link {
    padding: 4px;
    padding-left: 8px;
    padding-right: 8px;
}

.nav-link-container {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.nav-element {
    width: 100%;
    display: flex;
    justify-content: space-between;
}

.nav-link:hover {
    background-color: gray;
    color: black;
}

.nav-link-login{
    padding: 4px;
    padding-left: 8px;
    padding-right: 8px;
    border-radius: 0.25rem;
}

.nav-link-login:hover {
    background-color: gray;
    color: black;
}

@media screen and (max-width: 600px) {
    nav {
        border: none;
        flex-direction: column;
    }

    .nav-element {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
