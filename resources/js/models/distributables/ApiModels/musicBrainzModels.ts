export interface MusicBrainzSearchItem{
    id: string,
    title: string,
    "artist-credit": ArtistCreditObject[],
    "first-release-date": string,
}
interface ArtistCreditObject{
    name: string,
    artist: MusicBrainzArtist[]
}
interface MusicBrainzArtist {
    id: string,
    name: string
}
