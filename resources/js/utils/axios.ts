import axios from "axios";
import Swal from "sweetalert2";

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

interface ErrorResponse {
    message: String;
    errors: undefined | String[][];
}

const ax = axios.create({
    headers: {
        "X-Requested-With": "XMLHttpRequest",
    },
    withCredentials: true,
    baseURL: `${import.meta.env.VITE_API_URL}`,
});

ax.get("/sanctum/csrf-cookie");

// Add a default exception handling
ax.interceptors.response.use(undefined, async (error) => {
    if (axios.isAxiosError(error) && error.response) {
        // Don't want to show this error when checking if the user is logged in.
        if (!error.request.responseURL.endsWith("/api/user")) {
            await Swal.fire({
                title:
                    error.response.status === 422
                        ? "Validation error"
                        : "Unexpected error",
                text: String((error.response.data as ErrorResponse).message),
                icon: "error",
            });
        }
    }

    return Promise.reject(error);
});

export default ax;
