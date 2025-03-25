export interface BaseDistributable {
    type: 'Book' | 'Cd' | 'Game',
    id: number,
    title: string,
    synopsis: string,
    checked_in: boolean,
};

export interface Book extends BaseDistributable {
    type: 'Book',
    author: string | null,
    published_date: string | null,
    isbn: string | null,
};

export interface Cd extends BaseDistributable {
    type: 'Cd',
    artist: string | null,
    release_date: string | null,
};

export interface Game extends BaseDistributable {
    type: 'Game',
    release_date: string | null,
    studio: string | null,
    platform: string | null,
};

export type Distributable = Book | Cd | Game;
