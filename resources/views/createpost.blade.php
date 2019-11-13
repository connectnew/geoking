@extends('layouts.dashboard')

@section('body')

    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
              
        <?php 
        // Program to display current page URL. 
          
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                        "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                        $_SERVER['REQUEST_URI']; 
          
        //echo $link;
        //~ $links='ar';
        //~ $linkss='en';


        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);

        if(array_key_exists(2, $uri_segments)) {
          $matchpara=$uri_segments[2]; 
        }else
          $matchpara = '';

        //~ if (strpos($link,$matchpara) !== false) {
            //~ echo 'exists.';
        //~ } else {
            //~ echo 'Not exist!!.';
        //~ }
        ?> 
            <div class="col-md-12">
             	<form method="post" action="create-gmb-post" enctype="multipart/form-data" id='create-form'>   
               <div class="position-relative rounded-0 inquiry-form set-business-comp create-post-cont p-4">
            <div class="row">
              <div class="col-12">
                <div class="col-12 p-0 mb-5">
                  <h2>{{__('Create Post')}}</h2>
                </div>
			@if(session('message'))
			<div class='alert alert-success'>
				{{ session('message') }}
			</div>
		    @endif
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row">
                    <div class="col-12">
                      <div class="row d-flex align-items-center create-post-form">
                        <div class="col-12 px-md-3 px-2">
                          <div class="row">
                            <p class="mt-1 mb-md-0 mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">{{__('Event title')}} <span class="font-14 d-inline-block w-100">({{__('Example')}}: {{__('Sale this week')}})</span></p>
                            <div class="col-lg-10 col-md-8 col-12">
                              <input type="text" class="form-control w-100 set-business-input" id="event_title" name="event_title" placeholder="{{__('Event title')}}" maxlength="300">
                            </div>
                            <div class="clearfix my-3 col-12"></div>
                            <p class="mt-1 mb-md-0 mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">{{__('Write your post')}} <span class="font-14 d-inline-block w-100">100-300 {{__('words')}}</span></p>
                            <div class="col-lg-10 col-md-8 col-12">
                              <textarea class="form-control w-100 post-desc" name="event_description" id="event_description" maxlength="300"> </textarea>
                            </div>
                            <div class="clearfix my-3 col-12"></div>
                            <p class="mt-3 mb-md-0 mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">{{__('Select location')}}({{__('s')}})</p>
                            <div class="col-lg-10 col-md-8 col-12">
                              <div class="row col-12 select-loc-wrap">
								
                                <select class="custom-select col-lg-3 col-md-12 set-business-input set-business" name="location[]" id="location" multiple="" style="height:80px">
                                 
                           
                                @foreach($locationsArr as $location)
                                
                                <option value="{{ $location->name}}">{{ $location->locationName}}  ({{ $location->locationGroupName }})</option>
                                @endforeach 
                                </select> 
								<input type="hidden" name="location_name" id="location_name">
                                <div class=" post-add-button">
                                  <div class="offset-lg-3">
                                    <div class="w-100 d-flex align-items-center">
                                      <div class="mt-3 mt-md-2 mb-0 mr-5 font-24 line-height-20 text-lg-right d-inline-block">{{__('Add a button')}}
                                        <div class="clearfix w-100"></div>
                                        <span class="w-100 font-18 mt-2 text-left float-left">{{__('Enter a website')}}</span> </div>
                                      <div class="toggle listing-switch d-inline-block ">
                                        <label class="switch">
                                          <input type="checkbox" class="primary" id="button-toggle" name="add_button" value="1">
                                          <span class="slider round"></span> </label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row create-postradio add-button-type-cont mt-3">
                                    <div class="col-lg-9 offset-lg-3">
										<select class="custom-select col-lg-6 col-md-12 set-business-input select-post-btn add_a-btn1" name="button_name" id="button_name">
										  <option value="">Add a button (optional)</option>
										   <option value="LEARN_MORE">Learn More</option>
										  <option value="BOOK">Reserve</option>
										  <option value="SIGN_UP">Sign up</option>
										  <option value="SHOP">SHOP</option>
										  <option value="ORDER">Order</option>
										
										</select>
										
										<div class="">
                                            <input type="url" name="button_url" id="button_url" class="enterWebsite" placeholder="Link for your button">
                                        </div>
