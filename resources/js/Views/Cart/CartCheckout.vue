<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useCartStore } from '../../Stores/cartStore';

defineOptions({
    name: 'CartCheckout',
})

const cartStore = useCartStore();
const { cartState } = storeToRefs(cartStore);

</script>

<template>
    <div>assholes</div>
</template>

<style>

</style>
