import { FormFields } from "../../../models/distributables/distributable";

//Takes a distributable type and creates a new distributable
export const createDistributable = async(
    distributableType: string,
    token: string,
    distributable: FormFields
) => {
        const response = await fetch(`/api/${distributableType}`, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        },
            body: JSON.stringify(distributable),
        });

        if (!response.ok) {
            throw new Error('Failed to create distributable');
        }

        const data = await response.json();
        console.log(data.message);
}

//Takes a distributable id and deletes a distributable
export const deleteDistributable = async(
    distributableType: string,
    distributableId: number,
    token: string
): Promise<void> => {
        const response = await fetch(`/api/${distributableType}/${distributableId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
        });

        if (!response.ok) {
            throw new Error('Failed to edit distributable');
        };
};

//Takes a distributable type and id and edits a distributable
export const editDistributable = async(
    distributableType: string,
    distributableId: number,
    token: string,
    distributable: FormFields
): Promise<void> => {
        const response = await fetch(`/api/${distributableType}/${distributableId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify(distributable),
        });

        if (!response.ok) {
            throw new Error('Failed to edit distributable');
        };
}

