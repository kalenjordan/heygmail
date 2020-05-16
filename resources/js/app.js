require('./bootstrap');

window.Vue = require('vue');

window.Vue.use(require('v-tooltip'));
window.Vue.use(require('vue-shortkey'));

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
    },
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
            if (this.isFormFieldFocused()) {
                this.manuallyAddCharacter('f');
                return;
            }

            this.focusMode = !this.focusMode;
        },
        clickLink(event, character, dontExecuteIfFormFieldFocused = true) {
            console.log(event);
            if (this.isFormFieldFocused() && dontExecuteIfFormFieldFocused) {
                this.manuallyAddCharacter(character);
                return;
            }

            event.target.click();
        },
        isFormFieldFocused() {
            let activeElement = document.activeElement;
            let inputs = ['input', 'select', 'textarea'];

            if (activeElement && inputs.indexOf(activeElement.tagName.toLowerCase()) !== -1) {
                return true;
            }
        },
        manuallyAddCharacter(character) {
            let activeElement = document.activeElement;
            activeElement.value += character;
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