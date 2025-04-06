export const searchAlbums = async (searchString: string) => {
    try{
        const res = await fetch(`/api/searchAlbums?query=${searchString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        return data.albums.items;
    } catch (error){
        console.log("error", error);
    };
}
