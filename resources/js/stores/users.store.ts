import { storeModuleFactory } from "@/stores/factory";
import type User from "@/stores/user";
import { computed } from "vue";

const base = storeModuleFactory<User>("users");
export const useUserStore = {
    actions: {
        ...base.actions,
    },
    getters: {
        ...base.getters,
        allAdmins: computed(() =>
            useUserStore.getters.all.value.filter((user: User) => user.is_admin)
        ),
    },
    setters: {
        ...base.setters,
    },
};
