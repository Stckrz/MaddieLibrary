<script>
export default {
    name: 'HomeView',
    data() {
        return {
            books: [],
            form: {
                title: '',
                author: '',
                published_date: '',
                synopsis: '',
            }
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
        async createBook() {
            try {
                const response = await fetch('/api/books', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form),
                });

                if (!response.ok) {
                    throw new Error('Failed to create book');
                }

                const data = await response.json();
                console.log(data.message);

                // Clear the form
                this.form = {
                    title: '',
                    author: '',
                    published_date: '',
                    synopsis: '',
                };

                // Re-fetch the books to update the list
                this.fetchBooks();
            } catch (error) {
                console.error('Error creating book:', error);
            }
        },
    },
}
</script>

<template>
    <div>
        <div className="bookListContainer">
            <h1 class="color-red-950 m-1000">My Books</h1>
            <ul class="bookList">
                <li class="listItem" v-for="book in books" :key="book.id">
                    <router-link :to="{
                        name: 'book-detail',
                        params: { id: book.id }
                    }">
                        <strong>{{ book.title }}</strong>
                        by {{ book.author }}
                        (Published {{ book.published_date }})
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
