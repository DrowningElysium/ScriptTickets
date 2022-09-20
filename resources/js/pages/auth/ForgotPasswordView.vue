<script setup lang="ts">
import { Form, Field } from "vee-validate";
import { useAuthStore } from "@/stores";
import * as Yup from "yup";
import AuthLayout from "./components/AuthLayout.vue";

const schema = Yup.object().shape({
    email: Yup.string()
        .required("Email address is required")
        .email("Email address must be a valid"),
});

const onSubmit = async (values: any) => {
    const authStore = useAuthStore();
    const { email } = values;
    await authStore.sendReset(email);
};
</script>

<template>
    <AuthLayout>
        <template v-slot:title>Forgot Password</template>

        <Form
            @submit="onSubmit"
            :validation-schema="schema"
            v-slot="{ errors, isSubmitting }"
        >
            <!-- Email input -->
            <div class="form-outline mb-3">
                <label class="form-label" for="email">Email address</label>
                <Field
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    :class="{ 'is-invalid': errors.email }"
                />
                <div class="invalid-feedback">
                    {{ errors.email }}
                </div>
            </div>

            <div class="row text-start">
                <div class="col-12 d-flex justify-content-end">
                    <!-- Submit button -->
                    <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        :disabled="isSubmitting"
                    >
                        <span
                            v-show="isSubmitting"
                            class="spinner-border spinner-border-sm mr-1"
                        ></span>
                        Send email
                    </button>
                </div>
            </div>
        </Form>
    </AuthLayout>
</template>
