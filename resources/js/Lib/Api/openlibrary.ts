export const searchBooks = async (queryString: string) => {
    try{
        const res = await fetch(`/api/searchBooks?query=${queryString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        return data.docs;
    } catch (error){
        console.log("error", error);
    };
}

export const searchBookById = async (id: string) => {
    try{
        const res = await fetch(`/api/searchBookDetail?key=${id}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        console.log(data);
        return data;
    } catch (error){
        console.log("error", error);
    };
}

// takes the 'olid' fetched from the search point, and returns a url for the cover image.
export const searchBookCover = async (olid: string) => {
    try{
        const res = await fetch(`/api/searchCover?olid=${olid}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        return data.url;
    } catch (error){
        console.log("error", error);
    };
}
