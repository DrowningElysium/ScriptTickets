<script setup lang="ts">
import type Ticket from "@/stores/ticket";
import type Response from "@/stores/response";
import DateSpan from "@/components/DateSpan.vue";
import { useAuthStore, useTicketStore } from "@/stores";
import { Form, Field } from "vee-validate";
import { ref } from "vue";
import * as Yup from "yup";

const props = defineProps<{ ticket: Ticket; response: Response }>();
const modify = ref<boolean>(false);
const auth = useAuthStore();

const schema = Yup.object().shape({
    content: Yup.string().required("Content is required"),
});

const onSubmit = async (values: any) => {
    const { content } = values;
    const response = { ...props.response, content: content };
    useTicketStore.actions.updateResponse(props.ticket, response);
    modify.value = false;
};
</script>

<template>
    <div class="response mb-4">
        <div class="d-flex justify-content-between">
            <div class="response-author ms-1">
                {{ props.response.author.full_name }}
            </div>

            <div class="response-date me-1">
                <DateSpan :date="props.response.created_at" />
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between" v-if="!modify">
                    <div class="response-content">
                        {{ props.response.content }}
                    </div>

                    <div
                        class="response-actions ms-1"
                        v-if="response.author_id === auth.user.id"
                    >
                        <a
                            class="btn btn-outline-secondary"
                            @click="modify = !modify"
                        >
                            <FontAwesomeIcon
                                icon="fa-regular fa-pen-to-square"
                            />
                        </a>
                    </div>
                </div>

                <Form
                    @submit="onSubmit"
                    v-if="modify"
                    :validation-schema="schema"
                    v-slot="{ errors, isSubmitting }"
                >
                    <Field
                        as="textarea"
                        id="content"
                        name="content"
                        class="form-control me-auto"
                        :class="{ 'is-invalid': errors.content }"
                        placeholder="Leave a response here"
                        aria-label="Leave a response here"
                        :value="props.response.content"
                    />

                    <button
                        type="submit"
                        class="btn btn-secondary"
                        :disabled="isSubmitting"
                    >
                        <span
                            v-show="isSubmitting"
                            class="spinner-border spinner-border-sm ms-auto"
                        ></span>
                        Submit
                    </button>
                </Form>
            </div>
        </div>
    </div>
</template>
