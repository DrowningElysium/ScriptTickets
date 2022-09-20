import axios from "axios";

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
ax.interceptors.response.use(undefined, (error) => {
    if (axios.isAxiosError(error) && error.response) {
        alert((error.response.data as ErrorResponse).message); // Will be replaced with a better solution.
    }
});

export default ax;
