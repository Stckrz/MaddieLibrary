<script lang="ts" setup>
import { useToastStore } from '../Stores/toastStore';
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';

defineOptions({
    name: 'PatronDetailView',
})
const route = useRoute();
const id = route.params.id as string;

const toastStore = useToastStore();
const patron = ref<any>({});
const isEditing = ref(false);
const form = ref({
    lastName: '',
    firstName: '',
    card_number: '',
    email: '',
})

const createToast = (message: string, status: string) => {
    toastStore.addToast(message, status);
};


const fetchPatron = async (patronId: string) => {
    try {
        const response = await fetch(`/api/patrons/${patronId}`)
        const patronData = await response.json();
        patron.value = patronData;
        form.value.lastName = patronData.lastName;
        form.value.firstName = patronData.firstName;
        form.value.card_number = patronData.card_number;
        form.value.email = patronData.email;
    } catch (error) {
        console.error('Error Fetching patron: ', error);
    }
}
const editPatron = async () => {
    try {
        const response = await fetch(`/api/patrons/${patron.value.id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(form.value),
        });
        const data = await response.json();
        if (!response.ok) {

            throw new Error(data.message);

        }
        form.value = { ...data.data };
        fetchPatron(id)
        isEditing.value = false;
        // Clear the form
    } catch (error: any) {
        if(error.message){
        createToast(error.message, "error");
        }
        console.error('Error editing patron:', error);
    }
}
const editHandler = () => {
    isEditing.value = !isEditing.value
}
onMounted(() => {
    fetchPatron(id);
})

</script>
<template>
    <div class="bookDetailContainer">
        <h1>Patron detail page for {{ patron.firstName }} {{ patron.lastName }}</h1>
        <div
            class="flex flex-col md:flex-row w-full justify-between items-center my-4 px-4 md:px-0 gap-2 md:gap-0">
            <div class="flex flex-col gap-2 justify-center items-start md:mx-4 p-2 border w-full">
                <div v-if="!isEditing">
                    Last Name: {{ patron.lastName }}
                </div>
                <div class="w-full flex justify-between" v-else>
                    Last Name:
                    <input class="w-full" type="text" placeholder={{form.lastName}} v-model="form.lastName" />
                </div>
                <div v-if="!isEditing">
                    First Name: {{ patron.firstName }}
                </div>
                <div class="w-full flex justify-between" v-else>
                    Last Name:
                    <input class="w-full" type="text" placeholder={{form.firstName}} v-model="form.firstName" />
                </div>

                <div v-if="!isEditing">
                    Card_number: {{ patron.card_number }}
                </div>
                <div class="md:w-full flex justify-between" v-else>
                    Card_number:
                    <input class="w-full" type="text" v-model="form.card_number" />
                </div>

                <div v-if="!isEditing">
                    Email: {{ patron.email }}
                </div>
                <div class="md:w-full flex justify-between" v-else>
                    Email:
                    <input class="w-full" type="email" v-model="form.email" />
                </div>

                <div className="flex gap-2">
                    <button v-on:click="editHandler">
                        {{ !isEditing ? "Edit" : "Cancel" }}
                    </button>
                    <button v-if="isEditing" v-on:click="editPatron">Submit</button>
                </div>
            </div>
        </div>
    </div>

</template>
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