<!--								
                                      <ul>
                                        <li>
                                          <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="learnMore" value="Learn More" name="addbuttonType" value="customEx">
                                            <label class="custom-control-label" for="learnMore">Learn more</label>
                                          </div>
                                          
                                        </li>
                                        <li>
                                          <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="reserve" value="Reserve" name="addbuttonType" value="customEx">
                                            <label class="custom-control-label" for="reserve">Reserve</label>
                                          </div>
                                        </li>
                                        <li>
                                          <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="signup" value="Sign Up" name="addbuttonType" value="customEx">
                                            <label class="custom-control-label" for="signup">Sign up</label>
                                          </div>
                                        </li>
                                        <li>
                                          <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="buybtn" value="Buy" name="addbuttonType" value="customEx">
                                            <label class="custom-control-label" for="buybtn">Buy</label>
                                          </div>
                                        </li>
                                        <li>
                                          <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="getOffer" value="Get Offer" name="addbuttonType" value="customEx">
                                            <label class="custom-control-label" for="getOffer">Get offer</label>
                                          </div>
                                        </li>
                                      </ul>
-->
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="clearfix my-3 col-12"></div>
                            <p class="mt-3 mb-md-0 mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">{{__('Post image')}}/{{__('video')}}</p>
                            <div class="col-lg-10 col-md-8 col-12">
                              <div class="row">
                                <div class="col-lg-5 col-md-12">
                                  <input type="text" class="form-control w-100 set-business-input float-left" name='img_url' id="img_url" >
                                  <br>
                                  <span class="d-inline-block w-100 font-16 mt-1">JPG {{__('or')}} PNG, 720x540px {{__('minimum size')}}</span> </div>
                                <div class="col-lg-7 col-md-12 mt-lg-0 mt-3">
                                  <div class="upload-btn-wrapper mr-2">
                                    <button class="btn">{{__('Select Image')}}</button>
                                    <input type="file" name="selectImage" id="selectImage" accept="image/*">
                                  </div>
                                  <div class="upload-btn-seperator"> -{{__('or')}}- </div>
                                  <div class="upload-btn-wrapper mx-2">
                                    <button class="btn">{{__('Select video')}}</button>
                                    <input type="file" name="selectVideo" id="selectVideo"  accept="video/*">
                                  </div>
                                </div>
                              </div>
                            </div>

						<div class="img-error col-md-12"></div>
                             <div class=" mt-3 schedule-post-cont_form schedule_post1">
							<div class="white-rounded-box1  schedule-post-cont schedule_post1_cont">
					  
                           <!--div class="col-12 px-4 py-3">
						     <p class="mt-3 mb-md-0 mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">Schedule Options</p>
                               <!-- <h3>Schedule Options</h3>
                                <label class="postSelect mt-1 schedule-opt-label">
                                  <select class="custom-select  wd-170 d-inline-block schedule-opt" name="schedule_option" id="schedule_option">
                                    <option value="1" selected="">Post now</option> 
                                    <option value="2">Post on specific date/time</option>
                                  </select>      
                                </label>
                                <div class="w-100 d-lg-none d-block pb-3 mb-1"></div>
                            
                           </div-->
				<p class="mt-3 mb-md-0 testing mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">{{__('Schedule Options')}}</p>
				<div class="col-lg-10 col-md-8 col-12">
				<label class="postSelect mt-1 schedule-opt-label schedule-label1">
                                  <select class="custom-select  wd-170 d-inline-block schedule-opt b-inline-block" name="schedule_option" id="schedule_option">
                                    <option value="1" selected="">{{__('Post now')}}</option> 
                                    <option value="2">{{__('Post on specific date')}}/{{__('time')}}</option>
                                  </select>      
                                </label>
				</div>
				<div class="w-100 d-lg-none d-block pb-3 mb-1"></div>
						 <div class="post-schedule-options">
							
                                
							<p class="mt-3 mb-md-0 testing mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">Schedule at</p>
							<div class="col-lg-10 col-md-8 col-12 Schedule_at ">
                                <input type="date" class="col-md-3 form-control wd-350 d-inline-block c-inline-block"  id="start_date" name="s_start_date" placeholder="YYYY-MM-DD">  
                                <input type="time" class="form-control  d-inline-block  wd-132 "  name="s_time" id="time" placeholder="HH:MM (24 hour format)"> 
