<template>
    <div class="bookFormWrapper mt-3 md:w-1/2 lg:w-1/2 w-11/12">
        <h2>Add New Book</h2>
        <form class="newBookForm" @submit.prevent="createBook">
            <div class="formElement">
                <label>Title:</label>
                <input v-model="form.title" type="text" required />
            </div>
            <div class="formElement">
                <label>Author:</label>
                <input v-model="form.author" type="text" />
            </div>
            <div class="formElement">
                <label>Published date:</label>
                <input v-model="form.published_date" type="date" />
            </div>
            <div class="formElement">
                <label>Synopsis:</label>
                <textarea v-model="form.synopsis"></textarea>
            </div>
            <div class="formElement">
                <label>Isbn:</label>
                <input v-model="form.isbn"></input>
            </div>
            <button
                class="w-1/3 self-center"
                type="submit">Create</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'CreateBookView',
    data() {
        return {
            form: {
                title: '',
                author: '',
                published_date: '',
                synopsis: '',
                isbn: '',
                checked_in: true,
            }
        };
    },
    methods: {
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
                    isbn: '',
                    checked_in: true,
                };
            } catch (error) {
                console.error('Error creating book:', error);
            }
        },
    },
}
</script>
<style>
.bookFormWrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 10px;
    border: 1px solid gray;
}
</style>
