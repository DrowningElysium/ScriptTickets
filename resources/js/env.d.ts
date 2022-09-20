/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_APP_URL: string;
    readonly VITE_API_URL: string;

    readonly VITE_PUSHER_APP_KEY: string;
    readonly VITE_PUSHER_HOST: string;
    readonly VITE_PUSHER_PORT: string;
    readonly VITE_PUSHER_SCHEME: string;
    readonly VITE_PUSHER_APP_CLUSTER: string;
}

interface ImportMeta {
    readonly env: ImportMetaEnv;
}
