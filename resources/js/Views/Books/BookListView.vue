<script>
import Modal from '../../Components/Modal/Modal.vue';
import CreateBookView from '../CreateBookView.vue';
export default {
    name: "BookListView",
    components: {
        Modal,
        CreateBookView,
    },

    data() {
        return {
            books: [],
            newBookModalShown: false,
            selectedBook: 0,
        };
    },
    mounted() {
        this.fetchBooks();
    },
    methods: {
        async fetchBooks() {
            try {
                const response = await fetch('/api/books');
                this.books = await response.json();
            } catch (error) {
                console.error('Error Fetching Books: ', error);
            }
        },
        toggleNewBookModal() {
            this.newBookModalShown = !this.newBookModalShown
        },
    },
}
</script>

<template>
    <div class="bookListContainer">
        <div class="bookListHeaderContainer">
            <h1>Books</h1>
            <button v-on:click="toggleNewBookModal">New Book</button>
        </div>
        <table className="bookTable">
            <tbody>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published</th>
                </tr>
                <tr v-for="book in books" :key="book.id">
                    <td>
                        {{ book.id }}
                    </td>
                    <td>
                        <router-link :to="{
                            name: 'book-detail',
                            params: { id: book.id }
                        }">
                            {{ book.title }}
                        </router-link>
                    </td>
                    <td>
                        {{ book.author }}
                    </td>
                    <td>
                        {{ book.published_date }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <Modal :closeModal="toggleNewBookModal" :modalShown="newBookModalShown">
                <CreateBookView />
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
</style>
