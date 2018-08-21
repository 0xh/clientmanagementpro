import VueUp from 'vueup'
import vmodal from 'vue-js-modal'
var draggable = require('vuedraggable')

/*
 * Load Vue & Vue-Resource.
 *
 * Vue is the JavaScript framework used by Evolutly.
 */
if (window.Vue === undefined) {
    window.Vue = require('vue');

    window.Bus = new Vue();
}

/**
 * Load Vue Global Mixin.
 */
// relative path: 
// resources/assets/js/evolutly

// This is  a Computed Properties For Evolutly Object

Vue.use(vmodal)
Vue.use(VueUp)


var progressBar = require('components/progress-bar');

Vue.component('progress-bar', {
    mixins: [progressBar]
});
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
Vue.component('draggable', draggable)



/**
 * Define the Vue filters.
 */
// relative path: 
// resources/assets/js/evolutly
require('vue_evo_filters');

/**
 * Load the Evolutly form utilities.
 */
// relative path: 
// resources/assets/js/evolutly
require('forms/evo-form-bootstrap');

Vue.use(require('vue-full-calendar'))