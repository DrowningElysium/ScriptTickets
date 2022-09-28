<script setup lang="ts">
import type Ticket from "@/stores/ticket";
import { Form, Field } from "vee-validate";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import * as Yup from "yup";
import { useTicketStore } from "@/stores";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import CategoryDisplay from "@/pages/tickets/components/CategoryDisplay.vue";
import DateSpan from "@/components/DateSpan.vue";
import TicketResponse from "@/pages/tickets/components/TicketResponse.vue";

const route = useRoute();

onMounted(async () => {
    await useTicketStore.actions.getById(parseInt(route.params.id as string));
});
const ticket = ref<Ticket>(
    useTicketStore.getters.byId(parseInt(route.params.id as string))
);

const schema = Yup.object().shape({
    content: Yup.string().required("Content is required"),
});

const onSubmit = async (values: any) => {
    const { content } = values;
    useTicketStore.actions.createResponse(ticket.value, { content: content });
};
</script>

<template>
    <div class="px-4 py-5 px-md-5">
        <LoadingSpinner class="h-100" v-if="!ticket" />
        <div class="container h-100" v-if="ticket">
            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h1>Ticket: {{ ticket.title }}</h1>
                            </div>

                            <div>
                                {{ ticket.content }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4" v-if="ticket.responses">
                        <div class="display-6">Responses</div>

                        <div class="responses mt-2">
                            <TicketResponse
                                class="mb-4"
                                v-for="response in ticket.responses"
                                :key="response.id"
                                :ticket="ticket"
                                :response="response"
                            />
                        </div>

                        <Form
                            @submit="onSubmit"
                            :validation-schema="schema"
                            v-slot="{ errors, isSubmitting }"
                            class="hstack gap-3 mt-2"
                        >
                            <Field
                                as="textarea"
                                id="content"
                                name="content"
                                class="form-control me-auto"
                                :class="{ 'is-invalid': errors.email }"
                                placeholder="Leave a response here"
                                aria-label="Leave a response here"
                            />

                            <button
                                type="submit"
                                class="btn btn-secondary mb-auto"
                                :disabled="isSubmitting"
                            >
                                <span
                                    v-show="isSubmitting"
                                    class="spinner-border spinner-border-sm mr-1"
                                ></span>
                                Submit
                            </button>

                            <div class="vr mb-auto" style="height: 37px"></div>
                            <button
                                type="button"
                                class="btn btn-outline-danger mb-auto"
                            >
                                Reset
                            </button>
                        </Form>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <dl>
                                <dt>Categories</dt>
                                <dd class="text-center">
                                    <CategoryDisplay
                                        :categories="ticket.categories"
                                    />
                                </dd>

                                <dt>Status</dt>
                                <dd class="text-center">
                                    {{ ticket.status.title }}
                                </dd>

                                <dt>Submitted at</dt>
                                <dd class="text-center">
                                    <DateSpan :date="ticket.created_at" />
                                </dd>

                                <dt>Last update</dt>
                                <dd class="text-center">
                                    <DateSpan :date="ticket.updated_at" />
                                </dd>

                                <dt>Submitted by</dt>
                                <dd class="text-center">
                                    {{ ticket.author.full_name }}
                                </dd>

                                <dt>Assigned to</dt>
                                <dd class="text-center">
                                    {{
                                        ticket.assigned_to?.full_name ||
                                        "Unassigned"
                                    }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
