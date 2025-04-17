import { PatronForm } from "../../../models/patrons/patronModel";

//fetches patrons
export const fetchPatrons = async(token: string) => {
    const response = await fetch(`/api/patrons`, {
            headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        }
    });
    if(!response.ok){
        throw new Error('Failed to fetch patron');
    };
    const patronData = await response.json();
    return(patronData);

}

//fetches patron by id
export const fetchPatronById = async(id: number, token: string) => {
    const response = await fetch(`/api/patrons/${id}`, {
            headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        },
    });
    if(!response.ok){
        throw new Error('Failed to fetch patron');
    };
    const patronData = await response.json();
    return(patronData);

}

//creates a patron
export const createPatron = async (patron: PatronForm, token: string) => {
        const response = await fetch('/api/patrons', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        },
            body: JSON.stringify(patron),
        });

        if (!response.ok) {
            throw new Error('Failed to create patron');
        }
}

//edits a patron by id
export const editPatron = async (id: number, patron: PatronForm, token: string) => {
    const response = await fetch(`/api/patrons/${id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
        },
        body: JSON.stringify(patron),
    });
    if (!response.ok) {
        throw new Error('Failed to edit patron');
    }
    const data = await response.json();
    return data;
}

//
