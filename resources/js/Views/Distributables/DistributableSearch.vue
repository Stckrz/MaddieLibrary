<script lang="ts" setup>
import { ref, watch } from 'vue';
import { searchGames } from '../../Lib/Api/giantbomb';
import { searchBooks } from '../../Lib/Api/googleBooks';
import { Book, Cd, Distributable, Game, Movie, Show } from '../../models/distributables/distributable';
import { GiantBombGame } from '../../models/distributables/ApiModels/giantBomb';
import { searchAlbums } from '../../Lib/Api/spotifyApi';
import { searchMovies, searchShows } from '../../Lib/Api/tmdb';
import { GoogleBookItem } from '../../models/distributables/ApiModels/googleBooksModels';
import { SpotifyAlbumItem } from '../../models/distributables/ApiModels/spotifyModels';

defineOptions({
    name: 'DistributableSearch',
})
const {distributableType, selectItem} = defineProps<{
    distributableType: string;
    selectItem: (distributable: Distributable) => void;

}>();

const searchedGames = ref<GiantBombGame[]>([]);
const searchedBooks = ref<GoogleBookItem[]>([]);
const searchedAlbums = ref<SpotifyAlbumItem[]>([]);
const searchedMovies = ref<TmdbMovie[]>([]);
const searchedShows = ref<TmdbShow[]>([]);

const searchString = ref('');
let debounceTimeout: ReturnType<typeof setTimeout> | null = null;

const searchDistributable = async () => {
    searchedGames.value = [];
    searchedBooks.value = [];
    searchedAlbums.value = [];
    searchedMovies.value = [];
    searchedShows.value = [];
    if(searchString.value === ""){
        return;
    }
    switch(distributableType){
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
            }
            break;
        case "Cd":
            const albums = await searchAlbums(searchString.value);
            if(albums){
                searchedAlbums.value = albums;
            }
            break;
        case "Movie":
            const movies = await searchMovies(searchString.value);
            if(movies){
                searchedMovies.value = movies;
            }
            break;
        case "Show":
            const shows = await searchShows(searchString.value);
            if(shows){
                searchedShows.value = shows;
            }
            break;
    }
}

const parseSelectedCd = async (item: SpotifyAlbumItem) => {
    if(debounceTimeout) clearTimeout(debounceTimeout);
    searchedAlbums.value=[];
    const selectedCdDistributable: Cd = {
        type: 'Cd',
        title: item.name,
        synopsis: '',
        artist: item.artists[0].name,
        release_date: item.release_date,
        img_url: item.images[0]?.url,
        thumbnail: item.images[0]?.url
    }
    selectItem(selectedCdDistributable);
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
        img_url: item.image.original_url,
        thumbnail: item.image.thumb_url,
    }
    selectItem(selectedGameDistributable);
}

const parseSelectedMovie = (item: TmdbMovie) => {
    searchString.value = '';
    if(debounceTimeout) clearTimeout(debounceTimeout);
    searchDistributable();
    const selectedGameDistributable: Movie = {
        type: 'Movie',
        title: item.title,
        synopsis: item.overview,
        release_date: item.release_date,
        img_url: `https://image.tmdb.org/t/p/w500${item.poster_path}`,
        thumbnail: `https://image.tmdb.org/t/p/w500${item.poster_path}`
    }
    selectItem(selectedGameDistributable);
}

const parseSelectedShow = (item: TmdbShow) => {
    searchString.value = '';
    if(debounceTimeout) clearTimeout(debounceTimeout);
    searchDistributable();
    const selectedGameDistributable: Show = {
        type: 'Show',
        title: item.name,
        synopsis: item.overview,
        release_date: item.first_air_date,
        img_url: `https://image.tmdb.org/t/p/w500${item.poster_path}`,
        thumbnail: `https://image.tmdb.org/t/p/w500${item.poster_path}`
    }
    selectItem(selectedGameDistributable);
}

const parseSelectedBook = (item: GoogleBookItem) => {
    searchString.value = '';
    if(debounceTimeout) clearTimeout(debounceTimeout);
    searchDistributable();
    //We are checking here if the isbn10 is in the data retrieved. If not, we'll leave it blank for the user to fill out.
    const isbn = item.volumeInfo.industryIdentifiers.find(item => item.type === 'ISBN_10')
    const selectedGameDistributable: Book = {
        type: 'Book',
        title: item.volumeInfo.title,
        author: item.volumeInfo.authors[0],
        synopsis: item.volumeInfo.description,
        isbn: isbn?.identifier ?? null,
        published_date: item.volumeInfo.publishedDate,
        img_url: item.volumeInfo.imageLinks.thumbnail,
        thumbnail: item.volumeInfo.imageLinks.smallThumbnail,
    }
    selectItem(selectedGameDistributable);
}

watch(searchString, () => {
    //This is a simple manual debounce for 500ms on search field change
    if (debounceTimeout) clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            searchDistributable();
        }, 250);
})

watch(() => distributableType, () => {
    searchString.value = ''
});

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
                <span @click="parseSelectedBook(book)" class="gameTitle">{{book.volumeInfo.title}}</span>
                <div class="platformResults">
                    <span v-if="book.volumeInfo?.authors">{{book.volumeInfo?.authors[0]}}</span>
                </div>
            </div>
        </div>
        <div v-if="searchedAlbums.length > 0" class="resultList">
            <div v-if="distributableType === 'Cd'" v-for="album in searchedAlbums" class="gameResult">
                <span @click="parseSelectedCd(album)" class="gameTitle">{{album.name}}</span>
                <div class="platformResults">
                    <span v-if="album.artists[0]">{{album.artists[0].name}}</span>
                </div>
            </div>
        </div>
        <div v-if="searchedMovies.length > 0" class="resultList">
            <div v-if="distributableType === 'Movie'" v-for="movie in searchedMovies" class="gameResult">
                <span @click="parseSelectedMovie(movie)" class="gameTitle">{{movie.title}}</span>
            </div>
        </div>
        <div v-if="searchedShows.length > 0" class="resultList">
            <div v-if="distributableType === 'Show'" v-for="show in searchedShows" class="gameResult">
                <span @click="parseSelectedShow(show)" class="gameTitle">{{show.name}}</span>
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
