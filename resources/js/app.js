require('./bootstrap');

window.Vue = require('vue');

window.Vue.use(require('v-tooltip'));
window.Vue.use(require('vue-shortkey'), {prevent: ['input', 'textarea']});

import InstantSearch from 'vue-instantsearch';
window.Vue.use(InstantSearch);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
console.log(files);

const app = new Vue({
    el: '#app',
    mounted() {
        let formElement = document.querySelector('textarea');
        if (formElement) {
            formElement.focus();
        }

        document.addEventListener('keydown', (e) => {
            let activeElement = document.activeElement;
            if (e.code === 'Escape') {
                if (activeElement.getAttribute('type') === 'search') {
                    this.toggleSearch();
                }
                activeElement.blur();
            }
            if (e.code === 'Enter' && e.metaKey) {
                if (this.form) {
                    this.form.submit();
                }
            }
        });
    },
    data() {
        return {
            showAccountMenu: false,
            showMobileMenu: false,
            focusMode: false,
            showSearch: false,
        }
    },
    methods: {
        toggleAccountMenu: function () {
            this.showAccountMenu = !this.showAccountMenu;
        },
        toggleMobileMenu: function () {
            this.showMobileMenu = !this.showMobileMenu;
        },
        toggleFocusMode() {
            this.focusMode = !this.focusMode;
        },
        toggleSearch() {
            this.showSearch = ! this.showSearch;
            if (this.showSearch) {
                setTimeout(() => {
                    let input = document.querySelector('.ais-input');
                    if (input) {
                        input.focus();
                    }
                }, 200);
            }
        },
        clickLink(event) {
            event.target.click();
        },
        showKeyboardShortcuts() {
            alert("" +
                "F - focus mode" + "\n" +
                "Command + Enter - Submit form" + "\n" +
                "Shift + A - open airtable (admin only)" + "\n" +
                "");
        }
    }
});