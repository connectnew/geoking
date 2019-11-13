@extends('layouts.dashboard')

@section('body')
    <div class="">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                
              
              <div class="">
            
            <!-- Bread crumb and right sidebar toggle -->
            
            <div class="page-breadcrumb">
               <div class="row">
                  <div class="col-12 no-block align-items-center flex-wrap">
                     <div class="row">
                        <h4 class="page-title col-md-6 col-12 order-md-1 order-2">{{__('Schedule Posts')}}</h4>
                        <div class="ml-auto text-right col-md-6 col-12 order-md-2 order-1">
                           <nav aria-label="breadcrumb">
                              <ol class="breadcrumb justify-content-md-end">
                                 <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard mr-1"></i> {{__('Home')}}</a></li>
                                 <li class="breadcrumb-item"><a href="#">{{__('Dashboard')}}</a></li>
                                 <li class="breadcrumb-item active" aria-current="page">{{__('Manage Posts')}}</li>
                              </ol>
                           </nav>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
            <!-- End Bread crumb and right sidebar toggle -->
            
            
            <!-- Container fluid  -->
            
            <div class="container-fluid">
               
               <!-- Sales Cards  -->
               
               <div class="row">
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="active-posts">
            <div class="row">
				
              <div class="col-9">
                <h1>{{__('Active Posts')}}</h1>
                <h2>16</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-pencil-square-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="scheduled-posts">
            <div class="row">
              <div class="col-9">
                <h1>{{__('Scheduled Posts')}}</h1>
                <h2>1</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-calendar text-white font-30"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="expired-posts">
            <div class="row">
              <div class="col-9">
                <h1>{{__('Expired Posts')}}</h1>
                <h2>14</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-paper-plane-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
      </div>
             <div class="row mt-4">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                  <div class="d-none d-lg-block"> <a href="#" class="btn btn-light custom-btn-rounded">{{__('Posting Schedule')}}</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">{{__('Library')}}</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">{{__('Analytics')}}</a> </div>
                  <div class="d-block d-lg-none mb-3">
                    <select class="form-control h-40 post-schld-select">
                      <option selected="">{{__('Posting Schedule')}}</option>
                      <option>{{__('Library')}}</option>
                      <option>{{__('Settings')}}</option>
                      <option>{{__('Knowledgebase')}}</option>
                      <option>{{__('Analytics')}}</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary custom-btn-action p-2 px-3 action-menu-width text-center min-190 rounded-0" onclick="location.href='{{ url('create-post') }}';">{{__('Create Post')}} </button>
                    <!-- <div class="dropdown-menu action-menu action-menu-width custom-btn-action-dropdown min-190 py-0 rounded-5"> <a class="dropdown-item font-semi-bold" href="create-posts.html">Create New Post </a> <a class="dropdown-item font-semi-bold" href="#">Bulk import </a> <a class="dropdown-item font-semi-bold" href="#">Generate Report</a> <a class="dropdown-item font-semi-bold" href="#">Post Archive</a> </div> -->
                  </div>
                </div>
              </div>
              	<form method="post" action="save-schedule-post" enctype="multipart/form-data" id='schedule-form'>   
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
               <div class="row mt-3">
                  <div class="col-12">
                     <div class="white-rounded-box p-4 schedule-post-cont">
                        <div class="row">
							
                                			@if(session('message'))
										<div class='alert alert-success'>
											{{ session('message') }}
										</div>
										@endif
                          <div class="col-12 px-4 py-3">
                                <h3>{{__('Schedule post')}}</h3>
                                
                                 <label class="postSelect mt-1">
                                <select class="form-control wd-170 d-inline-block" name="post_id" id="post_id">
									<option value="">Select Post</option>
                                 	@foreach($localPosts as $localPost){
										<option value="{{ $localPost->id }}" @isset($post_id) @if($post_id ==$localPost->id) selected @endif @endisset>{{ $localPost->title }}</option>
									@endforeach
                                </select>      
                              </label>
                              
                           </div>
                           <div class="col-12 px-4 py-3 select-loc-wrap">
                                <h3>{{__('Select location')}}({{__('s')}})</h3>
                                <label class="postSelect mt-1" >
                                <select class="form-control wd-170 d-inline-block location-dropdown" name="location[]" multiple="" id="location-dropdown" >
                                 
                                    @foreach($locationsArr as $location)
                                
									<option value="{{ $location->name}}">{{ $location->locationName}}  ({{ $location->locationGroupName }})</option>
                                @endforeach
                                </select>      
                              </label>
                           </div>                           
                          <input type="hidden" name="location_name" id="location_name">
                           <div class="col-12 px-4 py-3">
                                <h3>{{__('Schedule')}} {{__('at')}}</h3>
                                <input type="date" class="form-control wd-350 d-inline-block"  value="" name="start_date" id="start_date">  
                                <input type="time" class="form-control wd-170 d-inline-block"  value="" name="time" id="time"> 
                                 <select name="timezone" class="col-md-3 form-control wd-170 d-inline-block" style="height:40px" id="timezone">
								<option value="Asia/Kolkata">{{__('Select Timezone')}}</option>
                                @foreach($tzlist as $tz)
                                
                                <option value="{{ $tz}}">{{ $tz}}</option>
                                @endforeach
                                
                                </select>     
                           </div>

                           <div class="col-12 px-4 py-3">
                                <h3>{{__('Repeat post')}}?</h3>
                                <label class="postSelect mt-1">
                                  <select class="form-control wd-170 d-inline-block" name="repeat" id="repeat">
                                    <option value="repeat" selected="">{{__('Repeat')}}</option>
                                    <option value="no-repeat">{{__('No Repeat')}}</option>
                                  </select>      
                                </label>
                                <div class="w-100 d-lg-none d-block pb-3 mb-1"></div>
                              <h3 class="width-140 repeat-opt-h3">{{__('Repeat every')}}:</h3>
                                <label class="postSelect mt-1 width-215 repeat-opt-label">
                                <select class="form-control wd-170 d-inline-block" name="repeat_option" id="repeat_option">
                                  <option value="1 day" selected="">{{__('Day')}}</option>
                                  <option value="1 week">{{__('Week')}}</option>
                                  <option value="1 month">{{__('Month')}}</option>
                                  <option value="3 months">{{__('Once Every')}} 3 {{__('Months')}}</option>
                                  <option value="6 months">{{__('Once Every')}} 6 {{__('Months')}}</option>
                                  <option value="1 year">{{__('Once Every Year')}}</option>
                                </select>      
                              </label>
                           </div>
                           <div class="col-12 px-4 py-3 would-section-s">
                             <h3 class="font-semi-bold w-100">{{__('Would you like this post to expire')}}?</h3>
                             <div class="w-100 clearfix"></div>
                             <div class="d-sm-flex d-block align-items-sm-center">
                             <span class="custom-control custom-checkbox d-sm-inline-block d-block float-left mr-3">
                                <input type="checkbox" class="custom-control-input" id="ReviewScore" checked="" name="expire_check" id="expire_check">
                                <label class="custom-control-label pl-0" for="ReviewScore">{{__('Expire after being posted')}}</label>
                             </span>
                             <div class="w-100 d-sm-none d-block"></div>
                             <label class="mt-1 mr-2 mz-11">
                              <input type="text" class="form-control wd-170 d-inline-block" placeholder="" value="" name="event_expire" id="event_expire"> 
                            </label>
							<h6 class="time1 schedule-time">
                            {{__('times')}}</h6>
                          </div>
                           </div>

                           <div class="col-12 text-right py-3 px-4">
                             
                               <button class="btn btn-blue-large">{{__('Schedule')}}</button>
                                 <a href="" data-dismiss="modal" title="Cancel" class=" font-semi-bold"><u>{{__('Cancel')}}</u></a>                               
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            
            </form>
            </div>
         </div>
            </div>
        </div>
    </div>

@endsection
