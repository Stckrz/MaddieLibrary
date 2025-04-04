<script lang="ts" setup>
import { ref, watch } from 'vue';
import { searchGames } from '../../Lib/Api/giantbomb';
import { searchBooks, searchBookCover, searchBookById } from '../../Lib/Api/openlibrary';
import { Book, Cd, Distributable, Game } from '../../models/distributables/distributable';
import { GiantBombGame } from '../../models/distributables/ApiModels/giantBomb';
import { OpenLibraryBookDetail, OpenLibraryBookSearchItem } from '../../models/distributables/ApiModels/openLibraryModels';
import { searchAlbumArt, searchAlbums } from '../../Lib/Api/musicBrainz';
import { MusicBrainzSearchItem } from '../../models/distributables/ApiModels/musicBrainzModels';

defineOptions({
    name: 'DistributableSearch',
})
const props = defineProps<{
    distributableType: string;
    selectItem: (distributable: Distributable) => void;

}>();

const searchedGames = ref<GiantBombGame[]>([]);
const searchedBooks = ref<OpenLibraryBookSearchItem[]>([]);
const searchedAlbums = ref<MusicBrainzSearchItem[]>([]);

const searchString = ref('');
let debounceTimeout: ReturnType<typeof setTimeout> | null = null;

const searchDistributable = async () => {
    searchedGames.value = [];
    searchedBooks.value = [];
    searchedAlbums.value = [];
    switch(props.distributableType){
        case "Game":
            const games = await searchGames(searchString.value);
            if(games){
                searchedGames.value = games;
            }
            break;
        case "Book":
            const books = await searchBooks(searchString.value);
            if(books){
                searchedBooks.value = books;
                console.log(searchedBooks.value)
            }
            break;
        case "Cd":
            const albums = await searchAlbums(searchString.value);
            if(albums){
                searchedAlbums.value = albums;
                console.log("shittybutt", searchedAlbums.value)
            }
            break;
    }
}

const parseSelectedCd = async (item: MusicBrainzSearchItem) => {
    // searchString.value = '';
    if(debounceTimeout) clearTimeout(debounceTimeout);
    searchedAlbums.value=[];
    const albumArt = await searchAlbumArt(item.releases[0].id);
    const selectedCdDistributable: Cd = {
        type: 'Cd',
        title: item.title,
        synopsis: '',
        artist: item["artist-credit"][0].name ?? '',
        release_date: item['first-release-date'],
        checked_in: true,
        img_url: albumArt,
        thumbnail: `http://coverartarchive.org/release/${item.id}-250.jpg`,
    }
    props.selectItem(selectedCdDistributable);
}

const parseSelectedGame = (item: GiantBombGame) => {
    searchString.value = '';
    if(debounceTimeout) clearTimeout(debounceTimeout);
    searchDistributable();
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

const parseSelectedBook = async (item: OpenLibraryBookSearchItem) => {
    let img_url = '';
    let bookDetail: OpenLibraryBookDetail | null = null;
    try{
        bookDetail = await searchBookById(item.key);
    } catch {
        console.log('oh nooo');
    }
    try{
        img_url = await searchBookCover(item.cover_edition_key);
    }catch {
        console.log('shittyassbutt')
    }
    if(bookDetail){
        searchString.value = '';
        if(debounceTimeout) clearTimeout(debounceTimeout);
        searchDistributable();
        const selectedBookDistributable: Book = {
            type: 'Book',
            title: bookDetail.title,
            author: item.author_name[0],
            synopsis: bookDetail.description.value ? bookDetail.description.value : bookDetail.description,
            isbn: bookDetail.isbn ?? '',
            published_date: bookDetail.publish_date,
            checked_in: true,
            img_url: img_url,
            thumbnail: img_url ?? ''
        }
        console.log(selectedBookDistributable)
        props.selectItem(selectedBookDistributable);
    }

}

watch(searchString, () => {
    //This is a simple manual debounce for 500ms on search field change
    if (debounceTimeout) clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            searchDistributable();
        }, 250);
})

</script>

<template>
    <div class="distributableSearchWrapper form-group">
        <label for="searchInput" class="form-label">Search</label>
        <input id="searchInput" name="searchInput" class="form-input" v-model='searchString'/>
        <div v-if="searchedGames.length>0" class="resultList">
            <div v-if="distributableType === 'Game'" v-for="game in searchedGames" class="gameResult">
                <span @click="parseSelectedGame(game)" class="gameTitle">{{game.name}}</span>
                <div class="platformResults">
                    <span v-for="platform in game.platforms">{{platform.abbreviation}}/</span>
                </div>
            </div>
        </div>
        <div v-if="searchedBooks.length > 0" class="resultList">
            <div v-if="distributableType === 'Book'" v-for="book in searchedBooks" class="gameResult">
                <span @click="parseSelectedBook(book)" class="gameTitle">{{book.title}}</span>
                <div class="platformResults">
                    <span v-if="book.author_name[0]">{{book.author_name[0]}}</span>
                </div>
            </div>
        </div>
        <div v-if="searchedAlbums.length > 0" class="resultList">
            <div v-if="distributableType === 'Cd'" v-for="album in searchedAlbums" class="gameResult">
                <span @click="parseSelectedCd(album)" class="gameTitle">{{album.title}}</span>
                <div class="platformResults">
                    <span v-if="album?.artistCredit?.length > 0">{{album.artistCredit[0].name}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.distributableSearchWrapper{
    background-color: var(--main-bg-color);
    position: relative;
}

.resultList{
    position: absolute;
    background-color: var(--main-bg-color);
    max-height: 500%;
    max-width: 65vw;
    min-width: 65vw;
    overflow-y: auto;
    border: 1px solid white;
    padding: 4px;
    border-radius: 0.25rem;
    gap: 4px;
    top: 50px;
    width: auto;
}

.gameTitle{
    width: 50%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


.gameResult{
    display: flex;
    justify-content: space-between;
    cursor: pointer;
    transition: background-color 0.5s linear, color 0.5s linear;
    padding: 2px;
    gap: 8px;
}

.gameResult:hover{
    background-color: gray;
    color: black;
    border-radius: 0.25rem;
}
.platformResults{
    overflow: hidden;
    text-overflow: ellipsis;
    width: 50%;
}
</style>
