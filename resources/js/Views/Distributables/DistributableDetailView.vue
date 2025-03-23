<script lang="ts" setup>
import ConfirmationBox from '../../Components/ConfirmationBox/ConfirmationBox.vue';
import Modal from '../../Components/Modal/Modal.vue';
import EditDistributable from './EditDistributableView.vue';
import { useToastStore } from '../../Stores/toastStore';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { Distributable } from '../../models/distributables/distributable';

const toastStore = useToastStore();
defineOptions({
    name: 'DistributableDetailView'
})

const props = defineProps<{ id: string }>();
const router = useRouter();
const distributable = ref<Distributable | null>(null);
const isEditing = ref(false);
const dialogueShown = ref(false);
const coverUrl = ref('');

onMounted(() => {
    fetchDistributable(props.id);
})

const fetchDistributable = async (id: string) => {
    try {
        const response = await fetch(`/api/distributables/${id}`)
        distributable.value = await response.json();
        // if (distributable?.isbn) {
        //     coverUrl.value = `https://covers.openlibrary.org/b/isbn/${distributable.value.isbn}-M.jpg`
        // }
    } catch (error) {
        console.error('Error Fetching Distributable: ', error);
    }
}

const deleteDistributable = async () => {
    console.log('ass', props.id)
    console.log(distributable.value)
    let distributableInputType = ""
    switch (distributable.value?.type) {
        case "Game":
            distributableInputType = 'games';
            break;
        case "Cd":
            distributableInputType = 'cds';
            break;
        case "Book":
            distributableInputType = 'books';
            break;
    }
    try {
        const response = await fetch(`/api/${distributableInputType}/${props.id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' }
        })
        if (!response.ok) {
            console.error('Unable to delete');
        }
        const data = await response.json();
        toastStore.addToast("Distributable successfully deleted", "success");
        router.push({ path: '/distributables' })
    } catch (error) {
        console.error('Error Deleting Distributable: ', error);
    }
}
const toggleDialogue = () => {
    dialogueShown.value = !dialogueShown.value;
}
const toggleEditModal = () => {
    isEditing.value = !isEditing.value;
}
</script>
<template>
    <div>
        Id:
        {{ id }}
        <div>
            Title:
            {{ distributable?.title }}
        </div>
        <div>
            Synopsis:
            {{ distributable?.synopsis }}
        </div>
        <div>
            Checked in:
            {{ distributable?.checked_in }}
        </div>
        <div v-if="distributable?.type === 'Cd'">
            <div>
                Artist:
                {{ distributable?.artist }}
            </div>
            <div>
                Release Date:
                {{ distributable?.released_date }}
            </div>
        </div>
        <div v-if="distributable?.type === 'Game'">
            <div>
                Studio:
                {{ distributable.studio }}
            </div>
            <div>
                Platform:
                {{ distributable.platform }}
            </div>
            <div>
                Release Date
                {{ distributable.released_date }}
            </div>
        </div>
        <div v-if="distributable?.type === 'Book'">
            <div>
                Author:
                {{ distributable.author }}
            </div>
            <div>
                Publication Date:
                {{ distributable.published_date }}
            </div>
            <div>
                ISBN:
                {{ distributable.isbn }}
            </div>
        </div>
        <button @click="toggleDialogue">Delete</button>
        <button @click="toggleEditModal">Edit</button>
        <ConfirmationBox :callback="deleteDistributable" :dialogueShown="dialogueShown" :closeDialogue="toggleDialogue">
            <div>Really delete this?</div>
        </ConfirmationBox>
        <Modal v-if='distributable !== null' :modalShown="isEditing" :closeModal="toggleEditModal">
            <EditDistributable :distributable="distributable" />

        </Modal>
    </div>

</template>
