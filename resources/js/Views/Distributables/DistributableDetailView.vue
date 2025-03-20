<script>
import ConfirmationBox from '../../Components/ConfirmationBox/ConfirmationBox.vue';
import Modal from '../../Components/Modal/Modal.vue';
import toastMixin from '../../Mixins/toastMixin.js';
export default {
    name: 'DistributableDetailView',
    components: {
        Modal,
        ConfirmationBox,
    },
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    mixins: [
        toastMixin
    ],
    data() {
        return {
            distributable: {},
            isEditing: false,
            dialogueShown: false,
        }
    },
    methods: {
        async fetchDistributable(id) {
            try {
                const response = await fetch(`/api/distributables/${this.id}`)
                this.distributable = await response.json();
                if (this.distributable?.isbn) {
                    this.coverUrl = `https://covers.openlibrary.org/b/isbn/${this.distributable.isbn}-M.jpg`
                }
            } catch (error) {
                console.error('Error Fetching Distributable: ', error);
            }
        },
        async deleteDistributable() {
            console.log(this.distributable)
            let distributableInputType = ""
            switch (this.distributable.type) {
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
                const response = await fetch(`/api/${distributableInputType}/${this.id}`, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' }
                })
                if (!response.ok) {
                    console.error('Unable to delete');
                }
                const data = await response.json();
                this.addToast("Distributable successfully deleted", "success");
                this.$router.push({ path: '/distributables' })
            } catch (error) {
                console.error('Error Deleting Distributable: ', error);
            }
        },
        toggleDialogue() {
            this.dialogueShown = !this.dialogueShown;
        },
        toggleEditModal() {
            this.isEditing = !this.isEditing;
        }
    },
    mounted() {
        this.fetchDistributable(this.id);
    }
}
</script>
<template>
    <div>
        Id:
        {{ this.id }}
        <div>
            Title:
            {{ this.distributable.title }}
        </div>
        <div>
            Synopsis:
            {{ this.distributable.synopsis }}
        </div>
        <div>
            Checked in:
            {{ this.distributable.checked_in }}
        </div>
        <div v-if="distributable.type === 'Cd'">
            <div>
                Artist:
                {{ this.distributable.artist }}
            </div>
            <div>
                Release Date:
                {{ this.distributable.released_date }}
            </div>
        </div>
        <div v-if="distributable.type === 'Game'">
            <div>
                Studio:
                {{ this.distributable.studio }}
            </div>
            <div>
                Platform:
                {{ this.distributable.platform }}
            </div>
            <div>
                Release Date
                {{ this.distributable.release_date }}
            </div>
        </div>
        <div v-if="distributable.type === 'Book'">
            <div>
                Author:
                {{ this.distributable.author }}
            </div>
            <div>
                Publication Date:
                {{ this.distributable.published_date }}
            </div>
            <div>
                ISBN:
                {{ this.distributable.isbn }}
            </div>
        </div>
        <button @click="toggleDialogue">Delete</button>
        <ConfirmationBox :callback="deleteDistributable" :dialogueShown="dialogueShown" :closeDialogue="toggleDialogue">
            <div>Really delete this?</div>
        </ConfirmationBox>
        <Modal>

        </Modal>
    </div>

</template>
