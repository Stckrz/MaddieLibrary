<template>
    <div class="bookDetailContainer">
        <h1>Book detail page for {{ book.title }}</h1>
        <div class="flex flex-col md:flex-row md:w-1/2 w-full justify-between items-center my-4 px-4 md:px-0 gap-2 md:gap-0">
            <div class="md:mx-4 w-full flex items-center justify-center">
                <img class="object-fill" :src="coverUrl" />
            </div>
            <div class="flex flex-col gap-2 justify-center items-start md:mx-4 p-2 border w-full">
                <div v-if="!isEditing">
                    Title: {{ book.title }}
                </div>
                <div class="md:w-1/2 w-full flex justify-between" v-else>
                    Title:
                    <input class="w-3/4" type="text" placeholder={{form.title}} v-model="form.title" />
                </div>

                <div v-if="!isEditing">
                    Author: {{ book.author }}
                </div>
                <div class="md:w-1/2 flex justify-between" v-else>
                    Author:
                    <input class="w-3/4" type="text" v-model="form.author" />
                </div>

                <div v-if="!isEditing">
                    Published: {{ book.published_date }}
                </div>
                <div class="md:w-1/2 flex justify-between" v-else>
                    Published:
                    <input class="w-3/4" type="date" v-model="form.published_date" />
                </div>

                <div v-if="!isEditing">
                    Synopsis: {{ book.synopsis }}
                </div>
                <div class="md:w-1/2 flex justify-between" v-else>
                    Synopsis:
                    <textarea class="w-3/4 overflow-hidden" type="text" v-model="form.synopsis" />
                </div>
                <div className="flex gap-2">
                    <button v-on:click="editHandler">
                        {{ !isEditing ? "Edit" : "Cancel" }}
                    </button>
                    <button v-if="isEditing" v-on:click="editBook">Submit</button>
                </div>
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
                const response = await fetch(`/api/books/${this.book.id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form),
                });

                if (!response.ok) {
                    throw new Error('Failed to create book');
                }

                const data = await response.json();
                console.log(data.message);
                this.form = { ...data.data };
                this.fetchBook(this.id)
                this.isEditing = false;
                // Clear the form
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
