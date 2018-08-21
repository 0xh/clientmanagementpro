<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SEO -->
    <meta name="description" content="{{ config('seo.description', 'Laravel') }}">
    <meta name="keywords" content="{{ config('seo.keywords', 'Laravel') }}">
    <meta name="author" content="{{ config('seo.author', 'Laravel') }}">
	<title>{{ config('app.name', 'Laravel') }}</title>

	<!--pageMeta-->

	<!-- Lib CSS -->
	
	<link href="/minify/rgen_min.css" rel="stylesheet">
	<link href="/css/custom.css" rel="stylesheet">

	<!-- Favicons -->
	<link rel="icon" href="favicon.ico">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
	<script src="/js/html5shiv.js"></script>
	<script src="/js/respond.min.js"></script>
	<![endif]-->
	<!--[if IE 9 ]><script src="/js/ie-matchmedia.js"></script><![endif]-->

</head>
<body>
<div id="page">
@yield('content')		


<!-- JavaScript --> 
<script src="/minify/rgen_min.js"></script>
<script async src="/js/rgen.js"></script>

</body>
</html>