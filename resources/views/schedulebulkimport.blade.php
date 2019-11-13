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
            <h4 class="page-title col-md-6 col-12 order-md-1 order-2">{{__('Posting Schedule')}}</h4>
            <div class="ml-auto text-right col-md-6 col-12 order-md-2 order-1">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-md-end">
                  <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard mr-1"></i> {{__('Home')}}</a></li>
                  <li class="breadcrumb-item"><a href="#">{{__('Dashboard')}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{__('Posting Schedule')}}</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
     
    <!-- End Bread crumb and right sidebar toggle --> 
     
     
    <!-- Container fluid  --> 
    <form method="POST" action="process-bulk-import" enctype="multipart/form-data" id='bulk-import-form'>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="container-fluid"> 
       
      <!-- Sales Cards  --> 
      
       <div class="row">
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="active-posts">
            <div class="row">
              <div class="col-9">
                <h1>{{__('Active Posts')}}</h1>
                <h2>{{ $postCount->active_posts_count}}</h2>
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
                <h2>{{ $postCount->scheduled_posts_count}}</h2>
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
                <h2>{{ $postCount->expired_posts_count}}</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-paper-plane-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
      </div>
             
      <div class="row mt-4">
        <div class="col-xs-6 col-sm-12 col-md-12 col-lg-8">
          <div class="d-none d-lg-block"> <a href="#" class="btn btn-light custom-btn-rounded">{{__('Posting Schedule')}}</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">{{__('Library')}}</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">{{__('Setting')}}</a> </div>
          <div class="d-block d-lg-none mb-3">
            <select class="form-control">
              <option selected="">{{__('Posting Schedule')}}</option>
              <option>{{__('Library')}}</option>
              <option>{{__('Setting')}}</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6 col-sm-12 col-md-12 col-lg-4 text-right">
          <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle custom-btn-action p-2 px-3 action-menu-width text-left min-190 rounded-0" data-toggle="dropdown"> {{__('Action Menu')}} </button>
            <div class="dropdown-menu action-menu action-menu-width custom-btn-action-dropdown min-190 py-0 rounded-5"> <a class="dropdown-item font-semi-bold" href="{{ url('create-post')}}">{{__('Create New Post')}} </a> <a class="dropdown-item font-semi-bold" href="{{ url('schedule-post-bulk-upload') }}">{{__('Bulk import')}} </a> <a class="dropdown-item font-semi-bold" href="#">{{__('Generate Report')}}</a> <a class="dropdown-item font-semi-bold" href="#">{{__('Post Archive')}}</a> </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12">
          <div class="white-rounded-box posting_schedule_page">
            <div class="row">
              <div class="col-12 p-4">
				  	@if(session('message'))
										<div class='alert alert-success'>
											{{ session('message') }}
										</div>
										@endif
                <h3 class="mb-4">{{__('Import request')}}</h3>
                <div class="number_wrap">
                  <div class="number"> 1 </div>
                  <div class="number_content">
                    <h4>{{__('Copy your data into GeoKing Excel template')}}.</h4>
                    <h5>{{__('Follow instructions on the first page of the template')}}.</h5>
<!--
                    <button type="button" class="btn btn-outline-primary mt-1">Download Template</button>
-->
                    <a href="https://geoking.biz/laravel/csv/example.csv" class="btn btn-outline-primary mt-1">{{__('Download Template')}}</a>
                  </div>
                </div>
                <div class="number_wrap">
                  <div class="number"> 1 </div>
                  <div class="number_content">
                    <h4>{{__('Upload your edited Excel files to GeoKing')}}.</h4>
                    <h5 class="blue_text">{{__('How to import order history')}}</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7 col-12">
                <div class="bg_gray p-4">
                  <div class="custom-control custom-checkbox mr-sm-2 text-left form-group">
                    <input type="checkbox" class="custom-control-input" id="ExcelTemplate" name="csv_check" >
                    <label class="custom-control-label text-left" for="ExcelTemplate"> {{__('Yes i used GeoKing  Excel template')}}</label>
                  </div>
                  <div class="row">
                    <div class="col-9">
                      <div class="file_uploadedImgInput">
                        <div class="file_fileUpload"> <span>{{__('Upload file')}}</span>
                          <input type="file" class="upload" id="filePicWithLogo" name="file" name="filePicWithLogo">
                        </div>
                        <span id="file_filename" style="display: none;"></span> </div>
                    </div>
                    <div class="col-3 text-right"><a href="" class="blue_text">{{__('Cancel')}}</a></div>
                  </div>
                  <div class="validation-error"></div>
                  <div class="row">
                    <div class="col-9">
						 <input type="submit" class="upload" value="Submit">
						</div>
						</div>
                </div>
              </div>
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

@endsection

