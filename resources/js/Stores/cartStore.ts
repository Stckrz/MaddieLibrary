import { defineStore } from "pinia";
import { Distributable } from "../models/distributables/distributable";
import { Patron } from "../models/patrons/patronModel";
import { ref } from "vue";

export interface Cart{
    patron: Patron | null,
    cartDistributables: Distributable[],
}
export const useCartStore = defineStore('cart', () => {
    const cartState = ref<Cart>({
        patron: null,
        cartDistributables: [],
    });

    const addToCart: (distributable: Distributable) => void = (distributable: Distributable) => {
        const foundCartItem = cartState.value.cartDistributables.find(cartDistributable => cartDistributable.id === distributable.id);
        if(foundCartItem === undefined){
           cartState.value.cartDistributables.push(distributable);
        }
    };

    const removeFromCart: (id: number) => void = (id: number) => {
        console.log(cartState.value.cartDistributables.filter(cartDistributable => cartDistributable.id !== id))
        cartState.value.cartDistributables = cartState.value.cartDistributables.filter(cartDistributable => cartDistributable.id !== id);
    };

    const updatePatron: () => void = (patron?: Patron) => {
        if(patron){
            cartState.value.patron = patron;
        }else{
            cartState.value.patron = null;
        };
    };

    const clearCartState: () => void = () =>{
        cartState.value.patron = null;
        cartState.value.cartDistributables = [];
    };

    return {cartState, addToCart, removeFromCart, updatePatron, clearCartState}
});
