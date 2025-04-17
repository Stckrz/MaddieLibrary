<script lang="ts" setup>
import { useUserInfo } from '../../Composables/useUserInfo.js';
import { editDistributable } from '../../Lib/Api/Distributables/distributableApi.js';
import { Distributable, FormFields } from '../../models/distributables/distributable.js';
import { useToastStore } from '../../Stores/toastStore';
import { ref, watch } from 'vue';

const toastStore = useToastStore();
const {userInfo} = useUserInfo();
defineOptions({
    name: 'EditDistributable'
});

const props = defineProps<{
    distributable: Distributable;
}>();

const distributableType = ref('');

const form = ref<FormFields>({
    title: null,
    author: null,
    artist: null,
    synopsis: null,
    img_url: null,
    thumbnail: null,
    platform: null,
    studio: null,
    published_date: null,
    release_date: null,
    isbn: null,
});

const populateForm = () => {
    distributableType.value = props.distributable.type;
    form.value = {
        title: props.distributable.title,
        synopsis: props.distributable.synopsis,
        author: props.distributable.type === "Book" ? props.distributable.author : null,
        published_date: props.distributable.type === "Book" ? props.distributable.published_date : null,
        isbn: props.distributable.type === "Book" ? props.distributable.isbn : null,
        platform: (props.distributable.type === "Game") ? props.distributable.platform : null,
        studio: null,
        img_url: props.distributable.img_url,
        thumbnail: props.distributable.thumbnail,
        release_date: props.distributable.type === "Game" || props.distributable.type === "Cd" || props.distributable.type === "Movie" ? props.distributable.release_date : null,
        artist: props.distributable.type === "Cd" ? props.distributable.artist : null,
    };
};

const editDistributableHandler = async () => {
    if(props.distributable.id && userInfo.value?.token){
        let distributableInputType = "";
        switch (distributableType.value) {
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
            case "Show":
                distributableInputType = 'shows';
                break;
        }
        try{
            editDistributable(distributableInputType, props.distributable?.id, userInfo.value?.token, form.value)
        } catch (error) {
            console.error('Error editing distributable:', error);
            toastStore.addToast("Unable to edit distributable", "error");
        }
    }
};

watch(() => props.distributable, (newVal) => {
    if (newVal) {
        populateForm();
    }
}, { immediate: true });
</script>

<template>
    <div class="form-group">
        <label for="distributableType" class="form-label">Type
            <div id="distributableType">{{ distributable?.type }}</div>
        </label>
    </div>
    <form class="newDistributableForm" @submit.prevent="editDistributableHandler">
        <div class="fieldContainer">
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input id="title" name="title" v-model="form.title" type="text" aria-required="true" class="form-input"
                    required />
            </div>
        </div>
        <div v-if="distributableType === 'Book'" class="fieldContainer">
            <div class="form-group">
                <label for="isbn" class="form-label">ISBN</label>
                <input id="isbn" name="isbn" v-model="form.isbn" type="text" aria-required="true" class="form-input"
                    required />
            </div>
            <div class="form-group">
                <label for="author" class="form-label">Author</label>
                <input id="author" name="author" v-model="form.author" type="text" aria-required="true"
                    class="form-input" required />
            </div>
            <div class="form-group">
                <label for="published_date" class="form-label">Published Date</label>
                <input id="published_date" name="published_date" v-model="form.published_date" type="date"
                    aria-required="true" class="form-input" required />
            </div>
        </div>
        <div v-if="distributableType === 'Cd'" class="fieldContainer">
            <div class="form-group">
                <label for="artist" class="form-label">Artist</label>
                <input id="artist" name="artist" v-model="form.artist" type="text" aria-required="true"
                    class="form-input" required />
            </div>
            <div class="form-group">
                <label for="release_date" class="form-label">Release Date</label>
                <input id="release_date" name="release_date" v-model="form.release_date" type="date"
                    aria-required="true" class="form-input" />
            </div>
        </div>
        <div v-if="distributableType === 'Game'" class="fieldContainer">
            <div class="form-group">
                <label for="platform" class="form-label">Platform</label>
                <input id="platform" name="platform" v-model="form.platform" type="text" aria-required="true"
                    class="form-input" required />
            </div>
            <div class="form-group">
                <label for="release_date" class="form-label">Release Date</label>
                <input id="release_date" name="release_date" v-model="form.release_date" type="date"
                    aria-required="true" class="form-input" />
            </div>
        </div>
        <div v-if="distributableType === 'Movie'" class="fieldContainer">
            <div class="form-group">
                <label for="release_date" class="form-label">Release Date</label>
                <input id="release_date" name="release_date" v-model="form.release_date" type="date"
                    aria-required="true" class="form-input" />
            </div>
        </div>
        <div v-if="distributableType === 'Show'" class="fieldContainer">
            <div class="form-group">
                <label for="release_date" class="form-label">Release Date</label>
                <input id="release_date" name="release_date" v-model="form.release_date" type="date"
                    aria-required="true" class="form-input" />
            </div>
        </div>

            <div class="form-group">
                <label for="img_url" class="form-label">img_url
                </label>
                <input id="img_url" name="img_url" v-model="form.img_url" type="text" aria-required="true"
                    class="form-input" />
            </div>
            <div class="form-group">
                <label for="thumbnail" class="form-label">thumbnail
                </label>
                <input id="thumbnail" name="thumbnail" v-model="form.thumbnail" type="text" aria-required="true"
                    class="form-input" />
            </div>
            <div class="form-group">
                <label for="synopsis" class="form-label">Synopsis
                </label>
                <textarea id="synopsis" name="synopsis" v-model="form.synopsis" type="text" aria-required="true"
                    class="form-input" />
            </div>
        <button type="submit">Submit</button>
    </form>
</template>
<style scoped>
.newDistributableForm {
    margin: 4px;
}

.selectType {
    width: 100%;
}

select {
    width: 100%;
    padding: 4px;
    margin: 4px;
    border-radius: 0.2em
}
</style>
