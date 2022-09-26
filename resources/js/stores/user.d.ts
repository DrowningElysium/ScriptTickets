export default interface User {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    telephone_number: string;
    is_admin: boolean;
    created_at: string; // Need to change type?
    updated_at: string; // Need to change type?
}
