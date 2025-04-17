<script lang="ts" setup>
import { useUserInfo } from '../../Composables/useUserInfo';
import { createPatron } from '../../Lib/Api/Patron/PatronApi';
import { PatronForm } from '../../models/patrons/patronModel';
import { useToastStore } from '../../Stores/toastStore';
import { ref } from 'vue';
const {userInfo} = useUserInfo();
const form = ref<PatronForm>(
    {
        lastName: '',
        firstName: '',
        card_number: '',
        email: '',
    }
)
const toastStore = useToastStore();

const createPatronHandler = async () => {
    if(!userInfo.value?.token){
        toastStore.addToast("Unauthorized", "error");
        return;
    }
    try {
        await createPatron(form.value, userInfo.value?.token)

        // Clear the form
        form.value = {
            lastName: '',
            firstName: '',
            card_number: '',
            email: '',
        };
    } catch (error) {
        console.error('Error creating patron:', error);
        toastStore.addToast("Unable to create patron", "error");
    }
}
</script>
<template>
    <h2>Add New Patron</h2>
    <form class="newBookForm h-full justify-between" @submit.prevent="createPatronHandler">
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
