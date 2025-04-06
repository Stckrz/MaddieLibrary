export interface GoogleBookItem{
    volumeInfo: VolumeInfo,
}

interface VolumeInfo {
    title: string,
    authors: string[],
    publishedDate: string,
    description: string,
    industryIdentifiers: IndustryIdentifiersObject[],
    imageLinks: {
        smallThumbnail: string,
        thumbnail: string
    }
}

interface IndustryIdentifiersObject {
    type: string,
    identifier: string,
}
