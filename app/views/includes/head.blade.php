<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="DoreCup">
<meta name="author" content="psadaic">
<meta name="_token" content="{{ csrf_token() }}"/>
<link rel="shortcut icon" type="image/x-icon" href="{{URL::to('/favicon.ico')}}" />
<title>d2c Summer Cup</title>
{{ HTML::style('assets/css/bootstrap.min.css'); }}
{{ HTML::style('assets/css/bootstrap-theme.min.css'); }}
{{ HTML::style('assets/css/style.css'); }}
{{ HTML::script('assets/js/jquery-1.11.3.min.js'); }}
{{ HTML::script('assets/js/bootstrap.min.js'); }}
<style type="text/css">
    .hidden-content {
      display: none;
    }

	.navbar-brand {
    	position: absolute;
    	width: 100%;
    	left: 0;
    	top: -29px;
    	text-align: center;
    	margin: auto;
	}

	.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
	  	background-color: #d0d0d0;
	}

	.navbar-nav > li > a, .navbar-brand {
    	padding-top:22px !important; 
   	 	padding-bottom:0 !important;
    	height: 64px;
	}

	.navbar {
        min-height:64px !important;
    }
    
    .navbar .navbar-collapse {
        text-align: center;
    }
    .btn-dore { 
        color: #ffffff; 
        background-color: #D01B22; 
        border-color: #961C20; 
    } 
 
    .btn-dore:hover, 
    .btn-dore:focus, 
    .btn-dore:active, 
    .btn-dore.active, 
    .open .dropdown-toggle.btn-dore { 
        color: #ffffff; 
        background-color: #E3040C; 
        border-color: #961C20; 
    } 
 
    .btn-dore:active, 
    .btn-dore.active, 
    .open .dropdown-toggle.btn-dore { 
        background-image: none; 
    } 
 
    .btn-dore.disabled, 
    .btn-dore[disabled], 
    fieldset[disabled] .btn-dore, 
    .btn-dore.disabled:hover, 
    .btn-dore[disabled]:hover, 
    fieldset[disabled] .btn-dore:hover, 
    .btn-dore.disabled:focus, 
    .btn-dore[disabled]:focus, 
    fieldset[disabled] .btn-dore:focus, 
    .btn-dore.disabled:active, 
    .btn-dore[disabled]:active, 
    fieldset[disabled] .btn-dore:active, 
    .btn-dore.disabled.active, 
    .btn-dore[disabled].active, 
    fieldset[disabled] .btn-dore.active { 
        background-color: #D01B22; 
        border-color: #961C20; 
    } 
 
    .btn-dore .badge { 
        color: #D01B22; 
        background-color: #ffffff; 
    }
</style>