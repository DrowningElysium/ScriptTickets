<script setup lang="ts">
import type Ticket from "@/stores/ticket";
import DateSpan from "@/components/DateSpan.vue";
import CategoryDisplay from "@/pages/tickets/components/CategoryDisplay.vue";

const props = defineProps<{ tickets: Ticket[] }>();
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
            <tr v-for="ticket in props.tickets" :key="ticket.id">
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
