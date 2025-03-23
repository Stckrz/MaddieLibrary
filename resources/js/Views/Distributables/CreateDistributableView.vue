<script lang="ts" setup>
import { useToastStore } from '../../Stores/toastStore';
import {ref, watch} from 'vue';

const toastStore = useToastStore();
defineOptions({
    name: 'CreateDistributable',
});

const distributableType = ref("Book");
const form = ref({
title: '',
author: '',
artist: '',
synopsis: '',
platform: '',
studio: '',
published_date: '',
release_date: '',
isbn: '',
checked_in: true,
});


const createToast = (message: string, status: string) => {
    toastStore.addToast(message, status);
};

const createDistributable = async() => {
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
            }
            try {
                const response = await fetch(`/api/${distributableInputType}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(form.value),
                });

                if (!response.ok) {
                    throw new Error('Failed to create book');
                }

                const data = await response.json();
                console.log(data.message);

                // Clear the form
                form.value = {
                    title: '',
                    author: '',
                    artist: '',
                    synopsis: '',
                    platform: '',
                    studio: '',
                    published_date: '',
                    release_date: '',
                    isbn: '',
                    checked_in: true,
                };
                createToast("Distributable created successfully!", "success");
            } catch (error) {
                console.error('Error creating distributable:', error);
                createToast("Unable to create distributable", "error");
            }
        }

watch(distributableType, (newType) => {
    form.value = {
        title: '',
        author: '',
        artist: '',
        synopsis: '',
        platform: '',
        studio: '',
        published_date: '',
        release_date: '',
        isbn: '',
        checked_in: true,
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
        </select>
    </div>
    <form class="newDistributableForm" @submit.prevent="createDistributable">
        <div class="fieldContainer">
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input id="title" name="title" v-model="form.title" type="text" aria-required="true" class="form-input"
                    required />
            </div>
            <div class="form-group">
                <label for="synopsis" class="form-label">Synopsis
                </label>
                <textarea id="synopsis" name="synopsis" v-model="form.synopsis" type="text" aria-required="true"
                    class="form-input" />
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
                <label for="studio">Studio</label>
                <input id="studio" name="studio" v-model="form.studio" type="text" aria-required="true" />
            </div>
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
