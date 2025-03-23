import { useToastStore } from '../Stores/toastStore.js';

export function useToast() {
    const toastStore = useToastStore();
    const addToast = (message: string, messageType: string) => {
        toastStore.addToast(message, messageType)
    };
    return {
        addToast
    };
}
