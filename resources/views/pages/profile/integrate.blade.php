@extends('layouts.dashboard')

@section('body')

<div class="row mt-3">
	<div class="col-12">
		<div class="white-rounded-box">
			<div class="row m-lg-5 m-3">
				<div class="col-12">
					<div class="row">
						<div class="col-lg-2 col-md-3"> <img src="/assets/images/google-logo-lg.png" class="img-fluid"> </div>
						<div class="col-lg-7 col-md-5">
							<h3 class="font-16 font-semi-bold">Google</h3>
							<p class="font-16 gray_txt font-semi-bold">Connect your Google My Business account and start responding to Google reviews directly from within our platform.</p>
							<p class="font-16 font-italic gray_txt">Please note, the connected Google My Business account must be "owner" of single-GMB account and response ability is limited to post-connection activity.</p>
						</div>
						<div class="col-lg-3 col-md-4 text-center pt-4 mt-2"> <a href="#"><img src="/assets/images/google-login-btn.png" class="img-fluid"></a> </div>
					</div>
					<hr class="my-5" style="border-top: 1px dashed #d6d6d7;">
					<div class="row">
						<div class="col-md-2"> <img src="/assets/images/icn-fb-logo-lg.png" class="img-fluid"> </div>
						<div class="col-md-7">
							<h3 class="font-16 font-semi-bold">Facebook</h3>
							<p class="font-16 gray_txt font-semi-bold">Connect your Facebook pages account and start responding to Facebook reviews directly from within our platform. Due to security updates by Facebook, integrating your Facebook account is the only way to pull in Facebook reviews and recommendations.</p>
							<p class="font-16 font-italic gray_txt">The connected Facebook account should be an Admin for your brand's page and have permissions to manage each location's business page.</p>
						</div>
						<div class="col-md-3 text-center pt-4 mt-2"> <a href="#"><img src="/assets/images/icn-fb-login-btn.png" class="img-fluid"></a> </div>
					</div>
					<hr class="my-5" style="border-top: 1px dashed #d6d6d7;">
					<div class="row">
						<div class="col-md-2 pt-4 mt-2"> <img src="/assets/images/booking_logo.png" class="img-fluid"> </div>
						<div class="col-md-7">
							<h3 class="font-16 font-semi-bold">Booking.com</h3>
							<p class="font-16 gray_txt font-semi-bold">Connect your Booking.com account and start responding to Google reviews directly from within our platform.</p>
							<p class="font-16 font-italic gray_txt">Please note, the connected Booking.com account must be "owner" of the-GMB account and response ability is limited to post-connection activity.</p>
						</div>
						<div class="col-md-3 text-center pt-4 mt-2"> <a href="#"><img src="/assets/images/login-with-booking.png" class="img-fluid"></a> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
