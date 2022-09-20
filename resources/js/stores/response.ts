import type Ticket from "./ticket";
import type User from "./user";

export default interface Response {
    id: number;
    author_id: number;
    ticket_id: number;
    content: string;
    created_at: Date;
    updated_at: Date;

    author: User | null;
    ticket: Ticket | null;
}
