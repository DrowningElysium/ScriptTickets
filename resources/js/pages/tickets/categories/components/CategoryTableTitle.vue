<script setup lang="ts">
import type Category from "@/stores/category";
import { useTicketCategoryStore } from "@/stores";
import Swal from "sweetalert2";
import { Form, Field } from "vee-validate";
import { ref } from "vue";
import * as Yup from "yup";

const props = defineProps<{ category: Category }>();
const modify = ref(false);

const schema = Yup.object().shape({
    title: Yup.string().required("Title is required"),
});

const onSubmit = async (values: any) => {
    const { title } = values;
    const category = { ...props.category, title: title };
    useTicketCategoryStore.actions.update(category.id, category);
    modify.value = false;
};

const destroy = async (category: Category) => {
    // If the category has tickets, it's not allowed to be deleted.
    if (category.tickets_count) {
        return;
    }

    const answer = await Swal.fire({
        title: `Are you sure you want to delete the category "${category.title}"?`,
        showDenyButton: true,
    });

    if (answer.isConfirmed) {
        useTicketCategoryStore.actions.delete(category.id);
    }
};
</script>

<template>
    <td class="d-flex justify-content-start">
        <div class="actions hstack gap-1 me-2">
            <FontAwesomeIcon
                v-if="!modify"
                @click="modify = true"
                icon="fa-regular fa-pen-to-square"
                title="Edit category"
            />

            <FontAwesomeLayers
                v-if="modify"
                @click="modify = false"
                title="Cancel editing"
            >
                <FontAwesomeIcon icon="fa-regular fa-pen-to-square" />
                <FontAwesomeIcon icon="fa-solid fa-slash" />
            </FontAwesomeLayers>

            <FontAwesomeIcon
                v-if="!modify"
                @click="destroy(category)"
                icon="fa-regular fa-trash-can"
                :class="{ disabled: category.tickets_count }"
                title="Delete category"
            />
        </div>

        <div class="edit-form w-100" v-if="modify">
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
                        placeholder="Fill in the title"
                        aria-label="Fill in the title"
                        :value="props.category.title"
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
                        Save
                    </button>
                </div>
            </Form>
        </div>
        <div v-if="!modify">{{ props.category.title }}</div>
    </td>
</template>
