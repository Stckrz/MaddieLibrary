<template>
    <div class="bookFormWrapper mt-3 lg:w-1/2 w-1/4">
        <h2>Add New Patron</h2>
        <form class="newBookForm h-full justify-between" @submit.prevent="createPatron">
            <div class="flex formElement w-full">
                <label class="">Name:</label>
                <input class="flex w-3/4" v-model="form.name" type="text" required />
            </div>
            <div class="formElement">
                <label>Card Number:</label>
                <input class="w-3/4" v-model="form.card_number" type="text" />
            </div>
            <div class="formElement">
                <label>Email:</label>
                <input class="w-3/4" v-model="form.email" type="email" />
            </div>
            <button
                class="w-1/3 self-center"
                type="submit">Create</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'CreatePatronView',
    data() {
        return {
            form: {
                name: '',
                card_number: '',
                email: '',
            }
        };
    },
    methods: {
        async createPatron() {
            try {
                const response = await fetch('/api/patrons', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form),
                });

                if (!response.ok) {
                    throw new Error('Failed to create patron');
                }

                const data = await response.json();
                console.log(data.message);

                // Clear the form
                this.form = {
                    name: '',
                    card_number: '',
                    email: '',
                };
            } catch (error) {
                console.error('Error creating patron:', error);
            }
        },
    },
}
</script>
<style>
.patronFormWrapper {
    display: flex;
    flex-direction: column;
    width: 30%;
    justify-content: center;
    padding: 10px;
    border: 1px solid gray;
}
</style>
