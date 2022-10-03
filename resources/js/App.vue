<script setup lang="ts">
import { onMounted } from "vue";
import { useAuthStore } from "./stores";

const auth = useAuthStore();
onMounted(() => {
    auth.checkLogin();
});

const logout = () => {
    auth.logout();
};
</script>

<template>
    <div class="wrapper">
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Script Tickets</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbar"
                    aria-controls="navbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul
                        class="navbar-nav ms-auto mb-2 mb-lg-0"
                        v-if="!auth.isAuthenticated"
                    >
                        <li class="nav-item">
                            <RouterLink
                                :to="{ name: 'register' }"
                                class="nav-link"
                                active-class="active"
                            >
                                Register
                            </RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink
                                :to="{ name: 'login' }"
                                class="nav-link"
                                active-class="active"
                            >
                                Login
                            </RouterLink>
                        </li>
                    </ul>

                    <ul
                        class="navbar-nav ms-auto mb-2 mb-lg-0"
                        v-if="auth.isAuthenticated"
                    >
                        <li class="nav-item">
                            <RouterLink
                                :to="{ name: 'home' }"
                                class="nav-link"
                                active-class="active"
                            >
                                Home
                            </RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink
                                :to="{ name: 'tickets.index' }"
                                class="nav-link"
                                active-class="active"
                            >
                                Tickets
                            </RouterLink>
                        </li>
                        <li class="nav-item" v-if="auth.user.is_admin">
                            <RouterLink
                                :to="{ name: 'ticket-categories.index' }"
                                class="nav-link"
                                active-class="active"
                            >
                                Ticket Categories
                            </RouterLink>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" @click.prevent="logout">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            <RouterView />
        </div>
    </div>
</template>
