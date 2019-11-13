@extends('layouts.dashboard')

@section('body')

<div class="row">
	<div class="col-md-12 col-lg-4 pb-3">
		<div class="active-posts">
			<div class="row">
				<div class="col-9">
					<h1 class="text-nowrap">Total Locations</h1>
					<h2>{{ App\Location::where('created_by', auth()->id())->count() }}</h2>
				</div>
				<div class="col-3 text-right"><img src="/assets/images/location-marker.png"> </div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-lg-4 pb-3">
		<div class="scheduled-posts">
			<div class="row">
				<div class="col-9">
					<h1 class="text-nowrap">Live Locations</h1>
					<h2>{{ App\Location::where('created_by', auth()->id())->where('is_confirmed',true)->count() }}</h2>
				</div>
				<div class="col-3 text-right"> <img src="/assets/images/live-locations-icon.png"> </div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-lg-4 pb-3">
		<div class="expired-posts">
			<div class="row">
				<div class="col-9">
					<h1 class="text-nowrap">Pending Verification</h1>
					<h2>{{ App\Location::where('created_by', auth()->id())->where('is_confirmed',false)->count() }}</h2>
				</div>
				<div class="col-3 text-right"> <img src="/assets/images/pending-verification-icon.png"> </div>
			</div>
		</div>
	</div>
</div>


<manage :user="{{ Auth::user() }}"></manage>

<simple-alert :alert_id="'simple-alert-manage'" :alert_btn="'Close'"></simple-alert>

<div class="modal fade" id="CreateLocationGroup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content reset__popup">
			<div class="modal-body">
				<h3 class="mb-3 font-weight-normal">Create Location Group</h3>
				<p class="mb-3">Choose a name that briefly but clearly identifies your 
				location group.</p>
				<div class="form-group input-group input-with-icon mb-2">
					<span class="has-float-label">
						<input type="text" class="form-control border-top-0 border-left-0 border-right-0 pl-0" id="GroupName" name="GroupName" placeholder="Group name" required />
						<label class="control-label" for="GroupName">Group name</label>
					</span>
					<p class="text-right float-right w-100 text-muted">0 / 50</p>
				</div>
				<div class="row">
					<div class="col-12 text-right">
						<button class="btn btn-outline-light text-info border-0 font-16 text-uppercase" data-dismiss="modal">Cancel</button>
						<button class="btn btn-outline-light text-dark border-0 font-16 text-uppercase" data-dismiss="modal">Create</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="AddMany" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content reset__popup">
			<div class="modal-body">
				<h1 class="mb-3 font-weight-normal font-32">Import locations <a href="#!" class="float-right text-secondary"><i class="fa fa-times font-26 font-weight-normal" data-dismiss="modal"></i></a></h1>
				<p class="mb-3 rating"><img src="/assets/images/raiting_big.png"> <img src="/assets/images/raiting_big.png"> <img src="/assets/images/raiting_big.png"> <img src="/assets/images/raiting_big.png"> <img src="/assets/images/raiting_big.png"></p>
				<h2 class="mb-3 text-muted font-24">Manage multiple locations by importing a spreadsheet</h2>
				<div class="file_uploadedImgInput pb-3">
					<div class="file_fileUpload"> <span>Select file</span>
						<input type="file" class="upload" id="filePicWithLogo" name="filePicWithLogo" />
					</div>
					<span id="file_filename" style="display: none;"></span> </div>
					<div class="row w-100">
						<div class="col-12 text-left">
							<h3 class="font-22 border-bottom pb-3"><a href="#!" class="text-secondary"><i class="fa fa-download"></i> Download the template</a></h3>
							<h3 class="font-22 border-bottom pb-3"><a href="#!" class="text-secondary"><i class="fa fa-download"></i> Download sample spreadsheet</a></h3>
							<h3 class="font-22 border-bottom pb-3"><a href="#!" class="text-secondary"><i class="fa fa-download"></i> Download attribute reference spreadsheet</a></h3>
							<h3 class="font-22 pb-3"><a href="#!" class="text-secondary"><i class="fa fa-question-circle-o"></i> Learn how to create an import file</a></h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@endsection