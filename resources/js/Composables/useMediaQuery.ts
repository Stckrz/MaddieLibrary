import {ref, onMounted, onUnmounted} from 'vue';

export function useMediaQuery(query){
    const matches = ref(false);
    let mediaQuery;

    const updateMatch = () => {
        matches.value = mediaQuery.matches
    }

    onMounted(() => {
        mediaQuery = window.matchMedia(query)
        updateMatch()
        mediaQuery.addEventListener('change', updateMatch)
    })
    onUnmounted(()=>{
        mediaQuery.removeEventListener('change', updateMatch)

    })
    return matches
}
