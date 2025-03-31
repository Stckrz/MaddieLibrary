export interface GiantBombGame{
    name: string,
    deck: string,
    description: string,
    image: GameImageObject,
    platforms: Platforms[],
    original_release_date: string
}

interface Platforms {
    name: string,
    abbreviation: string,
}

interface GameImageObject {
    icon_url: string,
    medium_url: string,
    screen_url: string,
    screen_large_url: string,
    small_url: string,
    super_url: string,
    thumb_url: string,
    tiny_url: string,
    original_url: string,
}
