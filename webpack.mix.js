let mix = require('laravel-mix');
var path = require('path');
mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js'),
            path.resolve(__dirname, 'resources/assets/js/evolutly'),
            'node_modules',
        ],
        alias: {
            'vue$': 'vue/dist/vue.js'
        }
    }
});
mix.styles([
    // Add Here all CSS to Concatenate

    // We import Metro Ui
    'resources/assets/metro/css/metro.css',
    'resources/assets/metro/css/metro-icons.css',
    'resources/assets/metro/css/metro-responsive.css',
    'resources/assets/metro/css/metro-schemes.css',
    'resources/assets/metro/css/metro-colors.css',
    'resources/assets/metro/css/metroskin-animation.css',
    'resources/assets/metro/css/font-awesome.css',
    'resources/assets/metro/plugins/bootstrap/css/bootstrap.metro.css',
    'resources/assets/metro/css/help.css',
    'resources/assets/metro/css/parsley.css',
    // This Contain CSS Class For Sidebar and Other Widget
    'resources/assets/metro/css/docs.css',
    'resources/assets/metro/css/docs-rtl.css',
    'node_modules/sweetalert/dist/sweetalert.css'
], 'public/css/metro.css')  

// This Has Jquery Included
mix.js('resources/assets/js/app.js', 'public/js/app.js')
mix.js('resources/assets/js/evolutly.js', 'public/js/evolutly.js')

mix.combine([
    // required Jquery to Run this
    'node_modules/sweetalert/dist/sweetalert.min.js',
    'resources/assets/metro/js/metro.js',
    'resources/assets/metro/plugins/jquery-ui.min.js',
    // 'resources/assets/metro/plugins/countup/countUp-ui.min.js',
    // added data tables // read more about this shit
    'resources/assets/metro/js/jquery.dataTables.min.js',
    // This Contains The Js For Sidebar
    'resources/assets/metro/js/docs.js',
], 'public/js/metro.js')

if (mix.config.inProduction) {
    mix.version()
}
// mix.browserSync({
//     proxy: 'sparky.dev'
// });