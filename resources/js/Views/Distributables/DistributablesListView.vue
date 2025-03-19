<script>
import Modal from '../../Components/Modal/Modal.vue';
import CreateBookView from '../CreateBookView.vue';
import CreateDistributableView from '../Distributables/CreateDistributableView.vue';
import { FaSort } from 'vue3-icons/fa';


export default {
    name: "DistributablesListView",
    components: {
        Modal,
        CreateBookView,
        CreateDistributableView,
        FaSort,

    },
    data() {
        return {
            distributables: [],
            newBookModalShown: false,
            selectedDistributable: 0,
            sortAsc: 'asc',
            sortCategory: "distributables",
        };
    },
    mounted() {
        this.fetchDistributables();
    },

    watch: {
        sortCategory(newType, oldType) {
            this.fetchDistributables()
        }
    },
    methods: {
        async fetchDistributables() {
            try {
                const response = await fetch(`/api/${this.sortCategory}`);
                this.distributables = await response.json();
            } catch (error) {
                console.error('Error Fetching Distributables: ', error);
            }
        },
        toggleNewBookModal() {
            this.newBookModalShown = !this.newBookModalShown
        },
        async sortDistributables(sortBy) {
            try {
                const response = await fetch(`/api/${this.sortCategory}?sort_by=${sortBy}&sort_order=${this.sortAsc}`);
                this.distributables = await response.json();
                this.sortAsc = this.sortAsc === 'asc' ? 'desc' : 'asc';
            } catch (error) {
                console.error('Error Fetching Distributables: ', error);
            }
        },
    },

}
</script>

<template>
    <div class="distributablesListContainer">
        <div class="bookListHeaderContainer">
            <h1>Distributables</h1>
            <div class="sort-wrapper">
                <label for="Distributables">
                    <input id="Distributables" type="radio" name="sort_category" value="distributables" v-model="sortCategory"/>
                    All
                </label>
                <label for="Games">
                    <input id="Games" type="radio" name="sort_category" value="games" v-model="sortCategory"/>
                    Games
                </label>
                <label for="Books">
                    <input id="Books" type="radio" name="sort_category" value="books" v-model="sortCategory"/>
                    Books
                </label>
                <label for="Cds">
                    <input id="Cds" type="radio" name="sort_category" value="cds" v-model="sortCategory"/>
                    Cds
                </label>
            </div>
            <button v-on:click="toggleNewBookModal">New Distributable</button>
        </div>
        <table class="bookTable">
            <tbody>
                <tr>
                    <th v-on:click="sortDistributables('type')">
                        <div class="tableHeaderContainer">
                            <div class="h-full flex items-center justify-center">Type</div>
                            <FaSort class="self-start" size="1em" />
                        </div>
                    </th>
                    <th v-on:click="sortDistributables('title')">

                        <div class="tableHeaderContainer">
                            <div class="h-full flex items-center justify-center">Title</div>
                            <FaSort class="self-start" size="1em" />
                        </div>
                    </th>
                    <th>Published</th>
                </tr>
                <tr v-for="distributable in distributables" :key="distributable.id" class="tableListItem" :to="{
                    name: 'distributable-detail',
                    params: { id: distributable.id }
                }" @click="$router.push({ name: 'distributable-detail', params: { id: distributable.id } })">
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
                <!-- <CreateDistributableView /> -->
                <CreateDistributableView :closeModal='toggleNewBookModal' />
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

.tableHeaderContainer {
    display: flex;
    align-items: flex-center;
    cursor: pointer;
}

.sort-wrapper{
    display: flex;
    gap: 20px;

}
</style>
