<script setup lang="ts">
import Router from "@/router";
import { useTicketStore, useTicketCategoryStore } from "@/stores";
import type Ticket from "@/stores/ticket";
import { Form, Field } from "vee-validate";
import { onMounted, ref } from "vue";
import * as Yup from "yup";

onMounted(async () => {
    await useTicketCategoryStore.actions.getAll();
});
const categories = ref<Ticket>(useTicketCategoryStore.getters.all);

const schema = Yup.object().shape({
    title: Yup.string().required("Title is required"),
    categories: Yup.array().required("Categories is required"),
    content: Yup.string().required("Content is required"),
});

const onSubmit = async (values: any) => {
    const { title, categories, content } = values;
    const ticket = {
        title: title,
        categories: categories,
        content: content,
    };
    useTicketStore.actions.create(ticket);
    await Router.push({ name: "tickets.index" });
};
</script>

<template>
    <div class="px-4 py-5 px-md-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="card-title display-6">Create ticket</div>

                    <Form
                        class="w-100"
                        @submit="onSubmit"
                        :validation-schema="schema"
                        v-slot="{ errors, isSubmitting }"
                    >
                        <div class="form-outline mb-2">
                            <label class="form-label" for="title">Title</label>

                            <Field
                                id="title"
                                name="title"
                                class="form-control"
                                :class="{ 'is-invalid': errors.title }"
                            />

                            <div class="invalid-feedback">
                                {{ errors.title }}
                            </div>
                        </div>

                        <div class="form-outline mb-2">
                            <label class="form-label" for="categories">
                                Categories
                            </label>

                            <Field
                                as="select"
                                multiple
                                id="categories"
                                name="categories"
                                class="form-control"
                                :class="{ 'is-invalid': errors.categories }"
                                v-slot="{ value }"
                            >
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                    :selected="value?.includes(category.id)"
                                >
                                    {{ category.title }}
                                </option>
                            </Field>

                            <div class="invalid-feedback">
                                {{ errors.categories }}
                            </div>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label" for="content"
                                >Content</label
                            >

                            <Field
                                as="textarea"
                                id="content"
                                name="content"
                                class="form-control"
                                :class="{ 'is-invalid': errors.content }"
                            />

                            <div class="invalid-feedback">
                                {{ errors.content }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button
                                type="submit"
                                class="btn btn-success"
                                :disabled="isSubmitting"
                            >
                                <span
                                    v-show="isSubmitting"
                                    class="spinner-border spinner-border-sm ms-auto"
                                ></span>
                                Update
                            </button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.form-label {
    margin-bottom: 0;
}
</style>
