export const loginAttempt = async (email: string, password: string) => {
    const loginObject = {
        email: email,
        password: password,
    }
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]')
    const csrfToken = csrfTokenMeta?.getAttribute('content') || '';
    const headers: HeadersInit = {
        'X-CSRF-TOKEN': csrfToken
    };
    try{
        const response = await fetch('/api/login', {
            method: 'POST',
            headers,
            body: JSON.stringify(loginObject),
        });
        const data = await response.json();
        console.log('data',data)

    } catch (error) {
        console.error(error);
    }
}
