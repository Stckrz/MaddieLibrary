<script lang="ts" setup>
import CreatePatronView from './CreatePatronView.vue';
import Modal from '../../Components/Modal/Modal.vue';
import { ref, onMounted } from 'vue';
import { Patron } from '../../models/patrons/patronModel';
import { useMediaQuery } from '../../Composables/useMediaQuery';

defineOptions({
    name: 'PatronList',
});

const isMobile = useMediaQuery('(max-width: 600px)');
const patrons = ref<Patron[]>([]);
const newPatronModalShown = ref(false);

const fetchPatrons = async () => {
    try {
        const response = await fetch('/api/patrons');
        patrons.value = await response.json();
    } catch (error) {
        console.error('Error Fetching Patrons: ', error);
    }
};

const toggleNewPatronModal = () => {
    newPatronModalShown.value = !newPatronModalShown.value
};

onMounted(() => {
    fetchPatrons();
})

</script>

                    }" @click="$router.push({ name: 'distributable-detail', params: { id: distributable.id } })">
<template>
    <div class="patronListContainer">
        <div class="patronHeaderBox">
            <h1 class="color-red-950 m-1000">Patrons</h1>
            <button @click="toggleNewPatronModal">
                New Patron
            </button>
        </div>
        <div v-if="isMobile" class="mobilePatronListContainer">
            <div
                v-for="patron in patrons"
                :key="patron.id"
                class="mobileTableListItem"
                @click="$router.push({name: 'patron-detail', params: {id: patron.id}})"
            >
                <div>Last Name: {{patron.lastName}}</div>
                <div>First Name: {{patron.firstName}}</div>
                <div>Card Number: {{ patron.card_number }}</div>
                <div>Email: {{ patron.email }}</div>
            </div>
        </div>
        <table class="patronList" v-if="!isMobile">
            <tbody>
                <tr>
                    <td>
                        Last
                    </td>
                    <td>
                        First
                    </td>
                    <td>
                        Number
                    </td>
                    <td>
                        Email
                    </td>
                </tr>
                <tr v-for="patron in patrons" :key="patron.id" class="tableListItem" @click="$router.push({name: 'patron-detail', params: {id: patron.id}})">
                    <td>
                        {{ patron.lastName }}
                    </td>
                    <td>
                        <router-link :to="{
                            name: 'patron-detail',
                            params: { id: patron.id }
                        }">
                            {{ patron.firstName }}
                        </router-link>
                    </td>
                    <td>{{ patron.card_number }}</td>
                    <td>{{ patron.email }}</td>

                </tr>
            </tbody>
        </table>
        <Modal :closeModal="toggleNewPatronModal" :modalShown="newPatronModalShown">
            <CreatePatronView />
        </Modal>
    </div>
</template>

<style>
.mobilePatronListContainer{
    display: flex;
    flex-direction: column;
    overflow: auto;
    height: 90%;
}

.mobileTableListItem {
    border-radius: 0.25rem;
    transition: background-color 0.5s linear, color 0.5s linear;
    cursor: pointer;
    padding: 8px;
}

.mobileTableListItem:hover {
    background-color: gray;
    color: black;
}

.patronListContainer {
    width: 100%;
    height: 100%;
    align-self: flex-start;
}

.patronList {
    width: 100%
}

.patronHeaderBox {
    display: flex;
    justify-content: spacebetween;
    width: 100%;
    padding: 4px;
}
</style>
