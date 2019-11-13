<template>
	<div class="row">
		<div class="col-12">
			<div class="generate-reviews">
				<div class="responsive-tabs-container accordion-xs accordion-sm">
					<ul class="nav nav-tabs responsive-tabs" id="myTab" role="tablist">
						<li class="nav-item active">
							<a class="nav-link active show" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
								<span class="orange-border">One by one</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">
								<span class="green-border">Many at a time</span>
							</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<a class="nav-link accordion-link first" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>

						<div class="tab-pane p-0 show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">          

							<div class="row ml-0 mr-0">
								<div class="col-lg-6 col-12 px-3 px-md-5 bg-white border-right mb-lg-0 mb-3">
									<div class="py-4 px-0 default_form">
										<div class="row">
											<div class="col-12">
												<label for="exampleInputEmail1">Choose the email template for this campaign </label>
											</div>
											<div class="col-12 mb-3">
												<div class="dropdown select--wrapper">
													<button id="dLabel" class="select-value text-left fontSize--12 d-inline pull-left mr-1 max--w220" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select template</button>
													<ul class="dropdown-menu custome-dropdown" aria-labelledby="dLabel" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -200px, 0px); top: 0px; left: 0px; will-change: transform;">
														<li class="inquiry-form" v-for="(item, index) in selects">
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" name="m1" :id="'many' + index">
																	<label class="custom-control-label custom-control-label-1" :for="'many' + index"> &nbsp;<i class="fa" :class="item.icon" aria-hidden="true"></i> {{ item.title }} </label>
																</div>
															</li>
													</ul>
												</div>
											</div>     
										</div> 

										<div class="row">
											<div class="col-md-6 col-12">
												<div class="form-group">
													<label for="exampleInputEmail1">From Email <i class="fa fa-question-circle color-light" aria-hidden="true"></i></label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
												</div>
											</div>
											<div class="col-md-6 col-12">
												<div class="form-group">
													<label for="exampleInputEmail1">Reply To</label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""> </div>          
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label for="exampleInputEmail1">Email Subject</label>
														<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""> 
													</div>            
												</div>             

												<div class="col-12">
													<div class="form-group">
														<label for="exampleInputEmail1">Compose email</label>
														<textarea textarea rows="4" cols="50"  class="form-control" id="" aria-describedby="" placeholder=""></textarea>
													</div>            
												</div>



												<div class="col-md-3 col-12 row mt-3">
													<div class="col-md-4 col-12 default_form p-1">
														<label>When:</label>
													</div>
													<div class="col-md-8 col-12"><input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""></div>
												</div>
												<div class="col-md-7 col-12 row mt-3">
													<div class="col-md-2 col-12 default_form p-1"><label>time:</label></div>
													<div class="col-md-4 col-12 revews-selectbox mb-2">
														<select class="form-control font-14">
															<option value="" selected="">per day</option>                                    
															<option value="Locations # 1">weekly</option>
															<option value="Locations # 2">monthly</option>
															<option value="Locations # 3">yearly</option>
														</select>
													</div>
													<div class="col-md-6 col-12 revews-selectbox mb-2">
														<select class="form-control font-14">
															<option value="" selected="">after the visit</option>                                    
															<option value="Locations # 1">before the visit</option>                                   
														</select>
													</div>
												</div>

												<div class="col-12 text-right mt-5 mb-3">
													<button class="btn btn_dark-bg font-16 font-semi-bold px-4">Confirm</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-12 bg-gray">
										<div class="w-100 px-3">
											<h1 class="reviews-page-title font-weight-normal mb-0 mt-3">Preview</h1>
											<div class="clearfix"></div>
											<div class="w-100 text-center py-3"><img src="/assets/images/campaign-preview1.png" class="img-fluid"></div>
										</div>
									</div>
								</div>

							</div>







							<a class="nav-link accordion-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
							<div class="tab-pane show p-0" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
								<div class="row ml-0 mr-0">
									<div class="col-lg-6 col-12 px-md-5 px-3 bg-white border-right mb-lg-0 mb-3">
										<div class="py-4 px-0 default_form">
											<div class="row">
												<div class="col-12">
													<label for="exampleInputEmail1">Choose the email template for this campaign </label>
												</div>
												<div class="col-12 mb-3">
													<div class="dropdown select--wrapper">
														<button id="dLabel" class="select-value text-left fontSize--12 d-inline pull-left mr-1 max--w220" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select template</button>
														<ul class="dropdown-menu custome-dropdown" aria-labelledby="dLabel" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -200px, 0px); top: 0px; left: 0px; will-change: transform;">
															<li class="inquiry-form" v-for="(item, index) in selects">
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" name="r1" :id="'radio' + index">
																	<label class="custom-control-label custom-control-label-1" :for="'radio' + index"> &nbsp;<i class="fa" :class="item.icon" aria-hidden="true"></i> {{ item.title }} </label>
																</div>
															</li>
														</ul>
													</div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label for="exampleInputEmail1">Upload CSV, TXT, vCard & Excel files</label>
														<div class="custom-file">
															<input type="file" class="form-control custom-file-input" id="customFile">
															<label class="custom-file-label" for="customFile">Choose file</label>
														</div>
													</div>          
												</div>
												<div class="col-12">
													<div class="form-group">
														<label for="exampleInputEmail1">Email Heading</label>
														<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">                        </div>            
													</div>
													<div class="col-12">
														<div class="form-group">
															<label for="exampleInputEmail1">Compose email</label>
															<textarea textarea rows="4" cols="50"  class="form-control" id="" aria-describedby="" placeholder=""></textarea>
														</div>            
													</div>

													<div class="col-md-3 col-12 row my-3">
														<div class="col-md-4 col-12 default_form p-1">
															<label>When:</label>
														</div>
														<div class="col-md-8 col-12"><input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""></div>
													</div>
													<div class="col-md-7 col-12 row my-3 ">
														<div class="col-md-2 col-12 default_form p-1"><label>time:</label></div>
														<div class="col-md-4 col-12 revews-selectbox mb-2">
															<select class="form-control font-14">
																<option value="" selected="">per day</option>                                    
																<option value="Locations # 1">weekly</option>
																<option value="Locations # 2">monthly</option>
																<option value="Locations # 3">yearly</option>
															</select>
														</div>
														<div class="col-md-6 col-12 revews-selectbox mb-2">
															<select class="form-control font-14">
																<option value="" selected="">after the visit</option>                                    
																<option value="Locations # 1">before the visit</option>                                   
															</select>
														</div>
													</div>                    

													<div class="col-12 text-right mt-5 mb-3">
														<button class="btn btn_dark-bg font-16 font-semi-bold px-4">Confirm</button>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-6 col-12 bg-gray">
											<div class="w-100 px-3">
												<h1 class="reviews-page-title font-weight-normal mb-0 mt-3">Preview</h1>
												<div class="clearfix"></div>
												<div class="w-100 text-center py-3">
													<img src="/assets/images/campaign-preview.png" class="img-fluid">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</template>
		<script>
			export default {
				name: 'GenerateReviews',

				props: [],

				data() {
					return {
						type: 'profile',
						selects: [{
							icon: 'fa-thumbs-o-up',
							title: 'NPS'
						},{
							icon: 'fa-heart-o',
							title: 'Thanks for your visit'
						},{
							icon: 'fa-gift',
							title: 'Rate &amp; Win'
						},{
							icon: 'fa-pencil',
							title: 'Custom'
						},{
							icon: 'fa-calendar',
							title: 'Annual review'
						},{
							icon: 'fa-heart',
							title: 'Follow up email'
						}]
					}
				},

				computed: {

				},

				mounted() {

				},

				methods: {

				},

				created() {

				}

			}
		</script>