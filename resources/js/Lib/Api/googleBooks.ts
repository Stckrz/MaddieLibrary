export const searchBooks = async (searchString: string) => {
    try{
        const res = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${searchString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });
        const data = await res.json();
        console.log(data.items)
        return data.items;
    } catch (error){
        console.log("error", error);
    };
}
