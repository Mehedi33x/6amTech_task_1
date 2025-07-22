import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./routes";
import axios from "axios";

// axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);
const app = createApp(App);
app.use(router);
app.mount("#app");
