import { storeModuleFactory } from "@/stores/factory";
import type Category from "@/stores/category";
import type Status from "@/stores/status";
import type User from "@/stores/user";

export * from "./auth.store";
export { useTicketStore } from "./tickets.store";
export { useUserStore } from "./users.store";
export const useTicketCategoryStore =
    storeModuleFactory<Category>("ticket-categories");
export const useTicketStatusStore =
    storeModuleFactory<Status>("ticket-statuses");
