<script lang="ts" setup>
import { useToastStore } from '../../Stores/toastStore';
import {ref, watch} from 'vue';
import DistributableSearch from './DistributableSearch.vue';
import { Distributable, FormFields } from '../../models/distributables/distributable';
import { createDistributable } from '../../Lib/Api/Distributables/distributableApi';
import { useUserInfo } from '../../Composables/useUserInfo';

const toastStore = useToastStore();
const {userInfo} = useUserInfo();
defineOptions({
    name: 'CreateDistributable',
});

const distributableType = ref("Book");
const gamePlatform = ref('PC');
const form = ref<FormFields>({
    title: '',
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

const createDistributableHandler = async() => {
    if(userInfo.value?.token){
        let distributableInputType = ""
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
        try {
            await createDistributable(distributableInputType, userInfo.value.token, form.value)

            // Clear the form
            form.value = {
                title: '',
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
            };
            toastStore.addToast("Distributable created successfully!", "success");
        } catch (error) {
            console.error('Error creating distributable:', error);
            toastStore.addToast("Unable to create distributable", "error");
        }
    }
}

const fillFieldsWithSelected = (distributable: Distributable) => {
    switch (distributable.type) {
        case "Game":
            form.value = {
                title: distributable.title,
                synopsis: distributable.synopsis,
                release_date: distributable.release_date,
                platform: distributable.platform,
                img_url: distributable.img_url,
                thumbnail: distributable.thumbnail,
                studio: null,
                author: null,
                artist: null,
                published_date: null,
                isbn: null,
            }
            //auto set our gamePlatform value here
            if(distributable.platform){
                gamePlatform.value = distributable?.platform;
            }
            break;
        case "Book":
            form.value = {
                title: distributable.title,
                synopsis: distributable.synopsis,
                published_date: distributable.published_date,
                img_url: distributable.img_url,
                thumbnail: distributable.thumbnail,
                isbn: distributable.isbn,
                author: distributable.author,
                platform: null,
                studio: null,
                artist: null,
                release_date: null,
            }
            break;
        case "Cd":
            form.value = {
                title: distributable.title,
                synopsis: '',
                release_date: distributable.release_date,
                img_url: distributable.img_url,
                thumbnail: distributable.thumbnail,
                artist: distributable.artist,
                isbn: null,
                author: null,
                platform: null,
                studio: null,
                published_date: null
            }
            break;
        case "Movie":
            form.value = {
                title: distributable.title,
                synopsis: distributable.synopsis,
                release_date: distributable.release_date,
                img_url: distributable.img_url,
                thumbnail: distributable.thumbnail,
                artist: null,
                isbn: null,
                author: null,
                platform: null,
                studio: null,
                published_date: null
            }
            break;
        case "Show":
            form.value = {
                title: distributable.title,
                synopsis: distributable.synopsis,
                release_date: distributable.release_date,
                img_url: distributable.img_url,
                thumbnail: distributable.thumbnail,
                artist: null,
                isbn: null,
                author: null,
                platform: null,
                studio: null,
                published_date: null
            }
            break;
    }
}

watch(distributableType, () => {
    form.value = {
        title: '',
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
    };
});
</script>

<template>
    <div class="form-group">
        <label for="selectType" class="form-label">Type
        </label>
        <select id="selectType" name="selectType" v-model="distributableType" aria-label="selectType"
            class="form-input">
            <option>Book</option>
            <option>Game</option>
            <option>Cd</option>
            <option>Movie</option>
            <option>Show</option>
        </select>
    </div>
    <form class="newDistributableForm" @submit.prevent="createDistributableHandler">
        <div class="fieldContainer">
            <DistributableSearch :distributableType="distributableType" :selectItem="fillFieldsWithSelected"/>
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input id="title" name="title" v-model="form.title" type="text" aria-required="true" class="form-input"
                    required />
            </div>
        </div>
        <div v-if="distributableType === 'Book'" class="fieldContainer">
            <div class="form-group">
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
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="published_date" class="form-label">Published Date</label>
                    <input id="published_date" name="published_date" v-model="form.published_date" type="date"
                        aria-required="true" class="form-input" required />
                </div>
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
                <select
                    id="selectPlatform"
                    name="selectPlatform"
                    v-model="gamePlatform"
                    aria-label="selectPlatform"
                    class="form-input"
                >
                    <option>Playstation</option>
                    <option>Playstation 2</option>
                    <option>Playstation 4</option>
                    <option>Playstation 5</option>
                    <option>Nintendo 64</option>
                    <option>Nintendo DS</option>
                    <option>Nintendo Switch</option>
                    <option>PC</option>
                </select>
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
    display: flex;
    flex-direction: column;
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

@media screen and (max-width: 800px){
    .newDistributableForm{
        flex-direction: column;
    }
}
</style>
