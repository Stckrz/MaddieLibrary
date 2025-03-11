import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useToastStore = defineStore('toast', () => {
    const toasts = ref([]);

    const addToast = (message, type = 'success', duration = 3000) => {
        const id = Date.now();

        const toastTimer = setTimeout(() => {
            removeToast(id)
        }, duration)
        toasts.value.push({ id, message, type, toastTimer, timebarKey: id, isPaused: false });
    };

    const removeToast = (id) => {
        toasts.value = toasts.value.filter((toast) => toast.id !== id);
    };

    const resetToastDuration = (id, newDuration = 3000) => {
        const toast = toasts.value.find((t) => t.id === id);
        if (toast) {
            clearTimeout(toast.toastTimer);
            toast.timebarKey = Date.now();
            toast.isPaused = false;
            toast.toastTimer = setTimeout(() => {
                removeToast(id)
            }, newDuration)
        }
    };
    const cancelToastTimer = (id) => {
        const toast = toasts.value.find((t) => t.id === id);
        if (toast) {
            toast.isPaused = true;
            clearTimeout(toast.toastTimer);
        }
    }

    return { toasts, addToast, removeToast, resetToastDuration, cancelToastTimer };
});
