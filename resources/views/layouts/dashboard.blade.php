@extends('layouts.app')

@section('content')

<div id="main-wrapper"> 

	<the-header :user="{{ Auth::user() }}"></the-header>

	<the-sidebar @if(isset($category)) category="{{ $category }}" @endif @if(isset($routeName))link="{{ $routeName }}" @endif></the-sidebar>

	<div class="page-wrapper">
		
		{{-- Breadcrumb --}}
		{{-- <div class="page-breadcrumb">
			<div class="row">
				<div class="col-12 d-flex no-block align-items-center flex-wrap">
					<h4 class="page-title col-md-6 col-12 order-md-1 order-2">Integrations </h4>
					<div class="ml-auto text-right col-md-6 col-12 order-md-2 order-1">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-md-end">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard mr-1"></i> Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Integrations</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div> --}}
		
		{{-- Page Content --}}
		<div class="container-fluid no-breadcrumb-height">
			@yield('body')
		</div>

	</div>

</div>

@endsection