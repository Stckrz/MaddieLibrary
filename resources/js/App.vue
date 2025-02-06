<template>
    <nav class="nav-element">
        <router-link class="nav-link" to="/">Home</router-link>
        <Dropdown class="nav-link" :items="bookDropdownItems" label="Books" @select="handleSelect"/>
        <Dropdown class="nav-link" :items="patronDropdownItems" label="Patrons" @select="handleSelect"/>
    </nav>
    <div class="contentWrapper">
        <router-view />
    </div>
</template>

<script>
import '../css/app.css';
import Dropdown from './Components/Dropdown/Dropdown.vue';
export default {
    name: 'App',
    components: {
        Dropdown,
    },
    data() {
        return {
            bookDropdownItems: [
                {label: 'Books', value: '/'},
                {label: 'NewBook', value: '/books/create'},
            ],
            patronDropdownItems: [
                {label: 'Patrons', value: '/patrons/list'},
                {label: 'New Patron', value: '/patrons/create'},
            ]
        }
    },
    methods: {
        handleSelect(route) {
            if (route) {
                this.$router.push(route);
            }
        },
    },
}
</script>

<style>
button {
    border-radius: 0.25em;
    background-color: gray;
    color: black;
    transition: all 0.25s linear;
    transition-property: color, background-color;
    padding-left: 5px;
    padding-right: 5px;

}

button:hover {
    background-color: #494057;
    color: white;
}

input,
textarea {
    background-color: gray;
    border-radius: 0.125em;
}

nav {
    display: flex;
    gap: 10px;
    font-size: 24px;
    border-bottom: 1px solid gray;
    margin-left: 10px;
    margin-right: 10px;
}
.nav-link:hover {
    background-color: gray;
    color: black;
}

.newBookForm {
    padding: 5px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.formElement {
    display: flex;
    justify-content: space-between;
}

.bookList {
    display: flex;
    flex-direction: column;
}

.listItem {
    margin: 5px;
}

.bookListContainer {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.contentWrapper {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
