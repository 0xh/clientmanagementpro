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
<body onload="" class="{{ $appcolor or 'bg-steel' }}" dir="">
    @include('partials.navbar')
    <div class="page-container metro" id="spark-app" v-cloak>
        <div class="row flex" style="height:100%">
            <!-- Only Show Sidebar for Login User -->
            @if(Auth::check())
            <div class="cell sidebar-cell" style="height:100%;">
                @include( 'partials.sidebar' )
            </div>
            @endif
            <div class="cell auto-size">
                <div class="content-wrapper {{ $maincolor or 'bg-grayLighter' }} ">
                    <!-- Contain Our Main Content -->
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- Application Level Modals -->
        @if (Auth::check()) 
        @include('spark::modals.notifications') 
        @include('spark::modals.support') 
        @include('spark::modals.session-expired')
        @endif
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