import Swal from 'sweetalert2';
import moment from 'moment';
import axios from "axios"; 
// import axios from "@/axios"; 
export default {
    install(app) {
        app.config.globalProperties.$Swal = Swal;
        app.config.globalProperties.$moment = moment;
        app.config.globalProperties.$axios = axios;
    },
};