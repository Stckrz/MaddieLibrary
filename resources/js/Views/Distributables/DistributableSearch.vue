<script lang="ts" setup>
import { ref, watch } from 'vue';
import { searchGames } from '../../Lib/Api/giantbomb';
import { Distributable, Game } from '../../models/distributables/distributable';
import { GiantBombGame } from '../../models/distributables/ApiModels/giantBomb';

defineOptions({
    name: 'DistributableSearch',
})
const props = defineProps<{
    distributableType: string;
    selectItem: (distributable: Distributable) => void;

}>();

const searchedGames = ref<GiantBombGame[]>([]);
const searchString = ref('');
let debounceTimeout: ReturnType<typeof setTimeout> | null = null;

const searchDistributable = async () => {
    switch(props.distributableType){
        case "Game":
            const games = await searchGames(searchString.value);
            if(games){
                searchedGames.value = games;
            }
            break;
    }
}
const parseSelectedGame = (item: GiantBombGame) => {
    searchString.value = '';
    const selectedGameDistributable: Game = {
        type: 'Game',
        title: item.name,
        synopsis: item.deck,
        release_date: item.original_release_date,
        platform: item.platforms[0].name,
        checked_in: true,
        img_url: item.image.original_url,
        thumbnail: item.image.thumb_url,
    }
    props.selectItem(selectedGameDistributable);

}

watch(searchString, () => {
    //This is a simple manual debounce for 500ms on search field change
    if (debounceTimeout) clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            searchDistributable();
        }, 500);
})

</script>

<template>
    <div class="distributableSearchWrapper form-group">
        <label for="searchInput" class="form-label">Search</label>
        <input id="searchInput" name="searchInput" class="form-input" v-model='searchString'/>
        <div class="resultList">
            <div v-if="distributableType === 'Game'" v-for="game in searchedGames" class="gameResult">
                <span @click="parseSelectedGame(game)">{{game.name}}</span>
                <div>
                <span v-for="platform in game.platforms">{{platform.abbreviation}}/</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.distributableSearchWrapper{
    background-color: var(--main-bg-color);
}

.resultList{
    position: absolute;
    background-color: var(--main-bg-color);
    height: 50%;
    overflow-y: auto;
}

.gameResult{
    display: flex;
    justify-content: space-between;
}
</style>
