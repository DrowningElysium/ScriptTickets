import { storeModuleFactory } from "./factory";
import type Ticket from "./ticket.d";

export * from "./auth.store";
export const tickets = storeModuleFactory<Ticket>("tickets");
