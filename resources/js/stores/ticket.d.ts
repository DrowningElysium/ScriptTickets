import type Category from "./category";
import type Response from "./response";
import type Status from "./status";
import type User from "./user";

export default interface Ticket {
    id: number;
    author_id: number;
    category_id: number;
    status_id: number;
    title: string;
    content: string;
    created_at: Date;
    updated_at: Date;

    response_count: number;

    author: User;
    category: Category;
    responses: Response[];
    status: Status;
}
