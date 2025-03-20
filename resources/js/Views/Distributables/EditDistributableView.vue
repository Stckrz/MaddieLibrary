<script>
import toastMixin from '../../Mixins/toastMixin.js';
export default {
    name: 'EditDistributable',
    props: {
        distributable: {},
        closeModal: {
            type: Function,
            required: false
        },
    },
    mixins: [
        toastMixin
    ],
    data() {
        return {
            distributableType: this.distributable.type,
            form: {
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
            }
        }
    },
    watch: {
        distributable: {
            handler(newVal) {
                if (newVal) {
                    this.populateForm();
                }
            },
            immediate: true,
        },
    },
    methods: {
        populateForm() {
            this.distributableType = this.distributable.type,
                this.form = {
                    title: this.distributable.title,
                    author: this.distributable.author,
                    artist: this.distributable.artist,
                    synopsis: this.distributable.synopsis,
                    platform: this.distributable.platform,
                    studio: this.distributable.studio,
                    published_date: this.distributable.published_date,
                    release_date: this.distributable.release_date,
                    isbn: this.distributable.isbn,
                    checked_in: this.distributable.checked_in,
                }

        },
        async editDistributable() {
            let distributableInputType = ""
            switch (this.distributableType) {
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
                const response = await fetch(`/api/${distributableInputType}/${this.distributable.id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form),
                });

                if (!response.ok) {
                    throw new Error('Failed to edit distributable');
                }

                const data = await response.json();
                console.log(data.message);

                this.addToast("Distributable edited successfully!", "success");
            } catch (error) {
                console.error('Error editing distributable:', error);
                this.addToast("Unable to edit distributable", "error");
            }

        }
    },
}
</script>

<template>
    <div class="form-group">
        <label for="distributableType" class="form-label">Type
            <div id="distributableType">{{ this.distributable.type }}</div>
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
