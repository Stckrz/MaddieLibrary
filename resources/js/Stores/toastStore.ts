import { defineStore } from 'pinia';
import { ref } from 'vue';

interface Toast {
    id: number,
    message: string,
    type: string,
    toastTimer: number,
    timebarKey: number,
    isPaused: boolean
}

export const useToastStore = defineStore('toast', () => {
    const toasts = ref<Toast[]>([]);

    const addToast = (message: string, type = 'success', duration = 3000) => {
        const id = Date.now();

        const toastTimer = setTimeout(() => {
            removeToast(id)
        }, duration)
        toasts.value.push({ id, message, type, toastTimer, timebarKey: id, isPaused: false });
    };

    const removeToast = (id: number) => {
        toasts.value = toasts.value.filter((toast) => toast.id !== id);
    };

    const resetToastDuration = (id: number, newDuration = 3000) => {
        const toast = toasts.value.find((t: Toast) => t.id === id);
        if (toast) {
            clearTimeout(toast.toastTimer);
            toast.timebarKey = Date.now();
            toast.isPaused = false;
            toast.toastTimer = setTimeout(() => {
                removeToast(id)
            }, newDuration)
        }
    };
    const cancelToastTimer = (id: number) => {
        const toast = toasts.value.find((t) => t.id === id);
        if (toast) {
            toast.isPaused = true;
            clearTimeout(toast.toastTimer);
        }
    }

    return { toasts, addToast, removeToast, resetToastDuration, cancelToastTimer };
});
