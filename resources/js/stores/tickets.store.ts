import { storeModuleFactory } from "@/stores/factory";
import type Ticket from "@/stores/ticket";
import type Category from "@/stores/category";
import Axios from "@/utils/axios";
import type Response from "@/stores/response";

const base = storeModuleFactory<Ticket>("tickets");
export const useTicketStore = {
    actions: {
        ...base.actions,
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
            base.setters.setById(data);
        },
        updateResponse: async (ticket: Ticket, response: Response) => {
            const { data } = await Axios.put(
                `tickets/${ticket.id}/responses/${response.id}`,
                {
                    content: response.content,
                }
            );
            if (!data) return;
            base.setters.setById(data);
        },
    },
    getters: {
        ...base.getters,
        getByCategoryId: (id: number) => {
            return base.getters.all.value.filter((ticket: Ticket) => {
                return ticket.categories.find(
                    (category: Category) => category.id === id
                );
            });
        },
    },
    setters: { ...base.setters },
};
