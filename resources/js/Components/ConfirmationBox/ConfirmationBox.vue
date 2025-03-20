<script>
export default {
    name: "ConfirmationBox",
    props: {
        callback: {
            type: Function,
            required: true,
        },
        closeDialogue: {
            type: Function,
            required: true,
        },
        dialogueShown: {
            type: Boolean,
            required: true,
        },
    },
}
</script>

<template>
    <Teleport to="body">
        <Transition name="dialogue" tag="div">
            <div v-show="dialogueShown" class="dialogue">
                <div class="dialogueContent">
                    <div class="contentSlot">
                        <slot></slot>
                    </div>
                    <div class="confirmationButtonBox">
                        <button @click="closeDialogue" class="secondary">
                            Cancel
                        </button>
                        <button @click="callback">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.dialogue {
    height: 100%;
    width: 100%;
    position: absolute;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(25, 25, 25, 0.5);
}

.dialogueContent {
    padding: 10px;
    min-height: 15%;
    min-width: 30%;
    border-radius: 0.5em;
    background-color: var(--main-bg-color);
    border: 1px solid var(--text-color);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.contentSlot {
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dialogue-enter-active,
.dialogue-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.dialogue-enter-from,
.dialogue-leave-to {
    opacity: 0;
    transform: scale(1.05);
}

@media only screen and (max-width: 600px) {
    .dialogueContent {
        min-width: 70%;
    }

}

.confirmationButtonBox {
    display: flex;
    justify-content: flex-end;
    width: 100%;
}
</style>
