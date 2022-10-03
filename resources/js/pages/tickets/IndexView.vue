<script setup lang="ts">
import { useTicketStore } from "@/stores";
import TicketTable from "./components/TicketTable.vue";
import type Ticket from "@/stores/ticket";
import { onMounted, ref } from "vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";

onMounted(async () => {
    await useTicketStore.actions.getAll();
});

const tickets = ref<Ticket[]>(useTicketStore.getters.all);
</script>

<template>
    <div class="px-4 py-5 px-md-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div
                            class="card-title display-6"
                            style="margin-bottom: 0.2rem"
                        >
                            Tickets
                        </div>

                        <div class="ms-1">
                            <RouterLink
                                :to="{ name: 'tickets.create' }"
                                class="btn btn-secondary"
                            >
                                Create ticket
                            </RouterLink>
                        </div>
                    </div>

                    <LoadingSpinner v-if="!tickets" />
                    <TicketTable :tickets="tickets" v-if="tickets" />
                </div>
            </div>
        </div>
    </div>
</template>
