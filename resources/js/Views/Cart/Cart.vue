<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useCartStore } from '../../Stores/cartStore';
import { ref } from 'vue';
import { FaCaretLeft, FaCaretRight } from "vue3-icons/fa";
import ConfirmationBox from '../../Components/ConfirmationBox/ConfirmationBox.vue';

const cartStore = useCartStore();
const { cartState } = storeToRefs(cartStore);

defineOptions({
    name: "Cart",
})

const dialogueShown = ref(false);
const cartShown = ref(false);
const toggleCartShown = () => {
    cartShown.value = !cartShown.value;
}
const toggleDialogueShown = () => {
    dialogueShown.value = !dialogueShown.value;
}
const clearCart = () => {
    cartStore.clearCartState();
    cartShown.value = false;
    dialogueShown.value = false;
}
const removeFromCart = (id: number) => {
    cartStore.removeFromCart(id)
}

</script>

<template>
    <Teleport to="body">
        <div v-if="cartState.patron" class="cart" :class="{ open: cartShown, closed: !cartShown }">
            <div class="cartCollapseTag" @click="toggleCartShown">
                <div v-if="!cartShown">
                    <FaCaretLeft class='caretIcon'/>
                </div>
                <div v-else>
                    <FaCaretRight class='caretIcon' />
                </div>
            </div>
            <div v-show="true" class="cartContent">
                <div v-if="cartState.patron">
                    <div class="patronName">{{cartState.patron.lastName}}, {{cartState.patron.firstName}}</div>
                </div>
                <div v-if="cartState.cartDistributables.length > 0">
                    <div v-for="cart in cartState.cartDistributables" key="cart.id" class="cartDistributable">
                        <div>{{cart.title}}</div>
                        <button @click="removeFromCart(cart.id)">x</button>
                    </div>
                </diV>
                <div class="cartButtonBox">
                    <button @click="toggleDialogueShown">Clear Cart</button>
                    <button @click="$router.push({ name: 'cart-checkout'})" to="/cart/checkout">Checkout</button>
                </div>
            </div>
        </div>
        <ConfirmationBox :callback="clearCart" :dialogue-shown="dialogueShown" :close-dialogue="toggleDialogueShown">
            Really clear cart?
        </ConfirmationBox>
    </Teleport>
</template>

<style>
.caretIcon{
    height: 2em;
}
.cartCollapseTag{
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid white;
    border-right: 0;
    padding: 10px;
    height: 50%;
    background-color: var(--main-bg-color);
    transition: border 0.25s linear;
}
.cartCollapseTag:hover{
    border: 2px solid white;
    border-right: 0;
}
.cartContent{
    border: 1px solid white;
    padding: 4px;
    background-color: var(--main-bg-color)
}
.cartDistributable{
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}
.patronName{
    border-bottom: 1px solid white;
}
.cartButtonBox{
    display: flex;
    flex-direction: column;
}
.cart{
    position: absolute;
    right: 0px;
    min-height: 20%;
    top: 50%;
    padding: 4px;
    display: flex;
    transform: translateX(calc(100% - 40px));
    transition: transform 0.3s ease;
}
.cart.open {
  transform: translateX(0);
}
</style>
