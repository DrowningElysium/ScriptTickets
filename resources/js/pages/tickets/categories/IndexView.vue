<script setup lang="ts">
import type Ticket from "@/stores/ticket";
import { useTicketCategoryStore } from "@/stores";
import CategoryTable from "./components/CategoryTable.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import { Form, Field, type FormActions } from "vee-validate";
import { onMounted, ref } from "vue";
import * as Yup from "yup";

onMounted(async () => {
    await useTicketCategoryStore.actions.getAll();
});

const categories = ref<Ticket[]>(useTicketCategoryStore.getters.all);

const schema = Yup.object().shape({
    title: Yup.string().required("Title is required"),
});

const onSubmit = async (values: any, formAction: FormActions<any>) => {
    const { title } = values;
    const category = { title: title };
    useTicketCategoryStore.actions.create(category);
    formAction.resetForm();
};
</script>

<template>
    <div class="h-100 px-4 py-5 px-md-5">
        <div class="container h-100">
            <div class="card h-100">
                <div class="card-body">
                    <div class="w-100 d-flex justify-content-between">
                        <div class="card-title">
                            <h1>Tickets</h1>
                        </div>

                        <div class="create-category">
                            <Form
                                @submit="onSubmit"
                                :validation-schema="schema"
                                v-slot="{ errors, isSubmitting }"
                            >
                                <div class="input-group">
                                    <Field
                                        id="title"
                                        name="title"
                                        class="form-control me-auto"
                                        :class="{ 'is-invalid': errors.title }"
                                        placeholder="The title of the new category"
                                        aria-label="The title of the new category"
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
                                        Create
                                    </button>
                                </div>
                            </Form>
                        </div>
                    </div>

                    <LoadingSpinner v-if="!categories" />
                    <CategoryTable :categories="categories" v-if="categories" />
                </div>
            </div>
        </div>
    </div>
</template>
