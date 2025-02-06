<script>
export default {
    name: 'PatronList',
    data() {
        return {
            patrons: [],
        };
    },
    mounted() {
        this.fetchPatrons();
    },
    methods: {
        async fetchPatrons() {
            try {
                const response = await fetch('/api/patrons');
                this.patrons = await response.json();
            } catch (error) {
                console.error('Error Fetching Patrons: ', error);
            }
        },
    },
}
</script>

<template>
    <div>
        <div className="patronListContainer">
            <h1 class="color-red-950 m-1000">Patron List</h1>
            <ul class="patronList">
                <li class="listItem" v-for="patron in patrons" :key="patron.id">
                    <router-link :to="{
                        name: 'patron-detail',
                        params: { id: patron.id }
                    }">
                        <strong>{{ patron.name }}</strong>

                        <div>card number: {{ patron.card_number }}</div>
                        <div>Email: {{ patron.email }}</div>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
