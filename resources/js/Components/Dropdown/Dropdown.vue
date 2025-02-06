<template>
    <div class="dropdown-component">
        <select class="dropdown-option bg-black text-white hover:bg-gray" v-model="selectedValue" @change="handleSelect($event)">
            <option class="dropdown-option hidden" disabled :value="label">{{ label }}</option>
            <option class="dropdown-option text-white bg-black hover:bg-gray-500" v-for="item in items" :key="item.value" :value="item.value">
                {{ item.label }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'Dropdown',
    props: {
        items: {
            type: Array,
            required: true,
        },
        label: {
            type: String,
            default: 'Select an option',
        },
    },
    data() {
        return {
            selectedValue: this.label,
        }
    },
    methods: {
        handleSelect(event) {
            const selectedValue = event.target.value;
            this.$emit('select', selectedValue);
            this.selectedValue = this.label;
        },
    },
}
</script>

<style scoped>
.dropdown-option {
    color: #adb5bd;
}
.dropdown-option:hover{
    background: gray;
}

select {
    width: auto;
}
</style>
