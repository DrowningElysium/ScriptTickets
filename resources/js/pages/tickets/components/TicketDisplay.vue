<script setup lang="ts">
import { useAuthStore, useTicketStore, useTicketCategoryStore } from "@/stores";
import type Ticket from "@/stores/ticket";
import { Form, Field } from "vee-validate";
import { onMounted, ref } from "vue";
import * as Yup from "yup";
import CategoryDisplay from "./CategoryDisplay.vue";

const props = defineProps<{ ticket: Ticket }>();
const auth = useAuthStore();

onMounted(async () => {
    await useTicketCategoryStore.actions.getAll();
});
const categories = ref<Ticket>(useTicketCategoryStore.getters.all);
const modify = ref(false);

const schema = Yup.object().shape({
    title: Yup.string().required("Content is required"),
    categories: Yup.array().required("Content is required"),
    content: Yup.string().required("Content is required"),
});

const onSubmit = async (values: any) => {
    const { title, categories, content } = values;
    const ticket = {
        title: title,
        categories: categories,
        content: content,
    };
    useTicketStore.actions.update(props.ticket.id, ticket);
    modify.value = false;
};
</script>

<template>
    <div class="card">
        <div class="card-body">
            <div v-if="!modify">
                <div class="d-flex justify-content-between">
                    <div
                        class="card-title display-6"
                        style="margin-bottom: 0.2rem"
                    >
                        {{ props.ticket.title }}
                    </div>

                    <div class="ms-1" v-if="ticket.author_id === auth.user.id">
                        <a
                            class="btn btn-outline-secondary"
                            @click="modify = true"
                        >
                            <FontAwesomeIcon
                                icon="fa-regular fa-pen-to-square"
                            />
                        </a>
                    </div>
                </div>

                <div>
                    <CategoryDisplay :categories="props.ticket.categories" />
                </div>

                <div>
                    {{ props.ticket.content }}
                </div>
            </div>

            <div v-if="modify">
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
                            :value="props.ticket.title"
                        />

                        <div class="invalid-feedback">
                            {{ errors.email }}
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
                            :class="{ 'is-invalid': errors.title }"
                            v-slot="{ value }"
                        >
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                                :selected="
                                    value?.includes(category.id) ||
                                    props.ticket.categories.find(
                                        (c) => category.id === c.id
                                    )
                                "
                            >
                                {{ category.title }}
                            </option>
                        </Field>

                        <div class="invalid-feedback">
                            {{ errors.email }}
                        </div>
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label" for="content">Content</label>

                        <Field
                            as="textarea"
                            id="content"
                            name="content"
                            class="form-control"
                            :class="{ 'is-invalid': errors.content }"
                            :value="props.ticket.content"
                        />

                        <div class="invalid-feedback">
                            {{ errors.email }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="modify = false"
                        >
                            Cancel
                        </button>

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
</template>

<style scoped lang="scss">
.form-label {
    margin-bottom: 0;
}
</style>
