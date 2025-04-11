<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useCartStore } from '../../Stores/cartStore';
import { checkoutDistributable } from '../../Lib/Api/checkout';
import { useToastStore } from '../../Stores/toastStore';
import { ref } from 'vue';
import ConfirmationBox from '../../Components/ConfirmationBox/ConfirmationBox.vue';
import { useRouter } from 'vue-router';

defineOptions({
    name: 'CartCheckout',
})

const cartStore = useCartStore();
const { cartState } = storeToRefs(cartStore);
const router = useRouter();
const toastStore = useToastStore();
const clearCartDialogue = ref(false);

const executeCheckouts = async () => {
    let checkedOutItems = 0;
    for(const distributable of cartState.value.cartDistributables){
        if(cartState.value.patron?.id && distributable.id){
            const response = await checkoutDistributable(cartState.value.patron?.id, distributable.id)
            if(response.message){
                checkedOutItems += 1;
                cartStore.removeFromCart(distributable.id);
            }
            if(response.error){
                toastStore.addToast(response.error, "error");
            }
        }
    }
    toastStore.addToast(`${checkedOutItems} items checked out.`, "success");
};

const clearCart = () => {
    cartStore.clearCartState();
    clearCartDialogue.value = false;
    router.push({ path: '/distributables' })
}
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
        <button @click="executeCheckouts">checkout</button>
        <button @click="()=>{clearCartDialogue = true}">Clear Cart</button>
        <ConfirmationBox :callback="clearCart" :dialogue-shown="clearCartDialogue" :closeDialogue="()=>{clearCartDialogue = false}">
            Really Clear Cart?
        </ConfirmationBox>
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
