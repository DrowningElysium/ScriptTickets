import { storeModuleFactory } from "./factory";
import type Ticket from "./ticket.d";

export * from "./auth.store";
export const useTicketStore = storeModuleFactory<Ticket>("tickets");
