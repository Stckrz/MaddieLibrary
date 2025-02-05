<template>
    <div class="bookDetailContainer">
        <h1>Book detail page for {{ book.title }}</h1>
        <div class="flex w-1/2 justify-between my-2">
            <img :src="coverUrl" />
            <div class="flex flex-col gap-1 justify-center items-start">
                <div v-if="!isEditing">
                    Title: {{ book.title }}
                </div>
                <div v-else>
                    Title:
                    <input type="text" placeholder={{form.title}} v-model="form.title" />
                </div>

                <div v-if="!isEditing">
                    Author: {{ book.author }}
                </div>
                <div v-else>
                    Author:
                    <input type="text" v-model="form.author" />
                </div>

                <div v-if="!isEditing">
                    Published: {{ book.published_date }}
                </div>
                <div v-else>
                    Published:
                    <input type="date" v-model="form.published_date" />
                </div>

                <div v-if="!isEditing">
                    Synopsis: {{ book.synopsis }}
                </div>
                <div v-else>
                    Synopsis:
                    <input type="text" v-model="form.synopsis" />
                </div>

                <button v-on:click="editHandler">
                    {{ !isEditing ? "Edit" : "Cancel" }}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'BookDetailView',
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            book: {},
            coverUrl: '',
            isEditing: false,
            form: {
                title: '',
                author: '',
                published_date: '',
                synopsis: '',
                isbn: '',
                checked_in: true,
            }
        }
    },
    methods: {
        async fetchBook(id) {
            try {
                const response = await fetch(`/api/books/${this.id}`)
                this.book = await response.json();
                console.log(this.book)
                if (this.book.isbn) {
                    this.coverUrl = `https://covers.openlibrary.org/b/isbn/${this.book.isbn}-M.jpg`
                }
                this.form.title = this.book.title;
                this.form.author = this.book.author;
                this.form.published_date = this.book.published_date;
                this.form.synopsis = this.book.synopsis;
                this.form.isbn = this.book.isbn;
                this.form.checked_in = this.book.checked_in;
            } catch (error) {
                console.error('Error Fetching Book: ', error);
            }
        },
        editHandler() {
            this.isEditing = !this.isEditing
        },
        async editBook() {
            try {
                const response = await fetch('/api/books', {
                    method: 'PUT',
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
                    isbn: '',
                    checked_in: true,
                };
            } catch (error) {
                console.error('Error creating book:', error);
            }
        },
    },
    mounted() {
        this.fetchBook(this.id);
    }
}
</script>
<style>
h1 {
    font-size: 24px;
}

.bookDetailContainer {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    height: 100%;
    border: 1px solid gray;
}
</style>
