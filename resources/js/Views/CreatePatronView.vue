<script lang="ts" setup>
import { useToastStore } from '../Stores/toastStore';
import { ref } from 'vue';

const form = ref(
    {
        lastName: '',
        firstName: '',
        card_number: '',
        email: '',
    }
)
const toastStore = useToastStore();

const createToast = (message: string, status: string) => {
    toastStore.addToast(message, status);
};

const createPatron = async () => {
    try {
        const response = await fetch('/api/patrons', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(form.value),
        });

        if (!response.ok) {
            throw new Error('Failed to create patron');
        }

        // Clear the form
        form.value = {
            lastName: '',
            firstName: '',
            card_number: '',
            email: '',
        };
    } catch (error) {
        console.error('Error creating patron:', error);
        createToast("Unable to create patron", "error");
    }
}
</script>
<template>
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
</template>

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
