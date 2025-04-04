export const searchAlbums = async (queryString: string) => {
    try{
        const res = await fetch(`/api/searchAlbums?query=${queryString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        return data["release-groups"];
    } catch (error){
        console.log("error", error);
    };
}

export const searchAlbumArt = async (albumId: string) => {
    try{
        const response = await fetch(`http://coverartarchive.org/release/${albumId}`)
        const albumArtData = await response.json();
        if(albumArtData.images[0].image){
            return albumArtData.images[0].image
        }
        else{
            return '';
        }
    } catch (error) {
        console.log('error', error)
    }
}
