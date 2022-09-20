<script setup lang="ts">
import { Form, Field } from "vee-validate";
import { useAuthStore } from "@/stores";
import * as Yup from "yup";
import AuthLayout from "./components/AuthLayout.vue";
import { useRoute } from "vue-router";

const $route = useRoute();
const email = $route.query.email || "";

const schema = Yup.object().shape({
    email: Yup.string()
        .required("Email address is required")
        .email("Email address must be a valid"),
    password: Yup.string()
        .required("Password is required")
        .min(8, "Password needs at least 8 characters"),
    password_confirmation: Yup.string()
        .required("Password confirmation is required")
        .oneOf([Yup.ref("password"), null], "Passwords don't match"),
});

const onSubmit = async (values: any) => {
    const authStore = useAuthStore();
    const { email, password } = values;
    await authStore.resetPassword(
        $route.params.token as string,
        email,
        password
    );
};
</script>

<template>
    <AuthLayout>
        <template v-slot:title>Reset Password</template>

        <Form
            @submit="onSubmit"
            :validation-schema="schema"
            v-slot="{ errors, isSubmitting }"
        >
            <!-- Email input -->
            <div class="form-outline mb-1">
                <label class="form-label" for="email">Email address</label>
                <Field
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    :class="{ 'is-invalid': errors.email }"
                    v-model="email"
                />
                <div class="invalid-feedback">
                    {{ errors.email }}
                </div>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-1">
                <label class="form-label" for="password">Password</label>
                <Field
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    :class="{
                        'is-invalid': errors.password,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.password }}
                </div>
            </div>

            <!-- Password confirmation input -->
            <div class="form-outline mb-3">
                <label class="form-label" for="password_confirmation">
                    Password confirmation
                </label>
                <Field
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    :class="{
                        'is-invalid': errors.password_confirmation,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.password_confirmation }}
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
