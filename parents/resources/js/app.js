import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { VanillaComponents } from '@flavorly/vanilla-components';
import { Plugin } from '@flavorly/vanilla-components';
import { ExclamationTriangleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { setupCalendar, Calendar, DatePicker } from 'v-calendar';
import VueHtmlToPaper from 'vue-html-to-paper';
import 'maz-ui/css/main.css';
import { createI18n } from 'vue-i18n';
import messages from '@/lang/messages.js';
import "/node_modules/flag-icons/css/flag-icons.min.css";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import VueQrcode from '@chenfengyuan/vue-qrcode';

const i18n = createI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages,
});

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component(VueQrcode.name, VueQrcode)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast)
            .use(VueSweetalert2)
            .use(i18n)
            .use(VueHtmlToPaper)
            .use(setupCalendar, {})
            .use(VanillaComponents, Plugin)
            .use(ExclamationTriangleIcon, XMarkIcon)
            .use(VueDatePicker)
            .mixin({methods: {
                can: function(permissions) {
                    var param = Array(permissions)
                    var allPermissions = this.$page.props.auth.can;
                    var hasPermission = false;
                    param.forEach(function(item){
                        if(allPermissions[item]){
                            hasPermission = true;  
                        }
                    });
                    return hasPermission;
                },
                is_superAdmin: function(val) {
                    var permission_super = this.$page.props.auth.is_super_admin;
                    var user_level = this.$page.props.auth.user.user_level;
                    var hasPermission = false;
                    permission_super.forEach(function(item){
                        if(item.name==val && user_level===2){
                            hasPermission = true;
                        }
                    });
                    return hasPermission;
                }
            }})
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
