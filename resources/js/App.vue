<script setup lang="ts">
import { useAuthStore } from "./stores";

const authStore = useAuthStore();
const logout = () => {
    authStore.logout();
};
</script>

<template>
    <div class="vh-100">
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
                        v-if="!authStore.isAuthenticated"
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
                        v-if="authStore.isAuthenticated"
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
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                style="padding: 0 0.5rem"
                            >
                                <img
                                    :src="authStore.gravatar"
                                    class="img-fluid rounded-circle"
                                    alt="Profile picture"
                                />
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <RouterLink
                                        :to="{ name: 'home' }"
                                        class="dropdown-item"
                                        active-class="active"
                                    >
                                        My tickets
                                    </RouterLink>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a class="dropdown-item" @click="logout">
                                        Log out
                                    </a>
                                </li>
                            </ul>
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

<style scoped>
.content-wrapper {
    height: calc(100% - 56px);
    background-color: hsl(0, 0%, 96%);
    overflow-y: scroll;
}
</style>
