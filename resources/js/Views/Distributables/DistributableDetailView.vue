<script lang="ts" setup>
import ConfirmationBox from '../../Components/ConfirmationBox/ConfirmationBox.vue';
import Modal from '../../Components/Modal/Modal.vue';
import EditDistributable from './EditDistributableView.vue';
import { useToastStore } from '../../Stores/toastStore';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { Distributable } from '../../models/distributables/distributable';
import { useCartStore } from '../../Stores/cartStore';
import { storeToRefs } from 'pinia';

const cartStore = useCartStore();
const { cartState } = storeToRefs(cartStore);

const toastStore = useToastStore();
defineOptions({
    name: 'DistributableDetailView'
})

const props = defineProps<{ id: string }>();
const router = useRouter();
const distributable = ref<Distributable | null>(null);
const isEditing = ref(false);
const dialogueShown = ref(false);

onMounted(() => {
    fetchDistributable(props.id);
})

const fetchDistributable = async (id: string) => {
    try {
        const response = await fetch(`/api/distributables/${id}`)
        const data = await response.json();
        console.log(data)
        distributable.value = data;
    } catch (error) {
        console.error('Error Fetching Distributable: ', error);
    }
}

const deleteDistributable = async () => {
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
        case "Movie":
            distributableInputType = 'movies';
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
const addToCart = () => {
    if(distributable.value){
        cartStore.addToCart(distributable.value)
    }
}
</script>

<template>
    <div class="distributableWrapper">
        <div class="contentContainer">
            <div v-if="distributable?.img_url" class="imageContainer"><img :src="distributable?.img_url" /></div>
            <div v-else class="imageContainer">No image</div>
            <div class="informationWrapper">
                Id:
                {{ id }}
                <div>
                    Title:
                    {{ distributable?.title }}
                </div>
                <div>
                    <span>Available: </span>
                    <span :class="distributable?.checked_in ? 'checkedIn' : 'checkedOut'" >
                        {{ distributable?.checked_in ? 'Yes' : 'No' }}
                    </span>
                </div>
                <div v-if="distributable?.type === 'Cd'">
                    <div>
                        Artist:
                        {{ distributable?.artist }}
                    </div>
                    <div>
                        Release Date:
                        {{ distributable?.release_date }}
                    </div>
                </div>
                <div v-if="distributable?.type === 'Game'">
                    <div>
                        Platform:
                        {{ distributable.platform }}
                    </div>
                    <div>
                        Release Date:
                        {{ distributable.release_date }}
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
                <div>
                    Synopsis:
                    {{ distributable?.synopsis }}
                </div>
            </div>
            </div>
        <div class="buttonBox">
            <button @click="toggleDialogue">Delete</button>
            <button @click="toggleEditModal">Edit</button>
            <button @click="addToCart" v-if="cartState.patron && distributable?.checked_in">Add</button>
        </div>
        <ConfirmationBox :callback="deleteDistributable" :dialogueShown="dialogueShown" :closeDialogue="toggleDialogue">
            <div>Really delete this?</div>
        </ConfirmationBox>
        <Modal v-if='distributable !== null' :modalShown="isEditing" :closeModal="toggleEditModal">
            <EditDistributable :distributable="distributable" />
        </Modal>
    </div>
</template>

<style scoped>
.distributableWrapper{
    align-self: flex-start;
    width: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid white;
}
.contentContainer{
    display: flex;
    padding: 4px;
}
.imageContainer{
    width: 20%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
}
.informationWrapper{
    width: 80%;
    display: flex;
    flex-direction: column;
    padding: 4px;
}
.buttonBox{
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}
</style>