<!--
                                <input type="text" class="form-control wd-170 d-inline-block"  name="timezone" placeholder="Time Zone"> 
-->
                                <select name="timezone" class="col-md-3 f custom-select orm-control wd-170 d-inline-block wz-1" id="timezone">
								<option value="">Select Timezone</option>
                                @foreach($tzlist as $tz)
                                
                                <option value="{{ $tz}}">{{ $tz}}</option>
                                @endforeach
                                
                                </select>     
								</div>
                         
                                
								<p class="mt-3 mb-md-0 testing mb-2 col-lg-2 col-md-4 col-12 font-24 line-height-20">Repeat post?</p>
								<div class="col-lg-10 col-md-8 col-12 Schedule_at ">
                                <label class="postSelect mt-1 mz-2 mz-3">
								
                                  <select class="f custom-select orm-control wd-175 d-inline-block" name="repeat">
                                    <option value="repeat" selected="">Repeat</option>
                                    <option value="no-repeat">No Repeat</option>
                                  </select>      
                                </label>
                                <div class="w-100 d-lg-none d-block pb-3 mb-1"></div>
                              <h3 class="width-170 wd-100 repeat-opt-h3" >Repeat every:</h3>
                                <label class="postSelect mt-1 width-215 mz-2 mz-4 repeat-opt-label">
                                <select class=" custom-select  wd-176 d-inline-block" name="repeat_option">
                                  <option value="1 day" selected="">Day</option>
                                  <option value="1 week">Week</option>
                                  <option value="1 month">Month</option>
                                  <option value="3 months">Once Every 3 Months</option>
                                  <option value="6 months">Once Every 6 Months</option>
                                  <option value="1 year">Once Every Year</option>
                                </select>      
                              </label>
                           </div>
                           <!--div class="col-12 px-4 py-3">
                             <h3 class="font-semi-bold w-100 post_expire_like" style="width:100% !important;">Would you like this post to expire?</h3>
                             <div class="w-100 clearfix"></div>
                             <div class="d-sm-flex d-block align-items-sm-center">
                             <span class="custom-control custom-checkbox d-sm-inline-block d-block float-left mr-3">
                                <input type="checkbox" class="custom-control-input" id="expire_check" name="expire_check" checked="" value="1">
                                <label class="custom-control-label pl-0" for="ReviewScore">Expire after being posted</label>
                             </span>
                             <div class="w-100 d-sm-none d-block"></div>
                             <label class="mt-1 mr-2">
                              <input type="text" class="form-control wd-170 d-inline-block" placeholder="" value="4" id="event_expire" name="event_expire"> 
                            </label>
                            times
                          </div-->
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
				  <div class="would-section">
					<div class=" would-section22">
                             <div class="col-lg-12 col-md-12 "><h3 class="font-semi-bold w-100 post_expire_like" style="width:100% !important;">{{__('Would you like this post to expire')}}?</h3></div>
                             <div class="w-100 clearfix"></div>
                             <div class="col-lg-12 ex_1 d-sm-flex d-block align-items-sm-center">
							 <div class=" Expire-create ">
                             <span class="custom-control custom-checkbox d-sm-inline-block d-block float-left mr-3">
                                <input type="checkbox" class="custom-control-input" id="expire_check" name="expire_check" checked="" value="1">
                                <label class="custom-control-label pl-0 pl_0" for="ReviewScore">{{__('Expire after being posted')}}</label>
                             </span>
							 </div>
                             <div class="w-100 d-sm-none d-block"></div>
							 <div class="  Expire-create1">
                             <label class="mt-1 mr-2">
                              <input type="text" class="form-control wd-170 d-inline-block" placeholder="" value="4" id="event_expire" name="event_expire"> 
                            </label>
                            <h6 class="time1">{{__('times')}}</h6>
                          </div>
						  </div>
					</div>
					</div>
                   
				   
				   <div class="col-12 text-center validation-error">
                   
                   </div>
                  <div class="row px-md-3 px-2 d-flex align-items-center justify-content-end">
                    <div class="col-12 my-4 pt-4 text-right no-border">
                      <button type="submit" class="btn btn-blue-large mr-2">{{__('Publish')}}</button>
                      <a href="#"><u>{{__('Cancel')}}</u></a> </div>
                  </div>

              </div>
            </div>
             </form>  
          </div>
                
            </div>
        </div>
    </div>

@endsection


