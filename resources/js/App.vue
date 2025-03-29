<template>
    <nav class="nav-element">
        <router-link class="nav-link" to="/">Home</router-link>
        <router-link class="nav-link" to="/distributables">Distributables</router-link>
        <router-link class="nav-link" to="/patrons/list">Patrons</router-link>
    </nav>
    <div class="contentWrapper">
        <router-view />
        <Teleport to="body">
            <Toast>
            </Toast>
        </Teleport>
    </div>

            <div><Cart /></div>
</template>

<script lang="ts" setup>
import '../css/app.css';
import Toast from './Components/Toast/Toast.vue';
import Cart from './Views/Cart/Cart.vue';
</script>

<style>
button {
    border-radius: 0.25em;
    background-color: gray;
    color: black;
    transition: all 0.25s linear;
    transition-property: color, background-color;
    padding: 2px 5px 2px;
    margin: 4px;
}

button:hover {
    background-color: #494057;
    color: white;
}

input,
textarea {
    background-color: gray;
    color: black;
    border-radius: 0.125em;
    padding: 4px;
}

table,
th,
td {
    padding: 5px;
    table-layout: fixed;
}

th {
    text-align: start;
    font-weight: bold;
}

nav {
    display: flex;
    gap: 10px;
    font-size: 24px;
    border-bottom: 1px solid gray;
    margin-left: 10px;
    margin-right: 10px;
}

select {
    background-color: gray;
    color: black;
    display: flex;
    align-items: center;
    justify-content: center;
}

.secondary{
    background-color: #494057;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin: 2px;
}

.form-label {
    display: block;
}

.form-input {
    display: block;
    color: black;
    padding: 2px;
}

.fieldContainer {
    display: flex;
    gap: 10px;
}

.nav-link {
    padding: 4px;
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
    width: 100%;
    margin: 4px;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.contentWrapper {
    width: 100%;
    height: 94dvh;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media only screen and (max-width: 600px) {
    .fieldContainer {
        flex-direction: column;
    }
}

.tableListItem {
    border-radius: 50px;
    transition: background-color 0.5s linear, color 0.5s linear;
    cursor: pointer;
}

.tableListItem:hover {
    background-color: gray;
    color: black;
}

.tableHeaderContainer {
    display: flex;
    align-items: flex-center;
    cursor: pointer;
}
</style>
