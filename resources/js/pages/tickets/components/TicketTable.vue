<script setup lang="ts">
import { useAuthStore } from "@/stores";
import type Ticket from "@/stores/ticket";
import DateSpan from "@/components/DateSpan.vue";
import CategoryDisplay from "@/pages/tickets/components/CategoryDisplay.vue";
import { computed } from "vue";

const props = defineProps<{ tickets: Ticket[] }>();
const auth = useAuthStore();

const tickets = computed(() => {
    // Users want the most recently updated tickets found the fastest,
    //      admins want the tickets that haven't had an update the longest.
    return Object.values(props.tickets).sort((a: Ticket, b: Ticket) => {
        const dateA = Date.parse(a.updated_at);
        const dateB = Date.parse(b.updated_at);

        if (dateA > dateB) {
            return auth.user?.is_admin ? 1 : -1;
        }

        if (dateA < dateB) {
            return auth.user?.is_admin ? -1 : 1;
        }

        return 0;
    });
});
</script>

<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Categories</th>
                <th>Status</th>
                <th>Created by</th>
                <th>Last update</th>
                <th>Assigned to</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="ticket in tickets" :key="ticket.id">
                <td>{{ ticket.id }}</td>
                <td>
                    <RouterLink
                        :to="{
                            name: 'tickets.show',
                            params: { id: ticket.id },
                        }"
                    >
                        {{ ticket.title }}
                    </RouterLink>
                </td>
                <td>
                    <CategoryDisplay :categories="ticket.categories" />
                </td>
                <td>{{ ticket.status.title }}</td>
                <td>{{ ticket.author.full_name }}</td>
                <td>
                    <DateSpan :date="ticket.updated_at" />
                </td>
                <td>{{ ticket.assigned_to?.full_name || "Not assigned" }}</td>
            </tr>
        </tbody>
    </table>
</template>

<style scoped></style>
