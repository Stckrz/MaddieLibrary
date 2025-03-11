<script>
export default {
    props: {
        closeModal: {
            type: Function,
            required: true,
        },
        modalShown: {
            type: Boolean,
            required: true,
        },
    },
}
</script>

<template>
    <Teleport to="body">
        <Transition name="modal" tag="div">
            <div v-show="modalShown" class="modal">
                <div class="modalContent">
                    <slot></slot>
                    <button @click="closeModal">
                        close
                    </button>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.modal {
    height: 100%;
    width: 100%;
    position: absolute;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(25, 25, 25, 0.5);
}

.modalContent {
    padding: 10px;
    min-height: 30%;
    min-width: 30%;
    border-radius: 0.5em;
    background-color: #111111;
    border: 1px solid white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
    transform: scale(1.05);
}
</style>
