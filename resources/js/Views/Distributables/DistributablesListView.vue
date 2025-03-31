<script lang="ts" setup>
import Modal from '../../Components/Modal/Modal.vue';
import CreateDistributableView from '../Distributables/CreateDistributableView.vue';
import { FaSort } from 'vue3-icons/fa';
import { ref, watch, onMounted } from 'vue';
import { Distributable } from '../../models/distributables/distributable';

defineOptions({
    name: "DistributablesListView"
})

const distributables = ref<Distributable[]>([]);
const newBookModalShown = ref(false)
const sortAsc = ref('asc')
const sortCategory = ref("distributables")

onMounted(() => {
    fetchDistributables();
})

const fetchDistributables = async () => {
    try {
        const response = await fetch(`/api/${sortCategory.value}`);
        distributables.value = await response.json();
    } catch (error) {
        console.error('Error Fetching Distributables: ', error);
    }
}

const toggleNewBookModal = () => {
    newBookModalShown.value = !newBookModalShown.value
}

const sortDistributables = async (sortBy: string) => {
    try {
        const response = await fetch(`/api/${sortCategory.value}?sort_by=${sortBy}&sort_order=${sortAsc.value}`);
        distributables.value = await response.json();
        sortAsc.value = sortAsc.value === 'asc' ? 'desc' : 'asc';
    } catch (error) {
        console.error('Error Fetching Distributables: ', error);
    }
};

watch(sortCategory, () => {
    fetchDistributables();
});
</script>

<template>
    <div class="distributablesListContainer">
        <div class="sidebar">
            <div class="sort-wrapper">
                <label for="Distributables" class="sortItem">
                    <input id="Distributables" type="radio" name="sort_category" value="distributables"
                        v-model="sortCategory" />
                    All
                </label>
                <label for="Games" class="sortItem">
                    <input id="Games" type="radio" name="sort_category" value="games" v-model="sortCategory" />
                    Games
                </label>
                <label for="Books" class="sortItem">
                    <input id="Books" type="radio" name="sort_category" value="books" v-model="sortCategory" />
                    Books
                </label>
                <label for="Cds" class="sortItem">
                    <input id="Cds" type="radio" name="sort_category" value="cds" v-model="sortCategory" />
                    Cds
                </label>
                <label for="Movies" class="sortItem">
                    <input id="Movies" type="radio" name="sort_category" value="movies" v-model="sortCategory" />
                    Movies
                </label>
            </div>
            <button v-on:click="toggleNewBookModal">New</button>
        </div>
        <div class="tableSectionWrapper">
            <div class="bookListHeaderContainer">
                <h1>Distributables</h1>
            </div>
            <table class="bookTable">
                <thead>
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
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="distributable in distributables"
                        :key="distributable.id"
                        class="tableListItem"
                        :to="{
                            name: 'distributable-detail',
                            params: { id: distributable.id }
                        }"
                        @click="$router.push({
                            name: 'distributable-detail',
                            params: { id: distributable.id }
                        })"
                    >
                        <td>
                            {{ distributable.type }}
                        </td>
                        <td>
                            {{ distributable.title }}
                        </td>
                        <td v-if="distributable.type === 'Book' && distributable.published_date">
                            {{ new Date(distributable.published_date).toLocaleDateString() }}
                        </td>
                        <td v-if="(
                            distributable.type === 'Cd'
                                || distributable.type === 'Game'
                                || distributable.type === 'Movie'
                            ) && distributable.release_date">
                            {{ new Date(distributable.release_date).toLocaleDateString() }}
                        </td>
                        <td :class="distributable.checked_in ? 'checkedIn' : 'checkedOut'">
                            {{distributable.checked_in ? 'Yes' : 'No'}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <Modal :closeModal="toggleNewBookModal" :modalShown="newBookModalShown">
                <CreateDistributableView />
            </Modal>
        </div>
    </div>
</template>

<style scoped>
thead, th{
    position: sticky;
    background-color: var(--main-bg-color);
    top: 0;
}

table{
    border-collapse: collapse;
}

.tableSectionWrapper {
    width: 80%;
    height: 100%;
    position: relative;
    overflow-y: auto;
}

.sidebar {
    border-radius: 0.5rem;
    border: 1px solid white;
    margin-right: 8px;
    height: 100%;
    width: 20%;
    padding: 4px;
}

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
    display: flex;
    width: 100%;
    height: 100%;
    margin: 4px;
    flex-direction: row;
    align-items: flex-start;
    justify-content: center;
}


.sort-wrapper {
    display: flex;
    flex-direction: column;
}

.sortItem {
    cursor: pointer;
}

@media only screen and (max-width: 600px) {
    .sidebar{
        margin: 0;
        position: absolute;
        bottom: 0;
        height: 20%;
        width: 100%;
    }
}
</style>
