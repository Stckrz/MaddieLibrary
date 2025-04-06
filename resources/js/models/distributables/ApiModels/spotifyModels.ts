export interface SpotifyAlbumItem {
    images: SpotifyImageObject[],
    name: string,
    release_date: string,
    artists: SpotifyArtistObject[],

}

interface SpotifyImageObject {
    height: number,
    url: string,
    width: number
}

interface SpotifyArtistObject {
    name: string
}
