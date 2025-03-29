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
    <div class="checkoutWrapper">
        <h1 v-if="cartState.patron">
            Cart Checkout For {{cartState.patron.firstName}} {{cartState.patron.lastName}}
        </h1>
        <table class="checkoutTable">
            <tbody>
                <tr>
                    <th>
                        <div class="tableHeaderContainer">
                            <div class="h-full flex items-center justify-center">Type</div>
                        </div>
                    </th>
                    <th>
                        <div class="tableHeaderContainer">
                            <div class="h-full flex items-center justify-center">Title</div>
                        </div>
                    </th>
                    <th>Published</th>
                </tr>
                <tr
                    v-for="distributable in cartState.cartDistributables"
                    :key="distributable.id"
                    class="tableListItem"
                    :to="{
                        name: 'distributable-detail',
                        params: { id: distributable.id }
                    }"
                    @click="$router.push({
                        name: 'distributable-detail',
                        params: { id: distributable.id }
                    })"
                >
                    <td>
                        {{ distributable.type }}
                    </td>
                    <td>
                        {{ distributable.title }}
                    </td>
                    <td v-if="(distributable.type === 'Book') && distributable.published_date">
                        {{ new Date(distributable.published_date).toLocaleDateString() }}
                    </td>
                    <td v-if="(distributable.type === 'Game' || distributable.type === 'Cd') &&distributable.release_date">
                        {{ new Date(distributable.release_date).toLocaleDateString() }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style>
.checkoutWrapper{
    justify-self: flex-start;
    align-self: flex-start;
}
.checkoutTable{
    width: 100%;
}
</style>
