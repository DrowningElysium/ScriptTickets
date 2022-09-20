<script setup lang="ts">
import { useAuthStore } from "@/stores";
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthLayout from "./components/AuthLayout.vue";

const schema = Yup.object().shape({
    first_name: Yup.string().required("First name is required"),
    last_name: Yup.string().required("Last name is required"),
    email: Yup.string()
        .required("Email address is required")
        .email("Email address must be a valid"),
    telephone_number: Yup.string().required("Phonenumber is required"),
    password: Yup.string()
        .required("Password is required")
        .min(8, "Password needs at least 8 characters"),
    password_confirmation: Yup.string()
        .required("Password confirmation is required")
        .oneOf([Yup.ref("password"), null], "Passwords don't match"),
});

const onSubmit = async (values: any) => {
    const authStore = useAuthStore();
    const { first_name, last_name, email, telephone_number, password } = values;
    await authStore.register(
        first_name,
        last_name,
        email,
        telephone_number,
        password
    );
};
</script>

<template>
    <AuthLayout>
        <template v-slot:title>Registration</template>

        <Form
            @submit="onSubmit"
            :validation-schema="schema"
            v-slot="{ errors, isSubmitting }"
        >
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row">
                <div class="col-md-6 mb-1">
                    <div class="form-outline">
                        <label class="form-label" for="first_name"
                            >First name</label
                        >
                        <Field
                            type="text"
                            id="first_name"
                            name="first_name"
                            class="form-control"
                            :class="{
                                'is-invalid': errors.first_name,
                            }"
                        />
                        <div class="invalid-feedback">
                            {{ errors.first_name }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-1">
                    <div class="form-outline">
                        <label class="form-label" for="last_name"
                            >Last name</label
                        >
                        <Field
                            type="text"
                            id="last_name"
                            name="last_name"
                            class="form-control"
                            :class="{
                                'is-invalid': errors.last_name,
                            }"
                        />
                        <div class="invalid-feedback">
                            {{ errors.last_name }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-1">
                <label class="form-label" for="email"> Email address </label>
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

            <!-- Phonenumber input -->
            <div class="form-outline mb-1">
                <label class="form-label" for="telephone_number">
                    Phonenumber
                </label>
                <Field
                    type="text"
                    id="telephone_number"
                    name="telephone_number"
                    class="form-control"
                    :class="{
                        'is-invalid': errors.telephone_number,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.telephone_number }}
                </div>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-1">
                <label class="form-label" for="password"> Password </label>
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
            <div class="form-outline mb-1">
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

            <div class="d-flex justify-content-end mb-3">
                <div class="text-muted small">
                    Have an account?
                    <RouterLink :to="{ name: 'login' }">
                        Log in now!
                    </RouterLink>
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
                        Sign up
                    </button>
                </div>
            </div>
        </Form>
    </AuthLayout>
</template>
