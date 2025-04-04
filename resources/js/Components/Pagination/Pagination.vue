<script lang="ts" setup>

defineOptions({
    name: "Pagination",
})
const {callback, pageNumber} = defineProps<{
    callback: (page: number) => void,
    pageNumber: number
}>()

const pageIncrement = () => {
    callback(pageNumber + 1);
}
const pageDecrement = () => {
    if(pageNumber > 1) callback(pageNumber - 1);
}

</script>

<template>
    <div class="paginationWrapper">
        <div @click="pageDecrement">
            Previous
        </div>
        <div @click="pageIncrement">
            Next
        </div>
        <div>{{pageNumber}}</div>
    </div>
</template>

<style scoped>
.paginationWrapper{
    display: flex;
    gap: 4px;
    width: 100%;
    border: 1px solid blue;
    justify-content: flex-end;
}

</style>
