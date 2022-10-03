<script setup lang="ts">
import { useAuthStore, useTicketStatusStore, useTicketStore } from "@/stores";
import type Status from "@/stores/status";
import type Ticket from "@/stores/ticket";
import { Form, Field } from "vee-validate";
import { onMounted, ref } from "vue";
import * as Yup from "yup";

onMounted(async () => {
    await useTicketStatusStore.actions.getAll();
});
const statuses = ref<Status>(useTicketStatusStore.getters.all);
const props = defineProps<{ ticket: Ticket }>();
const modify = ref(false);
const auth = useAuthStore();

const schema = Yup.object().shape({
    status_id: Yup.number().required("Status is required"),
});

const onSubmit = async (values: any) => {
    const { status_id } = values;
    useTicketStore.actions.updateStatus(props.ticket, status_id);
    modify.value = false;
};
</script>

<template>
    <dd class="text-center">
        <span v-if="!modify">{{ props.ticket.status.title }}</span>
        <Form
            v-if="modify"
            @submit="onSubmit"
            :validation-schema="schema"
            v-slot="{ errors, isSubmitting }"
        >
            <div class="input-group">
                <Field
                    as="select"
                    id="status_id"
                    name="status_id"
                    class="form-control"
                    :value="props.ticket.status_id"
                    :class="{ 'is-invalid': errors.title }"
                    v-slot="{ value }"
                >
                    <option
                        v-for="status in statuses"
                        :key="status.id"
                        :value="status.id"
                        :selected="value === status.id"
                    >
                        {{ status.title }}
                    </option>
                </Field>

                <button
                    type="submit"
                    class="btn btn-secondary"
                    :disabled="isSubmitting"
                >
                    <span
                        v-show="isSubmitting"
                        class="spinner-border spinner-border-sm ms-auto"
                    ></span>
                    Save
                </button>
            </div>
        </Form>

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
