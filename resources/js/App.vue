<template>
    <nav>
        <router-link class="nav-link" to="/">Home</router-link>
        <router-link class="nav-link" to="/books/create">New Book</router-link>
    </nav>
    <div class="contentWrapper">
        <router-view />
    </div>
</template>

<script>
import '../css/app.css';
export default {
    name: 'App',
}
</script>

<style>
button {
    border-radius: 0.25em;
    background-color: gray;
    color: black;
    transition: all 0.25s linear;
    transition-property: color, background-color;

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
