
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 | This is For the Tenant Front End , We Dont wanna Messed With it...
 |
 */

require('./spark-bootstrap');

require('./components/bootstrap');

var app = new Vue({
    // You Are Actually Calling This From
    // vendor/laravel/spark/resources/assets/js/spark.js
    mixins: [require('spark')]
});
