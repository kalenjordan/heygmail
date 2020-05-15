require('./bootstrap');

window.Vue = require('vue');

import VTooltip from 'v-tooltip'
window.Vue.use(VTooltip);
window.Vue.use(require('vue-shortkey'), { prevent: ['input', 'textarea'] });

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
console.log(files);

const app = new Vue({
    el: '#app',
    data() {
        return {
            showAccountMenu: false,
            showMobileMenu: false,
            focusMode: false,
        }
    },
    methods: {
        toggleAccountMenu: function() {
            this.showAccountMenu = ! this.showAccountMenu;
        },
        toggleMobileMenu: function() {
            this.showMobileMenu = ! this.showMobileMenu;
        },
        toggleFocusMode() {
            this.focusMode = ! this.focusMode;
        }
    }
});