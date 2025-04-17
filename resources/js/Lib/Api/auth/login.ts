export const loginUser = async (email: string, password: string) => {
    const loginObject = {
        email: email,
        password: password,
    }
    try{
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(loginObject),
        });
        const data = await response.json();
        console.log('data',data)
        return data;

    } catch (error) {
        console.error(error);
    }
}
