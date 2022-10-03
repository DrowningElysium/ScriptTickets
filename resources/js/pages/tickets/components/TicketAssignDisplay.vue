<script setup lang="ts">
import { useAuthStore, useTicketStore, useUserStore } from "@/stores";
import type Ticket from "@/stores/ticket";
import type User from "@/stores/user";
import { onMounted, ref } from "vue";

onMounted(async () => {
    await useUserStore.actions.getAll();
});

const users = ref<User[]>(useUserStore.getters.allAdmins);
const props = defineProps<{ ticket: Ticket }>();
const auth = useAuthStore();

const modify = ref(false);
const isSubmitting = ref(false);
const assignedAdmin = ref<User | null>(props.ticket.assigned_to);

const submit = async () => {
    isSubmitting.value = true;
    await useTicketStore.actions.assignToAdmin(
        props.ticket,
        assignedAdmin.value
    );
    isSubmitting.value = false;

    modify.value = false;
};
</script>

<template>
    <dd class="text-center">
        <span v-if="!modify">
            {{ props.ticket.assigned_to?.full_name || "Unassigned" }}
        </span>

        <div class="input-group" v-if="modify">
            <select
                v-model="assignedAdmin"
                class="form-control"
            >
                <option :value="null" :selected="assignedAdmin === null">
                    Unassigned
                </option>

                <option
                    v-for="user in users"
                    :key="user.id"
                    :value="user"
                    :selected="assignedAdmin?.id === user.id"
                >
                    {{ user.full_name }}
                </option>
            </select>

            <button
                type="submit"
                class="btn btn-secondary"
                :disabled="isSubmitting"
                @click="submit"
            >
                <span
                    v-show="isSubmitting"
                    class="spinner-border spinner-border-sm ms-auto"
                ></span>
                Save
            </button>
        </div>

        <span class="actions ms-1" v-if="auth.user?.is_admin">
            <FontAwesomeIcon
                v-if="!modify"
                @click="modify = true"
                icon="fa-regular fa-pen-to-square"
                title="Edit status"
            />
        </span>
    </dd>
</template>
