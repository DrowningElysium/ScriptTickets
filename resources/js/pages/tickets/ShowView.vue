<script setup lang="ts">
import DateSpan from "@/components/DateSpan.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import TicketAssignDisplay from "@/pages/tickets/components/TicketAssignDisplay.vue";
import TicketDisplay from "./components/TicketDisplay.vue";
import TicketResponse from "./components/TicketResponseDisplay.vue";
import TicketStatusDisplay from "./components/TicketStatusDisplay.vue";
import type Ticket from "@/stores/ticket";
import { Form, Field, type FormActions } from "vee-validate";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import * as Yup from "yup";
import { useTicketStore } from "@/stores";

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

const onSubmit = async (values: any, formAction: FormActions<any>) => {
    const { content } = values;
    useTicketStore.actions.createResponse(ticket.value, { content: content });
    formAction.resetForm();
};
</script>

<template>
    <div class="px-4 py-5 px-md-5">
        <LoadingSpinner class="h-100" v-if="!ticket" />
        <div class="container h-100" v-if="ticket">
            <div class="row">
                <div class="col-9">
                    <TicketDisplay :ticket="ticket" />

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
                                :class="{ 'is-invalid': errors.content }"
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
                                type="reset"
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
                                <dt>Status</dt>
                                <TicketStatusDisplay :ticket="ticket" />

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
                                <TicketAssignDisplay :ticket="ticket" />
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
