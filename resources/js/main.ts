import { createApp } from "vue";
import { createPinia } from "pinia";
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from "@fortawesome/vue-fontawesome";

import App from "./App.vue";
import router from "./router";
import library from "./utils/icons";

import "./../css/app.scss";

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.component("FontAwesomeIcon", FontAwesomeIcon);
app.component("FontAwesomeLayers", FontAwesomeLayers);

app.mount("#app");
