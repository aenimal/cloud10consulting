@extends('layout.html_wrapper')

@section('head-includes')

    <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,700' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="/assets/bootstrap/css/jumbotron-narrow.css" rel="stylesheet">

    <link href="/assets/css/styles.css" rel="stylesheet">

@stop


@section('container')

    <div class="container">

      <div class="header">

        <ul class="nav nav-pills pull-right">

        	{{Menu::handler('main')}}
        	
        </ul>

        <h3 class="text-muted">
          <a href="/" alt="Cloud 10 Consulting"><img src="assets/images/cloud10-logo-small.jpg" alt="Cloud 10 Consulting" /></a>
        </h3> 

        @yield('header')

      </div>



      @yield('content')
    


      <div class="footer">
        <p>&copy; Cloud10Consuting 2014</p>
      </div>

    </div> <!-- /container -->

@stop