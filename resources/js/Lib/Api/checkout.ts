//checks out a distributable gives a patronId and distributableId
export const checkoutDistributable = async (patronId: number, distributableId: number, token: string) => {
    const checkoutObject = {
        "distributable_id": distributableId,
        "patron_id": patronId
    }
    try{
        const response = await fetch('/api/checkout/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(checkoutObject),
        })
        const data = await response.json();
        return data;
    }catch (error) {
        console.error(error);
    }
};

//checks in a distributable by id
export const checkinDistributable = async (distributableId: number, token: string) => {
    try{
        const response = await fetch(`/api/checkin/${distributableId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
        })
        const data = await response.json();
        return data;
    }catch (error) {
        console.error(error);
    }
};

//lists all checkouts
export const listCheckouts = async (token: string) => {
    try{
        const response = await fetch(`/api/checkouts`);
        const data = await response.json();
        return data;
    }catch (error) {
        console.error(error);
    }
};
