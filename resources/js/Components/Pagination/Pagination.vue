<script lang="ts" setup>

defineOptions({
    name: "Pagination",
})
const {callback, pageNumber, isNextPage} = defineProps<{
    callback: (page: number) => void,
    pageNumber: number,
    isNextPage: boolean,
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
        <button @click="pageDecrement">
            Prev
        </button>
        <div>{{pageNumber}}</div>
        <button
            :disabled="isNextPage ? false : true"
            @click="pageIncrement"
        >
            Next
        </button>
    </div>
</template>

<style scoped>
.paginationWrapper{
    display: flex;
    align-items: center;
    gap: 4px;
    width: 100%;
    justify-content: flex-end;
}
</style>
