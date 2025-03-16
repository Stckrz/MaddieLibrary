<template>
    <div class="bookFormWrapper mt-3 lg:w-1/2 w-1/4">
        <h2>Add New Patron</h2>
        <form class="newBookForm h-full justify-between" @submit.prevent="createPatron">
            <div class="form-group">
                <label class="form-label">Last Name:</label>
                <input class="form-input" v-model="form.lastName" type="text" required />
            </div>
            <div class="form-group">
                <label class="form-label">First Name:</label>
                <input class="form-input" v-model="form.firstName" type="text" required />
            </div>
            <div class="form-group">
                <label class="form-label">Card Number:</label>
                <input class="form-input" v-model="form.card_number" type="text" />
            </div>
            <div class="form-group">
                <label class="form-label">Email:</label>
                <input class="form-input" v-model="form.email" type="email" />
            </div>
            <button class="w-1/3 self-center" type="submit">Create</button>
        </form>
    </div>
</template>

<script>
import toastMixin from '../Mixins/toastMixin.js';
export default {
    name: 'CreatePatronView',
    mixins: [
        toastMixin
    ],
    data() {
        return {
            form: {
                lastName: '',
                firstName: '',
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

                // Clear the form
                this.form = {
                    lastName: '',
                    firstName: '',
                    card_number: '',
                    email: '',
                };
            } catch (error) {
                console.error('Error creating patron:', error);
                this.addToast("Unable to create patron", "error");
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
