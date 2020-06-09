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
            this.hotkeys(e, activeElement);
        });

        this.successMessage = window.successMessage;
    },
    data() {
        return {
            showAccountMenu: false,
            showMobileMenu: false,
            focusMode: false,
            showSearch: false,
            successMessage: null,
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
        hotkeys(e, activeElement) {
            if (document.querySelector('.ais-results a')) {
                this.hotkeysSearch(e, activeElement);
            }

            if (e.code === 'Escape') {
                this.successMessage = null;
                if (activeElement.getAttribute('type') === 'search') {
                    this.toggleSearch();
                }
                activeElement.blur();
            }
            if (e.code === 'Enter' && e.metaKey) {
                if (document.querySelector('form')) {
                    document.querySelector('form').submit();
                }
            }
        },
        hotkeysSearch(e, activeElement) {
            let activeSearchResult = null;
            activeSearchResult = document.querySelector('.ais-results a.active');
            if (! activeSearchResult) {
                let activeSearchResult = document.querySelector('.ais-results a:first-of-type');
                activeSearchResult.classList.add('active');
            }

            if (e.code === 'Enter' && activeSearchResult) {
                activeSearchResult.click();
            } else if (e.code === 'ArrowDown' && activeSearchResult) {
                let next = activeSearchResult.nextSibling;
                if (next) {
                    activeSearchResult.classList.remove('active');
                    next.classList.add('active');
                }
            } else if (e.code === 'ArrowUp' && activeSearchResult) {
                let next = activeSearchResult.previousSibling;
                if (next) {
                    activeSearchResult.classList.remove('active');
                    next.classList.add('active');
                }
            }
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