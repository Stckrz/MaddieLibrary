<script>
import PatronDetail from './PatronDetail.vue';
import CreatePatronView from './CreatePatronView.vue';
import Modal from '../Components/Modal/Modal.vue';
export default {
    name: 'PatronList',
    components: {
        Modal,
        CreatePatronView,
        PatronDetail
    },
    data() {
        return {
            patrons: [],
            newPatronModalShown: false,
        };
    },
    mounted() {
        this.fetchPatrons();
    },
    methods: {
        async fetchPatrons() {
            try {
                const response = await fetch('/api/patrons');
                this.patrons = await response.json();
            } catch (error) {
                console.error('Error Fetching Patrons: ', error);
            }
        },
        toggleNewPatronModal() {
            this.newPatronModalShown = !this.newPatronModalShown
        },
    },
}
</script>

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
                <tr v-for="patron in patrons" :key="patron.id">
                    <td>
                        <router-link :to="{
                            name: 'patron-detail',
                            params: { id: patron.id }
                        }">
                            {{ patron.lastName }}
                        </router-link>
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
        <!-- <div class="patronList"> -->
        <!--     <div class="listItem" v-for="patron in patrons" :key="patron.id"> -->
        <!--         <strong>{{ patron.name }}</strong> -->
        <!--         <div>card number: {{ patron.card_number }}</div> -->
        <!--         <div>Email: {{ patron.email }}</div> -->
        <!--     </div> -->
        <!-- </div> -->
        <Modal :closeModal="toggleNewPatronModal" :modalShown="newPatronModalShown">
            <CreatePatronView />
        </Modal>
    </div>
</template>

<style>
.patronListContainer {
    width: 100%;
}

.patronList {
    width: 100%
}

.patronHeaderBox {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 4px;
}
</style>
