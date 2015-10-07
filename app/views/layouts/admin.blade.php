<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
	<div id="alert-error">
		<noscript>
        	<center><strong>Error!</strong> JavaScript must be enabled for this application to work.</center>
        	<style> .noscript { display:none; } </style>
		</noscript>
	</div>
	<div id="wrapper" class="noscript unselectable">
		<div class="container">
    		<header class="row">
        		@include('includes.headeradmin')
    		</header>
    		<div class="push"></div><div class="push"></div>
    		<div id="main" class="row">
				@yield('content')
			</div>
			<footer class="row">
        		@include('includes.footer')
    		</footer>
    	</div>
	</div>
	@yield('scripts')
</body>
</html>