import Swal from "sweetalert2";
import type User from "./user";
import Axios from "@/utils/axios";
import Router from "@/router";
import md5 from "md5";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
    const user = ref(null as User | null);
    const returnUrl = ref(null as string | null);

    const isAuthenticated = computed(() => user.value);
    const gravatar = computed(() => {
        if (!user.value) {
            return "https://www.gravatar.com/avatar";
        }

        const email = user.value.email.trim().toLowerCase();
        const hash = md5(email);

        return "https://www.gravatar.com/avatar/" + hash;
    });

    const register = async (
        first_name: string,
        last_name: string,
        email: string,
        telephone_number: string,
        password: string
    ) => {
        try {
            const response = await Axios.post("register", {
                first_name: first_name,
                last_name: last_name,
                email: email,
                telephone_number: telephone_number,
                password: password,
            });

            user.value = response.data;

            await Router.push({ name: "home" });
        } catch (error) {
            //
        }
    };

    const login = async (
        email: string,
        password: string,
        remember: boolean
    ) => {
        try {
            const response = await Axios.post("login", {
                email: email,
                password: password,
                remember_me: remember,
            });

            user.value = response.data;

            await Router.push(returnUrl.value || { name: "home" });
        } catch (error) {
            //
        }
    };

    const checkLogin = async () => {
        try {
            const response = await Axios.get("user");

            user.value = response.data;

            await Router.push(returnUrl.value || { name: "home" });
        } catch (error) {
            //
        }
    };

    const sendReset = async (email: string) => {
        try {
            const response = await Axios.post("/forgot-password", {
                email: email,
            });

            alert(response.data.status);

            await Router.push({ name: "home" });
        } catch (error) {
            //
        }
    };

    const resetPassword = async (
        token: string,
        email: string,
        password: string
    ) => {
        try {
            const response = await Axios.post("/reset-password", {
                token: token,
                email: email,
                password: password,
            });

            Swal.fire({
                title: "Success",
                text: String(response.data.message),
                icon: "success",
            });

            await Router.push({ name: "login" });
        } catch (error) {
            //
        }
    };

    const logout = async () => {
        user.value = null;

        await Axios.post("/logout");
        await Router.push({ name: "login" });
    };

    return {
        user,
        returnUrl,
        isAuthenticated,
        gravatar,
        register,
        login,
        checkLogin,
        sendReset,
        resetPassword,
        logout,
    };
});
