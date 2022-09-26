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
    <div class="h-100 px-4 py-5 px-md-5">
        <div class="container h-100">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title">
                        <h1>Tickets</h1>
                    </div>

                    <LoadingSpinner v-if="!tickets" />
                    <TicketTable :tickets="tickets" v-if="tickets" />
                </div>
            </div>
        </div>
    </div>
</template>
