import {useToastStore} from '../Stores/toastStore';

export default {
    computed: {
        toastStore() {
            return useToastStore();
        }
    },
    methods: {
        addToast(message, messageType){
            this.toastStore.addToast(message, messageType)
        }
    }
}
