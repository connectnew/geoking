@extends('layouts.dashboard')



@section('breadcrumb')
    <h1>Home11</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/home">
                <i class="fa fa-fw ti-home"></i> CloudVMS
            </a>
        </li>
    </ol>
@endsection
@section('body')
    <div class="">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default border-success">

                </div>
			<form method="post" action="{{ url('save-competitors') }}" enctype="multipart/form-data" id='competition-form'>  
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row my-profile">
				<div class="col-md-12">
					<div class="col-12 p-0 mb-4">
					  <h2>My Profile</h2>
					  <h3>COMPETITION</h3>
					</div>
					
					<div id="response-msg"></div>
					  @if(session('message'))
			<div class='alert alert-success'>
				{{ session('message') }}
			</div>
		    @endif
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 1</label>
						<input type="text" class="d-block profile-full" name="competitor_1" id="competitor_1" @isset($competitors->competitor_1) value="{{ $competitors->competitor_1}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(1);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 2</label>
						<input type="text" class="d-block profile-full" name="competitor_2" id="competitor_2" @isset($competitors->competitor_2) value="{{ $competitors->competitor_2}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(2);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 3</label>
						<input type="text" class="d-block profile-full" name="competitor_3" id="competitor_3" @isset($competitors->competitor_3) value="{{ $competitors->competitor_3}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(3);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 4</label>
						<input type="text" class="d-block profile-full" name="competitor_4" id="competitor_4" @isset($competitors->competitor_4) value="{{ $competitors->competitor_4}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(5);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 5</label>
						<input type="text" class="d-block profile-full" name="competitor_5" id="competitor_5" @isset($competitors->competitor_5) value="{{ $competitors->competitor_5}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(5);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 6</label>
						<input type="text" class="d-block profile-full" name="competitor_6" id="competitor_6" @isset($competitors->competitor_6) value="{{ $competitors->competitor_6}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(6);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 7</label>
						<input type="text" class="d-block profile-full" name="competitor_7" id="competitor_7" @isset($competitors->competitor_7) value="{{ $competitors->competitor_7}} " @endisset> 
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(7);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 8</label>
						<input type="text" class="d-block profile-full" name="competitor_8" id="competitor_8" @isset($competitors->competitor_8) value="{{ $competitors->competitor_8}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(8);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 9</label>
						<input type="text" class="d-block profile-full" name="competitor_9" id="competitor_9" @isset($competitors->competitor_9) value="{{ $competitors->competitor_9}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(9);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Competitor 10</label>
						<input type="text" class="d-block profile-full" name="competitor_10" id="competitor_10" @isset($competitors->competitor_10) value="{{ $competitors->competitor_10}} " @endisset>
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateCompetitor(10);">Change</a></button>
					</div>
					<div class="col-12 p-0 mb-3 mt-5 d-flex flex-wrap justify-content-end">
						<button class="profile-btn mr-2" value="Save">Save</button>
						<button class="profile-btn cancel"><a href="#">Cancel</a></button>
					</div>
					
				</div>
				</div>
			</form>
			
        </div>
    </div>
	</div>

@endsection
