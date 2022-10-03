import { storeModuleFactory } from "@/stores/factory";
import axios from "@/utils/axios";
import Axios from "@/utils/axios";
import type Category from "@/stores/category";
import type Response from "@/stores/response";
import type Ticket from "@/stores/ticket";
import type User from "@/stores/user";

const base = storeModuleFactory<Ticket>("tickets");
export const useTicketStore = {
    actions: {
        ...base.actions,
        create: async (
            newItem: Pick<Ticket, "title" | "categories" | "content">
        ) => {
            const { data } = await axios.post("tickets", newItem);
            if (!data) return;
            useTicketStore.setters.setById(data);
        },
        update: async (
            id: number,
            item: Pick<Ticket, "title" | "categories" | "content">
        ) => {
            const { data } = await axios.put(`tickets/${id}`, item);
            if (!data) return;
            useTicketStore.setters.setById(data);
        },
        createResponse: async (
            ticket: Ticket,
            response: Pick<Response, "content">
        ) => {
            const { data } = await Axios.post(
                `tickets/${ticket.id}/responses`,
                {
                    content: response.content,
                }
            );
            if (!data) return;
            useTicketStore.setters.setById(data);
        },
        updateResponse: async (ticket: Ticket, response: Response) => {
            const { data } = await Axios.put(
                `tickets/${ticket.id}/responses/${response.id}`,
                {
                    content: response.content,
                }
            );
            if (!data) return;
            useTicketStore.setters.setById(data);
        },
        assignToAdmin: async (ticket: Ticket, user: User | null) => {
            if (user && !user.is_admin) return;
            const { data } = await Axios.post(`tickets/${ticket.id}/assign`, {
                user_id: user?.id || null,
            });
            if (!data) return;
            useTicketStore.setters.setById(data);
        },
        updateStatus: async (ticket: Ticket, statusId: number) => {
            const { data } = await Axios.post(`tickets/${ticket.id}/status`, {
                status_id: statusId,
            });
            if (!data) return;
            useTicketStore.setters.setById(data);
        },
    },
    getters: {
        ...base.getters,
        getByCategoryId: (id: number) => {
            return useTicketStore.getters.all.value.filter((ticket: Ticket) => {
                return ticket.categories.find(
                    (category: Category) => category.id === id
                );
            });
        },
    },
    setters: { ...base.setters },
};
