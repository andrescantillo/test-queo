import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ContentHeader from './components/ContentHeader.vue';
import Content from './components/Content.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VeeValidate from 'vee-validate';

import Swal from 'sweetalert2';
window.Swal = Swal;

const app = createApp(App)

app.component('content-header',ContentHeader)
.component('content',Content)
.use(store).use(router).use(VeeValidate).use(VueSweetalert2).mount('#app')
