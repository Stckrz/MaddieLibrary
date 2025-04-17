<template>
    <NavBar />
    <!-- <nav class="nav-element"> -->
    <!--     <router-link class="nav-link" to="/">Home</router-link> -->
    <!--     <router-link class="nav-link" to="/distributables">Distributables</router-link> -->
    <!--     <router-link class="nav-link" to="/patrons/list">Patrons</router-link> -->
    <!-- </nav> -->
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
import NavBar from './Components/NavBar/NavBar.vue';
</script>

<style>
h1{
    font-size: 24px;
    font-weight: bold;
}
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
    flex-grow: 1;
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
    max-height: 94dvh;
    display: flex;
    margin-top: 4px;
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

.checkedIn{
    color: green;
}
.checkedOut{
    color: red;
}

::-webkit-scrollbar {
    width: 20px;
border-radius: 0.5rem;
}

::-webkit-scrollbar-track {
    background-color: gray;
    border-radius: 0.125rem;
}

::-webkit-scrollbar-thumb {
    border: 1px solid gray;
    background: var(--main-bg-color);
    border-radius: 0.25rem;
}

</style>
