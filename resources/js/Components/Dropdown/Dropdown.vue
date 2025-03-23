<template>
    <div class="dropdown-component">
        <select class="dropdown-option bg-black text-white hover:bg-gray" v-model="selectedValue"
            @change="handleSelect($event)">
            <option class="dropdown-option hidden" disabled :value="label">{{ label }}</option>
            <option class="dropdown-option text-white bg-black hover:bg-gray-500" v-for="item in items"
                :key="item.value" :value="item.value">
                {{ item.label }}
            </option>
        </select>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
defineOptions({
    name: 'Dropdown',
})
const props = defineProps<{

    items: { value: any; label: string }[]
    label: String;
}>()

const emit = defineEmits<{
    (e: 'select', value: any): void
}>()

const selectedValue = ref(props.label)

const handleSelect = (event) => {
    const target = event.target as HTMLSelectElement
    const selectedValue = target.value;
    emit('select', selectedValue);
    selectedValue.value = props.label;
}
</script>

<style scoped>
.dropdown-option {
    color: #adb5bd;
}

.dropdown-option:hover {
    background: gray;
}

select {
    width: auto;
}
</style>
