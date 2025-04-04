<script lang="ts" setup>
import Modal from '../../Components/Modal/Modal.vue';
import CreateDistributableView from '../Distributables/CreateDistributableView.vue';
import Pagination from '../../Components/Pagination/Pagination.vue';
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
const sortBy = ref("")
const currentPage = ref<number>(1);

onMounted(() => {
    fetchDistributables();
})

const fetchDistributables = async () => {
    const offset = (currentPage.value - 1) * 10;
    let url = `/api/${sortCategory.value}?offset=${offset}`;
    if(sortBy.value){
        url += `&sort_by=${sortBy.value}&sort_order=${sortAsc.value}`;
    }
    try {
        const response = await fetch(url);
        distributables.value = await response.json();
    } catch (error) {
        console.error('Error Fetching Distributables: ', error);
    }
}

const toggleNewBookModal = () => {
    newBookModalShown.value = !newBookModalShown.value
}

//handles the change for values which affect sorting
const sortDistributables = async (newSortBy: string) => {
      if (sortBy.value === newSortBy) {
        // Toggle sort order if the same column is clicked
        sortAsc.value = sortAsc.value === 'asc' ? 'desc' : 'asc';
      } else {
        // Set a new sort column and reset to ascending
        sortBy.value = newSortBy;
        sortAsc.value = 'asc';
      }
      currentPage.value = 1; // Optionally reset page if sorting changes
      fetchDistributables();
};

const updateCurrentPage = (page: number) => {
    currentPage.value = page;
}

watch([sortCategory, currentPage], () => {
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
                        <td v-if="(
                            distributable.type === 'Cd'
                                || distributable.type === 'Game'
                                || distributable.type === 'Movie'
                            ) && !distributable.release_date">
                            No date found
                        </td>
                        <td :class="distributable.checked_in ? 'checkedIn' : 'checkedOut'">
                            {{distributable.checked_in ? 'Yes' : 'No'}}
                        </td>
                    </tr>
                </tbody>
            </table>
        <Pagination :callback="updateCurrentPage" :pageNumber="currentPage"/>
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
    width: 100%;
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
    background-color: var(--main-bg-color);
z-index: 9;
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
    background-color: var(--main-bg-color);
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
