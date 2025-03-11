<template>
    <div class="bookDetailContainer">
        <h1>Patron detail page for {{ patron.name }}</h1>
        <div class="flex flex-col md:flex-row md:w-1/2 w-full justify-between items-center my-4 px-4 md:px-0 gap-2 md:gap-0">
            <div class="flex flex-col gap-2 justify-center items-start md:mx-4 p-2 border w-full">
                <div v-if="!isEditing">
                    Name: {{ patron.name }}
                </div>
                <div class="md:w-1/2 w-full flex justify-between" v-else>
                    Name:
                    <input class="w-3/4" type="text" placeholder={{form.name}} v-model="form.name" />
                </div>

                <div v-if="!isEditing">
                    Card_rumber: {{ patron.card_number }}
                </div>
                <div class="md:w-1/2 flex justify-between" v-else>
                    Card_number:
                    <input class="w-3/4" type="text" v-model="form.card_number" />
                </div>

                <div v-if="!isEditing">
                    Email: {{ patron.email }}
                </div>
                <div class="md:w-1/2 flex justify-between" v-else>
                    Email:
                    <input class="w-3/4" type="email" v-model="form.email" />
                </div>

                <div className="flex gap-2">
                    <button v-on:click="editHandler">
                        {{ !isEditing ? "Edit" : "Cancel" }}
                    </button>
                    <button v-if="isEditing" v-on:click="editPatron">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'PatronDetailView',
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            patron: {},
            isEditing: false,
            form: {
                name: '',
                card_number: '',
                email: '',
            }
        }
    },
    methods: {
        async fetchPatron(id) {
            try {
                const response = await fetch(`/api/patrons/${this.id}`)
                this.patron = await response.json();
                console.log(this.patron)
                this.form.name = this.patron.name;
                this.form.card_number = this.patron.card_number;
                this.form.email = this.patron.email;
            } catch (error) {
                console.error('Error Fetching patron: ', error);
            }
        },
        async editPatron() {
            try {
                const response = await fetch(`/api/patrons/${this.patron.id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form),
                });

                if (!response.ok) {
                    throw new Error('Failed to edit patron');
                }

                const data = await response.json();
                console.log(data.message);
                this.form = { ...data.data };
                this.fetchPatron(this.id)
                this.isEditing = false;
                // Clear the form
            } catch (error) {
                console.error('Error editing patron:', error);
            }
        },
        editHandler(){
            this.isEditing = !this.isEditing
        },
    },
    mounted() {
        this.fetchPatron(this.id);
    }
}
</script>
<style>
h1 {
    font-size: 24px;
}

.bookDetailContainer {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    height: 100%;
    border: 1px solid gray;
}
</style>
