import type Category from "./category";
import type Response from "./response";
import type Status from "./status";
import type User from "./user";

export default interface Ticket {
    id: number;
    assigned_to_id: number;
    author_id: number;
    status_id: number;
    title: string;
    content: string;
    created_at: string;
    updated_at: string;

    response_count: number;

    assigned_to: User | null;
    author: User;
    categories: Category[];
    responses?: Response[];
    status: Status;
}
