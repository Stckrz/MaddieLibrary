<script lang="ts" setup>
import { Distributable } from '../../models/distributables/distributable.js';
import { useToastStore } from '../../Stores/toastStore';
import { ref, watch } from 'vue';

const toastStore = useToastStore();
defineOptions({
    name: 'EditDistributable'
});

const props = defineProps<{
    distributable: Distributable;
}>();

const distributableType = ref('');

interface FormFields{
    title: string | null,
    author: string | null,
    artist: string | null,
    synopsis: string | null,
    platform: string | null,
    studio: string | null,
    published_date: string | null,
    release_date: string | null,
    isbn: string | null,
    checked_in: boolean | null,
}
const form = ref<FormFields>({
    title: null,
    author: null,
    artist: null,
    synopsis: null,
    platform: null,
    studio: null,
    published_date: null,
    release_date: null,
    isbn: null,
    checked_in: null,
});

const createToast = (message: string, status: string) => {
    toastStore.addToast(message, status);
};

const populateForm = () => {
    distributableType.value = props.distributable.type;
    form.value = {
        title: props.distributable.title,
        synopsis: props.distributable.synopsis,
        checked_in: props.distributable.checked_in,
        author: props.distributable.type === "Book" ? props.distributable.author : null,
        published_date: props.distributable.type === "Book" ? props.distributable.published_date : null,
        isbn: props.distributable.type === "Book" ? props.distributable.isbn : null,
        platform: props.distributable.type === "Game" ? props.distributable.platform : null,
        studio: props.distributable.type === "Game" ? props.distributable.studio : null,
        release_date: props.distributable.type === "Game" || props.distributable.type === "Cd" ? props.distributable.released_date : null,
        artist: props.distributable.type === "Cd" ? props.distributable.artist : null,
    };
};

const editDistributable = async () => {
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
    }

    try {
        const response = await fetch(`/api/${distributableInputType}/${props.distributable.id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(form.value),
        });

        if (!response.ok) {
            throw new Error('Failed to edit distributable');
        };

        createToast("Distributable edited successfully!", "success");
    } catch (error) {
        console.error('Error editing distributable:', error);
        createToast("Unable to edit distributable", "error");
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
    <form class="newDistributableForm" @submit.prevent="editDistributable">
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
                <label for="studio" class="form-label">Studio</label>
                <input id="studio" name="studio" v-model="form.studio" type="text" aria-required="true"
                    class="form-input" />
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
