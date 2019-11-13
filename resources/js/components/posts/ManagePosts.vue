<template>
	<div>
		<div class="row">
			<div class="col-md-12 col-lg-4 pb-3">
				<div class="active-posts">
					<div class="row">
						<div class="col-9">
							<h1>Active Posts</h1>
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
							<h1>Scheduled Posts</h1>
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
							<h1>Expired Posts</h1>
							<h2>14</h2>
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
					<div class="dropdown-menu action-menu action-menu-width custom-btn-action-dropdown min-190 py-0 rounded-5"> <a class="dropdown-item font-semi-bold" href="create-posts.html">Create New Post </a> <a class="dropdown-item font-semi-bold" href="#">Bulk import </a> <a class="dropdown-item font-semi-bold" href="#">Generate Report</a> <a class="dropdown-item font-semi-bold" href="#">Post Archive</a> </div>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-12">
				<div class="white-rounded-box">
					<div class="row">
						<div class="col-12">
							<div class="row mb-2 mt-2">
								<div class="col-md-1 revews-selectbox pb-2">
									<select class="form-control rounded-5">
										<option value="10" selected="">10</option>
										<option value="15">15</option>
										<option value="20">20</option>
										<option value="25">25</option>
										<option value="30">30</option>
									</select>
								</div>
								<div class="offset-md-5 col-md-6 pb-2">
									<form class="search-post d-flex justify-content-end" action="#">
										<span class="position-relative d-inline-block mr-3">
											<input type="text" placeholder="Search" name="search" class="form-control rounded-5">
										</span>
										<button type="submit">Search</button>
									</form>
								</div>
							</div>
							<table id="example" class="table table-striped nowrap post-tbl" style="width:100%">
								<thead>
									<tr>
										<th class="text-left">Post Title</th>
										<th class="text-center">Location name</th>
										<th class="text-center">Type</th>
										<th class="text-center">Expiry date</th>
										<th class="text-center">Views</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-left">Business Name - Location A</td>
										<td>Location name</td>
										<td>Book</td>
										<td>04 May 2019 : 4:11 AM</td>
										<td>112</td>
										<td>Posted</td>
										<td><a href="#!"><i class="fa fa-pencil text-secondary font-20 mr-1"></i></a> <a href="#!"><i class="fa fa-clock-o text_dark_pink font-20 mr-1"></i></a> <a href="#!"><i class="fa fa-clone text_light_blue font-20 mr-1"></i></a> <a href="#!"><i class="fa fa-ban font-20 text_red"></i></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		name: 'ManagePosts',

		props: [],

		data() {
			return {

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