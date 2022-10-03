import { storeModuleFactory } from "@/stores/factory";
import type Ticket from "@/stores/ticket";
import type Category from "@/stores/category";
import Axios from "@/utils/axios";
import type Response from "@/stores/response";

const base = storeModuleFactory<Category>("ticket-categories");
export const useTicketCategoryStore = {
    actions: {
        ...base.actions,
    },
    getters: {
        ...base.getters,
    },
    setters: {
        ...base.setters,
    },
};
