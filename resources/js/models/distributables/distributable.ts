export interface BaseDistributable {
    type: 'Book' | 'Cd' | 'Game' | 'Movie' | 'Show',
    id?: number,
    title: string,
    synopsis: string | null,
    img_url: string | null,
    thumbnail: string | null,
    isCheckedOut?: boolean,
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
    platform: string | null,
};

export interface Movie extends BaseDistributable {
    type: 'Movie',
    release_date: string | null,
};

export interface Show extends BaseDistributable {
    type: 'Show',
    release_date: string | null,
};

export type Distributable = Book | Cd | Game | Movie | Show;

export interface FormFields {
    title: string | null,
    author: string | null,
    artist: string | null,
    synopsis: string | null,
    img_url: string | null,
    thumbnail: string | null,
    platform: string | null,
    studio: string | null,
    published_date: string | null,
    release_date: string | null,
    isbn: string | null,
}
