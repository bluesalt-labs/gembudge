// Gembudge core
require('./gembudge.js');

// Gembudge components
import App from 'App'

// Gembudge stylesheets
require('./scss/app.scss');

Gembudge.app = new Vue({
    el: '#gembudge-app',
    template: '<App/>',
    components: { App }
});