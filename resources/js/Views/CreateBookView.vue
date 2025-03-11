<template>
    <div class="bookFormWrapper mt-3 lg:w-1/2 w-1/4">
        <h2>Add New Book</h2>
        <form class="newBookForm h-full justify-between" @submit.prevent="createBook">
            <div class="flex formElement w-full">
                <label class="">Title:</label>
                <input class="flex w-3/4" v-model="form.title" type="text" required />
            </div>
            <div class="formElement">
                <label>Author:</label>
                <input class="w-3/4" v-model="form.author" type="text" />
            </div>
            <div class="formElement">
                <label>Published date:</label>
                <input class="w-3/4" v-model="form.published_date" type="date" />
            </div>
            <div class="formElement">
                <label>Synopsis:</label>
                <textarea class="w-3/4" v-model="form.synopsis"></textarea>
            </div>
            <div class="formElement">
                <label>Isbn:</label>
                <input class="w-3/4" v-model="form.isbn"></input>
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
    background-color: #111111;
    display: flex;
    flex-direction: column;
    width: 100%;
    justify-content: center;
    padding: 10px;
    border: 1px solid gray;
}
</style>
