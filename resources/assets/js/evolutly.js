// Interceptors , Depedencies ,
// Same Level file
require('./evolutly-bootstrap');

// All Our Global Components
// Located at resources/assets/js/evolutly
require('components/evo-components');

window.Vue = new Vue({
// Located at resources/assets/js/evolutly
    // mixins are all module.exports
    mixins: [require('evolutly-app')]
});
