export interface OpenLibraryBookSearchItem{
    title: string,
    author_name: string[],
    key: string,
    cover_edition_key: string,
}

export interface OpenLibraryBookDetail{
    title: string,
    description: {type: string, value: string} | string,
    publish_date: string,
    isbn?: string,
    covers: string[],
}
