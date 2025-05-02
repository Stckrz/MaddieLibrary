<script lang="ts" setup>
import { useToastStore } from '../Stores/toastStore';
import {useMediaQuery} from '../Composables/useMediaQuery'
import ConfirmationBox from '../Components/ConfirmationBox/ConfirmationBox.vue';
import Modal from '../Components/Modal/Modal.vue';
import { ref } from 'vue';

const isMobile = useMediaQuery('(max-width: 600px)');
const toastStore = useToastStore();

const isEditing = ref(false);
const dialogueShown = ref(false);

const createToast = () => {
    toastStore.addToast("Hello I am a toast!", "success");
};
const toggleDialogue = () => {
    dialogueShown.value = !dialogueShown.value;
};
</script>

<template>
    <div class="homepageWrapper">
        <div class="contentBox">
            <h1>
                Welcome To The Library!
            </h1>
            <p class="explanation">
                This is a personal catalogue of all of the physical media that I own, and is intended to allow me to borrow it to friends and family and keep track of who has borrowed what and for how long. Adding items to my inventory is made very simple by utilizing multiple API's including Giantbomb, TVDB, Spotify, and Google Books to search and auto-fill form data. This project was created using Laravel and Vuejs, and the repository can be found here:
                <a href="https://github.com/Stckrz/MaddieLibrary">Github</a>
            </p>
        </div>
        <div class="demobox">
            <p>Oh! I also really wanted to be able to show off my modal and especially my toast, because I think they are cool, but there is really no place for you to see them if you are not authenticated.. So I made this little box where you can see them!</p>
            <div class="buttonBox">
                <button v-on:click="createToast">
                    Toast
                </button>
                <button v-on:click="toggleDialogue">
                    Modal
                </button>
            </div>

            <ConfirmationBox :callback="toggleDialogue" :dialogueShown="dialogueShown" :closeDialogue="toggleDialogue">
                <div>Are you sure about stuff?</div>
            </ConfirmationBox>
        </div>
    </div>
</template>

<style scoped>
    a{
        color: blueviolet;
    }

    .contentBox{
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .homepageWrapper{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        height: 100%;
    }

    .explanation{
        width: 80%;
    }

    .homeNavigationLinks {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .demobox{
        width: 80%;
        border: 4px solid grey;
        padding: 12px;
        border-radius: 0.25rem;
    }

    .buttonBox{
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: center;
    }
</style>
