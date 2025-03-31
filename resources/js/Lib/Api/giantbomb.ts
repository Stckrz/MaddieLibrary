export const searchGames = async (searchString: string) => {
    try{
        const res = await fetch(`/api/search?query=${searchString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        return data.results;
    } catch (error){
        console.log("error", error);
    };
}
