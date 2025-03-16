<script>
import Modal from '../../Components/Modal/Modal.vue';
import CreateBookView from '../CreateBookView.vue';
import CreateDistributableView from '../Distributables/CreateDistributableView.vue';
export default {
    name: "DistributablesListView",
    components: {
        Modal,
        CreateBookView,
        CreateDistributableView,
    },

    data() {
        return {
            distributables: [],
            newBookModalShown: false,
            selectedDistributable: 0,
        };
    },
    mounted() {
        this.fetchDistributables();
    },
    methods: {
        async fetchDistributables() {
            try {
                const response = await fetch('/api/distributables');
                this.distributables = await response.json();
                console.log(this.distributables)
            } catch (error) {
                console.error('Error Fetching Distributables: ', error);
            }
        },
        toggleNewBookModal() {
            this.newBookModalShown = !this.newBookModalShown
        },
    },
}
</script>

<template>
    <div class="distributablesListContainer">
        <div class="bookListHeaderContainer">
            <h1>Distributables</h1>
            <button v-on:click="toggleNewBookModal">New Distributable</button>
        </div>
        <table class="bookTable">
            <tbody>
                <tr>
                    <th>Id</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Published</th>
                </tr>
                <tr v-for="distributable in distributables" :key="distributable.id" class="tableListItem" :to="{
                    name: 'distributable-detail',
                    params: { id: distributable.id }
                }" @click="$router.push({ name: 'distributable-detail', params: { id: distributable.id } })">
                    <td>
                        {{ distributable.id }}
                    </td>
                    <td>
                        {{ distributable.type }}
                    </td>
                    <td>
                        {{ distributable.title }}
                    </td>
                    <td v-if="distributable.published_date">
                        {{ new Date(distributable.published_date).toLocaleDateString() }}
                    </td>
                    <td v-if="distributable.release_date">
                        {{ new Date(distributable.release_date).toLocaleDateString() }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <Modal :closeModal="toggleNewBookModal" :modalShown="newBookModalShown">
                <!-- <CreateBookView /> -->
                <CreateDistributableView :closeModal='toggleNewBookModal'/>
            </Modal>
        </div>
    </div>
</template>

<style scoped>
.bookTable {
    width: 100%;
}

.bookListHeaderContainer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 4px;
}

.distributablesListContainer {
    padding: 4px;
    display: flex;
    width: 100%;
    margin: 4px;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.tableListItem {
    border-radius: 50px;
}

.tableListItem:hover {
    background-color: gray;
    color: black;
}
</style>
