<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<!-- Head-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SEO -->
    <meta name="description" content="{{ config('seo.description', 'Laravel') }}">
    <meta name="keywords" content="{{ config('seo.keywords', 'Laravel') }}">
    <meta name="author" content="{{ config('seo.author', 'Laravel') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <!-- This is the Compiled CSS of Spark and Metro Ui -->
    <link href="{{ mix('css/metro.css') }}" rel="stylesheet">
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <!-- Metro Asset CSS Helper -->
    {!! call_css(isset($css)? $css : array()) !!}
    <!-- Inject Css On The Fly -->
    @stack('critical_css')

    <!-- Add Globals For Laravel and Spark -->
    @include('partials.global_js')

    <!-- Inject Header JS on the Fly -->
    @stack('header_js')
</head>

<!-- Body Contents -->

<body onload="init();" class="{{ $appcolor or 'bg-steel' }} " dir="">
    <div id="spark-app" v-cloak>
        <!-- Make The Containing Full Screen -->
        <div id="login-page" class="page-container op-black" style="height:100vh">
            @yield('content')
        </div>
    </div>
    </div>
    @include( 'partials.footer')
    <!-- Proper Order of Js is Necessary -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/metro.js') }}"></script>
    <!-- Metro Asset JS Helper for Jquery Plugins -->
    {!! call_js(isset($js)? $js : array()) !!}
    <!-- Inject Script On The Fly -->
    @stack('footer_js')

</body>

</html>