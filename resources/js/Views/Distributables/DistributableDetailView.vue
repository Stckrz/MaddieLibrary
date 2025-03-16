<script>
export default {
    name: 'DistributableDetailView',
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            distributable: {},
            isEditing: false,
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
                console.error('Error Fetching Book: ', error);
            }
        },
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
    </div>

</template>
