<script lang="ts" setup>
import CreatePatronView from './CreatePatronView.vue';
import Modal from '../../Components/Modal/Modal.vue';
import { ref, onMounted } from 'vue';
import { Patron } from '../../models/patrons/patronModel';

defineOptions({
    name: 'PatronList',
});

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
        <table class="patronList">
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
.patronListContainer {
    width: 100%;
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
