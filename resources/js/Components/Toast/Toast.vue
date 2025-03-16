<script>
import { mapStores } from 'pinia';
import { useToastStore } from '../../Stores/toastStore.js';
export default {
    computed: {
        ...mapStores(useToastStore)
    },
}
</script>

<template>
    <div class="toast">
        <transition-group name="toast" tag="div">
            <div v-for="toast in toastStore.toasts" :key="toast.id" :class="['toastContent', toast.type]"
                @click="toastStore.removeToast(toast.id)" @mouseover="toastStore.cancelToastTimer(toast.id)"
                @mouseleave="toastStore.resetToastDuration(toast.id)">
                {{ toast.message }}
                <div class="timeBar" :key="toast.timebarKey"
                    :style="toast.isPaused ? { width: '100%', animation: 'none' } : {}">
                </div>
            </div>
        </transition-group>
    </div>
</template>

<style scoped>
.toast {
    margin: 4px;
    position: absolute;
    bottom: 0;
    right: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
    align-items: center;
    background: rgba(25, 25, 25, 0.5);
    z-index: 9000;
}

.toastContent {
    padding: 10px;
    min-height: 25%;
    min-width: 25%;
    margin: 4px;
    border-radius: 0.5em;
    background-color: #111111;
    border: 1px solid white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.error {
    border: 1px solid red;
}

.timeBar {
    width: 100%;
    height: 2px;
    background-color: white;
    animation: timeDown 3.2s linear;
}

@keyframes timeDown {
    0% {
        width: 100%
    }

    100% {
        width: 0%
    }
}

.toast-enter-active,
.toast-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: scale(1.1);
}
</style>
