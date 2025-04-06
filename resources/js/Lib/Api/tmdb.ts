export const searchMovies = async (searchString: string) => {
    try{
        const res = await fetch(`/api/searchMovies?query=${searchString}`, {
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

export const searchShows = async (searchString: string) => {
    try{
        const res = await fetch(`/api/searchShows?query=${searchString}`, {
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
