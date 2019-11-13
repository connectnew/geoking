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
            
			
			<div class="row teams_page">
            <div class="col-md-12">
				<div class="col-12 p-0 mb-4 ">
                  
                  
			<form method="post" action="{{ url('save-team') }}" enctype="multipart/form-data" id='team-form'>   

					<div class="col-xl-10 col-md-10 col-lg-12 inquiry-form plr-50">
					   <h1 class="mt-4">Tell us about your team</h1>
					   
					   			@if(session('message'))
								<div class='alert alert-success'>
									{{ session('message') }}
								</div>
								@endif
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					
					   <div class="table-responsive">
						  <table class="table table-borderless team-table">
							 <thead>
								<tr>
								   <th></th>
								   <th class="name-email-col"></th>
								   <th class="text-left">Action</th>
								   <th class="text-left">Frequency</th>
								</tr>
							 </thead>
							 <tbody>
								<tr>
								   <td class="text-center">
									  
									  
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" class="avatar-cropper-img-input" name="file_1">
									  </div>
									
									  <button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->marketing_manager->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->marketing_manager->photo }}"  height="80" width="80" @if( empty($teamArr->marketing_manager->photo)) style="display:none"  @endif>
									   @if( !empty($teamArr->marketing_manager->photo))
									   <a href="javascript:void(0)" class="edit-img">
									   <i class="fa fa-pencil-square-o" aria-hidden="true">
									   </i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   <input type="hidden" name="remove_1" class="remove" value="">
									   @endif
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]" @isset($teamArr->marketing_manager) value="{{ $teamArr->marketing_manager->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]" @isset($teamArr->marketing_manager) value="{{ $teamArr->marketing_manager->email}}" @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">Marketing Manager</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-0" class="custom-control-input" name="instant_alert[]"  value="instant_0" @isset($teamArr->marketing_manager) @if($teamArr->marketing_manager->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-0" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing2-0" class="custom-control-input" name="exec_summary[]"  value="exec_0"@isset($teamArr->marketing_manager)  @if($teamArr->marketing_manager->exec_summary ==1) checked @endif @endisset> <label for="customControlAutosizing2-0" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily"@isset($teamArr->marketing_manager) @if($teamArr->marketing_manager->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly" @isset($teamArr->marketing_manager) @if($teamArr->marketing_manager->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly" @isset($teamArr->marketing_manager) @if($teamArr->marketing_manager->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
								<tr>
								   <td class="text-center">
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" class="avatar-cropper-img-input" name="file_2">
									  </div>
									  <button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->sales_manager->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->sales_manager->photo }}"  height="80" width="80" @if( empty($teamArr->sales_manager->photo)) style="display:none"  @endif>
									    @if( !empty($teamArr->sales_manager->photo))
									   <a href="javascript:void(0)" class="edit-img"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   
									   <input type="hidden" name="remove_2" class="remove" value="">
									   @endif
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]" @isset($teamArr->sales_manager) value="{{$teamArr->sales_manager->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]" @isset($teamArr->sales_manager) value="{{$teamArr->sales_manager->email}}" @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">Sales Manager</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-1" class="custom-control-input" name="instant_alert[]" value="instant_1" @isset($teamArr->sales_manager) @if($teamArr->sales_manager->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-1" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl" @isset($teamArr->sales_manager) @if($teamArr->sales_manager->exec_summary ==1) checked @endif @endisset><input type="checkbox" id="customControlAutosizing2-1" class="custom-control-input" name="exec_summary[]"  value="exec_1"> <label for="customControlAutosizing2-1" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily" @isset($teamArr->sales_manager) @if($teamArr->sales_manager->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly" @isset($teamArr->sales_manager) @if($teamArr->sales_manager->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly" @isset($teamArr->sales_manager) @if($teamArr->sales_manager->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
								<tr>
								   <td class="text-center">
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" class="avatar-cropper-img-input" name="file_3">
									  </div>
									 <button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->operations_manager->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->operations_manager->photo }}"  height="80" width="80" @if( empty($teamArr->operations_manager->photo)) style="display:none"  @endif>
									   
									    @if( !empty($teamArr->operations_manager->photo))
									    <a href="javascript:void(0)" class="edit-img"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   <input type="hidden" name="remove_3" class="remove" value="">
									    @endif
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]" @isset($teamArr->operations_manager)  value="{{$teamArr->operations_manager->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]" @isset($teamArr->operations_manager)  value="{{$teamArr->operations_manager->email}}" @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">Operations Manager</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-2" class="custom-control-input" name="instant_alert[]" value="instant_2" @isset($teamArr->operations_manager)  @if($teamArr->operations_manager->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-2" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl" value="1"><input type="checkbox" id="customControlAutosizing2-2" class="custom-control-input" name="exec_summary[]" value="exec_2" @isset($teamArr->operations_manager)  @if($teamArr->operations_manager->exec_summary ==1) checked @endif @endisset> <label for="customControlAutosizing2-2" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily" @isset($teamArr->operations_manager)  @if($teamArr->operations_manager->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly" @isset($teamArr->operations_manager)  @if($teamArr->operations_manager->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly" @isset($teamArr->operations_manager)  @if($teamArr->operations_manager->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
								<tr>
								   <td class="text-center">
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" class="avatar-cropper-img-input" name="file_4">
									  </div>
									<button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->hr_manager->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->hr_manager->photo }}"  height="80" width="80" @if( empty($teamArr->hr_manager->photo)) style="display:none"  @endif>
									   @if( !empty($teamArr->hr_manager->photo))
									   <a href="javascript:void(0)" class="edit-img"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   <input type="hidden" name="remove_4" class="remove" value="">
									   @endif
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]" @isset($teamArr->hr_manager)  value="{{$teamArr->hr_manager->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]"  @isset($teamArr->hr_manager)  value="{{$teamArr->hr_manager->email}}"  @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">HR Manager</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-3" class="custom-control-input" name="instant_alert[]"  value="instant_3" @isset($teamArr->hr_manager)  @if($teamArr->hr_manager->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-3" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl" value="1"><input type="checkbox" id="customControlAutosizing2-3" class="custom-control-input" name="exec_summary[]" value="exec_3"  @isset($teamArr->hr_manager)  @if($teamArr->hr_manager->exec_summary ==1) checked @endif @endisset> <label for="customControlAutosizing2-3" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily" @isset($teamArr->hr_manager)  @if($teamArr->hr_manager->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly" @isset($teamArr->hr_manager)  @if($teamArr->hr_manager->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly" @isset($teamArr->hr_manager)  @if($teamArr->hr_manager->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
								<tr>
								   <td class="text-center">
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" name="file_5" class="avatar-cropper-img-input" >
									  </div>
									 <button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->it_manager->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->it_manager->photo }}"  height="80" width="80" @if( empty($teamArr->it_manager->photo)) style="display:none"  @endif>
									    @if( !empty($teamArr->it_manager->photo))
									   <a href="javascript:void(0)" class="edit-img"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   <input type="hidden" name="remove_5" class="remove" value="">
									   @endif
									  
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]" @isset($teamArr->it_manager)  value="{{$teamArr->it_manager->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]"  @isset($teamArr->it_manager)  value="{{$teamArr->it_manager->email}}" @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">IT</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-4" class="custom-control-input" name="instant_alert[]" value="instant_4" @isset($teamArr->it_manager)   @if($teamArr->it_manager->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-4" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing2-4" class="custom-control-input" name="exec_summary[]" value="exec_4" @isset($teamArr->it_manager)   @if($teamArr->it_manager->exec_summary ==1) checked @endif @endisset> <label for="customControlAutosizing2-4" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily" @isset($teamArr->it_manager)   @if($teamArr->it_manager->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly"   @isset($teamArr->it_manager)  @if($teamArr->it_manager->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly" @isset($teamArr->it_manager)  @if($teamArr->it_manager->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
								<tr>
								   <td class="text-center">
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" class="avatar-cropper-img-input" name="file_6">
									  </div>
									  <button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->brand_experience->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->brand_experience->photo }}"  height="80" width="80" @if( empty($teamArr->brand_experience->photo)) style="display:none"  @endif>
									   @if( !empty($teamArr->brand_experience->photo))
									   <a href="javascript:void(0)" class="edit-img"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   <input type="hidden" name="remove_6" class="remove" value="">
									   @endif
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]" @isset($teamArr->brand_experience) value="{{$teamArr->brand_experience->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]" @isset($teamArr->brand_experience)value="{{$teamArr->brand_experience->email}}" @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">Brand Experience</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-5" class="custom-control-input" name="instant_alert[]" value="instant_5"@isset($teamArr->brand_experience) @if($teamArr->brand_experience->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-5" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing2-5" class="custom-control-input" name="email[]" value="exec_5" @isset($teamArr->brand_experience) @if($teamArr->brand_experience->exec_summary ==1) checked @endif @endisset> <label for="customControlAutosizing2-5" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily" @isset($teamArr->brand_experience) @if($teamArr->brand_experience->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly" @isset($teamArr->brand_experience)  @if($teamArr->brand_experience->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly" @isset($teamArr->brand_experience) @if($teamArr->brand_experience->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
								<tr>
								   <td class="text-center">
									  <div class="avatar-cropper">
										 <!----> <input accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon" type="file" class="avatar-cropper-img-input" name="file_7">
									  </div>
									  <button id="pick-avatar-0" class="btn" type="button"  @if( !empty($teamArr->customer_support->photo)) style="display:none" @endif>Add Photo</button>
									    
									   <img src="{{$image_path}}{{ $teamArr->customer_support->photo }}"  height="80" width="80" @if( empty($teamArr->customer_support->photo)) style="display:none"  @endif>
									     @if( !empty($teamArr->customer_support->photo))
									   <a href="javascript:void(0)" class="edit-img"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="javascript:void(0)" class="remove-img"><i class="fa fa-times" aria-hidden="true"></i></a> 
									   <input type="hidden" name="remove_7" class="remove" value="">
									   @endif
									  
								   </td>
								   <td class="text-left text-nowrap">
									  <div class="row">
										 <div class="col-12 pr-4">
											<div class="d-inline-block pr-2 w-50"><input type="text" placeholder="Name" class="form-control" name="name[]"  @isset($teamArr->customer_support) value="{{$teamArr->customer_support->name}}" @endisset></div>
											<div class="d-inline-block w-50"><input type="text" placeholder="Email" class="form-control" name="email[]" @isset($teamArr->customer_support)  value="{{$teamArr->customer_support->email}}" @endisset></div>
										 </div>
										 <div class="col-12 text-wrap">
											<p class="mb-0">Customer Support</p>
										 </div>
									  </div>
								   </td>
								   <td class="text-left text-nowrap tp">
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing-6" class="custom-control-input" name="instant_alert[]" value="instant_6" @isset($teamArr->customer_support) @if($teamArr->customer_support->instant_alert ==1) checked @endif @endisset> <label for="customControlAutosizing-6" class="custom-control-label"> Instant alerts</label></div>
									  </div>
									  <div class="d-inline-block action-col">
										 <div class="custom-control custom-checkbox mr-sm-2 rtl-lbl"><input type="checkbox" id="customControlAutosizing2-6" class="custom-control-input" name="exec_summary[]" value="exec_6" @isset($teamArr->customer_support) @if($teamArr->customer_support->exec_summary ==1) checked @endif @endisset> <label for="customControlAutosizing2-6" class="custom-control-label"> Exec summary</label></div>
									  </div>
								   </td>
								   <td class="text-center">
									  <select class="form-control" name="frequency[]">
										 <option value="daily" @isset($teamArr->customer_support) @if($teamArr->customer_support->frequency == "daily") selected @endif @endisset>Daily</option>
										 <option value="weekly"@isset($teamArr->customer_support)  @if($teamArr->customer_support->frequency == "weekly") selected @endif @endisset>Weekly</option>
										 <option value="monthly"@isset($teamArr->customer_support)  @if($teamArr->customer_support->frequency == "monthly") selected @endif @endisset>Monthly</option>
									  </select>
								   </td>
								</tr>
							 </tbody>
						  </table>
					   </div>
					   <div class="row table-btm-rw">
					   <input type="submit" value="Save" name="submit" class="btn btn-lg">
					   <a href="#">Cancel</a>
					   </div>
					</div>


			</form>


			</div>
			
			
			</div>
        </div>
    </div>
	</div>

@endsection



