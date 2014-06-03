@extends('layout.html_wrapper')

@section('container')

<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<img alt="140x140" src="http://lorempixel.com/140/140/" />
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">Home</a>
				</li>
				<li>
					<a href="#">Services</a>
				</li>
				<li class="disabled">
					<a href="#">About</a>
				</li>
				<li class="dropdown pull-right">
					 <a href="#" data-toggle="dropdown" class="dropdown-toggle">Dropdown<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li>
							<a href="#">Action</a>
						</li>
						<li>
							<a href="#">Another action</a>
						</li>
						<li>
							<a href="#">Something else here</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="#">Separated link</a>
						</li>
					</ul>
				</li>
			</ul>
			
			@yield('content')

		</div>
	</div>
</div>

@stop