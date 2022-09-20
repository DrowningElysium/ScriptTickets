<script setup lang="ts">
import { Form, Field } from "vee-validate";
import { ref } from "vue";
import { useAuthStore } from "@/stores";
import * as Yup from "yup";
import AuthLayout from "./components/AuthLayout.vue";

// Needed to make the checkbox prechecked.
const rememberMe = ref(true);

const schema = Yup.object().shape({
    email: Yup.string()
        .required("Email address is required")
        .email("Email address must be a valid"),
    password: Yup.string().required("Password is required"),
});

const onSubmit = async (values: any) => {
    const authStore = useAuthStore();
    const { email, password, remember_me } = values;
    await authStore.login(email, password, remember_me);
};
</script>

<template>
    <AuthLayout>
        <template v-slot:title>Log in</template>

        <Form
            @submit="onSubmit"
            :validation-schema="schema"
            v-slot="{ errors, isSubmitting }"
        >
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

            <!-- Password input -->
            <div class="form-outline mb-1">
                <div>
                    <label class="form-label" for="password">Password&nbsp;</label>
                    <span class="small">
                        <RouterLink :to="{ name: 'forgot-password' }">(Forgotten?)</RouterLink>
                    </span>
                </div>
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

            <div class="d-flex justify-content-end mb-3">
                <div class="text-muted small">
                    Don't have an account?
                    <RouterLink :to="{ name: 'register' }">
                        Register now!
                    </RouterLink>
                </div>
            </div>

            <div class="row text-start">
                <!-- Checkbox -->
                <div class="col-6 form-check mb-1">
                    <Field
                        type="checkbox"
                        id="remember_me"
                        name="remember_me"
                        class="form-check-input me-2"
                        style="margin-left: -0.5em"
                        :unchecked-value="false"
                        :value="true"
                        v-model="rememberMe"
                    />
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>

                <div class="col-6 d-flex justify-content-end">
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
                        Log in
                    </button>
                </div>
            </div>
        </Form>
    </AuthLayout>
</template>
