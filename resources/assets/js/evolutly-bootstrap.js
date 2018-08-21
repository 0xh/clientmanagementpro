
/*
 * Load various JavaScript modules that assist Evolutly.
 */
window.URI = require('urijs');
window.axios = require('axios');
window._ = require('lodash');
window.moment = require('moment');
window.Promise = require('promise');
window.Cookies = require('js-cookie');

/*
 * Define Moment locales
 */
window.moment.defineLocale('en-short', {
    parentLocale: 'en',
    relativeTime: {
        future: "in %s",
        past: "%s",
        s: "1s",
        m: "1m",
        mm: "%dm",
        h: "1h",
        hh: "%dh",
        d: "1d",
        dd: "%dd",
        M: "1 month ago",
        MM: "%d months ago",
        y: "1y",
        yy: "%dy"
    }
});
window.moment.locale('en');

/*
 * Load jQuery and Bootstrap jQuery, used for front-end interaction.
 */
if (window.$ === undefined || window.jQuery === undefined) {
    window.$ = window.jQuery = require('jquery');
}
// Remove Since We Have it On Metro Ui JS
require('bootstrap/dist/js/npm');
// add finally in axios
require('promise.prototype.finally');
/**
 * Load Vue if this application is using Vue as its framework.
 * Load Vue & Vue-Resource.
 */
if ($('#evolutly-app').length > 0) {
// relative path: 
// resources/assets/js/evolutly
    require('vue-evo');
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': Evolutly.csrfToken
};

/**
 * Intercept the incoming responses.
 *
 * Handle any unexpected HTTP errors and pop up modals, etc.
 */
window.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    switch (error.response.status) {
        case 401:
        // LogOuts All Type of User...
            window.axios.get('/logout');

            // $('#modal-session-expired').modal('show');
            break;
        // Payment required Permission
        case 402:
            window.location = '/settings#/subscription';
            break;
    }

    return Promise.reject(error);
});