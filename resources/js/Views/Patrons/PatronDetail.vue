<script lang="ts" setup>
import { useToastStore } from '../../Stores/toastStore';
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import { Patron } from '../../models/patrons/patronModel';

defineOptions({
    name: 'PatronDetailView',
})
const route = useRoute();
const id = route.params.id as string;

const toastStore = useToastStore();
const patron = ref<Patron | null>(null);
const isEditing = ref(false);
const form = ref({
    lastName: '',
    firstName: '',
    card_number: '',
    email: '',
})

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
        const response = await fetch(`/api/patrons/${patron?.value?.id}`, {
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
        toastStore.addToast(error.message, "error");
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
    <div v-if="patron" class="bookDetailContainer">
        <h1>Patron detail page for {{ patron.firstName }} {{ patron.lastName }}</h1>
            <div class="patronTableContainer">
                <div v-if="!isEditing">
                    Last Name: {{ patron.lastName }}
                </div>
                <div class="detailInputItem" v-else>
                    <div class="patronFormLabel">Last Name:</div>
                    <input class="patronFormInput" type="text" placeholder={{form.lastName}} v-model="form.lastName" />
                </div>
                <div v-if="!isEditing">
                    First Name: {{ patron.firstName }}
                </div>
                <div class="detailInputItem" v-else>
                    <div class="patronFormLabel">Last Name:</div>
                    <input class="patronFormInput" type="text" placeholder={{form.firstName}} v-model="form.firstName" />
                </div>

                <div v-if="!isEditing">
                    Card_number: {{ patron.card_number }}
                </div>
                <div class="detailInputItem" v-else>
                <div class="patronFormLabel">Card_number:</div>
                    <input class="patronFormInput" type="text" v-model="form.card_number" />
                </div>

                <div v-if="!isEditing">
                    Email: {{ patron.email }}
                </div>
                <div class="detailInputItem" v-else>
                    <div class="patronFormLabel">Email:</div>
                    <input class="patronFormInput" type="email" v-model="form.email" />
                </div>

                <div className="patronFormButtonBox">
                    <button v-on:click="editHandler">
                        {{ !isEditing ? "Edit" : "Cancel" }}
                    </button>
                    <button v-if="isEditing" v-on:click="editPatron">Submit</button>
                </div>
            </div>
    </div>

</template>
<style scoped>
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

.detailInputItem{
    width: 100%;
    display: flex;
    justify-content: space-between;
}

.patronTableContainer{
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    justify-content: flex-start;
    align-items: flex-start;
    border: 1px solid gray;
    margin-top: 1rem;
    margin-bottom: 1rem;
    padding: 0.5rem;
}
.patronFormInput{
    flex-grow: 1;
}
.patronFormLabel{
    width: 16%;
}
.patronFormButtonBox{
    display: flex;
    gap: 0.5rem;
}
</style>
