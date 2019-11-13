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
            <h4 class="page-title col-md-6 col-12 order-md-1 order-2">Manage Posts</h4>
            <div class="ml-auto text-right col-md-6 col-12 order-md-2 order-1">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-md-end">
                  <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard mr-1"></i> Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Manage Posts</li>
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
        <div class="col-md-12 col-lg-4 pb-3 pb_3">
          <div class="active-posts">
            <div class="row">
              <div class="col-9">
                <h1>Active Posts</h1>
                <h2>{{ $postCount->active_posts_count}}</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-pencil-square-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 pb-3 pb_3">
          <div class="scheduled-posts">
            <div class="row">
              <div class="col-9">
                <h1>Scheduled Posts</h1>
                <h2>{{ $postCount->scheduled_posts_count}}</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-calendar text-white font-30"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 pb-3 pb_3">
          <div class="expired-posts">
            <div class="row">
              <div class="col-9">
                <h1>Expired Posts</h1>
                <h2>{{ $postCount->expired_posts_count}}</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-paper-plane-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
          <div class="d-none d-lg-block"> <a href="#" class="btn btn-light custom-btn-rounded">Posting Schedule</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">Post Library</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">Analytics</a> </div>
          <div class="d-block d-lg-none mb-3">
            <select class="form-control h-40 post-schld-select">
              <option selected="">Posting Schedule</option>
              <option>Library</option>
              <option>Setting</option>
              <option>Knowledgebase</option>
              <option>Analytics</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 text-right">
          <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle custom-btn-action p-2 px-3 action-menu-width text-left min-190 rounded-0" data-toggle="dropdown"> Action Menu </button>
            <div class="dropdown-menu action-menu action-menu-width custom-btn-action-dropdown min-190 py-0 rounded-5"> <a class="dropdown-item font-semi-bold" href="{{ url('create-post') }}">Create New Post </a> <a class="dropdown-item font-semi-bold" href="{{ url('schedule-post-bulk-upload') }}">Bulk import </a> <a class="dropdown-item font-semi-bold" href="#">Generate Report</a> <a class="dropdown-item font-semi-bold" href="#">Post Archive</a> </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12">
			
          <div class="white-rounded-box">
			  @if(session('message'))
			<div class='alert alert-success'>
				{{ session('message') }}
			</div>
		    @endif
			   <div class="processing-text"></div>
            <div class="row">
              <div class="col-12">
				  
						<div class="container">


							<table class="table data-table table table-striped post-tbl dataTable no-footer">

								<thead>

									<tr>

										<th>No</th>

										<th>Title</th>

										<th>Location Name</th>
										 <th>Type</th>
										 <th>Expiry Date</th>
										 <th>Views</th>
										 <th>Status</th>
										 <th width="100px">Action</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

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
    </div>

@endsection




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

  






   

<script type="text/javascript">

  $(function () {

    

    var table = $('.data-table').DataTable({

        processing: true,
		dom: 'lBfrtip',
        serverSide: true,

        ajax: "{{ route('users.index', app()->getLocale()) }}",
		pageLength: 10,

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'title', name: 'title'},

            {data: 'location_name', name: 'location_name'},
             {data: 'type', name: 'type'},

		 {data: 'expiry_date', name: 'expiry_date'},

		 {data: 'views', name: 'views'},



		 {data: 'status', name: 'status'},


            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });

    

  });

</script>




