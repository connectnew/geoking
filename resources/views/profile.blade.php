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
                    <div class="card-header bg-success text-white">{{__('Dashboard')}}</div>

                 
                </div>
            
			<form method="post" action="" enctype="multipart/form-data" id='profile-form'> 
				<div class="row my-profile">
				<div class="col-md-12">
					<div class="col-12 p-0 mb-4">
					  <h2>My Profile</h2>
					  <h3>COMPANY PROFILE</h3>
					</div>
					
					<div id="response-msg"></div>
					
					<div class="col-12 p-0 mb-3 profile_div">
						<label class="d-block form-label prifle-lab">Business type</label>
						<input type="text" class="d-block profile-full" placeholder="multi-site" name="business_type" id="business_type" disabled>
					</div>
					
					<div class="col-12 p-0 mb-3 profile_div">
						<label class="d-block form-label prifle-lab">Sector</label>
						<input type="text" class="d-block profile-full" placeholder="Retail" name="sector" value="sector" disabled>
					</div>
					
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Company name</label>
						<input type="text" class="d-block profile-full" name="company_name" id="company_name" value="{{ $userinfo->company}}">
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateUserCompanyName();">Change</a></button>
					</div>
					
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Full name</label>
						<input type="text" class="d-block profile-full" name="full_name" id="full_name" value="{{ $userinfo->first_name}}">
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateUserName();" >Change</a></button>
					</div>
					
					<div class="col-12 p-0 mb-3 mr-3 profile_div">
						<label class="d-block form-label prifle-lab">Email</label>
						<input type="text" class="d-block profile-full" name="email" id="email" value="{{ $userinfo->email}}">
						<button class="profile-btn" type="button"><a href="javascript:void(0)" onclick="updateUserEmail();" >Change</a></button>
					</div>
				</div>
				</div>
			
			</form>
        </div>
    </div>
	</div>

@endsection
